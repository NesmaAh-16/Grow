<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignmentSubmission extends Model
{
    protected $fillable = [
        'assignment_id',
        'student_id',
        'file_path',
        'notes',
        'submitted_at'
    ];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }
    public function studentProfile()
    {
        return $this->belongsTo(\App\Models\StudentProfile::class, 'student_id');
    }
    public function student()
    {
        return $this->belongsTo(\App\Models\User::class, 'student_id');
    }
}
