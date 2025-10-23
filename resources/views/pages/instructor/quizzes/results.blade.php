@extends('layouts.app')

{{-- Assuming $quiz is passed to this view --}}
@section('title', 'Results for Quiz: ' . $quiz->title)

@section('content')

<div class="py-12 bg-gray-50 px-4 min-h-screen">
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

    <div class="bg-white rounded-xl shadow-lg p-6">
        <h1 class="text-3xl font-extrabold text-green-900 border-b pb-4 mb-4">
            Exam Results: {{ $quiz->title }}
        </h1>
        <p class="text-gray-600">
            Course: <span class="font-semibold">{{ $quiz->course->title ?? 'N/A' }}</span> | 
            Passing Score: <span class="font-semibold text-green-700">{{ $quiz->passing_score }}%</span>
        </p>
    </div>

    {{-- Attempts Table --}}
    <div class="bg-white p-6 rounded-xl shadow-md">
        <h2 class="text-xl font-bold text-green-900 border-b pb-2 mb-4">
            Student Attempts ({{ $attempts->count() }})
        </h2>
        
        @if($attempts->isEmpty())
            <p class="text-gray-500 italic">No students have attempted this quiz yet.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Score</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Completion Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($attempts as $attempt)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $attempt->user->name ?? 'Unknown User' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-700">
                                    {{-- CORRECTED: Use percentage_score for the score display --}}
                                    {{ $attempt->percentage_score }}%
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    {{-- CRITICAL FIX: Use $attempt->passed --}}
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $attempt->passed ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $attempt->passed ? 'Passed' : 'Failed' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{-- CORRECTED: Use completed_at for the finish time --}}
                                    {{ $attempt->completed_at ? $attempt->completed_at->format('M d, Y H:i') : 'Incomplete' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>

</div>
@endsection