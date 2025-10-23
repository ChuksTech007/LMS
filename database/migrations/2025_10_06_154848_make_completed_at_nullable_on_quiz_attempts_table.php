<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('quiz_attempts', function (Blueprint $table) {
            // Change the 'completed_at' column to be nullable
            $table->timestamp('completed_at')->nullable()->change();
            
            // OPTIONAL: If 'score', 'percentage_score', and 'passed' are also causing issues and should be nullable/have defaults:
            // $table->integer('score')->default(0)->change();
            // $table->decimal('percentage_score', 5, 2)->default(0)->change();
            // $table->boolean('passed')->default(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quiz_attempts', function (Blueprint $table) {
            // Revert the 'completed_at' column to NOT nullable (optional, depends on original schema)
            // Note: This will fail if there are existing NULL values.
            $table->timestamp('completed_at')->nullable(false)->change();
        });
    }
};