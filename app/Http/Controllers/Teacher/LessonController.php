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

     public function details()
    {
        $lessons = Lesson::where('teacher_id', auth()->id())->latest()->paginate(12);
        return view('math', compact('lessons'));
    }

    public function arabic()
    {
        $lessons = Lesson::where('teacher_id', auth()->id())->latest()->paginate(12);
        return view('subject-page', compact('lessons'));
    }
    public function english()
    {
        $lessons = Lesson::where('teacher_id', auth()->id())->latest()->paginate(12);
        return view('english', compact('lessons'));
    }
    public function science()
    {
        $lessons = Lesson::where('teacher_id', auth()->id())->latest()->paginate(12);
        return view('science', compact('lessons'));
    }

}
