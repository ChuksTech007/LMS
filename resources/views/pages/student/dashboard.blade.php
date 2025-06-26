@extends('layouts.app')

@section('title', 'Kursus Saya')

@section('content')
	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<h2 class="text-2xl font-semibold text-gray-900 mb-6">Kursus yang Saya Ikuti</h2>

			<div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
				@forelse ($enrolledCourses as $course)
					<div class="bg-white overflow-hidden shadow-sm rounded-lg flex flex-col">
						<img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}"
							class="h-48 w-full object-cover">
						<div class="p-6 flex flex-col flex-grow">
							<h3 class="font-semibold text-lg text-gray-900">{{ $course->title }}</h3>
							<p class="mt-1 text-sm text-gray-500">Oleh {{ $course->instructor->name }}</p>

							{{-- Progress Bar --}}
							@php
								$progress = $course->getProgressFor(auth()->user());
							@endphp
							<div class="mt-4">
								<div class="flex justify-between mb-1">
									<span class="text-base font-medium text-indigo-700">Progres</span>
									<span class="text-sm font-medium text-indigo-700">{{ round($progress) }}%</span>
								</div>
								<div class="w-full bg-gray-200 rounded-full h-2.5">
									<div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ $progress }}%"></div>
								</div>
							</div>

							<div class="mt-6 flex-grow flex items-end">
								@if ($course->lessons->isNotEmpty())
									<a href="{{ route('learning.lesson', [$course, $course->lessons->first()]) }}"
										class="w-full text-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
										Lanjutkan Belajar
									</a>
								@endif
							</div>
						</div>
					</div>
				@empty
					<div class="col-span-3 text-center py-12">
						<p class="text-gray-500">Anda belum terdaftar di kursus manapun.</p>
						<a href="{{ route('courses.index') }}"
							class="mt-4 inline-block rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
							Lihat Katalog Kursus
						</a>
					</div>
				@endforelse
			</div>
		</div>
	</div>
@endsection