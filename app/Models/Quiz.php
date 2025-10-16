<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = ['lesson_id', 'title', 'available_from', 'available_to']; //
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
    public function results(Quiz $quiz)
    {
        // $quiz موجود أوتوماتيكيًا، ولو مش موجود Laravel يعطي 404
        // اعرض النتائج...
    }
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'title' => 'required|string|max:200',
            'total_marks' => 'nullable|integer|min:1',
            'available_from' => 'nullable|date',
            'available_to' => 'nullable|date|after_or_equal:available_from',
        ]);

        // ملكية الدرس
        abort_unless(
            \App\Models\Lesson::where('id', $data['lesson_id'])
                ->where('teacher_id', auth()->id()) // أو auth()->user()->teacher_id حسب سكيمتك
                ->exists(),
            403
        );

        // ✅ خزّني نتيجة الإنشاء في متغيّر
        $quiz = Quiz::create($data);

        // ✅ مرّري البارامتر باسم route model binding: 'quiz' => $quiz->id
        return redirect()
            ->route('quizzes.questions.create', ['quiz' => $quiz->id])
            ->with('success', 'تم إنشاء الاختبار. أضِف الأسئلة الآن.');
    }
}
