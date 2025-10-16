<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = ['teacher_id', 'title', 'subject', 'content', 'file_path', 'grade', 'published_at'];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
}

