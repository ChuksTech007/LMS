<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // Eager load quizzes and ONLY the COMPLETED attempts for the current user.
        $enrolledCourses = auth()->user()->enrolledCourses()
            ->with(['quiz' => function ($query) use ($userId) {
                // Load attempts related to the current user
                $query->with(['attempts' => function ($q) use ($userId) {
                    $q->where('user_id', $userId)
                      // 🔥 FIX: Check for any COMPLETED attempt (passed or failed)
                      ->whereNotNull('completed_at') 
                      ->latest('completed_at')
                      ->limit(1); // Only need the latest one to check if completed
                }]);
            }])
            ->latest()
            ->get();

        return view('pages.student.dashboard', compact('enrolledCourses'));
    }
}