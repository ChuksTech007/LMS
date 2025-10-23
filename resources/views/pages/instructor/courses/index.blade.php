@extends('layouts.app')

@section('title', 'Course Management')

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
                <h2 class="text-3xl font-extrabold text-green-900">My Courses</h2>
                <p class="mt-1 text-md text-gray-600">Here's a list of all your active courses.</p>
                <a href="{{ route('instructor.dashboard') }}"
                   class="inline-flex items-center text-sm font-semibold text-gray-600 hover:text-gray-800 transition-colors duration-200 mt-1">
                    &larr; Back to Dashboard
                </a>
            </div>
            <!-- The button now uses the new pill-shape design with the FUTO colors -->
            <a href="{{ route('instructor.courses.create') }}"
                class="inline-flex items-center rounded-md bg-green-800 px-6 py-3 text-sm font-semibold text-white shadow-lg
                       hover:bg-green-700 transition-colors duration-200">
                Add New Course
            </a>
        </div>

        {{-- Course Table --}}
        <div class="bg-white overflow-hidden shadow-xl rounded-xl animate-fade-in-up">
            <div class="p-6 text-gray-900">
                <div class="flow-root">
                    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <!-- Styled table headers -->
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-bold text-gray-700">Thumbnail</th>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-bold text-gray-700 sm:pl-0">Title</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-bold text-gray-700">Price</th>
                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0"><span class="sr-only">Actions</span></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @forelse ($courses as $course)
                                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                @if ($course->thumbnail)
                                                    <img src="{{ asset('/' . $course->thumbnail) }}"
                                                         alt="{{ $course->title }}" class="w-20 h-12 object-cover rounded-md">
                                                @else
                                                    <span class="text-xs text-gray-400">N/A</span>
                                                @endif
                                            </td>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-green-900 sm:pl-0">
                                                {{ $course->title }}
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm font-semibold text-yellow-600">
                                                ₦{{ number_format($course->price, 2) }}
                                            </td>
                                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0 space-x-2">
                                                <!-- Redesigned action buttons with a more modern feel -->
                                                <a href="{{ route('instructor.courses.lessons.index', $course) }}"
                                                   class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700 hover:bg-yellow-200 transition-colors">
                                                    Curriculum
                                                </a>
                                                <a href="{{ route('instructor.courses.edit', $course) }}"
                                                   class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-700 hover:bg-indigo-200 transition-colors">
                                                    Edit
                                                </a>
                                                <form action="{{ route('instructor.courses.destroy', $course) }}"
                                                      method="POST" class="inline-block"
                                                      onsubmit="return confirm('Are you sure you want to delete this course?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700 hover:bg-red-200 transition-colors">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-6 text-gray-500">
                                                <p class="text-lg">You don't have any courses yet.</p>
                                                <p class="text-sm mt-1">Click "Add New Course" to get started.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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
