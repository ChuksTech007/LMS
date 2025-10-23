<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'price' => 'decimal:2',
        ];
    }

    /**
     * Get the instructor that owns the course (Explicit name).
     */
    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    /**
     * Get the user that owns the course (Standard Laravel convention).
     */
    public function user(): BelongsTo
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

    /**
     * Get the single quiz for the course.
     */
    public function quiz(): HasOne
    {
        return $this->hasOne(Quiz::class)->where('status', 0);
    }

    /**
     * Get all quizzes for the course (Current and Past).
     */
    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'course_user');
    }

    /**
     * Calculate the completion progress for a specific user.
     */
    public function getProgressFor(User $user): int
    {
        $totalLessonsCount = $this->lessons()->count();

        if ($totalLessonsCount === 0) {
            return 0;
        }

        $completedLessonsCount = $user->completedLessons()
            ->where('course_id', $this->id)
            ->count();

        return ($completedLessonsCount / $totalLessonsCount) * 100;
    }

    /**
     * Get reviews for the course.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get the categories for the course.
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Get live sessions for the course.
     */
    public function liveSessions(): HasMany
    {
        return $this->hasMany(LiveSession::class);
    }

    /**
     * Get payments for the course.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Check if a user has paid for this course.
     */
    public function isPaidBy(User $user): bool
    {
        return $this->payments()
            ->where('user_id', $user->id)
            ->where('status', 'verified')
            ->exists();
    }
}