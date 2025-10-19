<?php

namespace App\Http\Controllers\Teacher;
use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = \App\Models\Quiz::with(['lesson:id,grade,title'])
            ->whereHas('lesson', fn($q) => $q->where('teacher_id', auth()->id()))
            ->withCount('questions')
            ->latest()
            ->paginate(12);

        return view('quizzes-dashboard', compact('quizzes'));
    }



    // عرض
    /* public function show(int $id)
     {
         $quiz = Quiz::withCount('questions')
             ->with(['lesson', 'questions'])
             ->findOrFail($id);
             //$quiz->loadMissing('lesson','questions')->loadCount('questions');
         $quiz->load(['lesson', 'questions']);
         $attemptsAllowed = $quiz->attempts_allowed ?? 1;
         $totalMarks = $quiz->total_marks ?? 100;
         return view('quiz-page', compact('quiz', 'attemptsAllowed', 'totalMarks'));
     }*/

    public function show(Quiz $quiz)
    {
        // تحميل العلاقات
        $quiz->loadMissing('lesson', 'questions')->loadCount('questions');

        // حماية الملكية (لو لازم)
        if ($quiz->lesson && $quiz->lesson->teacher_id !== auth()->id()) {
            abort(403);
        }

        $attemptsAllowed = $quiz->attempts_allowed ?? 1;
        $totalMarks = $quiz->total_marks ?? 100;

        return view('quiz-page', compact('quiz', 'attemptsAllowed', 'totalMarks'));
    }

    public function create()
    {
        $lessons = \App\Models\Lesson::where('teacher_id', auth()->id())
            ->orderBy('title')->get(['id', 'title']);
        return view('create-quiz', compact('lessons'));
    }


    public function createContinue()
    {
        $lessons = Lesson::where('teacher_id', auth()->id())->get();
        return view('create-quiz-step2', compact('lessons'));
    }
    public function attempt(Quiz $quiz)
    {
        $now = now();

        if ($quiz->available_from && $now->lt($quiz->available_from)) {
            return back()->with('error', 'الاختبار لم يبدأ بعد.');
        }
        if ($quiz->available_to && $now->gt($quiz->available_to)) {
            return back()->with('error', 'انتهى وقت الاختبار.');
        }

        $quiz->load('questions')->loadCount('questions');
        $durationMinutes = $quiz->duration_minutes ?? 15;
        $attemptsAllowed = $quiz->attempts_allowed ?? 1;
        $totalMarks = $quiz->total_marks ?? $quiz->questions->sum('points');
        return view('attempt-quiz', compact('quiz', 'durationMinutes', 'attemptsAllowed', 'totalMarks'));
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'grade' => ['required', 'integer', 'min:1', 'max:12'],
            'title' => ['required', 'string', 'max:200'],
            'total_marks' => ['nullable', 'integer', 'min:1'],
            'attempts_allowed' => ['nullable', 'integer', 'min:1', 'max:20'],
            'available_from' => ['nullable', 'date'],
            'available_to' => ['nullable', 'date', 'after_or_equal:available_from'],
        ]);

        $teacherId = auth()->id();
        $subject = 'رياضيات';

        $lesson = Lesson::firstOrCreate(
            ['teacher_id' => $teacherId, 'grade' => $data['grade']],
            ['title' => $subject . ' – الصف ' . $data['grade']]
        );

        $attempts = (int) $r->input('attempts_allowed', 1);
        $attempts = max(1, min(20, $attempts));

        $quiz = Quiz::create([
            'lesson_id' => $lesson->id,
            'title' => $data['title'],
            'total_marks' => $data['total_marks'] ?? 100,
            'attempts_allowed' => $data['attempts_allowed'] ?? 1,   // اجعل الافتراضي 1 إن أردت
            'available_from' => $data['available_from'],
            'available_to' => $data['available_to'],
        ]);

        return redirect()
            ->route('quizzes.questions.createContinue', ['quiz' => $quiz->id])
            ->with('success', 'تم إنشاء الاختبار. أضِف الأسئلة الآن.');
    }




    // App\Http\Controllers\Teacher\QuizController.php
    public function results(Quiz $quiz)
    {
        // حمّل العلاقات المطلوبة إن لم تكن محمّلة
        $quiz->loadMissing('lesson', 'questions');

        // لو الاختبار غير مرتبط بدرس (أو الدرس محذوف)
        if (!$quiz->lesson) {
            return redirect()
                ->route('quizzes.index')
                ->with('error', 'هذا الاختبار غير مرتبط بدرس. يرجى ربطه بدرس أولاً.');
        }

        // تحقّق الملكية: لا تسمح لغير المعلّم المالك
        abort_unless($quiz->lesson->teacher_id === auth()->id(), 403);

        return view('quiz-results', compact('quiz'));
    }

    public function edit(Quiz $quiz)
    {
        // التحقق من ملكية المعلم للاختبار
        abort_unless($quiz->lesson && $quiz->lesson->teacher_id === auth()->id(), 403);

        // جلب الدروس التي يملكها هذا المعلم فقط
        $lessons = Lesson::where('teacher_id', auth()->id())
            ->orderBy('title')
            ->get(['id', 'title', 'grade']);

        return view('quiz-edit', compact('quiz', 'lessons'));
    }


    public function update(Request $r, Quiz $quiz)
    {
        $data = $r->validate([
            'title' => ['required', 'string', 'max:200'],
            'total_marks' => ['required', 'integer', 'min:1'],
            'attempts_allowed' => ['required', 'integer', 'min:1'],
            'available_from' => ['nullable', 'date'],
            'available_to' => ['nullable', 'date', 'after:available_from'],
            'lesson_id' => ['required', 'integer', 'exists:lessons,id'],
        ]);
        $quiz->update($data);
        return back();
    }
}
