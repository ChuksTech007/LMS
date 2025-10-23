@extends('layouts.app')

@section('title', 'Edit Courses')

@section('content')
	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

			{{-- Example: Inside resources/views/pages/instructor/courses/edit.blade.php --}}

<div class="flex justify-end mb-6">
    <a href="{{ route('instructor.live-sessions.create', $course) }}" 
       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 transition">
        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Schedule Live Session
    </a>
</div>

			<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
				<div class="p-6 text-gray-900">
					<h2 class="text-2xl font-semibold mb-6">Edit Courses: {{ $course->title }}</h2>

					<form action="{{ route('instructor.courses.update', $course) }}" method="POST"
						enctype="multipart/form-data" class="space-y-6">
						@csrf
						@method('PUT')
						@include('pages.instructor.courses.partials._form')
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection