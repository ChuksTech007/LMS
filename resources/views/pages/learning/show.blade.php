@extends('layouts.app')

@section('title', $currentLesson->title)

@section('content')
    {{-- Main container. On small screens, it's a vertical column. On large screens, it's a horizontal row.
             h-screen ensures the container takes up the full viewport height. --}}
    <div class="flex flex-col lg:flex-row h-screen">

        {{-- Sidebar for course lessons --}}
        {{-- On small screens, the sidebar takes up the full width. On large screens, it has a fixed width.
                 The overflow-y-auto class is now more effective with the h-screen on the parent. --}}
        <aside class="w-full lg:w-80 flex-shrink-0 bg-white lg:border-r lg:border-gray-200 overflow-y-auto shadow-lg animate-slideInLeft">
            <div class="p-4 bg-green-800 text-white sticky top-0 z-10">
                <h3 class="text-lg font-bold">{{ $course->title }}</h3>
                <p class="text-sm text-gray-200 mt-1">By {{ $course->instructor->name }}</p>
            </div>
            <nav class="mt-4">
                <ul>
                    @foreach ($course->lessons as $lesson_item)
                        <li>
                            <a href="{{ route('learning.lesson', [$course, $lesson_item]) }}"
                                class="flex items-center p-4 text-sm font-medium transition-colors duration-200
                                {{ $lesson_item->id === $currentLesson->id
                                    ? 'bg-yellow-100 text-green-900 border-l-4 border-yellow-500 font-bold'
                                    : 'text-gray-600 hover:bg-gray-100 hover:text-green-900 hover:border-l-4 hover:border-green-500' }}">

                                @if (auth()->user()->completedLessons->contains($lesson_item))
                                    {{-- Completed Icon - Using FUTO green for consistency --}}
                                    <svg class="h-5 w-5 mr-3 flex-shrink-0 text-green-500" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                            clip-rule="evenodd" />
                                    </svg>
                                @else
                                    {{-- Default Icon - Using a more subtle gray for contrast --}}
                                    <svg class="h-5 w-5 mr-3 flex-shrink-0 text-gray-400" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                @endif
                                <span class="truncate">{{ $lesson_item->title }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>
            
            {{-- ADDED PAST QUIZZES LINK --}}
            <div class="px-4 py-3 border-t border-gray-200 mt-4">
                <a href="{{ route('quizzes.past', $course) }}"
                    class="flex items-center text-sm font-bold text-green-700 hover:text-green-900 transition-colors duration-200">
                    <svg class="h-5 w-5 mr-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    View Past Quizzes & Results
                </a>
            </div>
        </aside>

        {{-- Main content area --}}
        <main class="flex-1 p-6 lg:p-10 overflow-y-auto w-full animate-fadeIn">
            @if (session('success'))
                <div class="mb-4 rounded-md bg-yellow-50 p-4 animate-bounceIn">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            {{-- Success Icon using FUTO colors --}}
                            <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-yellow-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif
            <div class="max-w-4xl mx-auto">
                <h1 class="text-3xl font-bold text-gray-900">{{ $currentLesson->title }}</h1>
                @if (!auth()->user()->completedLessons->contains($currentLesson))
                    <form action="{{ route('learning.complete', [$course, $currentLesson]) }}" method="POST"
                        class="mt-4">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center rounded-md bg-yellow-400 px-4 py-2 text-sm font-semibold text-green-900 shadow-sm hover:bg-yellow-500 hover:scale-105 transition-all duration-300">
                            Mark as Completed
                        </button>
                    </form>
                @else
                    <div
                        class="mt-4 inline-flex items-center rounded-md bg-green-50 px-3 py-2 text-sm font-semibold text-green-700 ring-1 ring-inset ring-green-600/20 animate-fadeIn">
                        You have completed this lesson.
                    </div>
                @endif
                <p class="text-sm text-gray-500 mt-2">Duration: {{ $currentLesson->duration_in_minutes }} minutes</p>

                <a href="{{ route('student.dashboard') }}"
                    class="inline-flex items-center text-sm font-semibold text-gray-600 hover:text-gray-800 transition-colors duration-200 mt-1">
                    &larr; Back to Dashboard
                </a>

                <div class="prose lg:prose-xl mt-8">
                    {!! nl2br(e($currentLesson->content)) !!}
                </div>

                @if ($currentLesson->video_url)
                    <div class="mt-8 mx-auto max-w-4xl rounded-lg overflow-hidden shadow-xl animate-zoomIn">
                        <div class="w-full h-[300px] sm:h-[400px] md:h-[500px] lg:h-[600px]">
                            @php
                                $videoUrl = $currentLesson->video_url;
                                $embedHtml = '';

                                // YouTube
                                if (preg_match('/(youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $videoUrl, $matches)) {
                                    $videoId = $matches[2];
                                    $embedHtml = '<iframe src="https://www.youtube.com/embed/'.$videoId.'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="w-full h-full"></iframe>';
                                }
                                // Google Drive
                                elseif (preg_match('/drive\.google\.com\/file\/d\/([a-zA-Z0-9_-]+)/', $videoUrl, $matches)) {
                                    $fileId = $matches[1];
                                    $embedHtml = '<iframe src="https://drive.google.com/file/d/'.$fileId.'/preview" frameborder="0" allowfullscreen class="w-full h-full"></iframe>';
                                }
                            @endphp

                            @if ($embedHtml)
                                {!! $embedHtml !!}
                            @else
                                <p>This video link is from an unsupported platform.</p>
                            @endif
                        </div>
                    </div>
                @endif


                <div class="mt-12 border-t border-gray-200 pt-8 animate-fadeInUp">
                    <h3 class="text-xl font-bold text-gray-900">Leave a Review</h3>
                    @if (session('success'))
                        <p class="mt-2 text-sm text-green-600">{{ session('success') }}</p>
                    @endif

                    <form action="{{ route('courses.reviews.store', $course) }}" method="POST" class="mt-4 space-y-4">
                        @csrf
                        <div>
                            <label for="rating" class="block text-sm font-medium text-gray-700">Your Rating</label>
                            <div class="flex items-center mt-1">
                                <select name="rating" id="rating"
                                    class="rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 px-3 py-2">
                                    <option value="5">5 Stars</option>
                                    <option value="4">4 Stars</option>
                                    <option value="3">3 Stars</option>
                                    <option value="2">2 Stars</option>
                                    <option value="1">1 Star</option>
                                </select>
                            </div>
                            @error('rating')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="comment" class="block text-sm font-medium text-gray-700">Your Comment</label>
                            <textarea name="comment" id="comment" rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:outline-none focus:ring-0 focus:border-transparent px-3 py-2"></textarea>
                            @error('comment')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit"
                            class="inline-flex items-center rounded-md border border-transparent bg-green-900 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-green-800 hover:scale-105 transition-all duration-300">Submit
                            Review</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
<style>
/* Base animation styles remain, but color references were updated in the HTML for Tailwind classes */
@keyframes slideInLeft {
    0% { opacity: 0; transform: translateX(-20px); }
    100% { opacity: 1; transform: translateX(0); }
}
@keyframes fadeIn {
    0% { opacity: 0; }
    100% { opacity: 1; }
}
@keyframes bounceIn {
    0% { transform: scale(0.8); opacity: 0; }
    60% { transform: scale(1.05); opacity: 1; }
    100% { transform: scale(1); }
}
@keyframes zoomIn {
    0% { transform: scale(0.95); opacity: 0; }
    100% { transform: scale(1); opacity: 1; }
}
.animate-slideInLeft { animation: slideInLeft 0.8s ease-out; }
.animate-fadeIn { animation: fadeIn 0.8s ease-out; }
.animate-bounceIn { animation: bounceIn 0.5s ease-out; }
.animate-zoomIn { animation: zoomIn 0.6s ease-out; }
.hover\:scale-105:hover {
    transform: scale(1.05);
}
</style>
@endsection