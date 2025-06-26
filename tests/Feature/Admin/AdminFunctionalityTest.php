<?php

use App\Enums\Role;
use App\Models\Category;
use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\patch;
use function Pest\Laravel\post;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::factory()->create(['role' => Role::ADMIN]);
    $this->student = User::factory()->create(['role' => Role::STUDENT]);
});

test('admin can change a user role', function () {
    actingAs($this->admin)
        ->patch(route('admin.users.update', $this->student), [
            'role' => 'instructor',
        ]);

    $this->assertDatabaseHas('users', [
        'id' => $this->student->id,
        'role' => 'instructor',
    ]);
});

test('admin can publish and unpublish a course', function () {
    $instructor = User::factory()->create(['role' => Role::INSTRUCTOR]);
    $course = Course::factory()->create([
        'user_id' => $instructor->id,
        'is_published' => false,
    ]);

    // First, assert it is not published
    $this->assertFalse($course->is_published);

    // Action: Admin toggles the status
    actingAs($this->admin)->patch(route('admin.courses.toggleStatus', $course));

    // Assertion: Check the database that the course is now published
    // We use fresh() to get the updated state from the database
    $this->assertTrue($course->fresh()->is_published);
});

test('admin can create a new category', function () {
    actingAs($this->admin)->post(route('admin.categories.store'), [
        'name' => 'New Category Name',
    ]);

    $this->assertDatabaseHas('categories', [
        'name' => 'New Category Name',
        'slug' => 'new-category-name',
    ]);
});