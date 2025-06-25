@extends('layouts.app')

@section('title', 'Tambah Pelajaran Baru')

@section('content')
	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
				<div class="p-6 text-gray-900">
					<h2 class="text-2xl font-semibold mb-2">Tambah Pelajaran ke Kursus: {{ $course->title }}</h2>
					<a href="{{ route('instructor.courses.lessons.index', $course) }}"
						class="text-sm text-indigo-600 hover:text-indigo-900">&larr; Kembali ke Kurikulum</a>

					<form action="{{ route('instructor.courses.lessons.store', $course) }}" method="POST"
						class="mt-6 space-y-6">
						@csrf
						@include('pages.instructor.lessons.partials._form')
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection