@extends('layouts.app')

@section('title', $quiz->title)

@section('content')

<div class="py-12 bg-gray-50 px-4 min-h-screen">

    <div class="max-w-4xl mx-auto space-y-8">
        <a href="{{ route('student.dashboard') }}"
            class="inline-flex items-center text-sm font-semibold text-gray-600 hover:text-gray-800 transition-colors duration-200 mt-1">
            &larr; Back to Dashboard
        </a>
        <div class="bg-white rounded-xl shadow-2xl p-6 sm:p-10">
            <h1 class="text-3xl font-bold text-green-900 mb-2">{{ $quiz->title }}</h1>
            <p class="text-gray-600 border-b pb-4 mb-6">
                Course: <span class="font-semibold">{{ $quiz->course?->title ?? 'N/A' }}</span> |
                Questions: <span class="font-semibold">{{ $questions->count() }}</span> |
                Time Limit: <span class="font-semibold">{{ $quiz->duration_minutes }} minutes</span> |
                Passing Score: <span class="font-semibold">{{ $quiz->passing_score }}%</span>
            </p>

            <div id="timer" class="bg-yellow-100 p-3 rounded-lg text-center text-lg font-bold text-green-900 mb-6 sticky top-4 shadow-md">
                Time Remaining: <span id="time-display">--:--</span>
            </div>

            <form id="quiz-form" action="{{ route('quizzes.submit', $quiz->id) }}" method="POST" class="space-y-8">
                @csrf
                @foreach ($questions as $index => $question)
                    <div class="border border-gray-200 p-6 rounded-lg bg-gray-50 shadow-sm transition-all hover:shadow-md">
                        <p class="text-xl font-semibold text-gray-800 mb-4">
                            {{ $index + 1 }}. {{ $question->text }}
                        </p>

                        <div class="space-y-3">
                            @php
                                $options = is_array($question->options) ? $question->options : json_decode($question->options, true);
                                $options = is_array($options) ? $options : []; 
                            @endphp

                            @foreach ($options as $optionIndex => $option)
                                @php
                                    // Generate the option key (Option A, Option B, etc.)
                                    $optionKey = 'Option ' . chr(65 + $optionIndex); // 65 is ASCII for 'A'
                                @endphp
                                <label class="flex items-center p-3 border rounded-lg cursor-pointer bg-white hover:bg-green-50 transition duration-150 ease-in-out">
                                    {{-- Use the generated key as the radio button value --}}
                                    <input type="radio" name="q_{{ $question->id }}" value="{{ $optionKey }}" required
                                        class="h-5 w-5 text-green-600 border-gray-300 focus:ring-green-500">
                                    <span class="ml-3 text-base text-gray-700">{{ $option }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <div class="pt-8 border-t border-gray-200">
                    <button type="submit"
                        class="w-full px-6 py-4 text-xl font-semibold rounded-lg shadow-xl text-white bg-green-900 hover:bg-green-800 transition duration-150 ease-in-out disabled:opacity-50"
                        id="submit-quiz-btn">
                        Submit Final Answers
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const timeLimitMinutes = {{ $quiz->duration_minutes }};
    
    // This assumes $attempt->started_at is a Carbon instance and is NOT null, guaranteed by the controller.
    const startedAt = new Date('{{ $attempt->started_at->toIso8601String() }}'); 
    
    const endTime = new Date(startedAt.getTime() + timeLimitMinutes * 60000);
    const timerDisplay = document.getElementById('time-display');
    const submitButton = document.getElementById('submit-quiz-btn');
    const form = document.getElementById('quiz-form');
    
    // Store original action URL
    const submitUrl = form.action;
    let interval; // Declare interval here so it's accessible

    /**
     * Handles the final submission of the quiz, used by both button click and timer expiration.
     */
    function submitQuiz(isTimeout = false) {
        // Disable everything immediately to prevent double submission
        submitButton.disabled = true;
        
        const formData = new FormData(form);
        
        if (isTimeout) { 
            // Clear the interval if it hasn't been cleared already
            if (interval) { clearInterval(interval); }
            
            // Add a signal for timeout submission
            formData.append('is_timeout', '1');
            submitButton.textContent = "Time Expired - Submitting...";
            
            // Disable all form controls to prevent user manipulation during submission
            form.querySelectorAll('input, button').forEach(el => el.disabled = true);
        } else {
            submitButton.textContent = "Submitting Answers...";
        }

        fetch(submitUrl, {
            method: 'POST',
            body: formData
        })
        .then(response => {
            // Check if the response is a redirect (Laravel typically redirects on success)
            if (response.redirected) {
                // If the submission was successful, redirect the user immediately
                window.location.href = response.url;
            } else {
                console.error("Submission failed or returned non-redirect response.");
                // Fallback to reload on unexpected response
                window.location.reload(); 
            }
        })
        .catch(error => {
            console.error('Network Error:', error);
            // Re-enable the button if fetch failed due to network/server issues
            submitButton.disabled = false;
            submitButton.textContent = "Submit Final Answers (Error)";
            console.error("A network error occurred. Please check your connection and try submitting again.");
        });
    }

    // Override the default form submission for the button click to use the robust fetch function
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        submitQuiz(false); // Not a timeout submission
    });


    function updateTimer() {
        const now = new Date();
        let timeRemaining = endTime.getTime() - now.getTime();

        if (timeRemaining <= 0) {
            timeRemaining = 0;
            timerDisplay.textContent = "00:00";
            
            // CRITICAL: Call the robust submit function with timeout flag
            submitQuiz(true); 
            return; // Stop execution
        }

        const totalSeconds = Math.floor(timeRemaining / 1000);
        const minutes = Math.floor(totalSeconds / 60);
        const seconds = totalSeconds % 60;

        const displayMinutes = String(minutes).padStart(2, '0');
        const displaySeconds = String(seconds).padStart(2, '0');

        timerDisplay.textContent = `${displayMinutes}:${displaySeconds}`;

        if (totalSeconds <= 60) {
            timerDisplay.parentElement.classList.remove('bg-yellow-100', 'text-green-900');
            timerDisplay.parentElement.classList.add('bg-red-100', 'text-red-700');
        }
    }

    // Start the interval and store it
    interval = setInterval(updateTimer, 1000);
    updateTimer(); 
});

</script>

@endsection