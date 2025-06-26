<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display the home page.
     */
    public function home()
    {
        return view("pages.home");
    }

    /**
     * Display a list of all public courses.
     */
    public function courseIndex()
    {
        $courses = Course::latest()->paginate(9); // Get latest courses with pagination

        return view('pages.courses.index', compact('courses'));
    }

    /**
     * Display a single course details.
     */
    public function courseShow(Course $course)
    {
        $course->load(['instructor', 'lessons']);

        return view('pages.courses.show', compact('course'));
    }
}
