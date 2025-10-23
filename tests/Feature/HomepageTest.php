<?php

// The 'test' function is the simplest way to define a test in Pest.
test('the homepage is accessible and displays correct content', function () {
    // 1. Action: Simulate a user visiting the homepage.
    $response = $this->get('/');

    // 2. Assertion: Check if the response was successful (HTTP 200 OK).
    $response->assertStatus(200);

    // 3. Assertion: Check if the page contains a specific, key text.
    $response->assertSee('Tingkatkan Skill Anda Bersama School');
});