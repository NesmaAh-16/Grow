<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Lesson;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    // قائمة الواجبات
    public function index()
    {
        $assignments = \App\Models\Assignment::query()
        ->with(['lesson:id,grade,teacher_id'])      // الصف
        ->withCount('submissions')                  // عدد الطلاب المسلّمين
        ->whereHas('lesson', fn($q) => $q->where('teacher_id', auth()->id()))
        ->latest()
        ->orderByDesc('due_at')
        ->get();

        return view('homeworks-dashboard', compact('assignments'));
    }

    public function show(Assignment $assignment)
    {
        $assignment->loadMissing('lesson');
        abort_unless($assignment->lesson && $assignment->lesson->teacher_id === auth()->id(), 403);

        return view('homework-detials', compact('assignment'));
    }

    public function create()
    {
        $lessons = Lesson::where('teacher_id', auth()->id())
            ->orderBy('grade')->orderBy('title')
            ->get(['id', 'title', 'grade']);
        return view('create-homework', compact('lessons'));
    }

    public function store(Request $r)
    {
        // 1) فاليديشن (grade أو lesson_id)
        $data = $r->validate([
            // لو بتستخدمي grade فقط:
            'grade' => ['nullable', 'integer', 'min:1', 'max:12'],
            // ولو أحياناً بتمرّري lesson_id جاهز بدلاً من grade:
            'lesson_id' => ['nullable', 'exists:lessons,id'],

            'title' => ['required', 'string', 'max:255'],
            'due_at' => ['required', 'date'],      // <-- وحّدي الاسم مع العمود (due_at أو due_date)
            'body' => ['nullable', 'string'],
            'file' => ['nullable', 'file', 'max:20480'],
        ], [], [
            'grade' => 'الصف',
            'lesson_id' => 'الدرس',
            'title' => 'عنوان الواجب',
            'due_at' => 'تاريخ التسليم',
            'file' => 'الملف',
        ]);

        // 2) حددي الـ lesson_id
        if (!empty($data['lesson_id'])) {
            // لو جاي من الفورم
            $lessonId = $data['lesson_id'];
        } else {
            // لو جاي grade -> أنشئي/أحضري درساً افتراضياً لهذا المعلّم
            $lesson = Lesson::firstOrCreate(
                ['teacher_id' => auth()->id(), 'grade' => $data['grade']],
                ['title' => 'رياضيات – الصف ' . $data['grade']]
            );
            $lessonId = $lesson->id;
        }

        // 3) تأكيد الملكية: لازم الدرس يتبع للمعلّم الحالي
        abort_unless(
            Lesson::where('id', $lessonId)->where('teacher_id', auth()->id())->exists(),
            403
        );

        // 4) رفع الملف إن وجد
        $filePath = null;
        if ($r->hasFile('file')) {
            $filePath = $r->file('file')->store('assignments', 'public');
        }

        // 5) إنشاء الواجب
        Assignment::create([
            'lesson_id' => $lessonId,
            'title' => $data['title'],
            'due_at' => $data['due_at'],      // <-- غيّري لـ 'due_date' إذا هذا اسم عمودك
            'body' => $data['body'] ?? null,
            'file_path' => $filePath,
        ]);

        return redirect()->route('assignments.index')->with('success', 'تم إضافة الواجب بنجاح.');
    }

    public function edit(Assignment $assignment)
    {
        $assignment->loadMissing(['attachments','lesson']);
        abort_unless($assignment->lesson && $assignment->lesson->teacher_id === auth()->id(), 403);

        $lessons = Lesson::where('teacher_id', auth()->id())->orderBy('grade')->orderBy('title')->get(['id', 'title', 'grade']);
        return view('homework-detials', compact('assignment', 'lessons'));
    }

    public function update(Request $r, Assignment $assignment)
    {
        $assignment->loadMissing('lesson');
        abort_unless($assignment->lesson && $assignment->lesson->teacher_id === auth()->id(), 403);

        $data = $r->validate([
            'lesson_id' => ['required', 'exists:lessons,id'],
            'title' => ['required', 'string', 'max:255'],
            'body' => ['nullable', 'string'],
            'due_at' => ['nullable', 'date'],
            'weight' => ['nullable', 'integer', 'min:0', 'max:100'],
        ]);

        abort_unless(Lesson::where('id', $data['lesson_id'])
            ->where('teacher_id', auth()->id())->exists(), 403);

        $assignment->update($data);

        return redirect()->route('assignments.index')->with('success', 'تم تحديث الواجب.');
    }

    public function destroy(Assignment $assignment)
    {
        $assignment->loadMissing('lesson');
        abort_unless($assignment->lesson && $assignment->lesson->teacher_id === auth()->id(), 403);

        $assignment->delete();
        return redirect()->route('assignments.index')->with('success', 'تم حذف الواجب.');
    }
}
