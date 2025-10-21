<?php

namespace App\Http\Controllers\UserAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TeachersController extends Controller
{
    public function index(Request $r)
    {

        $q = User::where('user_type', 'teacher')
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

        $teachers = $q->with('teacherProfile')->paginate(15)->withQueryString();
        return view('teachers-management', compact('teachers'));
    }

    public function create()
    {
        return view('teachers-create');
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'name' => 'required|string|max:120',
            'user_type' => 'teacher',
            'email' => 'required|email|unique:users,email',
            'national_id' => 'required|string|max:64|unique:users,national_id|unique:teacher_profiles,national_id',
            'status' => 'required|in:active,inactive,blocked,pending',
            'specialty' => 'required|string|max:100',
            'birthdate' => 'nullable|date',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => null,
            'phone' => null,
            'password' => Hash::make(Str::random(10)),
            'user_type' => 'teacher',
            'status' => $data['status'],
            'national_id' => $data['national_id'],
        ]);

        // بروفايل (مطابق لسكيمة جدولك)
        $user->teacherProfile()->create([
            'national_id' => $data['national_id'],
            'specialty' => $data['specialty'],
            'birthdate' => $data['birthdate'] ?? null,
        ]);

        if (method_exists($user, 'assignRole')) {
            $user->assignRole('teacher');
        }

        return redirect()->route('user_admin.teachers')->with('ok', 'تم إنشاء المعلم بنجاح.');
    }

    public function show(User $user)
    {
        abort_unless($user->user_type === 'teacher', 404);
        $user->load('teacherProfile'); // مهم
        return view('teachers-show', compact('user'));
    }

    public function edit(User $user)
    {
        abort_unless($user->user_type === 'teacher' || $user->hasRole('teacher') || $user->teacherProfile, 404);
        $user->loadMissing('teacherProfile');
        return view('teachers-edit', compact('user'));
    }

    public function update(Request $r, User $user)
    {
        abort_unless($user->user_type === 'teacher' || $user->hasRole('teacher') || $user->teacherProfile, 404);

        $data = $r->validate([
            'name' => 'required|string|max:120',
            'user_type' => 'teacher',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'national_id' => 'required|string|max:64|unique:users,national_id,' . $user->id . '|unique:teacher_profiles,national_id,' . optional($user->teacherProfile)->id,
            'status' => 'required|in:active,inactive,blocked,pending',
            'specialty' => 'required|string|max:100',
            'birthdate' => 'nullable|date',
        ]);

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'national_id' => $data['national_id'],
            'status' => $data['status'],
            'user_type' => 'teacher',
        ]);

        $user->teacherProfile()->updateOrCreate(
            [],
            [
                'national_id' => $data['national_id'],
                'specialty' => $data['specialty'],
                'birthdate' => $data['birthdate'] ?? null,
            ]
        );

        return redirect()->route('user_admin.teachers')->with('ok', 'تم تعديل بيانات المعلم.');
    }

    public function destroy(User $user)
    {
        abort_unless($user->user_type === 'teacher', 404);

        // لو عندك softDeletes في users
        $user->delete();

        // لو ما عندك cascade في teacher_profiles، احذفها يدويًّا:
        // $user->teacherProfile()?->delete();

        return redirect()
            ->route('user_admin.teachers')
            ->with('ok', 'تم حذف المعلم.');
    }


    public function activate(User $user)
    {
        abort_unless($user->user_type === 'teacher', 404);
        $user->update(['status' => 'active']);
        return back()->with('ok', 'تم تفعيل حساب المعلم.');
    }

    public function deactivate(User $user)
    {
        abort_unless($user->user_type === 'teacher', 404);
        $user->update(['status' => 'inactive']);
        return back()->with('ok', 'تم تعطيل حساب المعلم.');
    }
}
