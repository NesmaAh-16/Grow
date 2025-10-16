<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model
{
    protected $table = 'student_profiles';
    protected $fillable = ['user_id', 'national_id', 'grade', 'semester'];

    public function user()
    {
        //
        //return $this->belongsTo(User::class, 'user_id');
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

    public function getSemesterArabicAttribute(): string
    {
        $raw = trim((string) $this->semester);

        // أرقام
        if ($raw === '1')
            return 'الفصل الأول';
        if ($raw === '2')
            return 'الفصل الثاني';


        $low = mb_strtolower($raw);
        if (in_array($low, ['1st', 'first', 'term1', 't1']))
            return 'الفصل الأول';
        if (in_array($low, ['2nd', 'second', 'term2', 't2']))
            return 'الفصل الثاني';

        // عربي مباشر إن كان مخزّن جاهزًا
        if ($raw !== '')
            return $raw;

        return 'الفصل غير محدد';
    }
}
