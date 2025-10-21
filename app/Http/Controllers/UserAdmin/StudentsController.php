<?php

namespace App\Http\Controllers\UserAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentsController extends Controller
{
    public function index(Request $r)
    {
        // فلاتر بسيطة: بحث برقم الهوية/الاسم/الإيميل + تصفية حسب الحالة
        $q = User::where('user_type', 'student')
            ->when($r->filled('q'), function ($query) use ($r) {
                $term = trim($r->q);
                $query->where(function ($qq) use ($term) {
                    $qq->where('national_id', 'like', "%{$term}%")
                        ->orWhere('name', 'like', "%{$term}%")
                        ->orWhere('email', 'like', "%{$term}%");
                });
            })
            ->when($r->filled('status'), fn($query) => $query->where('status', $r->status))
            ->latest();

        $students = $q->paginate(15)->withQueryString();

        return view('students-management', compact('students'));
    }


    public function show(User $user)
    {
        abort_unless($user->user_type === 'student' || $user->hasRole('student') || $user->studentProfile, 404);
        $user->loadMissing('studentProfile');
        return view('students-show', compact('user'));
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'name' => 'required|string|max:120',
            'email' => 'required|email|unique:users,email',
            'national_id' => 'nullable|string|max:32|unique:users,national_id',
            'status' => 'nullable|in:active,inactive,blocked,pending',
            'grade' => 'nullable|string|max:50',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => null,
            'phone' => null,
            'password' => Hash::make(Str::random(10)),
            'user_type' => 'student',
            'status' => $data['status'],
            'national_id' => $data['national_id'] ?? null,
        ]);


        // بروفايل + رول
        $user->studentProfile()->create([
            'grade' => $data['grade'] ?? null,
            'national_id' => $data['national_id'] ?? null,   // << هنا
        ]);
        if (method_exists($user, 'assignRole')) {
            $user->assignRole('student');
        }

        return back()->with('ok', 'تم إنشاء الطالب.');
    }

    public function create()
    {
        // صفحة إنشاء
        return view('students-create');
    }

    public function edit(User $user)
    {
        abort_unless($user->user_type === 'student' || $user->hasRole('student') || $user->studentProfile, 404);

        // جلب قيمة الصف من البروفايل إن وجدت
        $grade = optional($user->studentProfile)->grade;
        return view('students-edit', compact('user', 'grade'));
    }

    public function update(Request $request, User $user)
    {
        abort_unless($user->user_type === 'teacher', 404);

        $data = $request->validate([
            'name' => 'required|string|max:120',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'national_id' => 'nullable|string|max:64|unique:users,national_id,' . $user->id,
            'status' => 'required|in:active,inactive,blocked,pending',
            'specialty' => 'nullable|string|max:100',
        ]);

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'national_id' => $data['national_id'] ?? null,
            'status' => $data['status'],
            'user_type' => 'teacher',
        ]);

        $user->teacherProfile()->updateOrCreate([], [
            'specialty' => $data['specialty'] ?? null,
        ]);

        return redirect()->route('user_admin.teachers')
            ->with('ok', 'تم تعديل بيانات المعلم.');
    }
    public function activate(User $user)
    {
        abort_unless($user->user_type === 'student', 404);
        $user->update(['status' => 'active']);
        return back()->with('ok', 'تم تفعيل حساب الطالب.');
    }

    public function deactivate(User $user)
    {
        abort_unless($user->user_type === 'student', 404);
        $user->update(['status' => 'inactive']);
        return back()->with('ok', 'تم تعطيل حساب الطالب.');
    }

    public function destroy(User $user)
    {
        abort_unless($user->user_type === 'student', 404);
        // softDeletes موجود عندك، فـ delete = soft delete
        $user->delete();
        return back()->with('ok', 'تم حذف الطالب (Soft Delete).');
    }
}
