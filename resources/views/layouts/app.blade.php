<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
	<meta charset="UTF-g">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="icon" href="/favicon.ico" type="image/x-icon">
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">

	<title>@yield('title', 'Skoolio')</title>

	{{-- Load CSS and JS assets via Vite --}}
	@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-800 antialiased h-full">

	<div id="app" class="min-h-full flex flex-col">

		<header>
			@include('layouts.partials.navbar')
		</header>

		<main class="flex-grow">
			@yield('content')
		</main>

		<footer class="bg-white shadow-inner mt-auto py-4">
			<div class="container mx-auto text-center text-sm text-gray-500">
				&copy; {{ date('Y') }} Skoolio. All Rights Reserved.
			</div>
		</footer>

	</div>

</body>

</html>