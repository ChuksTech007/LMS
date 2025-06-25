<?php

namespace App\Http\Controllers;

use App\Http\Requests\Instructor\StoreCourseRequest;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = auth()->user()->courses()->latest()->get();

        return view('pages.instructor.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.instructor.courses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        $validated = $request->validated();
        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        auth()->user()->courses()->create($validated);

        return redirect()->route('instructor.courses.index')->with('success', 'Kursus berhasil dibuat!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        return view('pages.instructor.courses.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCourseRequest $request, Course $course)
    {
        $validated = $request->validated();
        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if it exists
            if ($course->thumbnail) {
                Storage::disk('public')->delete($course->thumbnail);
            }
            // Store the new thumbnail
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $course->update($validated);

        return redirect()->route('instructor.courses.index')->with('success', 'Kursus berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        if ($course->thumbnail) {
            Storage::disk('public')->delete($course->thumbnail);
        }

        $course->delete();

        return redirect()->route('instructor.courses.index')->with('success', 'Kursus berhasil dihapus!');
    }
}
