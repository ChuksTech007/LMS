@extends('layouts.app')

@section('title', 'Past Quizzes for ' . $course->title)

@section('content')
    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900 border-b pb-4 mb-6">
    Past Quizzes & Archived Exams for {{ $course->title }}
    </h1>
    <p class="text-gray-600 mb-8">
    Here you can review previous exams and your past attempts.
    </p>

    <a href="{{ route('learning.lesson', [$course, $course->lessons->first()]) }}"
       class="inline-flex items-center text-sm font-semibold text-green-600 hover:text-green-800 transition-colors duration-200 mb-6">
    &larr; Back to Lessons
    </a>

    @forelse ($pastQuizzes as $quiz)
    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6 border-l-4 border-gray-400">
    <div class="px-4 py-5 sm:px-6">
    <h2 class="text-xl leading-6 font-medium text-gray-900">{{ $quiz->title }}</h2>
    <p class="mt-1 max-w-2xl text-sm text-gray-500">
    {{ $quiz->questions->count() }} Questions | Passing Score: {{ $quiz->passing_score }}%
    </p>
    </div>
    
    {{-- Student's Attempts --}}
    <div class="border-t border-gray-200">
    <dl>
    @forelse ($quiz->attempts as $attempt)
    <div class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }} px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
    <dt class="text-sm font-medium text-gray-500">
    Attempt Date
    </dt>
    <dd class="mt-1 text-sm sm:mt-0 sm:col-span-1">
    {{ $attempt->completed_at->format('M d, Y h:i A') }}
    </dd>
    <dd class="mt-1 text-sm font-bold sm:mt-0 sm:col-span-1 flex items-center justify-end">
    @php
    $pass = $attempt->passed;
    $badgeColor = $pass ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
    @endphp
    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $badgeColor }}">
    {{ $attempt->percentage_score }}% ({{ $pass ? 'Passed' : 'Failed' }})
    </span>
    <a href="{{ route('quizzes.attempt.show', $attempt) }}" 
       class="ml-4 text-sm font-medium text-yellow-600 hover:text-yellow-800">
    View Corrections &rarr;
    </a>
    </dd>
    </div>
    @empty
    <div class="px-4 py-5 text-sm text-gray-500 flex justify-between items-center">
    No completed attempts found for this archived quiz.
                                <a href="{{ route('quizzes.review', $quiz) }}" 
     class="text-sm font-medium text-green-600 hover:text-green-800 flex items-center">
    View Questions & Answers &rarr;
    </a>
    </div>
    @endforelse
    </dl>
    </div>
    </div>
    @empty
    <div class="text-center py-10 bg-white rounded-lg shadow-lg">
    <p class="text-lg text-gray-500">There are no archived quizzes available for review in this course.</p>
    </div>
    @endforelse
    </div>
@endsection