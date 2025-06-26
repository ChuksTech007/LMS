<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
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
    public function courseIndex(Request $request) // Inject Request
    {
        $categories = Category::all();
        $query = Course::where('is_published', true);

        // Filter by Category
        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('slug', $request->input('category'));
            });
        }

        // Filter by Search Term
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('description', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Get the final results with pagination
        $courses = $query->latest()->paginate(9);

        return view('pages.courses.index', compact('courses', 'categories'));
    }

    /**
     * Display a single course details.
     */
    public function courseShow(Course $course)
    {
        $course->load(['instructor', 'lessons', 'reviews.user', 'categories']);
        return view('pages.courses.show', compact('course'));
    }
}
