<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create 1 Admin
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'role' => Role::INSTRUCTOR,
        ]);

        User::factory()->create([
            'name' => 'Student',
            'email' => 'student@gmail.com',
            'password' => Hash::make('student'),
            'role' => Role::STUDENT,
        ]);

        // Create 3 Instructors
        User::factory()->count(3)->create([
            'role' => Role::INSTRUCTOR,
        ]);

        // Create 10 Students
        User::factory()->count(10)->create([
            'role' => Role::STUDENT,
        ]);

        // Run the Course and Lesson seeder
        $this->call([
            CourseAndLessonSeeder::class,
        ]);
    }
}
