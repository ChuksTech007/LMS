<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'description',
        'price',
        'thumbnail',
    ];

    /**
     * Get the user that owns the course.
     */
    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the lessons for the course.
     */
    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }
}
