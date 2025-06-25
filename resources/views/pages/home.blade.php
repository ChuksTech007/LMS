@extends('layouts.app')

{{-- This sets the page title for the 'title' yield in the layout --}}
@section('title', 'Selamat Datang di Skoolio')

{{-- This is the main content of the page --}}
@section('content')
	<div class="relative bg-white">
		<div class="mx-auto max-w-7xl lg:grid lg:grid-cols-12 lg:gap-x-8 lg:px-8">
			<div class="px-6 pb-24 pt-10 sm:pb-32 lg:col-span-7 lg:px-0 lg:pb-56 lg:pt-48 xl:col-span-6">
				<div class="mx-auto max-w-2xl lg:mx-0">
					<h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">
						Tingkatkan Skill Anda Bersama Skoolio
					</h1>
					<p class="mt-6 text-lg leading-8 text-gray-600">
						Platform pembelajaran online modern yang dirancang untuk membantu Anda mencapai potensi penuh.
						Jelajahi ratusan kursus yang diajarkan oleh para ahli di bidangnya.
					</p>
					<div class="mt-10 flex items-center gap-x-6">
						<a href="#"
							class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
							Mulai Belajar
						</a>
						<a href="#" class="text-sm font-semibold leading-6 text-gray-900">Lihat Katalog <span
								aria-hidden="true">→</span></a>
					</div>
				</div>
			</div>
			<div class="relative lg:col-span-5 lg:-mr-8 xl:absolute xl:inset-0 xl:left-1/2 xl:mr-0">
				{{-- A decorative image for desktop view, hidden on mobile --}}
				<img class="aspect-[3/2] w-full bg-gray-50 object-cover lg:absolute lg:inset-0 lg:aspect-auto lg:h-full hidden lg:block"
					src="https://images.unsplash.com/photo-1498758536662-35b82cd15e29?q=80&w=2187&auto=format&fit=crop"
					alt="Skoolio Learning">
			</div>
		</div>
	</div>
@endsection