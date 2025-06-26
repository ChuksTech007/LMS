@extends('layouts.app')

@section('title', 'Katalog Kursus')

@section('content')
	<div class="bg-white">
		<div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
			<h2 class="text-2xl font-bold tracking-tight text-gray-900">Katalog Kursus Skoolio</h2>

			<div class="py-4 border-b border-t border-gray-200 my-6">
				<div class="flex flex-wrap items-center gap-2">
					<span class="text-sm font-medium mr-2">Filter Kategori:</span>
					<a href="{{ route('courses.index') }}"
						class="rounded-full px-3 py-1 text-sm transition-colors
					  {{ !request('category') ? 'bg-indigo-600 text-white hover:bg-indigo-700' : 'bg-white text-gray-600 hover:bg-gray-100 ring-1 ring-inset ring-gray-300' }}">
						Semua
					</a>
					@foreach ($categories as $category)
						<a href="{{ route('courses.index', ['category' => $category->slug]) }}"
							class="rounded-full px-3 py-1 text-sm transition-colors
							  {{ request('category') == $category->slug ? 'bg-indigo-600 text-white hover:bg-indigo-700' : 'bg-white text-gray-600 hover:bg-gray-100 ring-1 ring-inset ring-gray-300' }}">
							{{ $category->name }}
						</a>
					@endforeach
				</div>
			</div>

			<div class="mt-6 mb-8">
				<form action="{{ route('courses.index') }}" method="GET">
					<div class="flex rounded-md shadow-sm">
						<div class="relative flex flex-grow items-stretch focus-within:z-10">
							<input type="search" name="search" id="search"
								class="block w-full rounded-none rounded-l-md border-0 py-2 px-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm"
								placeholder="Cari kursus..." value="{{ request('search') }}">
						</div>
						<button type="submit"
							class="relative -ml-px inline-flex items-center gap-x-1.5 rounded-r-md px-3 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
							<svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
								<path fill-rule="evenodd"
									d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
									clip-rule="evenodd" />
							</svg>
							Cari
						</button>
					</div>
				</form>
			</div>

			@if (request('search'))
				<p class="mb-6 text-sm text-gray-700">
					Menampilkan hasil pencarian untuk: <span class="font-bold">{{ request('search') }}</span>
					<a href="{{ route('courses.index') }}" class="ml-2 text-indigo-600 hover:text-indigo-800 text-xs">[Hapus
						Filter]</a>
				</p>
			@endif

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
				{{ $courses->appends(request()->query())->links() }}
			</div>
		</div>
	</div>
@endsection