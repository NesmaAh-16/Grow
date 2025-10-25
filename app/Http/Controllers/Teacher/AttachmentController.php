<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\AssignmentAttachment;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    public function destroy(Assignment $assignment, AssignmentAttachment $attachment)
    {
        abort_unless($assignment->lesson && $assignment->lesson->teacher_id === auth()->id(), 403);
        abort_unless($attachment->assignment_id === $assignment->id, 404);

        if ($attachment->path) {
            Storage::disk('public')->delete($attachment->path);
        }

        $attachment->delete();

        return back()->with('success', 'تم حذف المرفق.');
    }
}
