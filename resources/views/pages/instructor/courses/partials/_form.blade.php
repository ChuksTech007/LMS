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
        
        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 animate-fade-in-down">
            <div class="mb-4 sm:mb-0">
                <h2 class="text-3xl font-extrabold text-green-900">Add New Course</h2>
                <p class="mt-1 text-md text-gray-600">Fill in the details below to create a new course.</p>
                <a href="{{ route('instructor.dashboard') }}"
                   class="inline-flex items-center text-sm font-semibold text-gray-600 hover:text-gray-800 transition-colors duration-200 mt-1">
                    &larr; Back to Dashboard
                </a>
            </div>
        </div>
        

        {{-- Course Form --}}
        <div class="bg-white overflow-hidden shadow-xl rounded-xl animate-fade-in-up">
            <div class="p-6 text-gray-900">
                <form action="{{ isset($course) ? route('instructor.courses.update', $course) : route('instructor.courses.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(isset($course))
                        @method('PUT')
                    @endif
                    
                    <div class="space-y-6">
                        <div>
                            <label for="title" class="block text-sm font-medium leading-6 text-gray-900">Course Title</label>
                            <div class="mt-2">
                                <input type="text" name="title" id="title"
                                    class="block w-full rounded-md border-0 px-3 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:outline-none focus:ring-0 focus:border-transparent sm:text-sm sm:leading-6"
                                    value="{{ old('title', $course->title ?? null) }}">
                            </div>
                            @error('title')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="description" class="block text-sm font-medium leading-6 text-gray-900">Description</label>
                            <div class="mt-2">
                                <textarea id="description" name="description" rows="4"
                                    class="block w-full rounded-md border-0 px-3 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:outline-none focus:ring-0 focus:border-transparent sm:text-sm sm:leading-6">{{ old('description', $course->description ?? null) }}</textarea>
                            </div>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="price" class="block text-sm font-medium leading-6 text-gray-900">Price</label>
                            <div class="mt-2">
                                <input type="number" name="price" id="price"
                                    class="block w-full rounded-md border-0 px-3 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:outline-none focus:ring-0 focus:border-transparent sm:text-sm sm:leading-6"
                                    value="{{ old('price', $course->price ?? null) }}">
                            </div>
                            @error('price')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium leading-6 text-gray-900">Category</label>
                            <p class="text-xs text-gray-500">Select one or more categories relevant to this course.</p>
                            <div class="mt-2 space-y-2 border border-gray-200 rounded-md p-4">
                                @foreach ($categories as $category)
                                    <div class="relative flex items-start">
                                        <div class="flex h-6 items-center">
                                            <input id="category-{{ $category->id }}" name="categories[]" value="{{ $category->id }}" type="checkbox"
                                                class="h-4 w-4 rounded border-gray-300 accent-yellow-500 focus:outline-none focus:ring-0 focus:border-transparent"
                                                @checked(in_array($category->id, old('categories', isset($course) ? $course->categories->pluck('id')->toArray() : [])))>
                                        </div>
                                        <div class="ml-3 text-sm leading-6">
                                            <label for="category-{{ $category->id }}"
                                                class="font-medium text-gray-900">{{ $category->name }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @error('categories')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium leading-6 text-gray-900">Course Thumbnail</label>
                            <div x-data="{ thumbnailPreview: '{{ isset($course) && $course->thumbnail ? asset('storage/' . $course->thumbnail) : '' }}' }"
                                class="mt-2">
                                <input type="file" name="thumbnail" id="thumbnail" class="sr-only" x-ref="thumbnail" @change="
                                        let reader = new FileReader();
                                        reader.onload = (e) => {
                                            thumbnailPreview = e.target.result;
                                        };
                                        reader.readAsDataURL($refs.thumbnail.files[0]);
                                    ">

                                <div x-show="thumbnailPreview" class="mb-2">
                                    <label class="block text-xs font-medium leading-6 text-gray-600">Preview:</label>
                                    <img :src="thumbnailPreview" alt="Image Preview" class="h-40 w-auto rounded-md object-cover">
                                </div>

                                <div @click="$refs.thumbnail.click()" x-show="!thumbnailPreview"
                                    class="flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10 hover:border-yellow-500 cursor-pointer">
                                    <div class="text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <div class="mt-4 flex text-sm leading-6 text-gray-600">
                                            <p class="pl-1">Upload file or drag and drop</p>
                                        </div>
                                        <p class="text-xs leading-5 text-gray-600">PNG, JPG, GIF hingga 2MB</p>
                                    </div>
                                </div>

                                <button type="button" @click="$refs.thumbnail.click()" x-show="thumbnailPreview"
                                    class="mt-2 text-sm font-semibold text-green-800 hover:text-green-700">
                                    Change Image
                                </button>
                            </div>
                            @error('thumbnail')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end pt-6">
                            <button type="submit"
                                class="rounded-md bg-green-800 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-700">Save Course</button>
                        </div>
                    </div>
                </form>
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
