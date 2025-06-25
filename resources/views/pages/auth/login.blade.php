@extends('layouts.app')

@section('title', __('auth.login_title'))

@section('content')
	<div class="flex min-h-full flex-col justify-center py-12 sm:px-6 lg:px-8">
		<div class="sm:mx-auto sm:w-full sm:max-w-md">
			<h2 class="mt-6 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">
				{{ __('auth.login_title') }}
			</h2>
		</div>

		<div class="mt-10 sm:mx-auto sm:w-full sm:max-w-[480px]">
			<div class="bg-white px-6 py-12 shadow sm:rounded-lg sm:px-12">
				<form class="space-y-6" action="{{ route('login') }}" method="POST">
					@csrf

					<div>
						<label for="email"
							class="block text-sm font-medium leading-6 text-gray-900">{{ __('auth.email_address') }}</label>
						<div class="mt-2">
							<input id="email" name="email" type="email" autocomplete="email" required autofocus
								class="block w-full rounded-md border-0 px-3 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
						</div>
						@error('email')
							<p class="mt-2 text-sm text-red-600">{{ $message }}</p>
						@enderror
					</div>

					<div>
						<label for="password"
							class="block text-sm font-medium leading-6 text-gray-900">{{ __('auth.password') }}</label>
						<div class="mt-2">
							<input id="password" name="password" type="password" autocomplete="current-password" required
								class="block w-full rounded-md border-0 px-3 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
						</div>
						@error('password')
							<p class="mt-2 text-sm text-red-600">{{ $message }}</p>
						@enderror
					</div>

					<div class="flex items-center justify-between">
						<div class="flex items-center">
							<input id="remember" name="remember" type="checkbox"
								class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
							<label for="remember"
								class="ml-3 block text-sm leading-6 text-gray-900">{{ __('auth.remember_me') }}</label>
						</div>

						<div class="text-sm leading-6">
							<a href="#"
								class="font-semibold text-indigo-600 hover:text-indigo-500">{{ __('auth.forgot_password') }}</a>
						</div>
					</div>

					<div>
						<button type="submit"
							class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">{{ __('auth.login_button') }}</button>
					</div>
				</form>
			</div>

			<p class="mt-10 text-center text-sm text-gray-500">
				{{ __('auth.dont_have_account') }}
				<a href="{{ route('register') }}"
					class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">{{ __('auth.register_here') }}</a>
			</p>
		</div>
	</div>
@endsection