<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'slug',
        'content',
        'video_url',
        'duration_in_minutes',
    ];

    /**
     * Get the course that the lesson belongs to.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
