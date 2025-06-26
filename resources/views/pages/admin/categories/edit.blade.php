@extends('layouts.app')
@section('title', 'Edit Kategori')
@section('content')
	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<h2 class="text-2xl font-semibold text-gray-900 mb-6">Edit Kategori: {{ $category->name }}</h2>
			<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
				<form action="{{ route('admin.categories.update', $category) }}" method="POST">
					@csrf
					@method('PUT')
					@include('pages.admin.categories.partials._form')
				</form>
			</div>
		</div>
	</div>
@endsection