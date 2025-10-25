<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Support\Carbon;

class StudentDashboardController extends Controller
{


public function index()
{
    $user = auth()->user();
    $user->load('studentProfile');
    $profile = $user->studentProfile;

    $now = Carbon::now();

    // اختبارات متاحة الآن: داخل نافذة الوقت (أو بدون قيود إذا العمود Null)
    $availableQuizzes = Quiz::query()
        ->where(function ($q) use ($now) {
            $q->whereNull('available_from')->orWhere('available_from', '<=', $now);
        })
        ->where(function ($q) use ($now) {
            $q->whereNull('available_to')->orWhere('available_to', '>=', $now);
        })
        ->with('lesson:id,title')   // عدّل العلاقة إن لزم
        ->latest()
        ->get();

    // اختبارات قادمة: لها start > now
    $upcomingQuizzes = Quiz::query()
        ->whereNotNull('available_from')
        ->where('available_from', '>', $now)
        ->with('lesson:id,title')
        ->orderBy('available_from')
        ->get();

    return view('subjects', compact('profile', 'availableQuizzes', 'upcomingQuizzes'));
}

}

