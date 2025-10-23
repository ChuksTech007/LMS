@extends('layouts.app')

{{-- Use $quiz->title now that $quiz is always passed --}}
@section('title', 'Quiz ' . ($attempt ? 'Results' : 'Review') . ': ' . $quiz->title)

@section('content')
    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        
        {{-- Use $quiz->course for navigation --}}
        <a href="{{ route('quizzes.past', $quiz->course) }}" 
           class="inline-flex items-center text-sm font-semibold text-green-600 hover:text-green-800 transition-colors duration-200 mb-6">
            &larr; Back to Past Quizzes
        </a>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-8">
            <div class="px-4 py-5 sm:px-6 bg-green-700 text-white rounded-t-lg">
                <h1 class="text-2xl font-bold">
                    {{ $attempt ? 'Results' : 'Archived Quiz Review' }} for: {{ $quiz->title }}
                </h1>
                
                @if ($attempt)
                    <p class="mt-1 text-sm">Attempt taken on {{ $attempt->completed_at->format('M d, Y h:i A') }}</p>
                @else
                    <p class="mt-1 text-sm">This section shows all questions and correct answers for review.</p>
                @endif
            </div>
            
            {{-- Display SCORE CARD only if a completed attempt was submitted --}}
            @if ($attempt)
                <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                    @php
                        $pass = $attempt->passed;
                        // IMPORTANT: The score is fixed on the attempt record and does not need re-evaluation.
                        $badgeColor = $pass ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
                        $borderColor = $pass ? 'border-green-500' : 'border-red-500';
                    @endphp
                    
                    <div class="flex justify-between items-center p-4 rounded-lg border-l-4 {{ $borderColor }} bg-gray-50">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Final Score</p>
                            <p class="text-3xl font-extrabold text-gray-900">
                                {{ $attempt->percentage_score }}%
                            </p>
                        </div>
                        <span class="px-3 py-1 text-lg rounded-full font-semibold {{ $badgeColor }}">
                            {{ $pass ? 'PASSED' : 'FAILED' }}
                        </span>
                    </div>
                </div>
            @endif
        </div>
        
        <h2 class="text-xl font-bold text-gray-900 mb-4">Question Breakdown</h2>
        
        {{-- Iterate over the Quiz's Questions, which are passed as $questions --}}
        @foreach ($questions as $questionId => $question)
            @php
                // Get the specific submission data for this question (if we are in corrections mode)
                // This data contains the FIXED 'is_correct' status from the time of submission.
                $data = $submissionData[$questionId] ?? null;
                $isCorrect = $data['is_correct'] ?? null;
                
                // --- Styling Logic ---
                if ($attempt) {
                    // Corrections Mode: Base styling on the recorded submission result
                    $cardBorder = $isCorrect ? 'border-l-4 border-green-500' : 'border-l-4 border-red-500';
                    $iconColor = $isCorrect ? 'text-green-500' : 'text-red-500';
                } else {
                    // Review Mode: Generic styling
                    $cardBorder = 'border-l-4 border-gray-400';
                    $iconColor = 'text-gray-400';
                }
            @endphp
            
            <div class="bg-white shadow overflow-hidden rounded-lg mb-6 p-4 {{ $cardBorder }}">
                <div class="flex items-start">
                    <div class="flex-shrink-0 pt-1">
                        @if ($attempt)
                            {{-- Corrections Mode: Show Check/Cross icon based on *recorded* $isCorrect --}}
                            @if ($isCorrect)
                                <svg class="h-6 w-6 {{ $iconColor }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            @else
                                <svg class="h-6 w-6 {{ $iconColor }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            @endif
                        @else
                            {{-- Review Mode: Show generic icon --}}
                            <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.409 9.177 5 7.5 5 4.093 5 2.5 6.593 2.5 10c0 3.407 1.593 5 5 5h3.5m0 0l-3.5 3.5m3.5-3.5l3.5-3.5m-3.5 3.5V6.253" /></svg>
                        @endif
                    </div>
                    <div class="ml-4 w-full">
                        <p class="text-sm font-semibold text-gray-700 mb-2">Question {{ $loop->index + 1 }}:</p>
                        <p class="text-base font-medium text-gray-900 mb-3">{{ $question->text }}</p>
                        
                        <div class="space-y-2 text-sm">
                            {{-- Show User's Answer (Only if attempt exists and they answered the question) --}}
                            @if ($attempt && $data)
                                <p class="text-gray-700">
                                    <span class="font-bold">Your Answer:</span>
                                    <span class="{{ $isCorrect ? 'text-green-600' : 'text-red-600 font-semibold' }}">
                                        {{ $data['submitted'] ?? 'No Answer' }}
                                    </span>
                                </p>
                            @endif

                            {{-- Always show the Correct Answer --}}
                            <p class="text-gray-700">
                                <span class="font-bold">Correct Answer:</span>
                                <span class="text-green-600 font-semibold">
                                    {{ $data['correct'] ?? $question->correct_answer }} 
                                </span>
                            </p>

                            <p class="text-xs text-gray-500 mt-2">
                                Options: ({{ implode(' / ', $question->options) }})
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        
    </div>
@endsection