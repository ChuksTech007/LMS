@extends('layouts.app')

@section('title', 'Category Management')

@section('content')
<!-- A consistent background gradient for a premium feel -->
<div class="py-12 bg-gray-50 min-h-screen px-4">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 animate-fade-in-down">
            <div class="mb-4 sm:mb-0">
                <h2 class="text-3xl font-extrabold text-green-900">Course Categories</h2>
                <a href="{{ route('admin.dashboard') }}"
                   class="inline-flex items-center text-sm font-semibold text-gray-600 hover:text-gray-800 transition-colors duration-200 mt-1">
                    &larr; Back to Dashboard
                </a>
            </div>
            <a href="{{ route('admin.categories.create') }}"
               class="inline-flex items-center rounded-md bg-green-900 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-800 transition-colors duration-200">
                Add Category
            </a>
        </div>

        @if (session('success'))
            <div class="mb-6 rounded-2xl bg-green-50 p-4 animate-fade-in-up">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Table to display categories --}}
        <div class="bg-white overflow-hidden shadow-xl rounded-2xl p-6 animate-fade-in-up">
            <div class="text-gray-900">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Category Name</th>
                                    <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Courses</th>
                                    <th class="relative py-3.5 pl-3 pr-4 sm:pr-6"><span class="sr-only">Actions</span></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @forelse ($categories as $category)
                                    <tr>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                            {{ $category->name }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            {{ $category->courses_count }}
                                        </td>
                                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                            <a href="{{ route('admin.categories.edit', $category) }}" class="text-green-600 hover:text-green-900 transition-colors duration-200">Edit</a>
                                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline-block ml-4">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 transition-colors duration-200">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4 text-gray-500">No categories available.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{-- Pagination links, if needed --}}
        <div class="mt-6 animate-fade-in-up">
            @isset($categories)
                {{ $categories->links() }}
            @endisset
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
