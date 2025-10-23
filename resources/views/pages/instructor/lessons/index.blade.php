@extends('layouts.app')

@section('title', 'Curriculum Management')

@section('content')
<!-- Reusing the new background gradient for a consistent look -->
<div class="py-12 bg-gray-50 min-h-screen px-4">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
        
        {{-- Success Message Alert --}}
        @if (session('success'))
            <!-- New, redesigned success alert to match the aesthetic -->
            <div class="mb-6 rounded-xl bg-green-100 p-4 shadow-md animate-fade-in-down">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-green-700" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif
        
        {{-- Page Header with Action Button --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 animate-fade-in-down">
            <div class="mb-4 sm:mb-0">
                <h2 class="text-3xl font-extrabold text-green-900">
                    Curriculum: {{ $course->title }}
                </h2>
                <a href="{{ route('instructor.courses.index') }}"
                   class="inline-flex items-center text-sm font-semibold text-gray-600 hover:text-gray-800 transition-colors duration-200 mt-1">
                   &larr; Back to Course List
                </a>
            </div>
            <!-- The button now uses the new pill-shape design with the FUTO colors -->
            <a href="{{ route('instructor.courses.lessons.create', $course) }}"
               class="inline-flex items-center rounded-md bg-green-800 px-6 py-3 text-sm font-semibold text-white shadow-lg
                      hover:bg-green-700 transition-colors duration-200">
                Add New Lesson
            </a>
        </div>

        {{-- Lessons List --}}
        <div class="bg-white overflow-hidden shadow-xl rounded-xl animate-fade-in-up">
            <div class="p-6 text-gray-900">
                @if($lessons->isEmpty())
                    <p class="text-center text-gray-500 py-6">No lessons found in this course.</p>
                @else
                    <ul role="list" class="divide-y divide-gray-200">
                        @foreach($lessons as $lesson)
                            <li class="flex justify-between items-center gap-x-6 py-5 hover:bg-gray-50 transition-colors duration-150">
                                <div class="flex min-w-0 gap-x-4">
                                    <div class="min-w-0 flex-auto">
                                        <p class="text-lg font-semibold leading-6 text-green-900">{{ $lesson->title }}</p>
                                        <p class="mt-1 truncate text-sm leading-5 text-gray-500">
                                            {{ $lesson->duration_in_minutes }} minutes
                                        </p>
                                    </div>
                                </div>
                                <div class="shrink-0 flex items-center space-x-2">
                                    <a href="{{ route('instructor.courses.lessons.edit', [$course, $lesson]) }}"
                                       class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-gray-800 hover:bg-yellow-200 transition-colors">
                                        Edit
                                    </a>

                                    <form action="{{ route('instructor.courses.lessons.destroy', [$course, $lesson]) }}"
                                          method="POST"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus pelajaran ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700 hover:bg-red-200 transition-colors">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Custom CSS for animations -->
<style>
    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-down {
        animation: fadeInDown 0.8s ease-out forwards;
    }
    .animate-fade-in-up {
        animation: fadeInUp 0.8s ease-out 0.8s forwards; opacity: 0;
    }
</style>
@endsection
