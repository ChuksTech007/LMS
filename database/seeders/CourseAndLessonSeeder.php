<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseAndLessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all instructors
        $instructors = User::where('role', Role::INSTRUCTOR)->get();

        if ($instructors->isEmpty()) {
            $this->command->warn('Tidak ada user dengan peran instructor. Silakan buat/ubah user terlebih dahulu.');
            return;
        }

        // For each instructor, create some courses, and for each course, create some lessons
        foreach ($instructors as $instructor) {
            Course::factory()
                ->count(8) // Create 8 courses for each instructor
                ->has(Lesson::factory()->count(15)) // And for each of those courses, create 15 lessons
                ->create(['user_id' => $instructor->id]);
        }
    }
}
