<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Table for Quizzes (Exams)
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('passing_score')->default(70); // Percentage required to pass
            $table->integer('duration_minutes')->default(30); // Time limit
            $table->timestamps();
        });

        // Table for Questions (Multiple Choice)
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained()->onDelete('cascade');
            $table->text('text');
            $table->json('options'); // Store options as a JSON array: ['Option A', 'Option B', 'Option C', 'Option D']
            $table->string('correct_answer'); // Store the correct option text (e.g., 'Option C')
            $table->timestamps();
        });

        // Table for Student Quiz Attempts/Results
        Schema::create('quiz_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('quiz_id')->constrained()->onDelete('cascade');
            $table->integer('score'); // Raw score (number of correct answers)
            $table->integer('total_questions');
            $table->integer('percentage_score');
            $table->boolean('passed');
            $table->dateTime('started_at');
            $table->dateTime('completed_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quiz_attempts');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('quizzes');
    }
};
