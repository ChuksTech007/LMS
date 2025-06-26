<?php

use App\Enums\Role;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Create an instructor and a student for our tests
    $this->instructor = User::factory()->create(['role' => Role::INSTRUCTOR]);
    $this->student = User::factory()->create(['role' => Role::STUDENT]);

    // Create a course with lessons
    $this->course = Course::factory()
        ->has(Lesson::factory()->count(5))
        ->create(['user_id' => $this->instructor->id]);
});

test('a student can enroll in a course', function () {
    actingAs($this->student)
        ->post(route('courses.enroll', $this->course))
        ->assertRedirect(route('courses.show', $this->course));

    $this->assertDatabaseHas('course_user', [
        'user_id' => $this->student->id,
        'course_id' => $this->course->id,
    ]);
});

test('an enrolled student can access the learning page', function () {
    // Enroll the student first
    $this->student->enrolledCourses()->attach($this->course);

    $firstLesson = $this->course->lessons->first();

    actingAs($this->student)
        ->get(route('learning.lesson', [$this->course, $firstLesson]))
        ->assertOk()
        ->assertSee($firstLesson->title);
});

test('a non-enrolled user cannot access the learning page', function () {
    $firstLesson = $this->course->lessons->first();

    actingAs($this->student)
        ->get(route('learning.lesson', [$this->course, $firstLesson]))
        ->assertForbidden(); // Expect 403 Forbidden
});

test('an enrolled student can mark a lesson as complete', function () {
    $this->student->enrolledCourses()->attach($this->course);
    $firstLesson = $this->course->lessons->first();

    actingAs($this->student)
        ->post(route('learning.complete', [$this->course, $firstLesson]))
        ->assertRedirect();

    $this->assertDatabaseHas('lesson_user', [
        'user_id' => $this->student->id,
        'lesson_id' => $firstLesson->id,
    ]);
});