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
        User::factory()->createMany([
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin'),
                'role' => Role::ADMIN
            ],
            [
                'name' => 'Instructor',
                'email' => 'ins@gmail.com',
                'password' => Hash::make('admin'),
                'role' => Role::INSTRUCTOR
            ],
            [
                'name' => 'Student',
                'email' => 'stu@gmail.com',
                'password' => Hash::make('admin'),
                'role' => Role::STUDENT
            ],
        ]);

        // Creates 1 Admin, 3 Instructors, 10 Students
        User::factory()->create(['name' => 'Admin User', 'email' => 'admin@skoolio.test', 'role' => Role::ADMIN]);
        User::factory()->count(3)->create(['role' => Role::INSTRUCTOR]);
        User::factory()->count(10)->create(['role' => Role::STUDENT]);

        // Run the Course and Lesson seeder
        $this->call([
            CourseAndLessonSeeder::class,
        ]);
    }
}
