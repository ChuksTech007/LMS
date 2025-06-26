@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
			{{-- Update Profile Information Form --}}
			<div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
				<div class="max-w-xl">
					<h2 class="text-lg font-medium text-gray-900">Informasi Profil</h2>
					<p class="mt-1 text-sm text-gray-600">Perbarui informasi profil dan alamat email akun Anda.</p>

					@if (session('status') === 'profile-updated')
						<p class="mt-2 font-medium text-sm text-green-600">Profil berhasil disimpan.</p>
					@endif

					<form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
						@csrf
						@method('patch')

						<div>
							<label for="name" class="block text-sm font-medium">Nama</label>
							<input id="name" name="name" type="text"
								class="mt-1 block w-full rounded-md px-3 py-1.5 border-gray-300 shadow-sm"
								value="{{ old('name', $user->name) }}" required autofocus>
							@error('name')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
						</div>

						<div>
							<label for="email" class="block text-sm font-medium">Email</label>
							<input id="email" name="email" type="email"
								class="mt-1 block w-full rounded-md px-3 py-1.5 border-gray-300 shadow-sm"
								value="{{ old('email', $user->email) }}" required>
							@error('email')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
						</div>

						<div class="flex items-center gap-4">
							<button type="submit"
								class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white">Simpan</button>
						</div>
					</form>
				</div>
			</div>

			{{-- Update Password Form --}}
			<div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
				<div class="max-w-xl">
					<h2 class="text-lg font-medium text-gray-900">Ubah Password</h2>
					<p class="mt-1 text-sm text-gray-600">Pastikan akun Anda menggunakan password yang panjang dan acak agar
						tetap aman.</p>

					@if (session('status') === 'password-updated')
						<p class="mt-2 font-medium text-sm text-green-600">Password berhasil diperbarui.</p>
					@endif

					<form method="post" action="{{ route('profile.password.update') }}" class="mt-6 space-y-6">
						@csrf
						@method('put')

						<div>
							<label for="current_password" class="block text-sm font-medium">Password Saat Ini</label>
							<input id="current_password" name="current_password" type="password"
								class="mt-1 block w-full rounded-md px-3 py-1.5 border-gray-300 shadow-sm">
							@error('current_password', 'updatePassword')<p class="text-sm text-red-600 mt-2">{{ $message }}
							</p>@enderror
						</div>

						<div>
							<label for="password" class="block text-sm font-medium">Password Baru</label>
							<input id="password" name="password" type="password"
								class="mt-1 block w-full rounded-md px-3 py-1.5 border-gray-300 shadow-sm">
							@error('password', 'updatePassword')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>
							@enderror
						</div>

						<div>
							<label for="password_confirmation" class="block text-sm font-medium">Konfirmasi Password
								Baru</label>
							<input id="password_confirmation" name="password_confirmation" type="password"
								class="mt-1 block w-full rounded-md px-3 py-1.5 border-gray-300 shadow-sm">
						</div>

						<div class="flex items-center gap-4">
							<button type="submit"
								class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white">Ubah
								Password</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection