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
        $withinWindow =
            (is_null($quiz->available_from) || $quiz->available_from <= $now) &&
            (is_null($quiz->available_to)   || $quiz->available_to   >= $now);

        if (!$withinWindow) {
            return view('attempt-quiz', [
                'quiz'            => $quiz,
                'durationMinutes' => $quiz->duration_minutes ?? 15,
                'error'           => 'خطأ: هذا الاختبار غير متاح حاليًا.',
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
        // TODO: استقبل وقيّم الإجابات حسب نظامك
        return back()->with('ok', 'تم تسليم الاختبار.');
    }
}
