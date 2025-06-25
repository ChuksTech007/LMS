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

										@if(auth()->user()->completedLessons->contains($lesson_item))
											{{-- Completed Icon --}}
											<svg class="h-5 w-5 mr-3 flex-shrink-0 text-green-500" viewBox="0 0 20 20" fill="currentColor">
												<path fill-rule="evenodd"
													d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
													clip-rule="evenodd" />
											</svg>
										@else
											{{-- Default Icon --}}
											<svg class="h-5 w-5 mr-3 flex-shrink-0 text-gray-400" fill="none" viewBox="0 0 24 24"
												stroke="currentColor">
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
		</aside>

		<main class="flex-1 p-6 lg:p-10 overflow-y-auto">
			@if (session('success'))
				<div class="mb-4 rounded-md bg-green-50 p-4">
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
			@endif
			<div class="max-w-4xl mx-auto">
				<h1 class="text-3xl font-bold text-gray-900">{{ $currentLesson->title }}</h1>
				@if (!auth()->user()->completedLessons->contains($currentLesson))
					<form action="{{ route('learning.complete', [$course, $currentLesson]) }}" method="POST" class="mt-4">
						@csrf
						<button type="submit"
							class="inline-flex items-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-700">
							Tandai Telah Selesai
						</button>
					</form>
				@else
					<div
						class="mt-4 inline-flex items-center rounded-md bg-green-50 px-3 py-2 text-sm font-semibold text-green-700 ring-1 ring-inset ring-green-600/20">
						Anda telah menyelesaikan pelajaran ini
					</div>
				@endif
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