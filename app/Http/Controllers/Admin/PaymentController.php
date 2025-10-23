<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Events\StudentEnrolled;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display all payments for admin/instructor.
     */
    public function index(Request $request)
    {
        $status = $request->query('status', 'pending');
        
        $query = Payment::with(['user', 'course', 'verifier'])
            ->latest();

        // For instructors, only show payments for their courses
        if (auth()->user()->role->value === 'instructor') {
            $query->whereHas('course', function ($q) {
                $q->where('user_id', auth()->id());
            });
        }

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        $payments = $query->paginate(20);
        
        // Get counts for all statuses for the filter tabs
        $statusCounts = [
            'pending' => Payment::where('status', 'pending')
                ->when(auth()->user()->role->value === 'instructor', function ($q) {
                    $q->whereHas('course', fn($q) => $q->where('user_id', auth()->id()));
                })
                ->count(),
            'verified' => Payment::where('status', 'verified')
                ->when(auth()->user()->role->value === 'instructor', function ($q) {
                    $q->whereHas('course', fn($q) => $q->where('user_id', auth()->id()));
                })
                ->count(),
            'rejected' => Payment::where('status', 'rejected')
                ->when(auth()->user()->role->value === 'instructor', function ($q) {
                    $q->whereHas('course', fn($q) => $q->where('user_id', auth()->id()));
                })
                ->count(),
        ];

        return view('pages.admin.payments.index', compact('payments', 'status', 'statusCounts'));
    }

    /**
     * Show payment details.
     */
    public function show(Payment $payment)
    {
        $payment->load(['user', 'course', 'verifier']);
        
        return view('pages.admin.payments.show', compact('payment'));
    }

    /**
     * Verify a payment and enroll student.
     */
    public function verify(Request $request, Payment $payment)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:500',
        ]);

        if ($payment->status !== 'pending') {
            return back()->with('error', 'This payment has already been processed.');
        }

        $payment->update([
            'status' => 'verified',
            'verified_by' => auth()->id(),
            'verified_at' => now(),
            'admin_notes' => $request->admin_notes,
        ]);

        // Enroll the student in the course
        $course = $payment->course;
        $user = $payment->user;

        if (!$course->students()->where('user_id', $user->id)->exists()) {
            $course->students()->attach($user->id);
            
            // Dispatch enrollment event
            event(new StudentEnrolled($course, $user));
        }

        // Notify the student
        $user->notify(new \App\Notifications\PaymentVerified($payment));

        return back()->with('success', 'Payment verified and student enrolled successfully!');
    }

    /**
     * Reject a payment.
     */
    public function reject(Request $request, Payment $payment)
    {
        $request->validate([
            'admin_notes' => 'required|string|max:500',
        ]);

        if ($payment->status !== 'pending') {
            return back()->with('error', 'This payment has already been processed.');
        }

        $payment->update([
            'status' => 'rejected',
            'verified_by' => auth()->id(),
            'verified_at' => now(),
            'admin_notes' => $request->admin_notes,
        ]);

        return back()->with('success', 'Payment rejected.');
    }
}