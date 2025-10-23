<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Instructor\StoreCourseRequest;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\File; // Changed from Storage to File facade
use Illuminate\Support\Str;

class CourseController extends Controller
{
    // Define the base path relative to the 'public' directory
    private const BASE_THUMBNAIL_PATH = 'thumbnails';

    /**
     * Handles moving the uploaded file directly to the public/thumbnails directory.
     */
    private function saveThumbnail(UploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();
        $filename = time() . '_' . Str::random(10) . '.' . $extension;
        $destinationPath = public_path(self::BASE_THUMBNAIL_PATH);

        // Ensure the public/thumbnails directory exists
        if (!File::isDirectory($destinationPath)) {
            File::makeDirectory($destinationPath, 0777, true, true);
        }

        // Move the file from temp storage to the public directory
        $file->move($destinationPath, $filename);

        // Return the path relative to the public directory (e.g., 'thumbnails/123.jpg')
        return self::BASE_THUMBNAIL_PATH . '/' . $filename;
    }

    /**
     * Deletes the old file from the public directory.
     */
    private function deleteOldThumbnail(string $path = null): void
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
    
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
        $categories = Category::all();
        return view('pages.instructor.courses.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        $validated = $request->validated();
        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('thumbnail')) {
            try {
                // Use the custom method to save to public/thumbnails
                $validated['thumbnail'] = $this->saveThumbnail($request->file('thumbnail'));
            } catch (\Exception $e) {
                // Handle upload failure
                return back()->withInput()->with('error', 'Failed to upload thumbnail image.');
            }
        }

        $course = auth()->user()->courses()->create($validated);

        $course->categories()->attach($request->input('categories'));

        return redirect()->route('instructor.courses.index')->with('success', 'Course created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        // Eager load lessons and quiz to prevent N+1 queries and ensure data is available
        // for show.blade.php, especially the newly created quiz.
        $course->load(['lessons', 'quiz']); 

        return view('pages.instructor.courses.show', compact('course'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        Gate::authorize('update', $course);

        $categories = Category::all();
        return view('pages.instructor.courses.edit', compact('course', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCourseRequest $request, Course $course)
    {
        Gate::authorize('update', $course);

        $validated = $request->validated();
        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('thumbnail')) {
            try {
                // Save the new thumbnail
                $newPath = $this->saveThumbnail($request->file('thumbnail'));
                
                // If successful, delete old thumbnail using the new custom method
                $this->deleteOldThumbnail($course->thumbnail);

                // Update the validated data with the new path
                $validated['thumbnail'] = $newPath;
            } catch (\Exception $e) {
                return back()->withInput()->with('error', 'Failed to upload new thumbnail image.');
            }
        }
        
        $course->update($validated);

        $course->categories()->sync($request->input('categories'));

        return redirect()->route('instructor.courses.index')->with('success', 'Course updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        Gate::authorize('delete', $course);

        if ($course->thumbnail) {
            // Use the custom method to delete the file from the public directory
            $this->deleteOldThumbnail($course->thumbnail);
        }

        $course->delete();

        return redirect()->route('instructor.courses.index')->with('success', 'Course deleted successfully!');
    }
}
