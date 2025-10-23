@extends('layouts.app')

@section('title', 'Course Catalog')

@section('content')
<div class="py-12 bg-gray-50 min-h-screen">
    <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:max-w-7xl lg:px-8">

        <h2 class="text-3xl font-extrabold tracking-tight text-green-900 mb-8 animate-fadeInDown">
            🎓 FUTO SkillUP Course Catalog
        </h2>

{{-- Category Filter --}}
<div class="bg-white rounded-xl shadow-md p-4 mb-8 border border-gray-100 animate-fadeInUp delay-100">
    <div class="flex flex-nowrap overflow-x-auto gap-2 items-center h-full no-scrollbar pb-1">
        <span class="text-sm font-semibold mr-2 text-green-900 flex-shrink-0">
            Filter by Category:
        </span>

        <a href="{{ route('courses.index') }}"
           class="rounded-full px-3 py-1 text-sm font-medium transition-all duration-300 transform hover:scale-105 flex-shrink-0
           {{ !request('category') ? 'bg-green-900 text-white shadow-md hover:bg-yellow-400 hover:text-green-900' : 'bg-white text-gray-600 hover:bg-gray-100 ring-1 ring-gray-300' }}">
            All
        </a>

        @foreach ($categories as $category)
            <a href="{{ route('courses.index', ['category' => $category->slug]) }}"
               class="rounded-full px-3 py-1 text-sm font-medium transition-all duration-300 transform hover:scale-105 flex-shrink-0
               {{ request('category') == $category->slug ? 'bg-green-900 text-white shadow-md hover:bg-yellow-400 hover:text-green-900' : 'bg-white text-gray-600 hover:bg-gray-100 ring-1 ring-gray-300' }}">
                {{ $category->name }}
            </a>
        @endforeach
    </div>
</div>

<style>
.no-scrollbar::-webkit-scrollbar { display: none; }
.no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>



        {{-- Search Bar --}}
        <div class="mb-8 animate-fadeInUp delay-200">
            <form action="{{ route('courses.index') }}" method="GET">
                <div class="flex rounded-lg shadow-sm overflow-hidden border border-gray-100">
                    <input type="search" name="search" id="search"
                               class="flex-grow border-0 py-3 px-4 text-gray-900 placeholder:text-gray-400 
                               focus:ring-2 focus:ring-yellow-400 focus:outline-none transition-all duration-300"
                               placeholder="🔍 Search courses..." value="{{ request('search') }}">
                    <button type="submit"
                                 class="inline-flex items-center gap-x-1.5 px-6 py-3 text-sm font-semibold text-green-900 bg-yellow-400 hover:bg-yellow-300 
                                 transition-all duration-300 transform hover:scale-105">
                        Search
                    </button>
                </div>
            </form>
        </div>

        {{-- Search Result Info --}}
        @if (request('search'))
            <p class="mb-6 text-sm text-gray-700 animate-fadeInUp delay-300">
                Showing results for: <span class="font-bold">{{ request('search') }}</span>
                <a href="{{ route('courses.index') }}" class="ml-2 text-green-900 hover:text-yellow-400 text-xs transition-colors">[Clear Filter]</a>
            </p>
        @endif

        {{-- Courses Grid --}}
        <div class="mt-6 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:gap-x-8">
            @forelse ($courses as $course)
                <div class="bg-white overflow-hidden rounded-xl shadow-lg border border-gray-100 flex flex-col transform transition duration-500 hover:scale-[1.02] hover:shadow-2xl animate-fadeInUp delay-{{ $loop->index * 100 }}">
                    <img src="{{ asset('/' . $course->thumbnail) }}" alt="{{ $course->title }}"
                         class="h-48 w-full object-cover object-center transform group-hover:scale-105 transition-transform duration-500 ease-out">
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="font-bold text-xl text-gray-900">{{ $course->title }}</h3>
                        <p class="mt-2 text-sm text-gray-500">By {{ $course->instructor->name }}</p>
                    </div>
                    <div class="p-6 pt-0 flex justify-between items-center mt-auto">
                        <p class="text-lg font-bold text-green-900">₦ {{ number_format($course->price, 0, ',', '.') }}</p>
                        <a href="{{ route('courses.show', $course) }}"
                           class="inline-flex items-center rounded-lg bg-green-900 px-4 py-2 text-sm font-semibold text-white shadow-md hover:bg-green-800 transition-all duration-300 transform hover:scale-105">
                            View Course
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-1 sm:col-span-2 lg:col-span-3 text-center py-20 bg-white rounded-xl shadow-md border border-gray-100 animate-fadeInUp">
                    <p class="text-xl text-gray-500 font-medium">🚫 No courses available right now.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-12 text-center">
            {{ $courses->appends(request()->query())->links() }}
        </div>
    </div>
</div>

<style>
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
.animate-fadeInUp {
    animation: fadeInUp 0.6s ease-out forwards;
}
.animate-fadeInDown {
    animation: fadeInDown 0.6s ease-out forwards;
}
/* Staggered animation delays for each card */
.delay-0 { animation-delay: 0s; }
.delay-100 { animation-delay: 0.1s; }
.delay-200 { animation-delay: 0.2s; }
.delay-300 { animation-delay: 0.3s; }
.delay-400 { animation-delay: 0.4s; }
.delay-500 { animation-delay: 0.5s; }
.delay-600 { animation-delay: 0.6s; }
</style>
@endsection
