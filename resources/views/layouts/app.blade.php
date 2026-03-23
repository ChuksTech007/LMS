<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">

    <title>@yield('title', 'FUTO-SkillUP')</title>

    {{-- Load CSS and JS assets via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-800 antialiased h-full">

    <div id="app" class="min-h-full flex flex-col">

        <header>
            @include('layouts.partials.navbar')
        </header>

        <main class="flex-grow">
            @include('pages.page-loader')

            {{-- Global Flash Messages --}}
            @if (session('success'))
                <div id="flash-success" class="fixed top-20 right-4 z-50 max-w-sm w-full bg-green-50 border border-green-200 rounded-xl shadow-lg p-4 flex items-start gap-3 animate-slideInRight">
                    <svg class="h-5 w-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-sm font-medium text-green-800 flex-1">{{ session('success') }}</p>
                    <button onclick="document.getElementById('flash-success').remove()" class="text-green-400 hover:text-green-600 flex-shrink-0">&times;</button>
                </div>
            @endif

            @if (session('error'))
                <div id="flash-error" class="fixed top-20 right-4 z-50 max-w-sm w-full bg-red-50 border border-red-200 rounded-xl shadow-lg p-4 flex items-start gap-3 animate-slideInRight">
                    <svg class="h-5 w-5 text-red-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-sm font-medium text-red-800 flex-1">{{ session('error') }}</p>
                    <button onclick="document.getElementById('flash-error').remove()" class="text-red-400 hover:text-red-600 flex-shrink-0">&times;</button>
                </div>
            @endif

            @if (session('warning'))
                <div id="flash-warning" class="fixed top-20 right-4 z-50 max-w-sm w-full bg-yellow-50 border border-yellow-200 rounded-xl shadow-lg p-4 flex items-start gap-3 animate-slideInRight">
                    <svg class="h-5 w-5 text-yellow-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-sm font-medium text-yellow-800 flex-1">{{ session('warning') }}</p>
                    <button onclick="document.getElementById('flash-warning').remove()" class="text-yellow-400 hover:text-yellow-600 flex-shrink-0">&times;</button>
                </div>
            @endif

            <style>
                @keyframes slideInRight {
                    from { opacity: 0; transform: translateX(100px); }
                    to { opacity: 1; transform: translateX(0); }
                }
                .animate-slideInRight { animation: slideInRight 0.4s ease-out forwards; }
            </style>

            <script>
                // Auto-dismiss flash messages after 5 seconds
                document.addEventListener('DOMContentLoaded', function () {
                    ['flash-success', 'flash-error', 'flash-warning'].forEach(function (id) {
                        var el = document.getElementById(id);
                        if (el) setTimeout(function () { el.style.opacity = '0'; el.style.transition = 'opacity 0.5s'; setTimeout(function () { el.remove(); }, 500); }, 5000);
                    });
                });
            </script>

            @yield('content')
        </main>

        <footer class="bg-white border-t-4 border-green-800 shadow-lg mt-auto">
            <div class="container mx-auto px-6 py-10 grid grid-cols-1 md:grid-cols-3 gap-8 text-gray-700">

                <!-- Column 1: Logo & About -->
                <div>
                    <a href="{{ route('home') }}" class="flex items-center space-x-2 mb-3">
                        <div class="w-8 h-8 rounded-full bg-yellow-400 flex items-center justify-center text-green-900 font-extrabold text-lg">F</div>
                        <h2 class="text-2xl font-bold text-green-800">FUTO-SkillUP</h2>
                    </a>
                    <p class="text-sm leading-relaxed">
                        Empowering students and professionals with certified technical skills to thrive in the modern workforce.
                    </p>
                </div>

                <!-- Column 2: Quick Links -->
                <div>
                    <h3 class="text-lg font-semibold text-green-800 mb-3">Quick Links</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-yellow-500 transition-colors">Home</a></li>
                        <li><a href="{{ route('courses.index') }}" class="hover:text-yellow-500 transition-colors">Browse Courses</a></li>
                        @guest
                            <li><a href="{{ route('register') }}" class="hover:text-yellow-500 transition-colors">Register</a></li>
                            <li><a href="{{ route('login') }}" class="hover:text-yellow-500 transition-colors">Login</a></li>
                        @endguest
                        @auth
                            <li><a href="{{ route('profile.edit') }}" class="hover:text-yellow-500 transition-colors">My Profile</a></li>
                        @endauth
                    </ul>
                </div>

                <!-- Column 3: Contact -->
                <div>
                    <h3 class="text-lg font-semibold text-green-800 mb-3">Get in Touch</h3>
                    <p class="text-sm">Federal University of Technology, Owerri</p>
                    <p class="text-sm">Email: <a href="mailto:info@futo.edu.ng" class="text-yellow-500 hover:underline">info@futo.edu.ng</a></p>
                    <p class="text-sm">Phone: <a href="tel:+2348000000000" class="text-yellow-500 hover:underline">+234 800 000 0000</a></p>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="bg-green-800 text-white text-center py-3 text-xs">
                &copy; {{ date('Y') }} FUTO-SkillUP. All Rights Reserved.
            </div>
        </footer>

    </div>

</body>

</html>
