<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

// App\Models\Assignment.php
class Assignment extends Model
{
    protected $fillable = ['lesson_id', 'title', 'due_at', 'body', 'file_path']; // أو due_date بدّل الاسم
    protected $casts = [
        'due_at' => 'datetime', // أو 'due_date' => 'datetime'
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
    public function submissions()
    {
        return $this->hasMany(AssignmentSubmission::class);
    }

    // حالة الواجب: قبل الموعد = "نشط" ، بعده = "منتهي"
     // لا تسمّيه status حتى لا يتضارب مع أي عمود
    public function getStatusLabelAttribute(): string
    {
        if (!$this->due_at) return 'نشط';
        // due_at صار Carbon تلقائياً بسبب $casts
        return $this->due_at->isPast() ? 'منتهي' : 'نشط';
    }
    public function attachments()
    {
        return $this->hasMany(\App\Models\AssignmentAttachment::class);
    }

}

