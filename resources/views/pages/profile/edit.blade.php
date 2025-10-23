@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<!-- Updated the main container with a subtle green-to-white gradient to match the registration page. -->
<div class="py-12 bg-gray-50 px-4">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        {{-- Update Profile Information Form --}}
        <!-- Added a slide-in animation to this section -->
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg animate-fade-in-left">
            <div class="max-w-xl">
                <!-- Heading and paragraph colors updated for brand consistency -->
                <h2 class="text-2xl font-semibold text-green-900">Profile Information</h2>
                <p class="mt-1 text-sm text-gray-600">Update your profile information and account email address.</p>

                @if (session('status') === 'profile-updated')
                    <p class="mt-2 font-medium text-sm text-green-700">Profile saved successfully</p>
                @endif

                <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                    @csrf
                    @method('patch')

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <!-- Input field styles updated to match the new color scheme on focus -->
                        <input id="name" name="name" type="text"
                               class="mt-2 block w-full rounded-md border border-gray-200 px-4 py-3 text-gray-900 shadow-sm
                                      focus:outline-none focus:ring-0 focus:border-transparent sm:text-sm"
                               value="{{ old('name', $user->name) }}" required autofocus>
                        @error('name')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <!-- Input field styles updated to match the new color scheme on focus -->
                        <input id="email" name="email" type="email"
                               class="mt-2 block w-full rounded-md border border-gray-200 px-4 py-3 text-gray-900 shadow-sm
                                      focus:outline-none focus:ring-0 focus:border-transparent sm:text-sm"
                               value="{{ old('email', $user->email) }}" required>
                        @error('email')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex items-center gap-4">
                        <!-- Button updated to use the green-900 background and a subtle hover animation -->
                        <button type="submit"
                                class="rounded-md bg-green-900 px-4 py-3 text-sm font-semibold text-white shadow-md
                                       hover:bg-green-800 hover:scale-[1.01] transition-all duration-200">Save</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Update Password Form --}}
        <!-- Added a slide-in animation to this section -->
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg animate-fade-in-right">
            <div class="max-w-xl">
                <!-- Heading and paragraph colors updated for brand consistency -->
                <h2 class="text-2xl font-semibold text-green-900">Change Password</h2>
                <p class="mt-1 text-sm text-gray-600">Make sure your account uses a long and random password to stay secure.</p>

                @if (session('status') === 'password-updated')
                    <p class="mt-2 font-medium text-sm text-green-700">Password has been successfully updated.</p>
                @endif

                <form method="post" action="{{ route('profile.password.update') }}" class="mt-6 space-y-6">
                    @csrf
                    @method('put')

                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                        <!-- Input field styles updated to match the new color scheme on focus -->
                        <input id="current_password" name="current_password" type="password"
                               class="mt-2 block w-full rounded-md border border-gray-200 px-4 py-3 text-gray-900 shadow-sm
                                      focus:outline-none focus:ring-0 focus:border-transparent sm:text-sm">
                        @error('current_password', 'updatePassword')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                        <!-- Input field styles updated to match the new color scheme on focus -->
                        <input id="password" name="password" type="password"
                               class="mt-2 block w-full rounded-md border border-gray-200 px-4 py-3 text-gray-900 shadow-sm
                                      focus:outline-none focus:ring-0 focus:border-transparent sm:text-sm">
                        @error('password', 'updatePassword')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                        <!-- Input field styles updated to match the new color scheme on focus -->
                        <input id="password_confirmation" name="password_confirmation" type="password"
                               class="mt-2 block w-full rounded-md border border-gray-200 px-4 py-3 text-gray-900 shadow-sm
                                      focus:outline-none focus:ring-0 focus:border-transparent sm:text-sm">
                        @error('password_confirmation', 'updatePassword')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex items-center gap-4">
                        <!-- Button updated to use the green-900 background and a subtle hover animation -->
                        <button type="submit"
                                class="rounded-md bg-green-900 px-4 py-3 text-sm font-semibold text-white shadow-md
                                       hover:bg-green-800 hover:scale-[1.01] transition-all duration-200">Change Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Custom CSS for animations, same as the registration page for consistency -->
<style>
    @keyframes fadeInLeft {
        from { opacity: 0; transform: translateX(-20px); }
        to { opacity: 1; transform: translateX(0); }
    }

    @keyframes fadeInRight {
        from { opacity: 0; transform: translateX(20px); }
        to { opacity: 1; transform: translateX(0); }
    }

    .animate-fade-in-left {
        animation: fadeInLeft 0.8s ease-out forwards;
    }
    .animate-fade-in-right {
        animation: fadeInRight 0.8s ease-out forwards;
    }
</style>
@endsection
