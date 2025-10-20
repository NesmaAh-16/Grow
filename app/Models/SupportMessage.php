<?php
// app/Models/SupportMessage.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportMessage extends Model
{
    protected $fillable = [
        'created_by_user_id','student_user_id','teacher_user_id','admin_user_id',
        'subject','message','response','status'
    ];

    public function creator()      { return $this->belongsTo(User::class, 'created_by_user_id'); }
    public function studentUser()  { return $this->belongsTo(User::class, 'student_user_id'); }
    public function teacherUser()  { return $this->belongsTo(User::class, 'teacher_user_id'); }
    public function adminUser()    { return $this->belongsTo(User::class, 'admin_user_id'); }
}
