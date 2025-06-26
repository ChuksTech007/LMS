@extends('layouts.app')
@section('title', 'Tambah Kategori')
@section('content')
	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<h2 class="text-2xl font-semibold text-gray-900 mb-6">Tambah Kategori Baru</h2>
			<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
				<form action="{{ route('admin.categories.store') }}" method="POST">
					@csrf
					@include('pages.admin.categories.partials._form')
				</form>
			</div>
		</div>
	</div>
@endsection