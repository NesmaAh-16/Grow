<?php

// app/Http/Controllers/StudentActivityController.php
namespace App\Http\Controllers;

use App\Models\StudentActivity;
use Illuminate\Http\Request;

class StudentActivityController extends Controller
{
    // تسجيل تسليم (واجب/كويز)
    public function submit(Request $r)
    {
        $data = $r->validate([
            'student_id'   => 'required|exists:students,id',
            'teacher_id'   => 'nullable|exists:teachers,id',
            'lesson_id'    => 'nullable|exists:lessons,id',
            'quiz_id'      => 'nullable|exists:quizzes,id',
            'assignment_id'=> 'nullable|exists:assignments,id',
        ]);

        $data['status'] = 'submitted';
        $data['submitted_at'] = now();

        StudentActivity::create($data);
        return back()->with('status', 'تم تسجيل التسليم.');
    }

    // تصحيح/تقييم
    public function grade(Request $r, StudentActivity $activity)
    {
        $r->validate([
            'grade'  => 'required|numeric|min:0|max:100',
            'status' => 'nullable|in:graded,late,submitted,assigned'
        ]);

        $activity->update([
            'grade'  => $r->grade,
            'status' => $r->status ?? 'graded',
        ]);

        return back()->with('status', 'تم تسجيل الدرجة.');
    }
}
