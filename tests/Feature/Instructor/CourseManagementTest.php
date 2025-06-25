<?php

use App\Enums\Role;
use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Create an instructor user before each test in this file
    $this->instructor = User::factory()->create(['role' => Role::INSTRUCTOR]);
});

test('instructor can view their course management page', function () {
    // Arrangement: Create a course that belongs to this instructor
    $course = Course::factory()->create(['user_id' => $this->instructor->id]);

    // Action: Visit the course management page
    $response = actingAs($this->instructor)->get(route('instructor.courses.index'));

    // Assertion: The page loaded successfully and we can see the course title
    $response->assertOk();
    $response->assertSee($course->title);
});

test('instructor can access the create course page', function () {
    actingAs($this->instructor)
        ->get(route('instructor.courses.create'))
        ->assertOk()
        ->assertSee('Tambah Kursus Baru');
});

test('instructor can create a new course', function () {
    // Action: Simulate submitting the form to create a course
    actingAs($this->instructor)->post(route('instructor.courses.store'), [
        'title' => 'Kursus Laravel 12 Terbaru',
        'description' => 'Deskripsi lengkap untuk kursus ini.',
        'price' => 250000,
    ]);

    // Assertion: Check that the course was actually created in the database
    $this->assertDatabaseHas('courses', [
        'title' => 'Kursus Laravel 12 Terbaru',
        'slug' => 'kursus-laravel-12-terbaru',
        'user_id' => $this->instructor->id,
    ]);
});

test('course creation requires a title, description, and price', function () {
    // Action: Try to submit the form with empty data
    $response = actingAs($this->instructor)->post(route('instructor.courses.store'), []);

    // Assertion: Check for validation errors for each specific field
    $response->assertSessionHasErrors(['title', 'description', 'price']);
});