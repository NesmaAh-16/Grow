<?php

/*namespace App\Http\Controllers\Teacher;
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
*/




namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LessonController extends Controller
{
    // قائمة الدروس
    public function index(Request $r)
    {
        $q = Lesson::query()->where('teacher_id', auth()->id())->latest();

        if ($r->filled('grade')) {
            $q->where('grade', (int) $r->grade);
        }

        $lessons = $q->paginate(15);

        return view('lesson-index', compact('lessons'));
    }

    // صفحة إنشاء
    public function create()
    {
        return view('lessons-create');
    }

    // حفظ درس جديد
    public function store(Request $r)
    {
        $data = $r->validate([
            'title'   => ['required','string','max:200'],
            'subject' => ['nullable','string','max:120'],
            'content' => ['nullable','string'],
            'grade'   => ['nullable','integer','min:1','max:12'],
            'file'    => ['nullable','file','max:20480'], // 20MB
        ], [], [
            'title' => 'عنوان الدرس',
            'file'  => 'الملف',
        ]);

        $filePath = null;
        if ($r->hasFile('file')) {
            $filePath = $r->file('file')->store('lessons', 'public');
        }

        $lesson = Lesson::create([
            'teacher_id'   => auth()->id(),
            'title'        => $data['title'],
            'subject'      => $data['subject'] ?? null,
            'content'      => $data['content'] ?? null,
            'file_path'    => $filePath,
            'grade'        => $data['grade'] ?? null,
            'published_at' => now(),
        ]);

        return redirect()->route('lessons.show', $lesson)->with('success', 'تم إضافة الدرس.');
    }

    // عرض درس
    public function show(Lesson $lesson)
    {
        abort_unless($lesson->teacher_id === auth()->id(), 403);
        return view('lessons-show', compact('lesson'));
    }

    // صفحة تعديل
    public function edit(Lesson $lesson)
    {
        abort_unless($lesson->teacher_id === auth()->id(), 403);
        return view('lessons-edit', compact('lesson'));
    }

    // حفظ التعديل
    public function update(Request $r, Lesson $lesson)
    {
        abort_unless($lesson->teacher_id === auth()->id(), 403);

        $data = $r->validate([
            'title'       => ['required','string','max:200'],
            'subject'     => ['nullable','string','max:120'],
            'content'     => ['nullable','string'],
            'grade'       => ['nullable','integer','min:1','max:12'],
            'file'        => ['nullable','file','max:20480'],
            'remove_file' => ['nullable','boolean'],
        ], [], [
            'title' => 'عنوان الدرس',
            'file'  => 'الملف',
        ]);

        // حذف الملف الحالي إن طُلِب
        if ($r->boolean('remove_file') && $lesson->file_path) {
            Storage::disk('public')->delete($lesson->file_path);
            $lesson->file_path = null;
        }

        // رفع ملف جديد
        if ($r->hasFile('file')) {
            if ($lesson->file_path) {
                Storage::disk('public')->delete($lesson->file_path);
            }
            $lesson->file_path = $r->file('file')->store('lessons', 'public');
        }

        $lesson->update([
            'title'   => $data['title'],
            'subject' => $data['subject'] ?? null,
            'content' => $data['content'] ?? null,
            'grade'   => $data['grade'] ?? null,
        ]);

        return redirect()->route('lessons.show', $lesson)->with('success', 'تم تحديث الدرس.');
    }

    // حذف
    public function destroy(Lesson $lesson)
    {
        abort_unless($lesson->teacher_id === auth()->id(), 403);

        if ($lesson->file_path) {
            Storage::disk('public')->delete($lesson->file_path);
        }
        $lesson->delete();

        return redirect()->route('lessons.index')->with('success', 'تم حذف الدرس.');
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
