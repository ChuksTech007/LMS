<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    private const PROOF_PATH = 'payment_proofs';

    /**
     * Show payment page for a course.
     */
    public function create(Course $course)
    {
        $user = auth()->user();

        // Check if already enrolled
        if ($course->students()->where('user_id', $user->id)->exists()) {
            return redirect()->route('courses.show', $course)
                ->with('info', 'You are already enrolled in this course.');
        }

        // Check if there's a pending or verified payment
        $existingPayment = Payment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->whereIn('status', ['pending', 'verified'])
            ->first();

        return view('pages.student.payments.create', compact('course', 'existingPayment'));
    }

    /**
     * Store payment proof.
     */
    public function store(Request $request, Course $course)
    {
        $request->validate([
            'proof_image' => 'required|image|mimes:jpeg,png,jpg|max:8192',
            'payment_reference' => 'nullable|string|max:255',
        ]);

        $user = auth()->user();

        // Check if already has a payment for this course
        $existingPayment = Payment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->whereIn('status', ['pending', 'verified'])
            ->first();

        if ($existingPayment) {
            return back()->with('error', 'You already have a payment submission for this course.');
        }

        // Save proof image
        $proofPath = null;
        if ($request->hasFile('proof_image')) {
            $file = $request->file('proof_image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '_' . Str::random(10) . '.' . $extension;
            $destinationPath = public_path(self::PROOF_PATH);

            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0777, true, true);
            }

            $file->move($destinationPath, $filename);
            $proofPath = self::PROOF_PATH . '/' . $filename;
        }

        // Create payment record
        $payment = Payment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'amount' => $course->price,
            'payment_reference' => $request->payment_reference,
            'proof_image' => $proofPath,
            'status' => 'pending',
        ]);

        // Notify instructor
        $course->instructor->notify(new \App\Notifications\PaymentSubmitted($payment));

        return redirect()->route('courses.show', $course)
            ->with('success', 'Payment proof submitted! Please wait for verification.');
    }

    /**
     * Show payment status.
     */
    public function show(Payment $payment)
    {
        $this->authorize('view', $payment);

        return view('pages.student.payments.show', compact('payment'));
    }
}