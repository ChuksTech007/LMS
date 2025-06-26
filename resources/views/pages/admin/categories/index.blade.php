@extends('layouts.app')
@section('title', 'Manajemen Kategori')
@section('content')
	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			{{-- ... (kode flash message success & error bisa ditaruh di sini) ... --}}
			<div class="flex justify-between items-center mb-6">
				<h2 class="text-2xl font-semibold text-gray-900">Kategori Kursus</h2>
				<a href="{{ route('admin.categories.create') }}"
					class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white">Tambah
					Kategori</a>
			</div>
			<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
				{{-- Tabel untuk menampilkan kategori --}}
			</div>
		</div>
	</div>
@endsection