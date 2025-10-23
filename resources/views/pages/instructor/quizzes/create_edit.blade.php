@extends('layouts.app')

{{-- Dynamically set the title based on whether $quiz exists --}}
@section('title', isset($quiz) ? 'Edit Quiz: ' . $quiz->title : 'Create New Quiz for ' . $course->title)

@section('content')

<div class="py-12 bg-gray-50 px-4 min-h-screen">
    <div class="max-w-4xl mx-auto space-y-8">
        <div class="bg-white rounded-xl shadow-2xl p-6 sm:p-10">
            {{-- Dynamic Header --}}
            <h1 class="text-3xl font-bold text-green-900 mb-2">
                {{ isset($quiz) ? 'Edit Course Exam' : 'Create Course Exam' }}
            </h1>
            <p class="text-gray-600">
                {{ isset($quiz) 
                    ? 'Modify the exam details and questions for: ' 
                    : 'Design the final examination for the course: ' 
                }}
                <span class="font-semibold text-green-700">{{ $course->title }}</span>
            </p>

            {{-- Display Validation Errors --}}
            @if ($errors->any())
                <div class="mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    <p class="font-bold">Please correct the following errors:</p>
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Dynamic Form Action/Method --}}
            <form action="{{ isset($quiz) ? route('instructor.quizzes.update', $quiz) : route('instructor.quizzes.store') }}" method="POST" class="mt-8 space-y-6">
                @csrf
                @if (isset($quiz))
                    @method('PUT') {{-- Method spoofing for update --}}
                @endif
                <input type="hidden" name="course_id" value="{{ $course->id }}">

                <!-- Quiz Settings -->
                <div class="space-y-4 border-b border-gray-200 pb-6">
                    <h2 class="text-xl font-semibold text-gray-800">Exam Settings</h2>

                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Quiz Title</label>
                        {{-- Use old() or $quiz data for pre-filling --}}
                        <input type="text" name="title" id="title" required 
                            value="{{ old('title', $quiz->title ?? '') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-400 focus:ring-yellow-400">
                    </div>
                    
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Quiz Description (Optional)</label>
                        <textarea name="description" id="description" rows="2"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-400 focus:ring-yellow-400">{{ old('description', $quiz->description ?? '') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="passing_score" class="block text-sm font-medium text-gray-700">Passing Score (%)</label>
                            <input type="number" name="passing_score" id="passing_score" 
                                value="{{ old('passing_score', $quiz->passing_score ?? 70) }}" required min="1" max="100"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-400 focus:ring-yellow-400">
                        </div>
                        <div>
                            <label for="duration_minutes" class="block text-sm font-medium text-gray-700">Duration (Minutes)</label>
                            <input type="number" name="duration_minutes" id="duration_minutes" 
                                value="{{ old('duration_minutes', $quiz->duration_minutes ?? 30) }}" required min="1"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-400 focus:ring-yellow-400">
                        </div>
                    </div>
                </div>

                <!-- Questions Section -->
                <div id="questions-container" class="space-y-8 pt-6">
                    <h2 class="text-xl font-semibold text-gray-800">Questions</h2>
                    
                    {{-- Hidden input to pass existing questions data to JS for pre-filling --}}
                    @if(isset($quiz) && count($quiz->questions) > 0)
                        <input type="hidden" id="existing-questions-data" value="{{ json_encode($quiz->questions) }}">
                    @endif
                </div>

                <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                    <button type="button" id="add-question-btn"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-green-900 bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition duration-150 ease-in-out">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Add Question
                    </button>

                    <button type="submit"
                        class="px-6 py-3 border border-transparent text-lg font-semibold rounded-lg shadow-md text-white bg-green-900 hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out">
                        {{ isset($quiz) ? 'Update Exam' : 'Save Quiz & Questions' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let questionCounter = 0;
const container = document.getElementById('questions-container');
// Options letters for display and value
const optionLetters = ['A', 'B', 'C', 'D', 'E', 'F']; 

/**
 * Generates the HTML for a single question block.
 * @param {object} questionData - Optional data object to pre-fill the form fields.
 */
function generateQuestionHtml(questionData = {}) {
    questionCounter++;
    const questionIndex = questionCounter;
    
    // Determine the options to display and pre-fill
    // Use existing data, or default to 4 empty options
    // Ensure options array handles cases where options is stored as JSON in the model
    let options = [];
    if (questionData.options) {
        if (Array.isArray(questionData.options)) {
            options = questionData.options;
        } else if (typeof questionData.options === 'string') {
            try {
                // Attempt to parse if it's a JSON string from old() data 
                options = JSON.parse(questionData.options);
            } catch (e) {
                options = questionData.options.split(','); // Fallback logic if needed, but array is expected
            }
        }
    } else {
        options = ['', '', '', ''];
    }
    
    const correctOptionValue = questionData.correct_answer || '';
    const questionText = questionData.text || '';
    
    // Generate HTML for options (limited to first 6 options, A-F)
    const optionsHtml = options.slice(0, 6).map((optionText, index) => {
        const letter = optionLetters[index];
        const optionValue = `Option ${letter}`; // Matches validation logic
        const isCorrect = correctOptionValue === optionValue;
        
        // Handle input value for old data, ensuring it's not null
        const inputValue = optionText !== null ? optionText : '';

        return `
            <div class="flex items-center space-x-2">
                <!-- Radio button sets the correct_answer value -->
                <input type="radio" id="q-${questionIndex}-correct-${letter}" name="questions[${questionIndex}][correct_answer]" value="${optionValue}" required
                    ${isCorrect ? 'checked' : ''}
                    class="h-4 w-4 text-green-600 border-gray-300 focus:ring-green-500">
                <label for="q-${questionIndex}-correct-${letter}" class="text-xs font-semibold text-green-800 whitespace-nowrap">Correct Answer?</label>
                
                <!-- Text input captures the option text -->
                <input type="text" name="questions[${questionIndex}][options][]" placeholder="Option ${letter} Text" required
                    value="${inputValue}"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-400 focus:ring-yellow-400 text-sm py-1">
            </div>
        `;
    }).join('');

    return `
        <div id="question-${questionIndex}" class="bg-gray-100 p-6 rounded-lg shadow-inner border border-gray-200 space-y-4">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-bold text-green-900">Question #${questionIndex}</h3>
                <button type="button" onclick="removeQuestion(${questionIndex})" class="text-red-500 hover:text-red-700 transition">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            <!-- Question Text -->
            <div>
                <label for="q-${questionIndex}-text" class="block text-sm font-medium text-gray-700">Question Text</label>
                <textarea name="questions[${questionIndex}][text]" id="q-${questionIndex}-text" required rows="3"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-400 focus:ring-yellow-400">${questionText}</textarea>
            </div>

            <!-- Options & Correct Answer -->
            <div class="space-y-2" id="options-container-${questionIndex}">
                <label class="block text-sm font-medium text-gray-700">Options (Min 2)</label>
                ${optionsHtml}
            </div>
        </div>
    `;
}

function addQuestion(questionData) {
    container.insertAdjacentHTML('beforeend', generateQuestionHtml(questionData));
}

// Global function to remove a question
function removeQuestion(id) {
    // Only remove if more than one question exists (to enforce minimum 1)
    if (container.children.length > 1) {
        const element = document.getElementById(`question-${id}`);
        if (element) {
            element.remove();
            // Re-index remaining questions
            reindexQuestions();
        }
    } else {
        // Use custom notification instead of alert()
        showNotification("You must have at least one question in the quiz.");
    }
}

// Global function to re-index the question array keys after removal
function reindexQuestions() {
    const questionDivs = container.querySelectorAll('[id^="question-"]');
    let currentMaxIndex = 0;

    questionDivs.forEach((div, newIndex) => {
        const newId = newIndex + 1;
        currentMaxIndex = newId;
        
        // 1. Update IDs, Header, and Remove Button
        div.id = `question-${newId}`;
        div.querySelector('h3').textContent = `Question #${newId}`;
        div.querySelector('button[onclick^="removeQuestion"]').setAttribute('onclick', `removeQuestion(${newId})`);
        
        // 2. Update Question Text Name and ID
        const textarea = div.querySelector('textarea[name$="[text]"]');
        if (textarea) {
            textarea.name = `questions[${newId}][text]`;
            textarea.id = `q-${newId}-text`;
        }

        // 3. Update Options Names (text inputs)
        const optionInputs = div.querySelectorAll('input[type="text"][name$="[options][]"]');
        optionInputs.forEach(input => {
            input.name = `questions[${newId}][options][]`;
        });
        
        // 4. Update Radio Button Names and IDs
        const radioInputs = div.querySelectorAll('input[type="radio"]');
        radioInputs.forEach((radio, radioIndex) => {
            const letter = optionLetters[radioIndex];
            radio.id = `q-${newId}-correct-${letter}`;
            radio.name = `questions[${newId}][correct_answer]`;
            // Re-connect the label
            // The label 'for' attribute search is slightly complex because the original index is lost, 
            // so we rely on the surrounding structure to find the correct label.
            // A simple check is to find the label that is a sibling within the same parent div.
            const parentDiv = radio.closest('.flex.items-center.space-x-2');
            const label = parentDiv.querySelector('label[for^="q-"]');
            if(label) {
                label.setAttribute('for', radio.id);
            }
        });
    });
    questionCounter = currentMaxIndex; // Reset counter for new additions
}

// Custom Notification/Alert replacement
function showNotification(message) {
    let notification = document.getElementById('custom-notification');
    if (!notification) {
        notification = document.createElement('div');
        notification.id = 'custom-notification';
        notification.className = 'fixed top-4 right-4 z-50 p-4 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded-lg shadow-lg transition-opacity duration-300 opacity-0';
        document.body.appendChild(notification);
    }
    notification.textContent = message;
    notification.classList.remove('opacity-0');
    notification.classList.add('opacity-100');
    
    setTimeout(() => {
        notification.classList.remove('opacity-100');
        notification.classList.add('opacity-0');
    }, 3000);
}


// Initialize form on load
document.addEventListener('DOMContentLoaded', () => {
    const existingQuestionsInput = document.getElementById('existing-questions-data');
    let questionsData = [];

    // 1. Load Existing Data (if in Edit Mode)
    if (existingQuestionsInput) {
        try {
            // Note: JSON.parse is needed because the value is a JSON string passed from Laravel/Blade
            questionsData = JSON.parse(existingQuestionsInput.value);
        } catch (e) {
            console.error("Failed to parse existing questions data:", e);
        }
    }

    // 2. Load Old Data (on validation failure) - Overrides existing data if errors occurred
    // We use @json(old('questions')) to safely inject Laravel's old input structure
    const oldQuestions = @json(old('questions'));
    if (oldQuestions && Object.keys(oldQuestions).length > 0) {
        // Convert associative array keys (1, 2, 3...) to a plain array of values
        questionsData = Object.values(oldQuestions); 
    }

    // 3. Render Questions
    if (questionsData.length > 0) {
        questionsData.forEach(q => addQuestion(q));
    } else {
        // If creating a new quiz, start with one empty question
        addQuestion();
    }

    // 4. Attach Event Listener for Add Button
    document.getElementById('add-question-btn').addEventListener('click', () => addQuestion());
});
</script>
@endsection
