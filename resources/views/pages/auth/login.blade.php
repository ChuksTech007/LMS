@extends('layouts.app')

@section('title', __('auth.login_title'))

@section('content')
<div class="flex min-h-screen flex-col justify-center py-12 sm:px-6 lg:px-8 bg-gradient-to-br from-green-50 to-white px-4">
    
    <!-- Logo / Title -->
    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-800 shadow-lg animate-bounce">
            <span class="text-white font-extrabold text-xl">F</span>
        </div>
        <h2 class="mt-6 text-3xl font-extrabold tracking-tight text-green-900">
            {{ __('auth.login_title') }}
        </h2>
        <p class="mt-2 text-sm text-gray-600">Sign in to access your FUTO-SkillUP account</p>
    </div>

    <!-- Form -->
    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white px-6 py-10 shadow-xl rounded-lg border-t-4 border-yellow-500 animate-fadeIn">
            <form class="space-y-6" action="{{ route('login') }}" method="POST">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-800">{{ __('auth.email_address') }}</label>
                    <input id="email" name="email" type="email" autocomplete="email" required autofocus
                        class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:outline-none focus:ring-0 focus:border-transparent sm:text-sm px-3 py-2">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-800">{{ __('auth.password') }}</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required
                        class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:outline-none focus:ring-0 focus:border-transparent sm:text-sm px-3 py-2">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember + Forgot -->
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-green-900 border-gray-300 rounded focus:outline-none focus:ring-0 focus:border-transparent">
                        <span class="ml-2 text-gray-700">{{ __('auth.remember_me') }}</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-green-900 font-semibold hover:underline">
                        {{ __('auth.forgot_password') }}
                    </a>
                </div>

                <!-- Submit -->
                <button type="submit"
                    class="w-full flex justify-center rounded-md bg-green-900 px-4 py-2 text-sm font-semibold text-white shadow-lg hover:bg-green-800 transform hover:scale-[1.02] transition duration-300">
                    {{ __('auth.login_button') }}
                </button>
            </form>
        </div>

        <!-- Register link -->
        <p class="mt-6 text-center text-sm text-gray-600">
            {{ __('auth.dont_have_account') }}
            <a href="{{ route('register') }}" class="text-yellow-600 font-semibold hover:underline">
                {{ __('auth.register_here') }}
            </a>
        </p>
    </div>
</div>

<!-- Animations -->
<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fadeIn {
    animation: fadeIn 0.8s ease-out forwards;
}
</style>
@endsection
