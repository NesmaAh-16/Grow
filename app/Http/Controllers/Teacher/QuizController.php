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
        $quizzes = Quiz::with('lesson')
            ->whereHas('lesson', fn($q) => $q->where('teacher_id', auth()->id()))
            ->latest()->paginate(12);

        return view('quizzes-dashboard', compact('quizzes'));
    }


    // عرض
    public function show(Quiz $quiz)
    {
        $quiz->load(['lesson', 'questions']);
        return view('quiz-page', compact('quiz'));
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

    $quiz->load('questions');
    return view('attempt-quiz', compact('quiz'));
}




    public function store(Request $r)
    {
        // 1) فاليديشن للصف + العنوان + باقي الحقول
        $data = $r->validate([
            'grade' => 'required|integer|min:1|max:12',
            'title' => 'required|string|max:200',
            'total_marks' => 'nullable|integer|min:1',
            'available_from' => 'nullable|date',
            'available_to' => 'nullable|date|after_or_equal:available_from',
        ]);

        $teacherId = auth()->id();          // أو auth()->user()->teacher_id حسب سكيمتك
        $subject = 'رياضيات';             // تخصّصك

        // 2) أنشئ/أحضِر درسًا افتراضيًا لهذا المعلّم وهذا الصف (بدون ما تختاري مادة)
        $lesson = Lesson::firstOrCreate(
            ['teacher_id' => $teacherId, 'grade' => $data['grade']],
            ['title' => $subject . ' – الصف ' . $data['grade']]
        );

        // 3) أنشئ الاختبار واربطه بالـ lesson_id
        $quiz = Quiz::create([
            'lesson_id' => $lesson->id,
            'title' => $data['title'],
            'total_marks' => $data['total_marks'] ?? 100,
            'available_from' => $data['available_from'],
            'available_to' => $data['available_to'],
        ]);

        // 4) وجّه مباشرة لصفحة إضافة الأسئلة (الخطوة 2)
        return redirect()
            ->route('quizzes.questions.createContinue', ['quiz' => $quiz->id])
            ->with('success', 'تم إنشاء الاختبار. أضِف الأسئلة الآن.');
    }



    public function results(Quiz $quiz)
    {
        abort_unless($quiz->lesson->teacher_id === auth()->id(), 403);
        return view('quiz-results', compact('quiz'));
    }





    // شاشة تعديل
    public function edit(Quiz $quiz)
    {
        $teacherId = auth()->user()->teacher_id ?? null;
        $lessons = Lesson::when($teacherId, fn($q) => $q->where('teacher_id', $teacherId))
            ->orderBy('title')->get(['id', 'title']);
        return view('teacher.quizzes.edit', compact('quiz', 'lessons'));
    }

}
