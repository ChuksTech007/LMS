<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LiveSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'bbb_meeting_id',
        'duration_minutes',
        'start_time',
    ];

protected $casts = [
    'start_time' => 'datetime',
    'duration_minutes' => 'integer',
];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}