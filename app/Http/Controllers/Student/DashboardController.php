<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $enrolledCourses = auth()->user()->enrolledCourses()->latest()->get();

        return view('pages.student.dashboard', compact('enrolledCourses'));
    }
}
