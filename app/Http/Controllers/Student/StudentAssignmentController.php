<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentAssignmentController extends Controller
{
    // قائمة الواجبات المتاحة الآن للطالب
    public function index()
    {
        $user = auth()->user();
        $now  = now();

        // إن كان عندك علاقات/قيود صف/فصل/مادة، أضفها في where(...) حسب سكيمتك
        $assignments = Assignment::query()
            // منشور: published_at <= الآن (أو null = غير مقيّد)
            ->where(function($q) use($now) {
                $q->whereNull('published_at')->orWhere('published_at', '<=', $now);
            })
            // لم ينتهِ بعد: due_at >= الآن (أو null = مفتوح)
            ->where(function($q) use($now) {
                $q->whereNull('due_at')->orWhere('due_at', '>=', $now);
            })
            ->with(['lesson:id,title'])
            // جِب إن كان الطالب سلّم من قبل
            ->withCount(['submissions as submitted_by_me' => function($q) use ($user) {
                $q->where('student_id', $user->id);
            }])
            ->orderBy('due_at')
            ->get();

        return view('student.assignments-index', compact('assignments'));
    }

    // صفحة تفاصيل واجب واحد
    public function show(Assignment $assignment)
    {
        $now = now();
        // تحقّق نافذة النشر/التسليم
        $available =
            (is_null($assignment->published_at) || $assignment->published_at <= $now) &&
            (is_null($assignment->due_at)       || $assignment->due_at       >= $now);

        // لو مغلق، اسمح بالعرض لكن لا تسمح بتسليم جديد
        $user = auth()->user();
        $mySubmission = $assignment->submissions()
            ->where('student_id', $user->id)
            ->latest()
            ->first();

        return view('student.assignment-show', [
            'assignment'   => $assignment->loadMissing('lesson:id,title'),
            'available'    => $available,
            'mySubmission' => $mySubmission,
        ]);
    }

    // صفحة نموذج التسليم
    public function createSubmission(Assignment $assignment)
    {
        $now = now();
        $available =
            (is_null($assignment->published_at) || $assignment->published_at <= $now) &&
            (is_null($assignment->due_at)       || $assignment->due_at       >= $now);

        abort_unless($available, 403, 'انتهت مهلة التسليم.');

        return view('student.assignment-submit', compact('assignment'));
    }

    // حفظ التسليم
    public function storeSubmission(Request $r, Assignment $assignment)
    {
        $now = now();
        $available =
            (is_null($assignment->published_at) || $assignment->published_at <= $now) &&
            (is_null($assignment->due_at)       || $assignment->due_at       >= $now);

        abort_unless($available, 403, 'انتهت مهلة التسليم.');

        $data = $r->validate([
            'file' => 'required|file|max:20480|mimes:pdf,doc,docx,ppt,pptx,zip,jpg,jpeg,png',
            'note' => 'nullable|string|max:2000',
        ]);

        $path = $r->file('file')->store('assignments_submissions', 'public');

        AssignmentSubmission::create([
            'assignment_id' => $assignment->id,
            'student_id'    => auth()->id(),
            'file_path'     => $path,
            'note'          => $data['note'] ?? null,
            'submitted_at'  => now(),
        ]);

        return redirect()->route('student.assignments.show', $assignment->id)
            ->with('ok', 'تم رفع التسليم بنجاح.');
    }
}
