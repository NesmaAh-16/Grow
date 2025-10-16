<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
     public $timestamps = false;
    protected $fillable = ['student_id','lesson_id','enrolled_at'];

    public function lesson()  { return $this->belongsTo(Lesson::class); }
    public function student() { return $this->belongsTo(User::class, 'student_id'); }
}
