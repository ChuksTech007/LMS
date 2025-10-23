<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'text',
        'options',
        'correct_answer'
    ];

    // Cast the options column to an array when retrieved
protected $casts = [
        'options' => 'array',
        'correct_answer' => 'string', 
        ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}