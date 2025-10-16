<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'quiz_id', 'type', 'text', 'options', 'correct', 'correct_tf', 'points', 'ord',
    ];

    protected $casts = [
        'options'    => 'array',
        'correct_tf' => 'boolean',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
