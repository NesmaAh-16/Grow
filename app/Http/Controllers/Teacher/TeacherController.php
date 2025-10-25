<?php

namespace App\Http\Controllers\Teacher;
use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\Quiz;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        $teacher = auth()->user();
        $classesCount = Lesson::where('teacher_id', $teacher->id)->count();
        $lessonIds = Lesson::where('teacher_id', $teacher->id)->pluck('id');
        $studentsCount = Enrollment::whereIn('lesson_id', $lessonIds)
                            ->distinct('student_id')->count('student_id');

        $recentAssignments = Assignment::with('lesson')
            ->whereIn('lesson_id', $lessonIds)
            ->latest()->take(5)->get();

        $recentQuizzes = Quiz::with('lesson')
            ->whereIn('lesson_id', $lessonIds)
            ->latest()->take(5)->get();

        return view('teacher', compact(
            'teacher','classesCount','studentsCount','recentAssignments','recentQuizzes'
        ));
    //
    }
}
