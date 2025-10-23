@extends('layouts.app')

@section('title', 'My Courses')

@section('content')
    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white rounded-2xl shadow-xl p-8 mb-12 border-b-4 border-green-700 animate-fadeInDown">
                <div class="flex items-center justify-between flex-wrap">
                    <div>
                        <h1 class="text-4xl font-extrabold text-gray-800">Welcome back,
                            {{ auth()->user()->name ?? 'Student' }}!</h1>
                        <p class="mt-2 text-xl text-gray-500">
                            You are currently enrolled in
                            <span class="font-bold text-green-700">{{ $enrolledCourses->count() }}</span>
                            amazing course{{ $enrolledCourses->count() !== 1 ? 's' : '' }}. Let's keep learning!
                        </p>
                    </div>
                    <div class="mt-4 sm:mt-0">
                        <a href="{{ route('courses.index') }}"
                            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-full shadow-md text-white bg-green-700 hover:bg-green-900 transition duration-300 transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13M12 6.253a5.253 5.253 0 014.253 5.253M12 6.253a5.253 5.253 0 00-4.253 5.253m-4.004 0a5.253 5.253 0 018.507 0m-8.507 0C6.545 11.5 6 12.723 6 14">
                                </path>
                            </svg>
                            View All Courses
                        </a>
                    </div>
                </div>
            </div>

            {{-- PHP Block to prepare live session data --}}
            @php
                // Collect all live sessions that haven't ended yet from all enrolled courses
