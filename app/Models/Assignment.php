<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = [
        'lesson_id', 'title', 'body', 'due_at', 'file_path', 'weight',
    ];

    protected $casts = [
        'due_at' => 'datetime',
        'weight' => 'integer',
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function submissions()
    {
        return $this->hasMany(AssignmentSubmission::class);
    }

    public function attachments()
    {
        return $this->hasMany(AssignmentAttachment::class);
    }

    public function getStatusLabelAttribute(): string
    {
        if (!$this->due_at) return 'نشط';
        return $this->due_at->isPast() ? 'منتهي' : 'نشط';
    }

}
