<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    /**
     * Handle the user enrollment for a course.
     */
    public function store(Request $request, Course $course)
    {
        // Check if the user is not already enrolled
        if (!$course->students()->where('user_id', auth()->id())->exists()) {
            // Attach the user to the course
            $course->students()->attach(auth()->id());
        }

        return redirect()->route('courses.show', $course)
            ->with('success', 'Selamat, Anda berhasil terdaftar di kursus ini!');
    }
}
