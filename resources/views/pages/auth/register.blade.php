@extends('layouts.app')

@section('title', __('auth.register_title'))

@section('content')
    <div class="flex min-h-full flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="mt-6 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">
                {{ __('auth.register_title') }}
            </h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-[480px]">
            <div class="bg-white px-6 py-12 shadow sm:rounded-lg sm:px-12">
                <form class="space-y-6" action="{{ route('register') }}" method="POST">
                    @csrf

                    <div>
                        <label for="name"
                            class="block text-sm font-medium leading-6 text-gray-900">{{ __('auth.full_name') }}</label>
                        <div class="mt-2">
                            {{-- Added px-3 here --}}
                            <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                                class="block w-full rounded-md border-0 px-3 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email"
                            class="block text-sm font-medium leading-6 text-gray-900">{{ __('auth.email_address') }}</label>
                        <div class="mt-2">
                            {{-- Added px-3 here --}}
                            <input id="email" name="email" type="email" value="{{ old('email') }}" required
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
                            {{-- Added px-3 here --}}
                            <input id="password" name="password" type="password" required
                                class="block w-full rounded-md border-0 px-3 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation"
                            class="block text-sm font-medium leading-6 text-gray-900">{{ __('auth.confirm_password') }}</label>
                        <div class="mt-2">
                            {{-- Added px-3 here --}}
                            <input id="password_confirmation" name="password_confirmation" type="password" required
                                class="block w-full rounded-md border-0 px-3 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>

                    <div>
                        <button type="submit"
                            class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">{{ __('auth.register_button') }}</button>
                    </div>
                </form>
            </div>

            <p class="mt-10 text-center text-sm text-gray-500">
                {{ __('auth.already_have_account') }}
                <a href="/login"
                    class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">{{ __('auth.login_here') }}</a>
            </p>
        </div>
    </div>
@endsection