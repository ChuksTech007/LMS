<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="UTF-g">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">

    <title>@yield('title', 'School')</title>

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
            @yield('content')
        </main>

        <footer class="bg-white border-t-4 border-green-800 shadow-lg mt-auto">
            <div class="container mx-auto px-6 py-10 grid grid-cols-1 md:grid-cols-3 gap-8 text-gray-700">

                <!-- Column 1: Logo & About -->
                <div>
                    <a href="/" class="flex items-center space-x-2 mb-3">
                        <div
                            class="w-8 h-8 rounded-full bg-yellow-400 flex items-center justify-center text-green-900 font-extrabold text-lg">
                            F</div>
                        <h2 class="text-2xl font-bold text-green-800">FUTO-SkillUP</h2>
                    </a>
                    <p class="text-sm leading-relaxed">
                        Empowering students and professionals with certified technical skills to thrive in the modern
                        workforce.
                    </p>
                </div>

                <!-- Column 2: Quick Links -->
                <div>
                    <h3 class="text-lg font-semibold text-green-800 mb-3">Quick Links</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-yellow-500 transition-colors">Home</a></li>
                        <li><a href="#" class="hover:text-yellow-500 transition-colors">Courses</a></li>
                        <li><a href="#" class="hover:text-yellow-500 transition-colors">About Us</a></li>
                        <li><a href="#" class="hover:text-yellow-500 transition-colors">Contact</a></li>
                    </ul>
                </div>

                <!-- Column 3: Contact -->
                <div>
                    <h3 class="text-lg font-semibold text-green-800 mb-3">Get in Touch</h3>
                    <p class="text-sm">Federal University of Technology, Owerri</p>
                    <p class="text-sm">Email: <a href="mailto:info@futo.edu.ng"
                            class="text-yellow-500 hover:underline">info@futo.edu.ng</a></p>
                    <p class="text-sm">Phone: <a href="tel:+2348000000000" class="text-yellow-500 hover:underline">+234
                            800 000 0000</a></p>
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
