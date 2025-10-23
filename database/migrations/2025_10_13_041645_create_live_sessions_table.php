<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('live_sessions', function (Blueprint $table) {
            $table->id();
            // Links this session to a specific course
            $table->foreignId('course_id')->constrained()->onDelete('cascade'); 
            $table->string('title');
            $table->string('bbb_meeting_id')->unique(); // Unique ID for BigBlueButton
            $table->integer('duration_minutes')->default(60); // Meeting duration
            $table->dateTime('start_time'); // When the class is scheduled
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('live_sessions');
    }
};