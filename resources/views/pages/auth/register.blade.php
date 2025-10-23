@extends('layouts.app')

@section('title', __('auth.register_title'))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-white flex items-center py-8 px-4 sm:px-6 lg:px-8">
  <div class="max-w-7xl mx-auto w-full">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">

      <div class="hidden lg:flex flex-col justify-center pl-8 space-y-6">
        <div class="inline-flex items-center gap-3">
          <div class="w-12 h-12 rounded-full bg-green-900 text-white grid place-items-center font-extrabold">F</div>
          <span class="px-3 py-1 rounded-full bg-yellow-400 text-green-900 font-semibold text-sm">FUTO-SkillUP</span>
        </div>

        <h2 class="text-4xl font-extrabold text-green-900 leading-tight">
          Join a community of learners & builders
        </h2>

        <p class="text-gray-700 max-w-md">
          Learn practical, in-demand skills with hands-on projects and expert instructors. Built for FUTO students and open to everyone.
        </p>

        <img src="https://images.unsplash.com/photo-1581368169147-447353f0cc70?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MjR8fGJsYWNrJTIwc3R1ZGVudCUyMHdpdGglMjBsYXB0b3AlMjBjb2Rpbmd8ZW58MHx8MHx8fDA%3D"
              alt="Students learning"
              class="w-full rounded-xl shadow-xl object-cover">
      </div>

      <div class="w-full mx-auto max-w-md">

        {{-- Mobile Logo (visible on all screens, centered, and animated) --}}
        <div class="flex justify-center mb-8 lg:hidden">
          <div class="inline-flex items-center gap-3 animate-bounce">
            <div class="w-12 h-12 rounded-full bg-green-900 text-white grid place-items-center font-extrabold">F</div>
            <span class="px-3 py-1 rounded-full bg-yellow-400 text-green-900 font-semibold text-sm">FUTO-SkillUP</span>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-xl border-t-4 border-yellow-500 overflow-hidden">
          <div class="px-6 py-8">
            <h3 class="text-2xl font-semibold text-green-900 mb-1">{{ __('auth.register_title') }}</h3>
            <p class="text-sm text-gray-600 mb-6">Create an account to access courses, projects and community features.</p>

            <form action="{{ route('register') }}" method="POST" class="space-y-5" novalidate>
              @csrf

              {{-- Name --}}
              <div>
                <label for="name" class="block text-sm font-medium text-gray-700">{{ __('auth.full_name') }}</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                        class="mt-2 block w-full rounded-md border border-gray-200 px-4 py-3 text-gray-900 shadow-sm
                                 focus:outline-none focus:ring-0 focus:border-transparent sm:text-sm" />
                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
              </div>

              {{-- Email --}}
              <div>
                <label for="email" class="block text-sm font-medium text-gray-700">{{ __('auth.email_address') }}</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required
                        class="mt-2 block w-full rounded-md border border-gray-200 px-4 py-3 text-gray-900 shadow-sm
                                 focus:outline-none focus:ring-0 focus:border-transparent sm:text-sm" />
                @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
              </div>

              {{-- Password --}}
              <div>
                <label for="password" class="block text-sm font-medium text-gray-700">{{ __('auth.password') }}</label>
                <input id="password" name="password" type="password" required
                        class="mt-2 block w-full rounded-md border border-gray-200 px-4 py-3 text-gray-900 shadow-sm
                                 focus:outline-none focus:ring-0 focus:border-transparent sm:text-sm" />
                @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
              </div>

              {{-- Confirm Password --}}
              <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">{{ __('auth.confirm_password') }}</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required
                        class="mt-2 block w-full rounded-md border border-gray-200 px-4 py-3 text-gray-900 shadow-sm
                                 focus:outline-none focus:ring-0 focus:border-transparent sm:text-sm" />
              </div>

              {{-- Submit --}}
              <div>
                <button type="submit"
                         class="w-full flex justify-center py-3 px-4 rounded-md bg-green-900 text-white font-semibold shadow-md
                                 hover:bg-green-800 transform hover:-translate-y-0.5 transition duration-150">
                  {{ __('auth.register_button') }}
                </button>
              </div>
            </form>

            {{-- Footer link --}}
            <p class="mt-6 text-center text-sm text-gray-600">
              {{ __('auth.already_have_account') }}
              <a href="{{ route('login') }}" class="font-semibold text-green-900 hover:text-yellow-500 transition-colors">
                {{ __('auth.login_here') }}
              </a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  @keyframes subtle-bounce{0%{transform:translateY(0)}50%{transform:translateY(-4px)}100%{transform:translateY(0)}}
  .hover\\:-translate-y-0\\.5:hover{transform:translateY(-2px)}
</style>
@endsection