<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;

class StudentDashboardController extends Controller
{
    public function index()
    {
        // 👇 جلب المستخدم الحالي
        $user = auth()->user();

        // 👇 تحميل علاقة الطالب مع البروفايل (StudentProfile)
        $user->load('studentProfile');

        // 👇 الحصول على البروفايل نفسه
        $profile = $user->studentProfile;

        // 👇 تمرير البيانات إلى واجهة الطالب
        return view('subjects', compact('profile'));
        // لاحظ: غيّر 'student.subjects' لاسم ملف الـ Blade عندك
    }
}
