<?php

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
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
|
| Routes that can be accessed by any visitor.
|
*/
Route::controller(PageController::class)->group(function () {
    Route::get('/', 'home')->name('home'); // Assuming you add a 'home' method
    Route::get('/courses', 'courseIndex')->name('courses.index');
    Route::get('/courses/{course:slug}', 'courseShow')->name('courses.show');
});


/*
|--------------------------------------------------------------------------
| Guest-Only Routes
|--------------------------------------------------------------------------
|
| Routes that can only be accessed by unauthenticated users.
|
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
| Authenticated User Routes
|--------------------------------------------------------------------------
|
| Routes that require a user to be logged in.
|
*/
Route::middleware('auth')->group(function () {
    // General Authenticated Routes
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('/notifications/{notification}', [NotificationController::class, 'read'])->name('notifications.read');
    Route::post('/courses/{course}/enroll', [EnrollmentController::class, 'store'])->name('courses.enroll');
    Route::get('/my-dashboard', [\App\Http\Controllers\Student\DashboardController::class, 'index'])->name('student.dashboard');
    Route::post('/courses/{course}/reviews', [ReviewController::class, 'store'])->name('courses.reviews.store');

    // Learning Routes (for enrolled students)
    Route::middleware('enrolled')->prefix('learn')->name('learning.')->group(function () {
        Route::get('/courses/{course}/lessons/{lesson}', [LearningController::class, 'showLesson'])->name('lesson');
        Route::post('/courses/{course}/lessons/{lesson}/complete', [LearningController::class, 'completeLesson'])->name('complete');
    });

    // Instructor Routes
    Route::middleware('role:instructor')->prefix('instructor')->name('instructor.')->group(function () {
        Route::get('/dashboard', function () {
            return view('pages.instructor.dashboard');
        })->name('dashboard');

        Route::resource('courses', CourseController::class);
        Route::resource('courses.lessons', LessonController::class)->scoped();
    });

    // Admin Routes
    Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update');

        Route::get('/courses', [\App\Http\Controllers\Admin\CourseController::class, 'index'])->name('courses.index');
        Route::patch('/courses/{course}/toggle-status', [\App\Http\Controllers\Admin\CourseController::class, 'toggleStatus'])->name('courses.toggleStatus');
    });
});