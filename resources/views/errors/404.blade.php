<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Page Not Found - School</title>
 @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

{{-- Key changes are in the body class and element styling --}}
<body class="flex items-center justify-center min-h-screen bg-gradient-to-br from-gray-900 to-gray-700">
	<div class="text-center p-8 rounded-2xl bg-gray-800 bg-opacity-50 shadow-2xl animate-fade-in-up">
		<p class="text-base font-semibold text-green-400">404</p>
		<h1 class="mt-4 text-3xl font-bold tracking-tight text-gray-100 sm:text-5xl">Page Not Found</h1>
		<p class="mt-6 text-base leading-7 text-gray-400">Sorry, we couldn't find the page you were looking for.</p>
		<div class="mt-10 flex items-center justify-center gap-x-6">
		<a href="{{ route('home') }}"
			class="rounded-md bg-green-900 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-green-800 transition-colors duration-200">
			Back to Home Page
		</a>
		</div>
	</div>
</body>

<!-- Custom CSS for animations -->
<style>
 @keyframes fadeInUp {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
 }
 .animate-fade-in-up {
  animation: fadeInUp 0.8s ease-out forwards;
 }
</style>

</html>
