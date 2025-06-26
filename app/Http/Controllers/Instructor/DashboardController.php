<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Get IDs of courses owned by the instructor
        $courseIds = $user->courses()->pluck('id');

        $stats = [
            'total_courses' => $courseIds->count(),
            // Count all lessons that belong to this instructor's courses
            'total_lessons' => Lesson::whereIn('course_id', $courseIds)->count(),
            // Count unique students enrolled in this instructor's courses
            'total_students' => DB::table('course_user')->whereIn('course_id', $courseIds)->distinct('user_id')->count('user_id'),
        ];

        return view('pages.instructor.dashboard', compact('stats'));
    }
}
