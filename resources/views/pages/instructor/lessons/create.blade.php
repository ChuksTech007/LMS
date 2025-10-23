@extends('layouts.app')

@section('title', 'Add New Lesson')

@section('content')
<!-- Reusing the new background gradient for a consistent look -->
<div class="py-12 bg-gray-50 min-h-screen px-4">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 animate-fade-in-down">
            <div class="mb-4 sm:mb-0">
                <h2 class="text-2xl font-extrabold text-green-900">
                    Add Lesson to Course: {{ $course->title }}
                </h2>
                <a href="{{ route('instructor.courses.lessons.index', $course) }}"
                   class="inline-flex items-center text-sm font-semibold text-gray-600 hover:text-gray-800 transition-colors duration-200 mt-1">
                   &larr; Back to Curriculum
                </a>
            </div>
        </div>

        {{-- Add Lesson Form --}}
        <div class="bg-white overflow-hidden shadow-xl rounded-2xl animate-fade-in-up">
            <div class="p-6 text-gray-900">
                <form action="{{ route('instructor.courses.lessons.store', $course) }}" method="POST"
                    class="mt-6 space-y-6">
                    @csrf
                    @include('pages.instructor.lessons.partials._form')
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Custom CSS for animations -->
<style>
    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-down {
        animation: fadeInDown 0.8s ease-out forwards;
    }
    .animate-fade-in-up {
        animation: fadeInUp 0.8s ease-out 0.8s forwards; opacity: 0;
    }
</style>
@endsection
