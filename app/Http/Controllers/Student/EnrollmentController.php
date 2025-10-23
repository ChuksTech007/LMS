<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Events\StudentEnrolled;
use App\Models\Course;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    /**
     * Handle the user enrollment for a course.
     */
    public function store(Request $request, Course $course)
    {
        $user = auth()->user();

        if (!$course->students()->where('user_id', $user->id)->exists()) {
            $course->students()->attach($user->id);

            // Dispatch the event after successful enrollment
            event(new StudentEnrolled($course, $user));
        }

        return redirect()->route('courses.show', $course)
            ->with('success', 'Congratulations, you have successfully enrolled in this course!');
    }
}
