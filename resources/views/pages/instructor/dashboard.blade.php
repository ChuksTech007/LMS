@extends('layouts.app')

@section('title', 'Instructor Dashboard')

@section('content')

<!-- A new, more dynamic background gradient for a premium feel -->

<div class="py-12 bg-gray-50 px-4 min-h-screen">
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">

    {{-- Welcome and Greeting --}}
    <!-- The header now uses a distinct, card-like container with a fade-in animation -->
    <div class="bg-white rounded-xl shadow-lg p-8 animate-fade-in-down">
        <h2 class="text-3xl sm:text-4xl font-extrabold text-green-900">
            Welcome, Instructor {{ auth()->user()->name }}!
        </h2>
        <p class="mt-2 text-md text-gray-600">This is a beautiful new summary of your teaching activities, including exam management.</p>
    </div>

    {{-- Stats Cards --}}
    <!-- A more visually distinct card layout with icons in the corner and a vibrant color accent border -->
    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
        <div class="bg-white rounded-xl shadow-xl border-b-4 border-yellow-400 overflow-hidden transition-all duration-300 transform hover:scale-[1.02] hover:shadow-2xl animate-fade-in-left-delay-1">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-500">Total Courses</h3>
                    <div class="flex-shrink-0 p-2 rounded-full bg-yellow-400 text-green-900">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                        </svg>
                    </div>
                </div>
                <div class="text-4xl font-extrabold text-green-900">{{ $stats['total_courses'] }}</div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-xl border-b-4 border-yellow-400 overflow-hidden transition-all duration-300 transform hover:scale-[1.02] hover:shadow-2xl animate-fade-in-left-delay-2">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-500">Total Lessons</h3>
                    <div class="flex-shrink-0 p-2 rounded-full bg-yellow-400 text-green-900">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                        </svg>
                    </div>
                </div>
                <div class="text-4xl font-extrabold text-green-900">{{ $stats['total_lessons'] }}</div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-xl border-b-4 border-yellow-400 overflow-hidden transition-all duration-300 transform hover:scale-[1.02] hover:shadow-2xl animate-fade-in-left-delay-3">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-500">Total Students</h3>
                    <div class="flex-shrink-0 p-2 rounded-full bg-yellow-400 text-green-900">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                    </div>
                </div>
                <div class="text-4xl font-extrabold text-green-900">{{ $stats['total_students'] }}</div>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
<div class="bg-white overflow-hidden shadow-xl rounded-xl p-8 animate-fade-in-up">
<h3 class="text-2xl font-bold text-green-900">Quick Actions</h3>
<p class="mt-1 text-sm text-gray-600">Easily manage your courses and students with these quick links.</p>
<div class="mt-6 flex flex-wrap gap-4">
<a href="{{ route('instructor.courses.create') }}"
class="rounded-md bg-green-900 px-6 py-3 text-sm font-semibold text-white shadow-md
 hover:bg-green-800 hover:scale-[1.05] transition-all duration-200 ease-in-out">
Add New Course
</a>
<a href="{{ route('instructor.courses.index') }}"
class="rounded-md bg-white px-6 py-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 hover:scale-[1.05] transition-all duration-200 ease-in-out">
Manage All Courses
</a>

{{-- FIX: Changed route to a dedicated quiz index page --}}
<a href="{{ route('instructor.quizzes.index') }}" 
class="rounded-md bg-yellow-400 px-6 py-3 text-sm font-semibold text-green-900 shadow-md hover:bg-yellow-500 hover:scale-[1.05] transition-all duration-200 ease-in-out">
Manage Exams & Results
</a>

<a href="{{ route('instructor.live-sessions.index') }}"
class="rounded-md bg-white px-6 py-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 hover:scale-[1.05] transition-all duration-200 ease-in-out">
Live Classes
</a>





</div>
</div>
...</div>

</div>

<!-- Custom CSS for animations -->

<style>
@keyframes fadeInDown {
from { opacity: 0; transform: translateY(-20px); }
to { opacity: 1; transform: translateY(0); }
}
@keyframes fadeInLeft {
from { opacity: 0; transform: translateX(-20px); }
to { opacity: 1; transform: translateX(0); }
}
@keyframes fadeInUp {
from { opacity: 0; transform: translateY(20px); }
to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in-down {
animation: fadeInDown 0.8s ease-out forwards;
}
.animate-fade-in-left-delay-1 { animation: fadeInLeft 0.8s ease-out 0.2s forwards; opacity: 0; }
.animate-fade-in-left-delay-2 { animation: fadeInLeft 0.8s ease-out 0.4s forwards; opacity: 0; }
.animate-fade-in-left-delay-3 { animation: fadeInLeft 0.8s ease-out 0.6s forwards; opacity: 0; }
.animate-fade-in-up {
animation: fadeInUp 0.8s ease-out 0.8s forwards; opacity: 0;
}
</style>

@endsection