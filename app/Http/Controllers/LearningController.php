<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LearningController extends Controller
{
    /**
     * Display the lesson for the authenticated user.
     **/
    public function showLesson(Course $course, Lesson $lesson)
    {
        // Eager load all lessons for the sidebar navigation
        $course->load('lessons');

        return view('pages.learning.show', [
            'course' => $course,
            'currentLesson' => $lesson,
        ]);
    }

    /**
     * Mark a lesson as completed for the authenticated user.
     */
    public function completeLesson(Request $request, Course $course, Lesson $lesson)
    {
        $user = auth()->user();

        // Attach the lesson to the user's completed lessons if it's not already attached.
        if (!$user->completedLessons->contains($lesson)) {
            $user->completedLessons()->attach($lesson->id);
        }

        return back()->with('success', 'Pelajaran ditandai selesai!');
    }
}
