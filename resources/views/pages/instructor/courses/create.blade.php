@extends('layouts.app')

@section('title', 'Add New Course')

@section('content')
	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
				<div class="p-6 text-gray-900">
					<h2 class="text-2xl font-semibold mb-6">Add New Course</h2>

					<form action="{{ route('instructor.courses.store') }}" method="POST" enctype="multipart/form-data"
						class="space-y-6">
						@csrf
						@include('pages.instructor.courses.partials._form')
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection