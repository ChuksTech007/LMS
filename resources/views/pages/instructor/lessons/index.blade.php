@extends('layouts.app')

@section('title', 'Manajemen Kurikulum')

@section('content')
	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			@if (session('success'))
				<div class="mb-6 rounded-md bg-green-50 p-4">
					<div class="flex">
						<div class="flex-shrink-0">
							<svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
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
			<div class="flex justify-between items-center mb-6">
				<div>
					<h2 class="text-2xl font-semibold text-gray-900">
						Kurikulum: {{ $course->title }}
					</h2>
					<a href="{{ route('instructor.courses.index') }}"
						class="text-sm text-indigo-600 hover:text-indigo-900">&larr; Kembali ke Daftar Kursus</a>
				</div>
				<a href="{{ route('instructor.courses.lessons.create', $course) }}"
					class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
					Tambah Pelajaran Baru
				</a>
			</div>

			<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
				<div class="p-6 text-gray-900">
					@if($lessons->isEmpty())
						<p class="text-center text-gray-500">Belum ada pelajaran di kursus ini.</p>
					@else
						<ul role="list" class="divide-y divide-gray-100">
							@foreach($lessons as $lesson)
								<li class="flex justify-between gap-x-6 py-5">
									<div class="flex min-w-0 gap-x-4">
										<div class="min-w-0 flex-auto">
											<p class="text-sm font-semibold leading-6 text-gray-900">{{ $lesson->title }}</p>
											<p class="mt-1 truncate text-xs leading-5 text-gray-500">
												{{ $lesson->duration_in_minutes }} menit
											</p>
										</div>
									</div>
									<div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
										<div class="flex items-center">
											<a href="{{ route('instructor.courses.lessons.edit', [$course, $lesson]) }}"
												class="text-indigo-600 hover:text-indigo-900">Edit</a>

											<form action="{{ route('instructor.courses.lessons.destroy', [$course, $lesson]) }}"
												method="POST"
												onsubmit="return confirm('Apakah Anda yakin ingin menghapus pelajaran ini?');">
												@csrf
												@method('DELETE')
												<button type="submit" class="ml-4 text-red-600 hover:text-red-900">Hapus</button>
											</form>
										</div>
									</div>
								</li>
							@endforeach
						</ul>
					@endif
				</div>
			</div>
		</div>
	</div>
@endsection