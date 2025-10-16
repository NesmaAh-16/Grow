<?php

namespace App\Http\Controllers\Teacher;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    // قائمة واجبات هذا المعلّم فقط
    public function index()
    {
        $assignments = Assignment::with('lesson')
            ->whereHas('lesson', fn($q) => $q->where('teacher_id', auth()->id()))
            ->latest()->paginate(12);

        return view('homeworks-dashboard', compact('assignments'));
    }

    // صفحة إنشاء واجب
    public function create()
    {
        // دروس المعلّم للاختيار
        $lessons = Lesson::where('teacher_id', auth()->id())->orderBy('title')->get();
        return view('homeworks-dashboard', compact('lessons'));
    }

    // حفظ واجب جديد
    public function store(Request $request) // أو edit إذا أنت مصر، لكن الأفضل store
    {
        $data = $request->validate([
            'lesson_id' => ['required', 'integer', Rule::exists('lessons', 'id')],
            'title' => ['required', 'string', 'max:200'],
            'description' => ['nullable', 'string'],
            'due_at' => ['nullable', 'date'],
            'file' => ['nullable', 'file'],
        ]);

        // جِب الدرس وتأكد أنه يخص المعلّم الحالي
        $lesson = Lesson::whereKey($data['lesson_id'])
            ->where('teacher_id', auth()->id())
            ->firstOrFail(); // ← لو مش موجود/مش تابع له يرجّع 404 بدل null

        // ارفع الملف إن وُجد
        $path = null;
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('assignments', 'public');
        }

        // أنشئ الواجب
        Assignment::create([
            'lesson_id' => $lesson->id,
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'file_path' => $path,
            'due_at' => $data['due_at'] ?? null,
        ]);

        return redirect()
            ->route('homeworks-dashboard')
            ->with('success', 'تم إنشاء الواجب بنجاح.');
    }
    // صفحة تعديل
    public function edit(Assignment $assignment)
    {
        $assignment->load('lesson:id,teacher_id');

        // لو الواجب غير مرتبط بأي درس
        if (!$assignment->lesson) {
            return redirect()->route('homeworks-dashboard')
                ->with('error', 'هذا الواجب غير مرتبط بدرس، رجاءً حدّد درسًا أولًا.');
        }


        // تحقق الملكية
        abort_unless($assignment->lesson->teacher_id === auth()->id(), 403);

        $lessons = Lesson::where('teacher_id', auth()->id())->orderBy('title')->get();
        return view('homework-detials', compact('assignment', 'lessons'));
    }

    public function update(Request $r, Assignment $assignment)
    {
        $assignment->load('lesson:id,teacher_id');
        abort_if(!$assignment->lesson, 404, 'هذا الواجب غير مرتبط بدرس.');
        abort_unless($assignment->lesson->teacher_id === auth()->id(), 403);

        $data = $r->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'file' => 'nullable|file|max:20480',
            'due_at' => 'nullable|date',
        ]);

        // الدرس الجديد لازم يكون مملوك لنفس المعلم
        abort_unless(
            Lesson::where('id', $data['lesson_id'])->where('teacher_id', auth()->id())->exists(),
            403
        );

        if ($r->hasFile('file')) {
            if ($assignment->file_path)
                Storage::disk('public')->delete($assignment->file_path);
            $assignment->file_path = $r->file('file')->store('assignments', 'public');
        }

        $assignment->fill([
            'lesson_id' => $data['lesson_id'],
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'due_at' => $data['due_at'] ?? null,
        ])->save();

        return redirect()->route('homeworks-dashboard')->with('success', 'تم تحديث الواجب.');
    }

    public function destroy(Assignment $assignment)
    {
        $assignment->load('lesson:id,teacher_id');
        abort_if(!$assignment->lesson, 404);
        abort_unless($assignment->lesson->teacher_id === auth()->id(), 403);

        if ($assignment->file_path)
            Storage::disk('public')->delete($assignment->file_path);
        $assignment->delete();

        return back()->with('success', 'تم حذف الواجب.');
    }

}
