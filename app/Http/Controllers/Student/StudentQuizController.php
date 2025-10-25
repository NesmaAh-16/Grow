<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Http\Request;

class StudentQuizController extends Controller
{
    public function start(Quiz $quiz)
    {
        $quiz->load('questions:id,quiz_id,text,type,points,options');

        $now = now();
        $isPublished = (bool) $quiz->published;
        $withinWindow =
            (is_null($quiz->start_at) || $quiz->start_at <= $now) &&
            (is_null($quiz->end_at)   || $quiz->end_at   >= $now);

        if (!$isPublished || !$withinWindow) {
            // نفس رسالة الخطأ في لقطة الشاشة
            return view('attempt-quiz', [
                'quiz'            => $quiz,
                'durationMinutes' => $quiz->duration_minutes ?? 15,
                'error'           => 'خطأ: لا يوجد اختبار منشور حاليًا. الرجاء إنشاء اختبار أولاً من لوحة تحكم المعلم.',
            ]);
        }

        return view('attempt-quiz', [
            'quiz'            => $quiz,
            'durationMinutes' => $quiz->duration_minutes ?? 15,
            'error'           => null,
        ]);
    }

    public function submit(Request $request, Quiz $quiz)
    {
        // استقبل answers[] واحسب الدرجة… (اتركها عندك إن كان موجود)
        // placeholder:
        // validate/grade/store attempt result…
        return back()->with('ok', 'تم تسليم الاختبار.');
    }
}
