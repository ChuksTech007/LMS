@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="mb-6">
				<h2 class="text-2xl font-semibold text-gray-900">Admin Dashboard</h2>
				<p class="mt-1 text-sm text-gray-600">Ringkasan data platform Skoolio.</p>
			</div>

			{{-- Stats Cards --}}
			<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
				{{-- Total Students --}}
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
									<dt class="truncate text-sm font-medium text-gray-500">Total Siswa</dt>
									<dd>
										<div class="text-lg font-medium text-gray-900">{{ $stats['total_students'] }}</div>
									</dd>
								</dl>
							</div>
						</div>
					</div>
				</div>

				{{-- Total Instructors --}}
				<div class="overflow-hidden rounded-lg bg-white shadow">
					<div class="p-5">
						<div class="flex items-center">
							<div class="flex-shrink-0">
								<svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
									stroke="currentColor">
									<path stroke-linecap="round" stroke-linejoin="round"
										d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
								</svg>
							</div>
							<div class="ml-5 w-0 flex-1">
								<dl>
									<dt class="truncate text-sm font-medium text-gray-500">Total Pengajar</dt>
									<dd>
										<div class="text-lg font-medium text-gray-900">{{ $stats['total_instructors'] }}
										</div>
									</dd>
								</dl>
							</div>
						</div>
					</div>
				</div>

				{{-- Total Courses --}}
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
									<dt class="truncate text-sm font-medium text-gray-500">Total Kursus</dt>
									<dd>
										<div class="text-lg font-medium text-gray-900">{{ $stats['total_courses'] }}</div>
									</dd>
								</dl>
							</div>
						</div>
					</div>
				</div>

				{{-- Total Enrollments --}}
				<div class="overflow-hidden rounded-lg bg-white shadow">
					<div class="p-5">
						<div class="flex items-center">
							<div class="flex-shrink-0">
								<svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
									stroke="currentColor">
									<path stroke-linecap="round" stroke-linejoin="round"
										d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.627 48.627 0 0 1 12 20.904a48.627 48.627 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.57 50.57 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
								</svg>
							</div>
							<div class="ml-5 w-0 flex-1">
								<dl>
									<dt class="truncate text-sm font-medium text-gray-500">Total Pendaftaran</dt>
									<dd>
										<div class="text-lg font-medium text-gray-900">{{ $stats['total_enrollments'] }}
										</div>
									</dd>
								</dl>
							</div>
						</div>
					</div>
				</div>

				<div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
					<div class="p-6 border-b border-gray-200">
						<h3 class="text-lg font-semibold leading-6 text-gray-900">Menu Manajemen</h3>
						<div class="mt-4">
							<a href="{{ route('admin.users.index') }}"
								class="text-indigo-600 hover:text-indigo-800 font-medium">Kelola Pengguna & Peran &rarr;</a>
							<br>
							<a href="{{ route('admin.courses.index') }}"
								class="text-indigo-600 hover:text-indigo-800 font-medium mt-2 inline-block">Kelola Semua
								Kursus &rarr;</a>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
@endsection