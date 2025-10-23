@extends('layouts.app') 
{{-- Use the main "app" layout for consistent header/footer --}}
@section('title', 'Edit Category') {{-- Set the browser page title --}}

@section('content')
<!-- Background for the page: soft gradient from light gray to light green -->
<div class="py-12 bg-gray-50 min-h-screen px-4">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

        {{-- ================== PAGE HEADER ================== --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 animate-fade-in-down">
            <div class="mb-4 sm:mb-0">
                <!-- Big title showing what category we're editing -->
                <h2 class="text-3xl font-extrabold text-green-900">
                    Edit Category: {{ $category->name }}
                </h2>
                <!-- Link back to the Categories list page -->
                <a href="{{ route('admin.categories.index') }}"
                   class="inline-flex items-center text-sm font-semibold text-gray-600 hover:text-gray-800 transition-colors duration-200 mt-1">
                    &larr; Back to Categories
                </a>
            </div>
        </div>

        {{-- ================== SUCCESS MESSAGE ================== --}}
        @if (session('success'))
            <!-- If the session has a 'success' message, show a green notification box -->
            <div class="mb-6 rounded-2xl bg-green-50 p-4 animate-fade-in-up">
                <div class="flex items-center">
                    <!-- Green check icon -->
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" 
                                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 
                                  00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 
                                  10-1.06 1.061l2.5 2.5a.75.75 0 
                                  001.137-.089l4-5.5z" 
                                  clip-rule="evenodd" />
                        </svg>
                    </div>
                    <!-- The success text itself -->
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- ================== FORM SECTION ================== --}}
        <div class="bg-white overflow-hidden shadow-xl rounded-2xl p-6 animate-fade-in-up">
            <div class="text-gray-900">
                <!-- The form sends a PUT request to update the category -->
                <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                    @csrf {{-- Laravel security token --}}
                    @method('PUT') {{-- Spoof HTTP PUT request --}}
                    
                    <!-- Include the shared form fields from a partial view -->
                    @include('pages.admin.categories.partials._form')
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ================== CUSTOM ANIMATIONS ================== --}}
<style>
    /* Fade in from above */
    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    /* Fade in from below */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    /* Utility classes to apply animations */
    .animate-fade-in-down {
        animation: fadeInDown 0.8s ease-out forwards;
    }
    .animate-fade-in-up {
        animation: fadeInUp 0.8s ease-out 0.8s forwards;
        opacity: 0; /* Start hidden until animation plays */
    }
</style>
@endsection
