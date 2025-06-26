<?php

use App\Enums\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses(RefreshDatabase::class);

test('guests cannot access the instructor dashboard', function () {
    // Action: Simulate a guest trying to access the instructor course list
    $response = get('/instructor/courses');

    // Assertion: Expect to be redirected to the login page
    $response->assertRedirect('/login');
});

test('students cannot access the instructor dashboard', function () {
    // Arrangement: Create a user with a 'student' role
    $student = User::factory()->create([
        'role' => Role::STUDENT,
    ]);

    // Action: Act as this student and try to access the instructor page
    $response = actingAs($student)->get('/instructor/courses');

    // Assertion: Expect a 403 Forbidden error
    $response->assertForbidden();
});

test('instructors can access their dashboard', function () {
    // Arrangement: Create a user with an 'instructor' role
    $instructor = User::factory()->create([
        'role' => Role::INSTRUCTOR,
    ]);

    // Action: Act as this instructor and access their page
    $response = actingAs($instructor)->get('/instructor/courses');

    // Assertion: Expect the request to be successful
    $response->assertOk(); // assertOk is a shortcut for assertStatus(200)
});

test('users can authenticate using the login screen', function () {
    // Arrangement: Create a user
    $user = User::factory()->create([
        'password' => bcrypt('password123'), // Use a known password
    ]);

    // Action: Simulate a POST request from the login form
    $response = post('/login', [
        'email' => $user->email,
        'password' => 'password123',
    ]);

    // Assertion: Check that the user is now authenticated
    $this->assertAuthenticated();

    // Assertion: Check that the user was redirected to the homepage
    $response->assertRedirect('/my-dashboard');
});

test('users cannot authenticate with an invalid password', function () {
    // Arrangement: Create a user
    $user = User::factory()->create();

    // Action: Try to login with the wrong password
    post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    // Assertion: Check that the user is NOT authenticated
    $this->assertGuest();
});