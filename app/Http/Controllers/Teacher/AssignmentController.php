<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    public function index()
    {
        $assignments = Assignment::query()
            ->with(['lesson:id,grade,teacher_id'])
            ->withCount('submissions')
            ->whereHas('lesson', fn($q) => $q->where('teacher_id', auth()->id()))
            ->latest()
            ->orderByDesc('due_at')
            ->get();

        return view('homeworks-dashboard', compact('assignments'));
    }

    public function show(Assignment $assignment)
    {
        $assignment->loadMissing(['lesson', 'attachments'])
                   ->loadCount('submissions');

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
        $data = $r->validate([
            'grade'     => ['nullable', 'integer', 'min:1', 'max:12'],
            'lesson_id' => ['nullable', 'exists:lessons,id'],
            'title'     => ['required', 'string', 'max:255'],
            'due_at'    => ['required', 'date'],
            'body'      => ['nullable', 'string'],

            'files'     => ['nullable', 'array'],
            'files.*'   => ['file', 'max:20480'],
        ], [], [
            'grade'     => 'الصف',
            'lesson_id' => 'الدرس',
            'title'     => 'عنوان الواجب',
            'due_at'    => 'تاريخ التسليم',
            'files'     => 'الملفات',
        ]);

        // Lesson id
        if (!empty($data['lesson_id'])) {
            $lessonId = $data['lesson_id'];
        } else {
            $lesson = Lesson::firstOrCreate(
                ['teacher_id' => auth()->id(), 'grade' => $data['grade']],
                ['title' => 'رياضيات – الصف ' . $data['grade']]
            );
            $lessonId = $lesson->id;
        }

        abort_unless(
            Lesson::where('id', $lessonId)->where('teacher_id', auth()->id())->exists(), 403
        );

        // إنشاء
        $assignment = Assignment::create([
            'lesson_id' => $lessonId,
            'title'     => $data['title'],
            'due_at'    => $data['due_at'],
            'body'      => $data['body'] ?? null,
            'file_path' => null,
        ]);

        // مرفقات
        if ($r->hasFile('files')) {
            foreach ($r->file('files') as $file) {
                $stored = $file->store('assignments', 'public');
                $assignment->attachments()->create([
                    'original_name' => $file->getClientOriginalName(),
                    'path'          => $stored,
                    'mime'          => $file->getClientMimeType(),
                    'size'          => $file->getSize(),
                ]);
            }
        }

        return redirect()->route('assignments.index')
                         ->with('success', 'تم إضافة الواجب بنجاح.');
    }

    public function edit(Assignment $assignment)
    {
        $assignment->loadMissing(['attachments', 'lesson']);
        abort_unless($assignment->lesson && $assignment->lesson->teacher_id === auth()->id(), 403);

        $lessons = Lesson::where('teacher_id', auth()->id())
            ->orderBy('grade')->orderBy('title')
            ->get(['id', 'title', 'grade']);

        return view('assignments-edit', compact('assignment', 'lessons'));
    }

    public function update(Request $r, Assignment $assignment)
    {
        $assignment->loadMissing('lesson');
        abort_unless($assignment->lesson && $assignment->lesson->teacher_id === auth()->id(), 403);

        $validated = $r->validate([
            'lesson_id'   => ['required', 'exists:lessons,id'],
            'title'       => ['required', 'string', 'max:255'],
            'body'        => ['nullable', 'string'],
            'due_at'      => ['nullable', 'date'],
            'weight'      => ['nullable', 'integer', 'min:0', 'max:100'],

            'new_files'   => ['nullable', 'array'],
            'new_files.*' => ['file', 'max:20480'],
        ]);

        // تأكيد ملكية الدرس
        abort_unless(
            Lesson::where('id', $validated['lesson_id'])
                  ->where('teacher_id', auth()->id())->exists(), 403
        );

        // ✅ حدّث الأعمدة الفعلية فقط (بدون new_files)
        $assignment->update([
            'lesson_id' => $validated['lesson_id'],
            'title'     => $validated['title'],
            'body'      => $validated['body'] ?? null,
            'due_at'    => $validated['due_at'] ?? $assignment->due_at,
            'weight'    => array_key_exists('weight', $validated) ? $validated['weight'] : $assignment->weight,
        ]);

        // ✅ احفظ المرفقات الجديدة (إن وُجدت) بعد التحديث
        if ($r->hasFile('new_files')) {
            foreach ($r->file('new_files') as $file) {
                $stored = $file->store('assignments', 'public');
                $assignment->attachments()->create([
                    'original_name' => $file->getClientOriginalName(),
                    'path'          => $stored,
                    'mime'          => $file->getClientMimeType(),
                    'size'          => $file->getSize(),
                ]);
            }
        }

        // رسالة نجاح والرجوع للتفاصيل
        return redirect()->route('assignments.show', $assignment->id)
                         ->with('success', 'تم حفظ التعديلات.');
    }

    public function destroy(Assignment $assignment)
    {
        $assignment->loadMissing('lesson', 'attachments');
        abort_unless($assignment->lesson && $assignment->lesson->teacher_id === auth()->id(), 403);

        foreach ($assignment->attachments as $att) {
            if ($att->path) {
                Storage::disk('public')->delete($att->path);
            }
        }

        $assignment->delete();

        return redirect()->route('assignments.index')
                         ->with('success', 'تم حذف الواجب.');
    }
}
