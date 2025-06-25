@extends('layouts.app')

@section('title', 'Katalog Kursus')

@section('content')
	<div class="bg-white">
		<div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
			<h2 class="text-2xl font-bold tracking-tight text-gray-900">Katalog Kursus Skoolio</h2>

			<div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:gap-x-8">
				@forelse ($courses as $course)
					<div class="group relative">
						<div
							class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80">
							<img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}"
								class="h-full w-full object-cover object-center lg:h-full lg:w-full">
						</div>
						<div class="mt-4 flex justify-between">
							<div>
								<h3 class="text-sm text-gray-700">
									<a href="{{ route('courses.show', $course) }}">
										<span aria-hidden="true" class="absolute inset-0"></span>
										{{ $course->title }}
									</a>
								</h3>
								<p class="mt-1 text-sm text-gray-500">Oleh {{ $course->instructor->name }}</p>
							</div>
							<p class="text-sm font-medium text-gray-900">Rp {{ number_format($course->price, 0, ',', '.') }}</p>
						</div>
					</div>
				@empty
					<p class="col-span-3 text-center text-gray-500">Belum ada kursus yang tersedia saat ini.</p>
				@endforelse
			</div>

			<div class="mt-12">
				{{ $courses->links() }}
			</div>
		</div>
	</div>
@endsection