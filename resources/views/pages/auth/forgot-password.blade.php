@extends('layouts.app')
@section('title', 'Lupa Password')
@section('content')
	<div class="flex min-h-full flex-col justify-center py-12">
		<div class="sm:mx-auto sm:w-full sm:max-w-md">
			<h2 class="text-center text-2xl font-bold">Lupa Password Anda?</h2>
			<p class="mt-2 text-center text-sm text-gray-600">Tidak masalah. Beri tahu kami email Anda dan kami akan
				mengirimkan link untuk mereset password.</p>
		</div>
		<div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
			<div class="bg-white px-4 py-8 shadow sm:rounded-lg sm:px-10">
				@if (session('status'))
				<div class="mb-4 font-medium text-sm text-green-600">{{ session('status') }}</div>@endif
				<form class="space-y-6" action="{{ route('password.email') }}" method="POST">
					@csrf
					<div>
						<label for="email" class="block text-sm font-medium">Alamat Email</label>
						<div class="mt-1">
							<input id="email" name="email" type="email" required autofocus
								class="block w-full rounded-md border-0 px-3 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300">
						</div>
						@error('email')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
					</div>
					<div>
						<button type="submit"
							class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm text-white">Kirim
							Link Reset Password</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection