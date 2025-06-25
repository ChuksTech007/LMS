<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\Instructor\LessonController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
});

Route::middleware(['auth', 'role:instructor'])
    ->prefix('instructor')
    ->name('instructor.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('pages.dashboard');
        })->name('dashboard');

        Route::resource('courses', CourseController::class);

        Route::resource('courses.lessons', LessonController::class)->scoped();
    });

// Routes for Registration
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

// Routes for Login
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// Route for Logout
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');