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

        $status = $course->is_published ? 'diterbitkan' : 'disembunyikan';
        return back()->with('success', "Status kursus '{$course->title}' berhasil diubah menjadi {$status}.");
    }
}
