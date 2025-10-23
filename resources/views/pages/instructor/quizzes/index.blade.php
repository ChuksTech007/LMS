@extends('layouts.app')

@section('title', 'Manage Quizzes & Exams')

@section('content')
<div class="py-12 bg-gray-50 px-4 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
        <h1 class="text-3xl font-extrabold text-green-900">Manage Quizzes & Exams</h1>
        <p class="text-gray-600">
            Easily manage, edit, and archive your course quizzes. Current exams are available to students, while Past Questions are archived.
            <a href="{{ route('instructor.dashboard') }}" class="inline-flex items-center text-sm font-semibold text-gray-600 hover:text-gray-800 transition-colors duration-200 mt-1">
                &larr; Back to Dashboard
            </a>
        </p>
        
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        {{-- =================================== --}}
        {{-- SECTION 1: Courses Missing a Quiz --}}
        {{-- =================================== --}}
        <h2 class="text-2xl font-bold text-gray-700">Courses Awaiting an Exam ({{ $courses->filter(fn($c) => $c->quizzes->isEmpty())->count() }})</h2>
        <div class="bg-white shadow-xl rounded-xl overflow-hidden mb-8">
            <ul class="divide-y divide-gray-200">
                @forelse ($courses->filter(fn($c) => $c->quizzes->isEmpty()) as $course)
                    <li class="p-4 hover:bg-gray-50 transition duration-150 ease-in-out flex justify-between items-center">
                        <p class="text-lg font-semibold text-gray-800">{{ $course->title }}</p>
                        <a href="{{ route('instructor.quizzes.create', $course->id) }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-green-900 bg-yellow-400 hover:bg-yellow-500 transition">
                            Create Exam
                        </a>
                    </li>
                @empty
                    <div class="p-4 text-center text-gray-500">
                        <p>All your courses either have a current or archived quiz.</p>
                    </div>
                @endforelse
            </ul>
        </div>

        {{-- =================================== --}}
        {{-- SECTION 2: CURRENT QUIZZES (Status = 0) --}}
        {{-- =================================== --}}
        <h2 class="text-2xl font-bold mt-8 text-green-700">Current Quizzes (Available to Students) ({{ $currentQuizzes->count() }})</h2>
        <div class="space-y-4">
            @forelse ($currentQuizzes as $quiz)
                <div class="bg-white shadow-md rounded-lg p-4 flex justify-between items-center border-l-4 border-green-500">
                    <div>
                        <h3 class="text-lg font-semibold text-green-900">{{ $quiz->title }} <span class="text-sm font-normal text-gray-500">({{ $quiz->course->title }})</span></h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Passing: <span class="font-medium text-green-700">{{ $quiz->passing_score }}%</span> | 
                            Attempts: <span class="font-medium text-green-700">{{ $quiz->attempts->count() }}</span> |
                            Duration: {{ $quiz->duration_minutes }} min
                        </p>
                    </div>
                    <div class="flex space-x-2 flex-shrink-0">
                        {{-- Edit --}}
                        <a href="{{ route('instructor.quizzes.edit', $quiz) }}" class="px-3 py-2 text-sm text-gray-700 bg-yellow-400 rounded-lg hover:bg-yellow-500 transition">Edit 📝</a>
                        
                        {{-- Results --}}
                        <a href="{{ route('instructor.quizzes.results', $quiz) }}" class="px-3 py-2 text-sm text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">Results 📊</a>
                        
                        {{-- TOGGLE BUTTON: Move to Past Questions (1) --}}
                        <form action="{{ route('instructor.quizzes.toggleStatus', $quiz) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="px-3 py-2 text-sm text-white bg-red-600 rounded-lg hover:bg-red-700 transition">
                                Archive 📦
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="p-4 bg-gray-100 rounded-lg text-center">No active quizzes available. Create one using the button above.</p>
            @endforelse
        </div>

        {{-- =================================== --}}
        {{-- SECTION 3: PAST QUESTIONS (Status = 1) --}}
        {{-- =================================== --}}
        <h2 class="text-2xl font-bold mt-10 text-gray-700">Past Questions (Archived) ({{ $pastQuizzes->count() }})</h2>
        <div class="space-y-4">
            @forelse ($pastQuizzes as $quiz)
                <div class="bg-gray-100 shadow-sm rounded-lg p-4 flex justify-between items-center opacity-90 border-l-4 border-gray-400">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">{{ $quiz->title }} <span class="text-sm font-normal text-gray-500">({{ $quiz->course->title }})</span></h3>
                        <p class="text-sm text-gray-500 mt-1">
                            **Archived** | Attempts: {{ $quiz->attempts->count() }}
                        </p>
                    </div>
                    <div class="flex space-x-2 flex-shrink-0">
                        {{-- Results --}}
                        <a href="{{ route('instructor.quizzes.results', $quiz) }}" class="px-3 py-2 text-sm text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">View Results</a>
                        
                        {{-- TOGGLE BUTTON: Move back to Current (0) --}}
                        <form action="{{ route('instructor.quizzes.toggleStatus', $quiz) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="px-3 py-2 text-sm text-gray-800 bg-green-300 rounded-lg hover:bg-green-400 transition">
                                Restore 🔄
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="p-4 bg-gray-100 rounded-lg text-center">No quizzes have been archived yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection