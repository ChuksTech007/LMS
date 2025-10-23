@extends('layouts.app')

@section('title', $course->title)

@section('content')
    <div class="bg-white">
        <!-- Success message alert, styled with FUTO green -->
        @if (session('success'))
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 mb-6 mt-6">
                <div class="bg-green-50 p-4 shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="pt-6">
            <div class="mx-auto mt-6 max-w-2xl sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-3 lg:gap-x-8 lg:px-8 px-4">
                <!-- Course Thumbnail -->
                <div class="aspect-h-4 aspect-w-3 hidden overflow-hidden lg:block shadow-lg">
                    <img src="{{ asset('/' . $course->thumbnail) }}" alt="{{ $course->title }}"
                        class="h-full w-full object-cover object-center">
                </div>

                <!-- Course Details & Enrollment section -->
                <div class="lg:col-span-2 lg:border-r lg:border-gray-200 lg:pr-8">
                    <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">{{ $course->title }}</h1>
                    <h3 class="text-lg font-medium text-gray-700 mt-2">By {{ $course->instructor->name }}</h3>

                    <!-- Reviews section, with FUTO yellow stars -->
                    <div class="mt-4">
                        <h3 class="sr-only">Reviews</h3>
                        <div class="flex items-center">
                            <div class="flex items-center">
                                @for ($i = 1; $i <= 5; $i++)
                                    <svg class="h-5 w-5 flex-shrink-0 {{ $course->reviews->avg('rating') >= $i ? 'text-yellow-500' : 'text-gray-300' }} transition-colors duration-200"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10.868 2.884c.321-.662 1.215-.662 1.536 0l1.83 3.75 4.145.602c.73.106 1.02.998.494 1.503l-2.998 2.922.708 4.128c.125.726-.638 1.28-1.286.945l-3.708-1.95-3.708 1.95c-.648.335-1.41-.22-1.286-.945l.708-4.128L2.39 8.94c-.527-.505-.236-1.397.494-1.503l4.145-.602 1.83-3.75z"
                                            clip-rule="evenodd" />
                                    </svg>
                                @endfor
                            </div>
                            <p class="ml-2 text-sm text-gray-500">{{ $course->reviews->count() }} Reviews</p>
                        </div>
                    </div>

                    <!-- Categories, styled with FUTO yellow -->
                    <div class="mt-4">
                        @foreach ($course->categories as $category)
                            <span
                                class="inline-flex items-center bg-yellow-100 px-3 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-700/10">
                                {{ $category->name }}
                            </span>
                        @endforeach
                    </div>

                    <p class="text-3xl tracking-tight text-gray-900 mt-4">
                        ₦{{ number_format($course->price, 2) }}
                    </p>

                    <!-- Enrollment buttons, styled with FUTO green and hover animation -->
                    <div class="mt-10">
                        @guest
                            <a href="{{ route('login') }}"
                                class="flex w-full items-center justify-center border border-transparent bg-gray-400 px-8 py-3 text-base font-medium text-white cursor-not-allowed transition-all duration-300 hover:scale-105">
                                Login to Register
                            </a>
                        @endguest

                        {{-- Add this to your existing course show page where the enrollment button is --}}

                        @auth
                            @php
                                $user = auth()->user();
                                $isEnrolled = $course->students()->where('user_id', $user->id)->exists();
                                $hasPaid = $user->hasPaidForCourse($course);
                                $pendingPayment = $user->getPendingPaymentForCourse($course);
                            @endphp

                            @if ($isEnrolled)
                                {{-- Already Enrolled --}}
                                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                    <div class="flex items-center">
                                        <svg class="h-5 w-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-green-800 font-semibold">You are enrolled in this course</span>
                                    </div>
                                    @if ($course->lessons->isNotEmpty())
                                        <a href="{{ route('learning.lesson', [$course, $course->lessons->first()]) }}"
                                            class="mt-3 block w-full text-center bg-green-700 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-800 transition duration-200">
                                            Continue Learning
                                        </a>
                                    @else
                                        <div class="mt-3 text-center text-gray-600 text-sm">
                                            Course content is being prepared. You'll be notified when lessons are available.
                                        </div>
                                    @endif
                                </div>
                            @elseif($pendingPayment)
                                {{-- Pending Payment --}}
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                    <div class="flex items-center">
                                        <svg class="h-5 w-5 text-yellow-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-yellow-800 font-semibold">Payment verification pending</span>
                                    </div>
                                    <p class="mt-2 text-sm text-yellow-700">
                                        Your payment is being reviewed. You'll be notified once it's verified.
                                    </p>
                                    <a href="{{ route('payments.show', $pendingPayment) }}"
                                        class="mt-3 inline-block text-yellow-700 hover:text-yellow-900 font-medium text-sm">
                                        View payment status →
                                    </a>
                                </div>
                            @else
                                {{-- Show Payment/Enrollment Button --}}
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                        <span class="text-gray-700 font-medium">Course Price:</span>
                                        <span
                                            class="text-3xl font-bold text-green-700">₦{{ number_format($course->price, 2) }}</span>
                                    </div>

                                    <a href="{{ route('courses.payment.create', $course) }}"
                                        class="block w-full text-center bg-green-700 text-white px-6 py-4 rounded-lg font-bold text-lg hover:bg-green-800 transition duration-200 shadow-lg">
                                        Enroll Now - Pay with Bank Transfer
                                    </a>

                                    <p class="text-sm text-gray-500 text-center">
                                        Secure payment via bank transfer. Instant access after verification.
                                    </p>
                                </div>
                            @endif
                        @else
                            {{-- Not Logged In --}}
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <p class="text-blue-800 font-medium mb-3">Please log in to enroll in this course</p>
                                <a href="{{ route('login') }}"
                                    class="block w-full text-center bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-200">
                                    Log In
                                </a>
                                <p class="mt-2 text-sm text-blue-600 text-center">
                                    Don't have an account? <a href="{{ route('register') }}"
                                        class="font-semibold underline">Register here</a>
                                </p>
                            </div>
                        @endauth
                    </div>
                </div>

                <a href="{{ route('student.dashboard') }}"
                    class="inline-flex items-center text-sm font-semibold text-gray-600 hover:text-gray-800 transition-colors duration-200 mt-8">
                    &larr; Back to Dashboard
                </a>

            </div>

            <div
                class="mx-auto max-w-2xl px-4 pb-16 pt-10 sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-3 lg:grid-rows-[auto,auto,1fr] lg:gap-x-8 lg:px-8 lg:pb-24 lg:pt-16">
                <div class="lg:col-span-2 lg:border-r lg:border-gray-200 lg:pr-8">
                    <!-- Course Description -->
                    <div class="py-10 lg:pt-6 lg:pb-16">
                        <div class="space-y-6">
                            <h2 class="text-xl font-bold text-gray-900">Course Description</h2>
                            <p class="text-base text-gray-900">{{ $course->description }}</p>
                        </div>
                    </div>

                    <!-- Course Curriculum -->
                    <div class="mt-10">
                        <h2 class="text-xl font-bold text-gray-900">Course Curriculum</h2>
                        <ul role="list" class="divide-y divide-gray-200 mt-4">
                            @foreach ($course->lessons as $lesson)
                                <li class="flex py-4">
                                    <svg class="h-6 w-6 text-green-600 mr-3" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9A2.25 2.25 0 0 0 13.5 5.25h-9A2.25 2.25 0 0 0 2.25 7.5v9A2.25 2.25 0 0 0 4.5 18.75Z" />
                                    </svg>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $lesson->title }}</p>
                                        <p class="text-sm text-gray-500">{{ $lesson->duration_in_minutes }} Minute</p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Student Reviews -->
                    <div class="mt-16">
                        <h2 class="text-xl font-bold text-gray-900">Reviews from Students</h2>
                        <div class="mt-6 space-y-10 divide-y divide-gray-200 border-b border-t border-gray-200 pb-10">
                            @forelse ($course->reviews as $review)
                                <div class="pt-10">
                                    <div class="flex items-center">
                                        <div class="font-medium text-gray-900">{{ $review->user->name }}</div>
                                        <div class="ml-4 flex items-center">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="h-5 w-5 flex-shrink-0 {{ $review->rating >= $i ? 'text-yellow-500' : 'text-gray-300' }}"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M10.868 2.884c.321-.662 1.215-.662 1.536 0l1.83 3.75 4.145.602c.73.106 1.02.998.494 1.503l-2.998 2.922.708 4.128c.125.726-.638 1.28-1.286.945l-3.708-1.95-3.708 1.95c-.648.335-1.41-.22-1.286-.945l.708-4.128L2.39 8.94c-.527-.505-.236-1.397.494-1.503l4.145-.602 1.83-3.75z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            @endfor
                                        </div>
                                    </div>
                                    <div class="prose prose-sm mt-4 max-w-none text-gray-500">
                                        <p>{{ $review->comment }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="pt-10 text-center text-gray-500">Be the first to review this course!</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
