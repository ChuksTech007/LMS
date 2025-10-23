<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\QuizResultMail; 

class QuizController extends Controller
{
    /**
     * Show the quiz and start the attempt. (For CURRENT quizzes only)
     */
    public function show(Quiz $quiz)
    {
        $user = auth()->user();

        // Check if the quiz is set as a Current Question (status 0)
        if ($quiz->status === 1) {
             return redirect()->route('student.dashboard')->with('error', 'This quiz is no longer available.');
        }

        $quiz->load('course');
        
        // Check if ANY attempt has been COMPLETED (passed or failed).
        $completedAttempt = $quiz->attempts()
                            ->where('user_id', $user->id)
                            ->whereNotNull('completed_at') 
                            ->latest('completed_at')
                            ->first();

        // If an attempt is completed (passed or failed), redirect them away.
        if ($completedAttempt) {
             // Redirect them to their attempt results instead of dashboard
             return redirect()->route('quizzes.attempt.show', $completedAttempt);
        }

        // Find the LATEST incomplete attempt (if one exists)
        $attempt = QuizAttempt::where('user_id', $user->id)
                            ->where('quiz_id', $quiz->id)
                            ->whereNull('completed_at')
                            ->latest('started_at')
                            ->first();
                            
        // If no incomplete attempt is found, create a NEW one.
        if (!$attempt) {
            $attempt = QuizAttempt::create([
                'user_id' => $user->id,
                'quiz_id' => $quiz->id,
                'started_at' => Carbon::now(),
                'completed_at' => null, 
                'score' => 0, 
                'total_questions' => 0,
                'percentage_score' => 0,
                'passed' => false,
                'submission_data' => [], 
            ]);
        }
        
        // Load questions for the quiz
        $questions = $quiz->questions()->select('id', 'text', 'options')->get();

        return view('pages.student.quizzes.show', compact('quiz', 'questions', 'attempt'));
    }

    // ... submit method remains unchanged ...
    public function submit(Request $request, Quiz $quiz)
    {
        $user = auth()->user();

        // Find the current incomplete attempt 
        $attempt = QuizAttempt::where('user_id', $user->id)
            ->where('quiz_id', $quiz->id)
            ->whereNull('completed_at')
            ->latest('started_at')
            ->firstOrFail(); 

        // Load the full question data, including correct_answer
        $questions = $quiz->questions()->get(); 
        
        $correct_answers = 0;
        $total_questions = $questions->count();
        $submission_data = []; // Array to store user answers and correctness

        foreach ($questions as $question) {
            $submitted_answer = $request->input("q_{$question->id}");
            $is_correct = (isset($question->correct_answer) && $submitted_answer === $question->correct_answer);

            if ($is_correct) {
                 $correct_answers++;
            }
            
            // Store submission details for results/corrections
            $submission_data[$question->id] = [
                'submitted' => $submitted_answer,
                'correct' => $question->correct_answer,
                'is_correct' => $is_correct,
            ];
        }

        $percentage_score = $total_questions > 0 ? round(($correct_answers / $total_questions) * 100) : 0;
        $passed = $percentage_score >= $quiz->passing_score;

        // Update the attempt record
        $attempt->update([
            'score' => $correct_answers,
            'total_questions' => $total_questions,
            'percentage_score' => $percentage_score,
            'passed' => $passed,
            'completed_at' => Carbon::now(),
            'submission_data' => $submission_data, // Save submission data
        ]);

        // Optional: Send Email with Score, Corrections, and Certificate (if passed)
        if (class_exists(\App\Mail\QuizResultMail::class)) {
            Mail::to($user->email)->send(new QuizResultMail($user, $quiz->course, $attempt, $questions));
        }

        // Success message for the user
        $message = "Your quiz, '{$quiz->title}', has been submitted and graded! Your score is {$percentage_score}%.";
        
        if ($passed) {
            $message .= " Congratulations, you passed! 🎉";
        } else {
             $message .= " You did not meet the passing score of {$quiz->passing_score}%.";
        }

        return redirect()->route('student.dashboard')->with('success', $message);
    }
    
    /**
     * Display a list of past (archived) quizzes for a course, along with student results.
     */
    public function pastQuizzes(Course $course)
    {
        $user = auth()->user();

        // Fetch all archived quizzes (status = 1) for this course.
        $pastQuizzes = $course->quizzes()
            ->where('status', 1) 
            ->with(['attempts' => function($query) use ($user) {
                // Filter attempts to only include the current user's completed attempts
                $query->where('user_id', $user->id)
                      ->whereNotNull('completed_at')
                      ->latest('completed_at');
            }, 'questions']) 
            ->get();

        return view('pages.student.quizzes.past', compact('course', 'pastQuizzes'));
    }

// ...

    /**
     * Display the detailed result and corrections for a specific completed attempt.
     */
    public function showAttempt(QuizAttempt $attempt)
    {
        // 1. Authorization check: Ensure the current user owns the attempt.
        if ($attempt->user_id !== auth()->id()) {
            abort(403);
        }

        // 2. Ensure the attempt is completed.
        if (is_null($attempt->completed_at)) {
             return redirect()->route('student.dashboard')->with('error', 'The attempt is not yet completed.');
        }

        // 3. Eager load necessary relations for the view.
        $attempt->load('quiz.course', 'quiz.questions');

        // 4. Prepare data for the view
        $submissionData = $attempt->submission_data;
        $quiz = $attempt->quiz; // <--- ADDED: Extract quiz from attempt
        $questions = $quiz->questions->keyBy('id'); 

        // Pass $quiz explicitly
        return view('pages.student.quizzes.attempt_show', compact('attempt', 'submissionData', 'questions', 'quiz')); 
    }

    /**
     * Display the archived quiz questions and correct answers for all enrolled students.
     * This is for review, not for attempting the quiz.
     */
    public function showArchivedQuiz(Quiz $quiz)
    {
        // Check if the quiz is archived (status = 1) - required for this view.
        if ($quiz->status !== 1) {
            return redirect()->route('student.dashboard')->with('error', 'This quiz is currently active and cannot be reviewed.');
        }

        // 1. Eager load questions (with correct answers) and the course.
        $quiz->load('course', 'questions');

        // 2. The view needs $questions keyed by ID for the structure of attempt_show
        $questions = $quiz->questions->keyBy('id');
        
        // 3. To reuse the attempt_show view, we pass a dummy/null $attempt and empty $submissionData.
        // We now explicitly pass $quiz as well.
        $attempt = null; 
        $submissionData = [];

        // Pass $quiz explicitly
        return view('pages.student.quizzes.attempt_show', compact('quiz', 'questions', 'attempt', 'submissionData'));
    }
}