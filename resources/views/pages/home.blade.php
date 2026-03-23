@extends('layouts.app')

@section('title', 'Welcome to FUTO-SkillUP')

@section('content')

{{-- ===== HERO SECTION ===== --}}
<div class="relative bg-green-800 text-white overflow-hidden">
    <div class="absolute top-0 left-0 w-64 h-64 bg-green-700 rounded-full blur-3xl opacity-30"></div>
    <div class="absolute bottom-0 right-0 w-72 h-72 bg-yellow-400 rounded-full blur-3xl opacity-20"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-12 py-20 flex flex-col lg:flex-row items-center gap-10">
        <!-- Left Text -->
        <div class="flex-1 space-y-6 animate-slideInLeft">
            <span class="px-4 py-1 text-xs font-bold uppercase tracking-widest bg-yellow-500 text-green-900 rounded-full shadow-lg">
                Your Future Starts Here
            </span>
            <h1 class="text-4xl lg:text-5xl font-extrabold leading-tight">
                Master In-Demand Skills with
                <span class="text-yellow-400">FUTO-SkillUP</span>
            </h1>
            <p class="text-lg text-gray-100 max-w-xl">
                Join an innovative learning community built for dreamers, doers, and change-makers.
                Learn from industry experts, tackle real projects, and unlock career opportunities.
            </p>
            <div class="flex flex-wrap gap-4">
                @guest
                    <a href="{{ route('register') }}" class="px-6 py-3 rounded-lg bg-yellow-400 text-green-900 font-semibold shadow-md hover:bg-yellow-300 transition-all hover:scale-105">
                        Get Started Free
                    </a>
                @endguest
                @auth
                    @if(auth()->user()->role->value === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="px-6 py-3 rounded-lg bg-yellow-400 text-green-900 font-semibold shadow-md hover:bg-yellow-300 transition-all hover:scale-105">
                            Go to Dashboard
                        </a>
                    @elseif(auth()->user()->role->value === 'instructor')
                        <a href="{{ route('instructor.dashboard') }}" class="px-6 py-3 rounded-lg bg-yellow-400 text-green-900 font-semibold shadow-md hover:bg-yellow-300 transition-all hover:scale-105">
                            Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('student.dashboard') }}" class="px-6 py-3 rounded-lg bg-yellow-400 text-green-900 font-semibold shadow-md hover:bg-yellow-300 transition-all hover:scale-105">
                            My Courses
                        </a>
                    @endif
                @endauth
                <a href="{{ route('courses.index') }}" class="px-6 py-3 rounded-lg border-2 border-yellow-400 text-yellow-400 hover:bg-yellow-400 hover:text-green-900 transition-all">
                    Browse Courses &rarr;
                </a>
            </div>
        </div>

        <!-- Right Image -->
        <div class="flex-1 relative animate-float">
            <img class="w-full h-auto object-cover rounded-2xl shadow-2xl"
                src="https://images.unsplash.com/photo-1559163304-2bd8f8600164?w=600&auto=format&fit=crop&q=60"
                alt="FUTO-SkillUP Learning">
            <div class="absolute top-4 right-4 bg-green-700 text-yellow-400 px-4 py-2 rounded-lg shadow-lg text-sm font-bold animate-bounce">
                {{ $stats['courses'] }}+ Courses
            </div>
        </div>
    </div>
</div>

{{-- ===== STATS SECTION ===== --}}
<div class="bg-yellow-400 py-12">
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 sm:grid-cols-3 gap-8 text-center text-green-900">
        <div>
            <div class="text-5xl font-extrabold">{{ $stats['courses'] }}+</div>
            <div class="mt-2 text-lg font-semibold">Published Courses</div>
        </div>
        <div>
            <div class="text-5xl font-extrabold">{{ $stats['students'] }}+</div>
            <div class="mt-2 text-lg font-semibold">Active Students</div>
        </div>
        <div>
            <div class="text-5xl font-extrabold">{{ $stats['instructors'] }}+</div>
            <div class="mt-2 text-lg font-semibold">Expert Instructors</div>
        </div>
    </div>
</div>

