<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Instructor\CourseController;
use App\Http\Controllers\Instructor\LessonController;
use App\Http\Controllers\Student\EnrollmentController;
use App\Http\Controllers\Student\LearningController;
use App\Http\Controllers\Public\PageController;
use App\Http\Controllers\Student\ReviewController;
use App\Http\Controllers\User\NotificationController;
use App\Http\Controllers\User\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Instructor\QuizController as InstructorQuizController;
use App\Http\Controllers\Student\QuizController as StudentQuizController;
use App\Http\Controllers\Instructor\LiveSessionController; 
use App\Http\Controllers\Student\LiveSessionController as StudentLiveSessionController;
use App\Http\Controllers\Student\PaymentController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Models\Course; 
use App\Models\QuizAttempt;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::controller(PageController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/courses', 'courseIndex')->name('courses.index');
    Route::get('/courses/{course:slug}', 'courseShow')->name('courses.show');
});


/*
|--------------------------------------------------------------------------
| Guest-Only Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::controller(RegisteredUserController::class)->group(function () {
        Route::get('/register', 'create')->name('register');
        Route::post('/register', 'store');
    });

    Route::controller(AuthenticatedSessionController::class)->group(function () {
        Route::get('/login', 'create')->name('login');
        Route::post('/login', 'store');
    });

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.update');
});


/*
|--------------------------------------------------------------------------
| Authenticated User Routes (Student/General)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

     // Certificate Routes
    Route::get('/certificates/{attempt}/download', [
        \App\Http\Controllers\Student\CertificateController::class, 
        'download'
    ])->name('certificates.download');
    
    Route::get('/certificates/{attempt}/view', [
        \App\Http\Controllers\Student\CertificateController::class, 
        'view'
    ])->name('certificates.view');
    
    // General Authenticated Routes
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('/notifications/{notification}', [NotificationController::class, 'read'])->name('notifications.read');
    
    // UPDATED: Payment routes replace direct enrollment
    Route::get('/courses/{course}/payment', [PaymentController::class, 'create'])->name('courses.payment.create');
    Route::post('/courses/{course}/payment', [PaymentController::class, 'store'])->name('courses.payment.store');
    Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
    
    // Keep enrollment route but it will be triggered after payment verification
    Route::post('/courses/{course}/enroll', [EnrollmentController::class, 'store'])->name('courses.enroll');
    
    Route::get('/dashboard', [\App\Http\Controllers\Student\DashboardController::class, 'index'])->name('student.dashboard');
    Route::post('/courses/{course}/reviews', [ReviewController::class, 'store'])->name('courses.reviews.store');
    
    // Student Quiz Routes
    Route::get('quizzes/{quiz}', [StudentQuizController::class, 'show'])->name('quizzes.show');
    Route::post('quizzes/{quiz}/submit', [StudentQuizController::class, 'submit'])->name('quizzes.submit');
    Route::get('quizzes/{quiz}/review', [StudentQuizController::class, 'showArchivedQuiz'])->name('quizzes.review');
    Route::get('courses/{course}/past-quizzes', [StudentQuizController::class, 'pastQuizzes'])->name('quizzes.past');
    Route::get('quizzes/attempt/{attempt}', [StudentQuizController::class, 'showAttempt'])->name('quizzes.attempt.show');
    
    
Route::controller(ProfileController::class)->prefix('profile')->name('profile.')->group(function () {
    Route::get('/', 'edit')->name('edit');
    Route::patch('/', 'update')->name('update');
    Route::put('/password', 'updatePassword')->name('password.update');
});

    // Learning Routes (for enrolled students)
    Route::middleware('enrolled')->prefix('learn')->name('learning.')->group(function () {
        Route::get('/courses/{course}/lessons/{lesson}', [LearningController::class, 'showLesson'])->name('lesson');
        Route::post('/courses/{course}/lessons/{lesson}/complete', [LearningController::class, 'completeLesson'])->name('complete');
    });

    // Instructor Routes
    Route::middleware('role:instructor')->prefix('instructor')->name('instructor.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Instructor\DashboardController::class, 'index'])->name('dashboard');
        Route::resource('courses', CourseController::class);
        Route::resource('courses.lessons', LessonController::class)->scoped();

        // QUIZ MANAGEMENT ROUTES
        Route::resource('quizzes', InstructorQuizController::class)->except(['create', 'show']);
        Route::get('courses/{course}/quiz/create', [InstructorQuizController::class, 'create'])->name('quizzes.create');
        Route::get('quizzes/{quiz}/results', [InstructorQuizController::class, 'results'])->name('quizzes.results');
        Route::patch('quizzes/{quiz}/toggle-status', [InstructorQuizController::class, 'toggleStatus'])->name('quizzes.toggleStatus');
        
        // LIVE SESSION MANAGEMENT ROUTES
        Route::resource('live-sessions', LiveSessionController::class)
            ->except(['show'])
            ->parameters(['live-sessions' => 'liveSession']);
        Route::get('courses/{course}/live-sessions/create', [LiveSessionController::class, 'create'])->name('live-sessions.create');
        Route::get('live-sessions/{liveSession}/join', [LiveSessionController::class, 'join'])->name('live-sessions.join');
        
        // PAYMENT MANAGEMENT ROUTES (Instructor can see their course payments)
        Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments.index');
        Route::get('/payments/{payment}', [AdminPaymentController::class, 'show'])->name('payments.show');
        Route::post('/payments/{payment}/verify', [AdminPaymentController::class, 'verify'])->name('payments.verify');
        Route::post('/payments/{payment}/reject', [AdminPaymentController::class, 'reject'])->name('payments.reject');
    });

    // Student Live Session Join Route
    Route::get('live-sessions/{liveSession}/join', [StudentLiveSessionController::class, 'join'])->name('student.live-sessions.join');

    // Admin Routes
    Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::get('/courses', [\App\Http\Controllers\Admin\CourseController::class, 'index'])->name('courses.index');
        Route::patch('/courses/{course}/toggle-status', [\App\Http\Controllers\Admin\CourseController::class, 'toggleStatus'])->name('courses.toggleStatus');
        Route::resource('/categories', CategoryController::class);
        
        // ADMIN PAYMENT MANAGEMENT
        Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments.index');
        Route::get('/payments/{payment}', [AdminPaymentController::class, 'show'])->name('payments.show');
        Route::post('/payments/{payment}/verify', [AdminPaymentController::class, 'verify'])->name('payments.verify');
        Route::post('/payments/{payment}/reject', [AdminPaymentController::class, 'reject'])->name('payments.reject');
    });
});

use App\Http\Controllers\Auth\GoogleController;

Route::get('/pagetest', function () {
    return view('pagetest');
})->middleware('auth');

Route::get('/auth/google/redirect', [GoogleController::class, 'redirect'])->name('auth.google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('auth.google.callback');