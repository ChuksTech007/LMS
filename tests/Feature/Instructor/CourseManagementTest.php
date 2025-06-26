<?php

use App\Enums\Role;
use App\Models\Category;
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
    // Arrangement: Create a category that can be assigned to the course
    $category = Category::create(['name' => 'Web Development', 'slug' => 'web-development']);

    // Action: Simulate submitting the form, now including the 'categories' data
    $response = actingAs($this->instructor)->post(route('instructor.courses.store'), [
        'title' => 'Kursus Laravel 12 Terbaru',
        'description' => 'Deskripsi lengkap untuk kursus ini.',
        'price' => 250000,
        'categories' => [$category->id], // This is the required data that was missing
    ]);

    // Assertion 1: Ensure we are redirected successfully
    $response->assertRedirect(route('instructor.courses.index'));

    // Assertion 2: Check that the course was created in the database
    $this->assertDatabaseHas('courses', [
        'title' => 'Kursus Laravel 12 Terbaru',
        'slug' => 'kursus-laravel-12-terbaru',
        'user_id' => $this->instructor->id,
    ]);

    // Assertion 3: Check that the many-to-many relationship was created
    $this->assertDatabaseHas('category_course', [
        'course_id' => Course::first()->id,
        'category_id' => $category->id,
    ]);
});

test('course creation requires a title, description, and price', function () {
    // Action: Try to submit the form with empty data
    $response = actingAs($this->instructor)->post(route('instructor.courses.store'), []);

    // Assertion: Check for validation errors for each specific field
    $response->assertSessionHasErrors(['title', 'description', 'price']);
});

test('instructor cannot edit another instructor\'s course', function () {
    // Arrangement: Create a second instructor and their course
    $otherInstructor = User::factory()->create(['role' => Role::INSTRUCTOR]);
    $courseToEdit = Course::factory()->create(['user_id' => $otherInstructor->id]);

    // Action: Try to access the edit page of the other instructor's course
    $response = actingAs($this->instructor)->get(route('instructor.courses.edit', $courseToEdit));

    // Assertion: Expect a 403 Forbidden error
    $response->assertForbidden();
});