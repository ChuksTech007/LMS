@extends('layouts.app')

@section('title', 'Instructor Dashboard')

@section('content')
	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="mb-6">
				<h2 class="text-2xl font-semibold text-gray-900">
					Selamat Datang, Instruktur {{ auth()->user()->name }}!
				</h2>
				<p class="mt-1 text-sm text-gray-600">Ini adalah ringkasan dari aktivitas mengajar Anda.</p>
			</div>

			{{-- Stats Cards --}}
			<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
				<div class="overflow-hidden rounded-lg bg-white shadow">
					<div class="p-5">
						<div class="flex items-center">
							<div class="flex-shrink-0">
								<svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
									stroke="currentColor">
									<path stroke-linecap="round" stroke-linejoin="round"
										d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
								</svg>
							</div>
							<div class="ml-5 w-0 flex-1">
								<dl>
									<dt class="truncate text-sm font-medium text-gray-500">Total Kursus Anda</dt>
									<dd>
										<div class="text-lg font-medium text-gray-900">{{ $stats['total_courses'] }}</div>
									</dd>
								</dl>
							</div>
						</div>
					</div>
				</div>

				<div class="overflow-hidden rounded-lg bg-white shadow">
					<div class="p-5">
						<div class="flex items-center">
							<div class="flex-shrink-0">
								<svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
									stroke="currentColor">
									<path stroke-linecap="round" stroke-linejoin="round"
										d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
								</svg>
							</div>
							<div class="ml-5 w-0 flex-1">
								<dl>
									<dt class="truncate text-sm font-medium text-gray-500">Total Pelajaran</dt>
									<dd>
										<div class="text-lg font-medium text-gray-900">{{ $stats['total_lessons'] }}</div>
									</dd>
								</dl>
							</div>
						</div>
					</div>
				</div>

				<div class="overflow-hidden rounded-lg bg-white shadow">
					<div class="p-5">
						<div class="flex items-center">
							<div class="flex-shrink-0">
								<svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
									stroke="currentColor">
									<path stroke-linecap="round" stroke-linejoin="round"
										d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
								</svg>
							</div>
							<div class="ml-5 w-0 flex-1">
								<dl>
									<dt class="truncate text-sm font-medium text-gray-500">Total Siswa Unik</dt>
									<dd>
										<div class="text-lg font-medium text-gray-900">{{ $stats['total_students'] }}</div>
									</dd>
								</dl>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
				<div class="p-6">
					<h3 class="text-lg font-semibold">Aksi Cepat</h3>
					<div class="mt-4 flex flex-wrap gap-4">
						<a href="{{ route('instructor.courses.create') }}"
							class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700">Tambah
							Kursus Baru</a>
						<a href="{{ route('instructor.courses.index') }}"
							class="rounded-md bg-white px-3.5 py-2.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Kelola
							Semua Kursus</a>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection