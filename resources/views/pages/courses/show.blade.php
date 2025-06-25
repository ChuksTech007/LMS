@extends('layouts.app')

@section('title', $course->title)

@section('content')
	<div class="bg-white">
		<div class="pt-6">
			<div class="mx-auto mt-6 max-w-2xl sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-3 lg:gap-x-8 lg:px-8">
				<div class="aspect-h-4 aspect-w-3 hidden overflow-hidden rounded-lg lg:block">
					<img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}"
						class="h-full w-full object-cover object-center">
				</div>
				<div class="lg:col-span-2 lg:border-r lg:border-gray-200 lg:pr-8">
					<h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">{{ $course->title }}</h1>
					<h3 class="text-lg font-medium text-gray-700 mt-2">Oleh {{ $course->instructor->name }}</h3>
					<p class="text-3xl tracking-tight text-gray-900 mt-4">Rp
						{{ number_format($course->price, 0, ',', '.') }}</p>
					<button type="submit"
						class="mt-10 flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-base font-medium text-white hover:bg-indigo-700">Daftar
						Kursus Ini</button>
				</div>
			</div>

			<div
				class="mx-auto max-w-2xl px-4 pb-16 pt-10 sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-3 lg:grid-rows-[auto,auto,1fr] lg:gap-x-8 lg:px-8 lg:pb-24 lg:pt-16">
				<div class="lg:col-span-2 lg:border-r lg:border-gray-200 lg:pr-8">
					<div class="py-10 lg:pt-6 lg:pb-16">
						<div class="space-y-6">
							<p class="text-base text-gray-900">{{ $course->description }}</p>
						</div>
					</div>

					<div class="mt-10">
						<h2 class="text-xl font-bold text-gray-900">Kurikulum Kursus</h2>
						<ul role="list" class="divide-y divide-gray-200 mt-4">
							@foreach ($course->lessons as $lesson)
								<li class="flex py-4">
									<svg class="h-6 w-6 text-indigo-500 mr-3" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
										stroke="currentColor">
										<path stroke-linecap="round" stroke-linejoin="round"
											d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9A2.25 2.25 0 0 0 13.5 5.25h-9A2.25 2.25 0 0 0 2.25 7.5v9A2.25 2.25 0 0 0 4.5 18.75Z" />
									</svg>
									<div class="ml-3">
										<p class="text-sm font-medium text-gray-900">{{ $lesson->title }}</p>
										<p class="text-sm text-gray-500">{{ $lesson->duration_in_minutes }} Menit</p>
									</div>
								</li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection