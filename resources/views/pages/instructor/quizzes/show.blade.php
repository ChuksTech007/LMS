@extends('layouts.app')

{{-- Assuming $course is passed to this view --}}
@section('title', 'Manage Course: ' . $course->title)

@section('content')
<div class="py-12 bg-gray-50 px-4 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

        {{-- Header and Quick Actions --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-white rounded-xl shadow-lg p-6">
            <h1 class="text-3xl font-extrabold text-green-900">
                Course: {{ $course->title }}
            </h1>
            <div class="mt-4 sm:mt-0 flex flex-wrap gap-3">
                
                {{-- 🚀 FIX: Add the "Create Quiz" button here! --}}
                @if (!$course->quiz)
                    <a href="{{ route('instructor.quizzes.create', $course->id) }}"
                       class="rounded-md bg-yellow-400 px-4 py-2 text-sm font-semibold text-green-900 shadow-md
                              hover:bg-yellow-500 transition duration-200">
                        <svg class="w-5 h-5 inline-block mr-1 -mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Create New Exam
                    </a>
                @else
                    <a href="{{ route('instructor.quizzes.results', $course->quiz->id) }}"
                       class="rounded-md bg-green-500 px-4 py-2 text-sm font-semibold text-white shadow-md
                              hover:bg-green-600 transition duration-200">
                        View Exam Results
                    </a>
                @endif

                <a href="{{ route('instructor.courses.lessons.create', $course->id) }}"
                   class="rounded-md bg-green-900 px-4 py-2 text-sm font-semibold text-white shadow-md
                          hover:bg-green-800 transition duration-200">
                    Add Lesson
                </a>
            </div>
        </div>
        
        <hr class="border-gray-300">

        {{-- Course Details and Lessons --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Course Overview Card --}}
            <div class="lg:col-span-1 bg-white p-6 rounded-xl shadow-md space-y-4">
                <h2 class="text-xl font-bold text-green-900 border-b pb-2">Overview</h2>
                <p class="text-gray-700">{{ $course->description }}</p>
                <p class="text-sm text-gray-500">
                    Status: 
                    <span class="font-semibold {{ $course->is_published ? 'text-green-600' : 'text-yellow-600' }}">
                        {{ $course->is_published ? 'Published' : 'Draft' }}
                    </span>
                </p>
                {{-- Add Edit/Delete buttons here --}}
            </div>

            {{-- Lessons Management Card --}}
            <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-md space-y-4">
                <h2 class="text-xl font-bold text-green-900 border-b pb-2 flex justify-between items-center">
                    Lessons ({{ $course->lessons->count() }})
                </h2>
                
                @if($course->lessons->isEmpty())
                    <p class="text-gray-500 italic">No lessons added yet.</p>
                @else
                    <ul class="divide-y divide-gray-200">
                        @foreach($course->lessons as $lesson)
                            <li class="py-3 flex justify-between items-center">
                                <span class="text-lg font-medium text-gray-800">{{ $lesson->title }}</span>
                                <a href="{{ route('instructor.courses.lessons.edit', [$course->id, $lesson->id]) }}" 
                                   class="text-sm text-blue-600 hover:text-blue-800">
                                    Edit
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

        </div>

    </div>
</div>
@endsection