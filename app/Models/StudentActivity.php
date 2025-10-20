<?php

// app/Models/StudentActivity.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentActivity extends Model
{
    protected $fillable = [
        'student_user_id',
        'teacher_user_id',
        'lesson_id',
        'quiz_id',
        'assignment_id',
        'status',
        'grade',
        'submitted_at'
    ];

    protected $casts = ['submitted_at' => 'datetime', 'grade' => 'decimal:2'];

    public function studentUser()
    {
        return $this->belongsTo(User::class, 'student_user_id');
    }
    public function teacherUser()
    {
        return $this->belongsTo(User::class, 'teacher_user_id');
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }
    public function studentProfile()
    {
        return $this->hasOne(StudentProfile::class, 'user_id', 'student_user_id');
    }
}
