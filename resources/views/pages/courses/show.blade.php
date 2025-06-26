@extends('layouts.app')

@section('title', $course->title)

@section('content')
	<div class="bg-white">
		@if (session('success'))
			<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 mb-4">
				<div class="rounded-md bg-green-50 p-4">
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
			<div class="mx-auto mt-6 max-w-2xl sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-3 lg:gap-x-8 lg:px-8">
				<div class="aspect-h-4 aspect-w-3 hidden overflow-hidden rounded-lg lg:block">
					<img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}"
						class="h-full w-full object-cover object-center">
				</div>
				<div class="lg:col-span-2 lg:border-r lg:border-gray-200 lg:pr-8">
					<h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">{{ $course->title }}</h1>
					<h3 class="text-lg font-medium text-gray-700 mt-2">Oleh {{ $course->instructor->name }}</h3>
					<div class="mt-4">
						<h3 class="sr-only">Reviews</h3>
						<div class="flex items-center">
							<div class="flex items-center">
								@for ($i = 1; $i <= 5; $i++)
									<svg class="h-5 w-5 flex-shrink-0 {{ $course->reviews->avg('rating') >= $i ? 'text-yellow-400' : 'text-gray-300' }}"
										viewBox="0 0 20 20" fill="currentColor">
										<path fill-rule="evenodd"
											d="M10.868 2.884c.321-.662 1.215-.662 1.536 0l1.83 3.75 4.145.602c.73.106 1.02.998.494 1.503l-2.998 2.922.708 4.128c.125.726-.638 1.28-1.286.945l-3.708-1.95-3.708 1.95c-.648.335-1.41-.22-1.286-.945l.708-4.128L2.39 8.94c-.527-.505-.236-1.397.494-1.503l4.145-.602 1.83-3.75z"
											clip-rule="evenodd" />
									</svg>
								@endfor
							</div>
							<p class="ml-2 text-sm text-gray-500">{{ $course->reviews->count() }} ulasan</p>
						</div>
					</div>
					<p class="text-3xl tracking-tight text-gray-900 mt-4">Rp
						{{ number_format($course->price, 0, ',', '.') }}
					</p>
					<div class="mt-10">
						@guest
							<a href="{{ route('login') }}"
								class="flex w-full items-center justify-center rounded-md border border-transparent bg-gray-400 px-8 py-3 text-base font-medium text-white cursor-not-allowed">
								Login untuk Mendaftar
							</a>
						@endguest

						@auth
							@if (auth()->user()->enrolledCourses->contains($course))
								@if ($course->lessons->isNotEmpty())
									<a href="{{ route('learning.lesson', [$course, $course->lessons->first()]) }}"
										class="flex w-full items-center justify-center rounded-md border border-transparent bg-green-600 px-8 py-3 text-base font-medium text-white hover:bg-green-700">
										Lanjutkan Belajar
									</a>
								@else
									<span
										class="flex w-full items-center justify-center rounded-md border border-transparent bg-gray-400 px-8 py-3 text-base font-medium text-white cursor-not-allowed">
										Kurikulum belum tersedia
									</span>
								@endif
							@else
								<form action="{{ route('courses.enroll', $course) }}" method="POST">
									@csrf
									<button type="submit"
										class="flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-base font-medium text-white hover:bg-indigo-700">
										Daftar Kursus Ini
									</button>
								</form>
							@endif
						@endauth
					</div>
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

					<div class="mt-16">
						<h2 class="text-xl font-bold text-gray-900">Ulasan dari Siswa</h2>
						<div class="mt-6 space-y-10 divide-y divide-gray-200 border-b border-t border-gray-200 pb-10">
							@forelse ($course->reviews as $review)
								<div class="pt-10">
									<div class="flex items-center">
										<div class="font-medium text-gray-900">{{ $review->user->name }}</div>
										<div class="ml-4 flex items-center">
											@for ($i = 1; $i <= 5; $i++)
												<svg class="h-5 w-5 flex-shrink-0 {{ $review->rating >= $i ? 'text-yellow-400' : 'text-gray-300' }}"
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
								<p class="pt-10 text-center text-gray-500">Jadilah yang pertama memberikan ulasan untuk kursus
									ini!</p>
							@endforelse
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection