<?php

namespace App\Http\Controllers\Teacher;
use App\Http\Controllers\Controller;
use App\Models\Lesson;

class LessonController extends Controller
{
    public function index()
    {
        $lessons = Lesson::where('teacher_id', auth()->id())->latest()->paginate(12);
        return view('lesson', compact('lessons'));
    }
}
