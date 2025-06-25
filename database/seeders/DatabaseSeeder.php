<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Instructor',
            'email' => 'instructor@gmail.com',
            'password' => bcrypt('instructor'),
            'role' => 'instructor',
        ]);

        User::factory()->create([
            'name' => 'Student',
            'email' => 'student@gmail.com',
            'password' => bcrypt('student'),
            'role' => 'student',
        ]);
    }
}
