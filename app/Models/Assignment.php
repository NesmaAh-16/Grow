<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = ['lesson_id','title','description','file_path','due_at'];
    public function lesson() { return $this->belongsTo(Lesson::class); }
}
