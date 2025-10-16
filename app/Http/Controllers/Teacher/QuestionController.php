<?php
// app/Http/Controllers/Teacher/QuestionController.php
namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class QuestionController extends Controller
{
    public function create(Quiz $quiz)
    {
        // لإظهار ملخص الاختبار أعلى الصفحة
        $quiz->loadCount('questions');
        return view('create-quiz-step2', compact('quiz'));
    }
    public function createContinue(\App\Models\Quiz $quiz)
    {
        $quiz->loadCount('questions');
        return view('create-quiz-step2', compact('quiz'));
    }

    //href="{{ route('quizzes.createContinue') }}"

    public function store(Request $r, Quiz $quiz)
    {

        $data = $r->validate([
            'questions' => 'required|array|min:1',
            'questions.*.type' => 'required|in:mc,tf',
            'questions.*.text' => 'required|string',
            'questions.*.points' => 'nullable|integer|min:1',
            'questions.*.ord' => 'nullable|integer|min:1',
            // لِـ MC:
            'questions.*.options' => 'nullable|array',
            'questions.*.options.*' => 'nullable|string',
            'questions.*.correct' => 'nullable|integer|min:1|max:4',
            // لِـ TF:
            'questions.*.correct_tf' => 'nullable|boolean',
        ]);

        foreach ($data['questions'] as $q) {
            $row = [
                'quiz_id' => $quiz->id,
                'type' => $q['type'],
                'text' => $q['text'],
                'points' => $q['points'] ?? 1,
                'ord' => $q['ord'] ?? 1,
            ];

            if ($q['type'] === 'mc') {
                $row['options'] = array_values(array_filter($q['options'] ?? []));
                $row['correct'] = $q['correct'] ?? null;
                $row['correct_tf'] = null;
            } else {
                $row['options'] = null;
                $row['correct'] = null;
                $row['correct_tf'] = (bool) ($q['correct_tf'] ?? false);
            }
            Question::query()->create($row);
            //Question::create($row);
        }

        return redirect()->route('quizzes.show', $quiz->id)->with('success', 'تم حفظ الأسئلة.');
    }
}
