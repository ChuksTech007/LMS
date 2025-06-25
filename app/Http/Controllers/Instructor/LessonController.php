<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Instructor\StoreLessonRequest;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LessonController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Course $course)
    {
        $lessons = $course->lessons()->orderBy('title')->get();

        return view('pages.instructor.lessons.index', compact('course', 'lessons'));
    }

    /**
     * Show the form for creating a new lesson.
     */
    public function create(Course $course)
    {
        return view('pages.instructor.lessons.create', compact('course'));
    }

    /**
     * Store a newly created lesson in storage.
     */
    public function store(StoreLessonRequest $request, Course $course)
    {
        $validated = $request->validated();
        $validated['slug'] = Str::slug($validated['title']);

        $course->lessons()->create($validated);

        return redirect()->route('instructor.courses.lessons.index', $course)
            ->with('success', 'Pelajaran berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified lesson.
     */
    public function edit(Course $course, Lesson $lesson)
    {
        return view('pages.instructor.lessons.edit', compact('course', 'lesson'));
    }

    /**
     * Update the specified lesson in storage.
     */
    public function update(StoreLessonRequest $request, Course $course, Lesson $lesson)
    {
        $validated = $request->validated();
        $validated['slug'] = Str::slug($validated['title']);

        $lesson->update($validated);

        return redirect()->route('instructor.courses.lessons.index', $course)
            ->with('success', 'Pelajaran berhasil diperbarui!');
    }

    /**
     * Remove the specified lesson from storage.
     */
    public function destroy(Course $course, Lesson $lesson)
    {
        $lesson->delete();

        return redirect()->route('instructor.courses.lessons.index', $course)
            ->with('success', 'Pelajaran berhasil dihapus!');
    }
}
