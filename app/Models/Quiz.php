<?php

namespace App\Models;
use App\Models\Question; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

  protected $fillable = [
        'course_id',
        'title',
        'description',
        'passing_score',
        'duration_minutes',
        'status'
    ];
    
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function attempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }
}
