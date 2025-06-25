<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LearningController extends Controller
{
    public function showLesson(Course $course, Lesson $lesson)
    {
        // Eager load all lessons for the sidebar navigation
        $course->load('lessons');

        return view('pages.learning.show', [
            'course' => $course,
            'currentLesson' => $lesson,
        ]);
    }
}
