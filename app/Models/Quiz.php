<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quiz extends Model
{
    protected $fillable = [
        'lesson_id',
        'title',
        'total_marks',
        'available_from',
        'available_to',
        'attempts_allowed',
    ];

    protected $casts = [
        'available_from'    => 'datetime',
        'available_to'      => 'datetime',
        'options'           => 'array',
        'attempts_allowed'  => 'integer',
    ];

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function getDurationMinutesAttribute(): ?int
    {
        if (!$this->available_from || !$this->available_to) {
            return null;
        }
        return $this->available_from->diffInMinutes($this->available_to);
    }
    use SoftDeletes;
}
