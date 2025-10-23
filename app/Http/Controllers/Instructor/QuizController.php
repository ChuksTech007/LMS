<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB; 



class QuizController extends Controller
{
    /**
     * Display a listing of the quizzes, separated by status.
     */
    public function index()
    {
        // Fetch ALL courses owned by the instructor
        $courses = auth()->user()->courses()
            ->with(['quizzes' => function($query) {
                // Eager load attempts for quizzes for better performance
                $query->with('attempts');
            }])
            ->get();

        // Separate quizzes into current (status 0) and past (status 1)
        $quizzes = $courses->flatMap(fn($course) => $course->quizzes);

        $currentQuizzes = $quizzes->where('status', 0);
        $pastQuizzes = $quizzes->where('status', 1);

        return view('pages.instructor.quizzes.index', compact('courses', 'currentQuizzes', 'pastQuizzes'));
    }
    
    /**
     * Show the page for creating a new Quiz for a specific Course.
     */
    public function create(Course $course)
    {
        if ($course->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $quiz = null; 
        return view('pages.instructor.quizzes.create_edit', compact('course', 'quiz'));
    }

    /**
     * Show the form for editing the specified quiz.
     */
    public function edit(Quiz $quiz)
    {
        $quiz->load('questions');
        $course = $quiz->course;

        if ($course->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        return view('pages.instructor.quizzes.create_edit', compact('quiz', 'course'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'passing_score' => 'required|integer|min:1|max:100',
            'duration_minutes' => 'required|integer|min:1',
            'questions' => 'required|array',
            'questions.*.text' => 'required|string',
            'questions.*.options' => 'required|array|min:2',
            'questions.*.correct_answer' => 'required|string',
        ]);

        $course = Course::findOrFail($request->course_id);
        
        if ($course->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        try {
            DB::beginTransaction();
            
            // 1. Create the Quiz (status defaults to 0 - Current)
            $quiz = Quiz::create([
                'course_id' => $course->id,
                'title' => $validatedData['title'],
                'description' => $validatedData['description'], 
                'passing_score' => $validatedData['passing_score'],
                'duration_minutes' => $validatedData['duration_minutes'],
                'status' => 0, // Explicitly set to Current
            ]);

            // 2. Add Questions
            $this->saveQuestions($quiz, $validatedData['questions']);
            
            DB::commit();
            
            return redirect()->route('instructor.quizzes.index')
                ->with('success', 'Quiz and questions created successfully! 🚀');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating quiz and questions.', ['error' => $e->getMessage()]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'A server error occurred while saving the quiz.');
        }
    }

    /**
     * Update the specified quiz in storage.
     */
    public function update(Request $request, Quiz $quiz)
    {
        if ($quiz->course->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'passing_score' => 'required|integer|min:1|max:100',
            'duration_minutes' => 'required|integer|min:1',
            'questions' => 'required|array',
            'questions.*.text' => 'required|string',
            'questions.*.options' => 'required|array|min:2',
            'questions.*.correct_answer' => 'required|string',
            // Note: We don't need status here, it's handled by toggleStatus
        ]);
        
        try {
            DB::beginTransaction();

            // 1. Update the Quiz details
            $quiz->update([
                'title' => $validatedData['title'],
                'description' => $validatedData['description'], 
                'passing_score' => $validatedData['passing_score'],
                'duration_minutes' => $validatedData['duration_minutes'],
            ]);

            // 2. Delete all existing questions and re-save the new set
            $quiz->questions()->delete();
            $this->saveQuestions($quiz, $validatedData['questions']);
            
            DB::commit();

            return redirect()->route('instructor.quizzes.index')
                ->with('success', 'Quiz updated successfully! 📝');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating quiz and questions.', ['error' => $e->getMessage(), 'quiz_id' => $quiz->id]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'A server error occurred while updating the quiz.');
        }
    }

    /**
     * Toggle the status of the specified quiz (0 to 1, or 1 to 0).
     */
    public function toggleStatus(Quiz $quiz)
    {
        if ($quiz->course->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $newStatus = $quiz->status === 0 ? 1 : 0;
        $statusText = $newStatus === 1 ? 'Past Question (Archived)' : 'Current Question';

        try {
            $quiz->update(['status' => $newStatus]);

            return redirect()->route('instructor.quizzes.index')
                ->with('success', "Quiz '{$quiz->title}' has been moved to {$statusText}.");

        } catch (\Exception $e) {
            Log::error('Error toggling quiz status.', ['error' => $e->getMessage(), 'quiz_id' => $quiz->id]);

            return redirect()->back()
                ->with('error', 'A server error occurred while updating the quiz status.');
        }
    }


    /**
     * Remove the specified quiz from storage. (Kept for completeness, though status is preferred)
     */
    public function destroy(Quiz $quiz)
    {
        if ($quiz->course->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        try {
            $quizTitle = $quiz->title;
            // The status field makes outright deletion less necessary, but keeping the code.
            $quiz->delete(); 

            return redirect()->route('instructor.quizzes.index')
                ->with('success', 'Quiz "' . $quizTitle . '" successfully deleted.');

        } catch (\Exception $e) {
            Log::error('Error deleting quiz.', ['error' => $e->getMessage(), 'quiz_id' => $quiz->id]);

            return redirect()->back()
                ->with('error', 'A server error occurred while deleting the quiz. The details have been logged.');
        }
    }

    /**
     * Helper function to save questions for a quiz.
     */
    protected function saveQuestions(Quiz $quiz, array $questionsData)
    {
        foreach ($questionsData as $qData) {
            Question::create([
                'quiz_id' => $quiz->id,
                'text' => $qData['text'],
                'options' => $qData['options'], 
                'correct_answer' => $qData['correct_answer'],
            ]);
        }
    }

    /**
     * Display a list of students who have attempted this quiz.
     */
    public function results(Quiz $quiz)
    {
        $quiz->load('course');

        $attempts = $quiz->attempts()
            ->whereNotNull('completed_at')
            ->with('user')
            ->orderBy('completed_at', 'desc')
            ->get();

        return view('pages.instructor.quizzes.results', compact('quiz', 'attempts'));
    }
}