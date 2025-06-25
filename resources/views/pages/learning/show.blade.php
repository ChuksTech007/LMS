@extends('layouts.app')

@section('title', $currentLesson->title)

@section('content')
	<div class="flex h-full">
		<aside class="w-80 flex-shrink-0 bg-white border-r border-gray-200 h-full overflow-y-auto">
			<div class="p-4">
				<h3 class="text-lg font-bold text-gray-800">{{ $course->title }}</h3>
				<p class="text-sm text-gray-500 mt-1">Oleh {{ $course->instructor->name }}</p>
			</div>
			<nav class="mt-4">
				<ul>
					@foreach ($course->lessons as $lesson_item)
								<li>
									<a href="{{ route('learning.lesson', [$course, $lesson_item]) }}" class="flex items-center p-4 text-sm font-medium transition-colors duration-200
												  {{ $lesson_item->id === $currentLesson->id
						? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-500'
						: 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
										<svg class="h-5 w-5 mr-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
												d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z">
											</path>
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
												d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
										</svg>
										{{ $lesson_item->title }}
									</a>
								</li>
					@endforeach
				</ul>
			</nav>
		</aside>

		<main class="flex-1 p-6 lg:p-10 overflow-y-auto">
			<div class="max-w-4xl mx-auto">
				<h1 class="text-3xl font-bold text-gray-900">{{ $currentLesson->title }}</h1>
				<p class="text-sm text-gray-500 mt-2">Durasi: {{ $currentLesson->duration_in_minutes }} menit</p>

				<div class="prose lg:prose-xl mt-8">
					{!! nl2br(e($currentLesson->content)) !!}
				</div>

				@if ($currentLesson->video_url)
					<div class="mt-8 aspect-w-16 aspect-h-9">
						{{-- Basic Youtube embed logic --}}
						@php
							$videoId = '';
							if (preg_match('/(youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $currentLesson->video_url, $matches)) {
								$videoId = $matches[2];
							}
						@endphp
						@if ($videoId)
							<iframe src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0"
								allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
								allowfullscreen></iframe>
						@endif
					</div>
				@endif
			</div>
		</main>
	</div>
@endsection