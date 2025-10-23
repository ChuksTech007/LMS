<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('instructor')->latest()->paginate(15);
        return view('pages.admin.courses.index', compact('courses'));
    }

    public function toggleStatus(Course $course)
    {
        $course->is_published = !$course->is_published;
        $course->save();

        $status = $course->is_published ? 'Published' : 'Unpublished';
        return back()->with('success', "The status for the course '{$course->title}' has been successfully changed to {$status}.");
    }
}
