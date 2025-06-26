@extends('layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="flex justify-between items-center mb-6">
				<div>
					<h2 class="text-2xl font-semibold text-gray-900">Manajemen Pengguna & Peran</h2>
					<a href="{{ route('admin.dashboard') }}" class="text-sm text-indigo-600 hover:text-indigo-900">&larr;
						Kembali ke Dasbor</a>
				</div>
			</div>

			@if (session('success'))
				<div class="mb-6 rounded-md bg-green-50 p-4">
					{{-- ... (kode flash message sama seperti sebelumnya) ... --}}
				</div>
			@endif

			<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
				<div class="text-gray-900">
					<div class="flow-root">
						<div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
							<div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
								<table class="min-w-full divide-y divide-gray-300">
									<thead>
										<tr>
											<th scope="col"
												class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-3">
												Nama</th>
											<th scope="col"
												class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Email</th>
											<th scope="col"
												class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Peran</th>
											<th scope="col"
												class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Bergabung
											</th>
											<th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-3"><span
													class="sr-only">Ubah Peran</span></th>
										</tr>
									</thead>
									<tbody class="bg-white">
										@forelse ($users as $user)
											<tr class="even:bg-gray-50">
												<td
													class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-3">
													{{ $user->name }}</td>
												<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $user->email }}
												</td>
												<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
													<span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium 
															{{ $user->role === App\Enums\Role::ADMIN ? 'bg-red-50 text-red-700 ring-red-600/20' : '' }}
															{{ $user->role === App\Enums\Role::INSTRUCTOR ? 'bg-blue-50 text-blue-700 ring-blue-600/20' : '' }}
															{{ $user->role === App\Enums\Role::STUDENT ? 'bg-green-50 text-green-700 ring-green-600/20' : '' }}
														">{{ $user->role->name }}</span>
												</td>
												<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
													{{ $user->created_at->format('d M Y') }}</td>
												<td
													class="whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-3">
													<form action="{{ route('admin.users.update', $user) }}" method="POST"
														class="flex items-center gap-x-2">
														@csrf
														@method('PATCH')
														<select name="role"
															class="block w-full rounded-md border-0 py-1 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
															@foreach(App\Enums\Role::cases() as $role)
																<option value="{{ $role->value }}" @selected($user->role === $role)>
																	{{ $role->name }}</option>
															@endforeach
														</select>
														<button type="submit"
															class="rounded bg-white px-2 py-1 text-xs font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Simpan</button>
													</form>
												</td>
											</tr>
										@empty
											<tr>
												<td colspan="5" class="text-center py-4 text-gray-500">Tidak ada pengguna lain.
												</td>
											</tr>
										@endforelse
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="mt-6">{{ $users->links() }}</div>
		</div>
	</div>
@endsection