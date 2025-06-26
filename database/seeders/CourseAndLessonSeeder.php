<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CourseAndLessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Get the first instructor to assign courses to
        $instructor = User::where('role', Role::INSTRUCTOR)->first();

        if (!$instructor) {
            $this->command->warn('No instructor user found. Please create one first.');
            return;
        }

        $this->command->info("Creating curated courses and lessons for instructor: {$instructor->name}");

        // 2. Define the curated courses and their lessons
        $coursesData = [
            [
                'course' => [
                    'title' => 'Laravel 12 From Scratch for Beginners',
                    'description' => 'Learn the fundamentals of web development with the most popular PHP framework. We will build a real-world application from the ground up.',
                    'price' => 250000,
                ],
                'lessons' => [
                    ['title' => 'Installation & Setup', 'duration_in_minutes' => 10],
                    ['title' => 'Routing & Controllers', 'duration_in_minutes' => 15],
                    ['title' => 'Blade Templating Engine', 'duration_in_minutes' => 12],
                    ['title' => 'Eloquent ORM Basics', 'duration_in_minutes' => 20],
                    ['title' => 'Forms & Validation', 'duration_in_minutes' => 18],
                ],
            ],
            [
                'course' => [
                    'title' => 'Modern Frontend with Vue.js 3',
                    'description' => 'Build interactive and modern user interfaces with Vue.js. We will cover components, state management with Pinia, and routing.',
                    'price' => 350000,
                ],
                'lessons' => [
                    ['title' => 'Introduction to Vue & The Vue Instance', 'duration_in_minutes' => 15],
                    ['title' => 'Component-Based Architecture', 'duration_in_minutes' => 25],
                    ['title' => 'State Management with Pinia', 'duration_in_minutes' => 22],
                    ['title' => 'Routing with Vue Router', 'duration_in_minutes' => 18],
                    ['title' => 'Communicating with APIs', 'duration_in_minutes' => 20],
                ],
            ],
            [
                'course' => [
                    'title' => 'Advanced Database Design & Optimization',
                    'description' => 'Go beyond basic queries. Learn about database normalization, indexing strategies, and how to write efficient SQL queries for large-scale applications.',
                    'price' => 450000,
                ],
                'lessons' => [
                    ['title' => 'Database Normalization (1NF, 2NF, 3NF)', 'duration_in_minutes' => 30],
                    ['title' => 'Understanding Database Indexes', 'duration_in_minutes' => 25],
                    ['title' => 'Writing Advanced SQL Queries', 'duration_in_minutes' => 28],
                    ['title' => 'Transactions & Concurrency Control', 'duration_in_minutes' => 20],
                ],
            ],
        ];

        // 3. Loop through the data and create records
        foreach ($coursesData as $data) {
            // Create the course
            $course = Course::create([
                'user_id' => $instructor->id,
                'title' => $data['course']['title'],
                'slug' => Str::slug($data['course']['title']),
                'description' => $data['course']['description'],
                'price' => $data['course']['price'],
            ]);

            // Create the lessons for this course
            foreach ($data['lessons'] as $lessonData) {
                $course->lessons()->create([
                    'title' => $lessonData['title'],
                    'slug' => Str::slug($lessonData['title']),
                    'duration_in_minutes' => $lessonData['duration_in_minutes'],
                    'content' => 'This is a sample lesson content. The actual content would be here.',
                ]);
            }
        }
    }
}
