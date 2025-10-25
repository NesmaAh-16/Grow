<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use Notifiable, HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'user_type',
        'username',
        'phone',
        'national_id',
    ];
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed','birth_date' => 'date',
    ];
    public function studentProfile()
    {
        return $this->hasOne(\App\Models\StudentProfile::class, 'user_id', 'id');
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }
    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
    public function teacherProfile()
    {
        return $this->hasOne(\App\Models\TeacherProfile::class);
    }

    public function lessons()
    {
        return $this->hasMany(\App\Models\Lesson::class, 'teacher_id');
    }

}
