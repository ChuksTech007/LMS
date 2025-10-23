<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Access Denied - School</title>
	@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
{{-- Key changes are in the body class --}}

<body class="flex items-center justify-center min-h-screen bg-gray-900">
	<div class="text-center">
		<p class="text-base font-semibold text-red-500">403</p>
		<h1 class="mt-4 text-3xl font-bold tracking-tight text-gray-100 sm:text-5xl">Access Denied</h1>
		<p class="mt-6 text-base leading-7 text-gray-400">Sorry, you do not have permission to access this page.
		</p>
		<div class="mt-10 flex items-center justify-center gap-x-6">
			<a href="{{ url()->previous('/') }}"
				class="rounded-md bg-green-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-yellow-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
				Go Back to Previous Page
			</a>
		</div>
	</div>
</body>

</html>