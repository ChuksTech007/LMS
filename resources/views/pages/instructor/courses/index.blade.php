@extends('layouts.app')

@section('title', 'Manajemen Kursus')

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
				<h2 class="text-2xl font-semibold text-gray-900">Kursus Saya</h2>
				<a href="{{ route('instructor.courses.create') }}"
					class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
					Tambah Kursus Baru
				</a>
			</div>

			<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
				<div class="p-6 text-gray-900">
					<div class="flow-root">
						<div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
							<div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
								<table class="min-w-full divide-y divide-gray-300">
									<thead>
										<tr>
											<th scope="col"
												class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Thumbnail
											</th>
											<th scope="col"
												class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
												Judul</th>
											<th scope="col"
												class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Harga</th>
											<th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0"><span
													class="sr-only">Edit</span></th>
										</tr>
									</thead>
									<tbody class="divide-y divide-gray-200">
										@forelse ($courses as $course)
											<tr>
												<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
													@if ($course->thumbnail)
														<img src="{{ asset('storage/' . $course->thumbnail) }}"
															alt="{{ $course->title }}" class="w-16 h-10 object-cover rounded">
													@else
														<span class="text-xs">N/A</span>
													@endif
												</td>
												<td
													class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">
													{{ $course->title }}
												</td>
												<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">Rp
													{{ number_format($course->price, 0, ',', '.') }}
												</td>
												<td
													class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
													<a href="{{ route('instructor.courses.lessons.index', $course) }}"
														class="text-green-600 hover:text-green-900">Kurikulum</a>
													<a href="{{ route('instructor.courses.edit', $course) }}"
														class="text-indigo-600 hover:text-indigo-900 ml-4">Edit</a>
													<form action="{{ route('instructor.courses.destroy', $course) }}"
														method="POST" class="inline-block ml-4"
														onsubmit="return confirm('Apakah Anda yakin ingin menghapus kursus ini?');">
														@csrf
														@method('DELETE')
														<button type="submit"
															class="text-red-600 hover:text-red-900">Hapus</button>
													</form>
												</td>
											</tr>
										@empty
											<tr>
												<td colspan="4" class="text-center py-4 text-gray-500">Anda belum memiliki
													kursus.</td>
											</tr>
										@endforelse
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection