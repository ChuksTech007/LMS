@extends('layouts.app')

@section('title', 'Manajemen Kursus')

@section('content')
	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<h2 class="text-2xl font-semibold text-gray-900 mb-6">Manajemen Kursus Global</h2>

			@if (session('success'))
				{{-- Flash message component --}}
			@endif

			<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
				<div class="text-gray-900">
					<table class="min-w-full divide-y divide-gray-300">
						<thead class="bg-gray-50">
							<tr>
								<th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Judul
								</th>
								<th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Pengajar</th>
								<th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
								<th class="relative py-3.5 pl-3 pr-4 sm:pr-6"><span class="sr-only">Ubah Status</span></th>
							</tr>
						</thead>
						<tbody class="divide-y divide-gray-200 bg-white">
							@forelse ($courses as $course)
								<tr>
									<td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
										{{ $course->title }}</td>
									<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
										{{ $course->instructor->name }}</td>
									<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
										@if($course->is_published)
											<span
												class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">Published</span>
										@else
											<span
												class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800">Unpublished</span>
										@endif
									</td>
									<td
										class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
										<form action="{{ route('admin.courses.toggleStatus', $course) }}" method="POST">
											@csrf
											@method('PATCH')
											<button type="submit" class="text-indigo-600 hover:text-indigo-900">Ubah
												Status</button>
										</form>
									</td>
								</tr>
							@empty
								<tr>
									<td colspan="4" class="text-center py-4 text-gray-500">Tidak ada kursus.</td>
								</tr>
							@endforelse
						</tbody>
					</table>
				</div>
			</div>
			<div class="mt-6">{{ $courses->links() }}</div>
		</div>
	</div>
@endsection