{{-- ===== HOW IT WORKS SECTION ===== --}}
<div class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-14">
            <h2 class="text-3xl font-extrabold text-green-900">How FUTO-SkillUP Works</h2>
            <p class="mt-3 text-gray-500 max-w-xl mx-auto">Get certified and advance your career in just a few simple steps.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <div class="bg-white rounded-2xl shadow-md p-8 text-center hover:shadow-xl transition-shadow">
                <div class="w-14 h-14 bg-yellow-400 text-green-900 rounded-full flex items-center justify-center text-2xl font-extrabold mx-auto mb-4">1</div>
                <h3 class="text-xl font-bold text-green-900 mb-2">Browse & Enroll</h3>
                <p class="text-gray-500 text-sm">Explore our catalog of expert-led courses and enroll with a simple bank transfer payment.</p>
            </div>
            <div class="bg-white rounded-2xl shadow-md p-8 text-center hover:shadow-xl transition-shadow">
                <div class="w-14 h-14 bg-yellow-400 text-green-900 rounded-full flex items-center justify-center text-2xl font-extrabold mx-auto mb-4">2</div>
                <h3 class="text-xl font-bold text-green-900 mb-2">Learn at Your Pace</h3>
                <p class="text-gray-500 text-sm">Watch lessons, attend live sessions with your instructor, and track your progress as you go.</p>
            </div>
            <div class="bg-white rounded-2xl shadow-md p-8 text-center hover:shadow-xl transition-shadow">
                <div class="w-14 h-14 bg-yellow-400 text-green-900 rounded-full flex items-center justify-center text-2xl font-extrabold mx-auto mb-4">3</div>
                <h3 class="text-xl font-bold text-green-900 mb-2">Get Certified</h3>
                <p class="text-gray-500 text-sm">Pass the final exam and download your official FUTO-SkillUP certificate to showcase your skills.</p>
            </div>
        </div>
    </div>
</div>

{{-- ===== FEATURED COURSES SECTION ===== --}}
@if($featuredCourses->isNotEmpty())
<div class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex items-center justify-between mb-10">
            <div>
                <h2 class="text-3xl font-extrabold text-green-900">Featured Courses</h2>
                <p class="mt-2 text-gray-500">Start learning with our most popular courses.</p>
            </div>
            <a href="{{ route('courses.index') }}" class="text-green-700 font-semibold hover:text-yellow-500 transition-colors hidden sm:block">
                View All &rarr;
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($featuredCourses as $course)
                <div class="bg-white border border-gray-100 rounded-2xl shadow-md overflow-hidden flex flex-col hover:shadow-xl hover:scale-[1.02] transition-all duration-300">
                    <img src="{{ asset('/' . $course->thumbnail) }}" alt="{{ $course->title }}" class="h-44 w-full object-cover">
                    <div class="p-5 flex flex-col flex-grow">
                        <div class="flex flex-wrap gap-1 mb-2">
                            @foreach($course->categories->take(2) as $cat)
                                <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-0.5 rounded-full">{{ $cat->name }}</span>
                            @endforeach
                        </div>
                        <h3 class="font-bold text-gray-900 text-lg leading-snug">{{ $course->title }}</h3>
                        <p class="text-sm text-gray-500 mt-1">By {{ $course->instructor->name }}</p>
                        <div class="flex items-center mt-2 gap-1">
                            @php $avg = round($course->reviews->avg('rating') ?? 0); @endphp
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 {{ $avg >= $i ? 'text-yellow-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                            <span class="text-xs text-gray-400 ml-1">({{ $course->reviews->count() }})</span>
                        </div>
                        <div class="mt-auto pt-4 flex items-center justify-between">
                            <span class="text-lg font-bold text-green-800">&#8358;{{ number_format($course->price, 0) }}</span>
                            <a href="{{ route('courses.show', $course) }}"
                               class="bg-green-800 text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                                View Course
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-10 text-center sm:hidden">
            <a href="{{ route('courses.index') }}" class="inline-block bg-green-800 text-white px-8 py-3 rounded-full font-semibold hover:bg-green-700 transition-colors">
                View All Courses
            </a>
        </div>
    </div>
</div>
@endif

{{-- ===== CTA SECTION ===== --}}
@guest
<div class="bg-green-800 py-16 text-center text-white">
    <h2 class="text-3xl font-extrabold mb-4">Ready to Start Learning?</h2>
    <p class="text-gray-200 mb-8 max-w-xl mx-auto">Join thousands of students building real skills with FUTO-SkillUP today.</p>
    <a href="{{ route('register') }}" class="inline-block bg-yellow-400 text-green-900 font-bold px-10 py-4 rounded-full shadow-lg hover:bg-yellow-300 transition-all hover:scale-105">
        Create Free Account
    </a>
</div>
@endguest

<style>
@keyframes slideInLeft {
    0% { opacity: 0; transform: translateX(-50px); }
    100% { opacity: 1; transform: translateX(0); }
}
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}
.animate-slideInLeft { animation: slideInLeft 0.9s ease-out; }
.animate-float { animation: float 3s ease-in-out infinite; }
</style>
@endsection
