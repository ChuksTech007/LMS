@extends('layouts.app')

@section('title', 'Welcome to FUTO-SkillUP')

@section('content')
<div class="relative bg-green-800 text-white overflow-hidden">
    <!-- Decorative shapes -->
    <div class="absolute top-0 left-0 w-64 h-64 bg-green-800 rounded-full blur-3xl opacity-20 animate-pulse"></div>
    <div class="absolute bottom-0 right-0 w-72 h-72 bg-yellow-400 rounded-full blur-3xl opacity-20 animate-ping"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-12 py-20 flex flex-col lg:flex-row items-center">
        <!-- Left Text Section -->
        <div class="flex-1 space-y-6 animate-slideInLeft">
            <span class="px-4 py-1 text-xs font-bold uppercase tracking-widest bg-yellow-500 text-green-900 rounded-full shadow-lg">
                Your Future Starts Here
            </span>
            <h1 class="text-5xl font-extrabold leading-tight">
                Master In-Demand Skills with 
                <span class="text-yellow-400">FUTO-SkillUP</span>
            </h1>
            <p class="text-lg text-gray-100 max-w-xl">
                Join an innovative learning community built for dreamers, doers, and change-makers. 
                Learn from industry experts, tackle real projects, and unlock career opportunities that match your passion.
            </p>
            <div class="flex gap-4">
                <a href="#" class="px-6 py-3 rounded-lg bg-yellow-400 text-green-900 font-semibold shadow-md hover:scale-105 transition-transform">
                    🚀 Get Started
                </a>
                <a href="{{ route('courses.index') }}" class="px-6 py-3 rounded-lg border-2 border-yellow-400 text-yellow-400 hover:bg-yellow-400 hover:text-green-900 transition-all">
                    Browse Courses →
                </a>
            </div>
        </div>

        <!-- Right Image Section -->
		<div class="flex-1 mt-10 lg:mt-0 relative animate-float">
			<div class="relative w-full h-full">
				<!-- Full height responsive image -->
				<img class="w-full h-full object-cover rounded-none lg:rounded-l-3xl shadow-2xl transform hover:scale-105 transition-transform duration-700 ease-out"
					src="https://images.unsplash.com/photo-1559163304-2bd8f8600164?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTl8fGJsYWNrJTIwc3R1ZGVudCUyMHdpdGglMjBsYXB0b3B8ZW58MHx8MHx8fDA%3D"
					alt="FUTO-SkillUP Learning">

				<!-- Floating badge -->
				<div class="absolute top-6 right-6 bg-green-900 text-yellow-400 px-4 py-2 rounded-lg shadow-lg text-sm font-bold animate-bounce">
					100+ Courses
				</div>

				<!-- Decorative overlay gradient -->
				<div class="absolute inset-0 bg-gradient-to-l from-green-900/20 to-transparent"></div>
			</div>
		</div>

    </div>
</div>

<style>
@keyframes slideInLeft {
    0% { opacity: 0; transform: translateX(-50px); }
    100% { opacity: 1; transform: translateX(0); }
}
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}
.animate-slideInLeft { animation: slideInLeft 1s ease-out; }
.animate-float { animation: float 3s ease-in-out infinite; }
</style>
@endsection