$upcomingSessions = collect();
foreach ($enrolledCourses as $course) {
    $upcomingSessions = $upcomingSessions->merge(
        $course->liveSessions->filter(function ($session) {
            // Filter sessions whose end time is in the future
            return $session->start_time->addMinutes($session->duration_minutes)->isFuture();
        }),
    );
}
// Sort them by start time, earliest first
$upcomingSessions = $upcomingSessions->sortBy('start_time');
            @endphp

            {{-- Upcoming Live Sessions Section --}}
            @if ($upcomingSessions->isNotEmpty())
                <h2 class="text-3xl font-extrabold text-indigo-700 mb-6 mt-8 animate-fadeInDown">Upcoming Live Sessions 🚀
                </h2>
                <div class="space-y-4 mb-12">
                    @foreach ($upcomingSessions as $liveSession)
                        @include('pages.student.live_sessions.show', ['liveSession' => $liveSession])
                    @endforeach
                </div>
                <hr class="border-gray-300 my-10">
            @endif

            <h2 class="text-3xl font-extrabold text-gray-900 mb-8 mt-12 animate-fadeInDown">Your Current Courses</h2>

            <div class="grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($enrolledCourses as $course)
                    <div
                        class="bg-white overflow-hidden rounded-2xl shadow-xl border border-gray-200 flex flex-col transform transition duration-500 hover:scale-[1.03] hover:shadow-2xl animate-fadeInUp delay-{{ $loop->index * 100 }}">
                        <img src="{{ asset('/' . $course->thumbnail) }}" alt="{{ $course->title }}"
                            class="h-48 w-full object-cover rounded-t-2xl">
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="font-bold text-2xl text-gray-900 leading-snug">{{ $course->title }}</h3>
                            <p class="mt-2 text-sm text-gray-500 italic">By {{ $course->instructor->name }}</p>

                            {{-- Progress Bar --}}
                            @php
                                $progress = $course->getProgressFor(auth()->user());
                                $progressBarColor = $progress == 100 ? 'bg-emerald-500' : 'bg-yellow-500';
                            @endphp
                            <div class="mt-6">
                                <div class="flex justify-between mb-2">
                                    <span class="text-base font-semibold text-gray-700">Progress</span>
                                    <span
                                        class="text-sm font-semibold {{ $progress == 100 ? 'text-green-700' : 'text-yellow-600' }}">{{ round($progress) }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5 shadow-inner">
                                    <div class="{{ $progressBarColor }} h-2.5 rounded-full transition-all duration-500 ease-in-out"
                                        style="width: {{ $progress }}%"></div>
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="mt-8 flex-grow flex items-end space-y-3 flex-col w-full">

                                {{-- 1. Continue Learning Link - FIXED: Check if lessons exist --}}
                                @if ($course->lessons->isNotEmpty())
                                    <a href="{{ route('learning.lesson', [$course, $course->lessons->first()]) }}"
                                        class="w-full text-center rounded-lg bg-green-700 px-4 py-3 text-sm font-bold text-white shadow-lg hover:bg-emerald-700 transition-all duration-300 transform hover:scale-[1.01]">
                                        Continue Learning
                                    </a>
                                @else
                                    <button disabled
                                        class="w-full text-center rounded-lg bg-gray-400 px-4 py-3 text-sm font-bold text-white cursor-not-allowed">
                                        No Lessons Available Yet
                                    </button>
                                @endif

                                {{-- 2. Quiz/Exam Link with Certificate Download --}}
                                @if ($course->quiz)
                                    @php
                                        $latestAttempt = $course->quiz->attempts->first();
                                        $quizCompleted = !is_null($latestAttempt);
                                        $quizPassed = $latestAttempt && $latestAttempt->passed;
                                    @endphp

                                    @if ($quizCompleted)
                                        @if ($quizPassed)
                                            {{-- Passed - Show certificate download option --}}
                                            <div class="w-full space-y-2">
                                                <button disabled
                                                    class="w-full text-center rounded-lg bg-green-700 px-4 py-3 text-sm font-bold text-white cursor-not-allowed">
                                                    ✓ Exam Passed ({{ $latestAttempt->percentage_score }}%)
                                                </button>
                                                <a href="{{ route('certificates.download', $latestAttempt->id) }}"
                                                    class="w-full text-center rounded-lg bg-yellow-500 px-4 py-3 text-sm font-bold text-white shadow-lg hover:bg-yellow-400 transition-all duration-300 transform hover:scale-[1.01] flex items-center justify-center gap-2">
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                    Download Certificate
                                                </a>
                                            </div>
                                        @else
                                            {{-- Failed - Show status --}}
                                            <button disabled
                                                class="w-full text-center rounded-lg bg-red-600 px-4 py-3 text-sm font-bold text-white cursor-not-allowed">
                                                Exam Completed ({{ $latestAttempt->percentage_score }}%)
                                            </button>
                                        @endif
                                    @else
                                        {{-- Not attempted yet --}}
                                        <a href="{{ route('quizzes.show', $course->quiz->id) }}"
                                            class="w-full text-center rounded-lg bg-yellow-500 px-4 py-3 text-sm font-bold text-white shadow-lg hover:bg-yellow-400 transition-all duration-300 transform hover:scale-[1.01]">
                                            Take Final Exam
                                        </a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div
                        class="col-span-1 sm:col-span-2 lg:col-span-3 text-center py-20 bg-white rounded-2xl shadow-xl border border-gray-200 animate-fadeInUp">
                        <p class="text-2xl text-gray-500 font-medium mb-6">You aren't enrolled in any courses yet.</p>
                        <a href="{{ route('courses.index') }}"
                            class="mt-6 inline-block rounded-full bg-green-700 px-8 py-4 text-base font-semibold text-white shadow-xl hover:bg-emerald-700 transition-all duration-300 transform hover:scale-105">
                            Browse the Course Catalog
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        .animate-fadeInDown {
            animation: fadeInDown 0.6s ease-out forwards;
        }

        .delay-0 {
            animation-delay: 0s;
        }

        .delay-100 {
            animation-delay: 0.1s;
        }

        .delay-200 {
            animation-delay: 0.2s;
        }

        .delay-300 {
            animation-delay: 0.3s;
        }

        .delay-400 {
            animation-delay: 0.4s;
        }

        .delay-500 {
            animation-delay: 0.5s;
        }

        .delay-600 {
            animation-delay: 0.6s;
        }
    </style>
@endsection
