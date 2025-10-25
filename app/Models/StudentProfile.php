<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model
{
    protected $table = 'student_profiles';
    protected $fillable = ['user_id', 'national_id', 'grade', 'semester','birth_date'];
    protected $casts = [
        'birth_date' => 'date',
    ];
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

    public function getGradeArabicAttribute(): string
    {
        $map = [
            1 => 'الأول',
            2 => 'الثاني',
            3 => 'الثالث',
            4 => 'الرابع',
            5 => 'الخامس',
            6 => 'السادس',
            7 => 'السابع',
            8 => 'الثامن',
            9 => 'التاسع',
            10 => 'العاشر',
            11 => 'الحادي عشر',
            12 => 'الثاني عشر',
        ];
        $n = (int) ($this->grade ?? 0);
        return $n ? ('الصف ' . ($map[$n] ?? (string) $n)) : 'الصف غير محدد';
    }

    public function getSemesterArabicAttribute()
{
    return match ((int) $this->semester) {
        1 => 'الفصل الأول',
        2 => 'الفصل الثاني',
        default => 'الفصل الأول', // ← الديفولت الحقيقي
    };
}
}
