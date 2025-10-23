@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
	<div class="flex min-h-full flex-col justify-center py-12">
		<div class="sm:mx-auto sm:w-full sm:max-w-md">
			<h2 class="text-center text-2xl font-bold">Atur Password Baru Anda</h2>
		</div>
		<div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
			<div class="bg-white px-4 py-8 shadow sm:rounded-lg sm:px-10">
				<form class="space-y-6" action="{{ route('password.update') }}" method="POST">
					@csrf

					{{-- Hidden inputs to pass token and email --}}
					<input type="hidden" name="token" value="{{ $request->route('token') }}">
					<input type="hidden" name="email" value="{{ $request->email }}">

					<div>
						<label for="password" class="block text-sm font-medium">Password Baru</label>
						<div class="mt-1">
							<input id="password" name="password" type="password" required autofocus
								class="block w-full rounded-md border-0 px-3 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300">
						</div>
						@error('password')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
					</div>

					<div>
						<label for="password_confirmation" class="block text-sm font-medium">Konfirmasi Password
							Baru</label>
						<div class="mt-1">
							<input id="password_confirmation" name="password_confirmation" type="password" required
								class="block w-full rounded-md border-0 px-3 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300">
						</div>
					</div>

					<div>
						<button type="submit"
							class="flex w-full justify-center rounded-md bg-green-600 px-3 py-2 text-sm text-white">Reset
							Password</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection