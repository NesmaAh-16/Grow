<?php

namespace App\Http\Controllers\UserAdmin;

use App\Models\User;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

    public function index()
    {

        $studentsCount = User::where(function ($q) {
            $q->where('user_type', 'student')
                ->orWhereHas('roles', fn($r) => $r->where('name', 'student'))
                ->orWhereHas('studentProfile');
        })->count();

        $teachersCount = User::where(function ($q) {
            $q->where('user_type', 'teacher')
                ->orWhereHas('roles', fn($r) => $r->where('name', 'teacher'))
                ->orWhereHas('teacherProfile');
        })->count();

        $pendingCount = User::where('status', 'pending')->count();   // أو اكتبي منطقك إن ما بتستخدمي pending
        $inactiveCount = User::where('status', 'inactive')->count();

        $latestUsers = User::latest()->take(10)->get();

        return view('users-admin-dashboard', compact(
            'studentsCount',
            'teachersCount',
            'pendingCount',
            'inactiveCount',
            'latestUsers'
        ));

    }
    public function allUsers()
    {
        $type = request('type');   // 'student' or 'teacher' or null
        $status = request('status'); // active/inactive/blocked/pending or null
        $term = trim((string) request('q'));

        $users = \App\Models\User::query()
            // بحث بالاسم/الإيميل/الهوية
            ->when($term !== '', function ($q) use ($term) {
                $q->where(function ($w) use ($term) {
                    $w->where('name', 'like', "%{$term}%")
                        ->orWhere('email', 'like', "%{$term}%")
                        ->orWhere('national_id', 'like', "%{$term}%");
                });
            })
            // فلترة الحالة كما هي
            ->when($status, fn($q) => $q->where('status', $status))
            // ✅ فلترة النوع بشكل مرن: user_type أو الدور أو وجود بروفايل
            ->when($type === 'student', function ($q) {
                $q->where(function ($qq) {
                    $qq->where('user_type', 'student')
                        ->orWhereHas('roles', fn($r) => $r->where('name', 'student'))
                        ->orWhereHas('studentProfile');
                });
            })
            ->when($type === 'teacher', function ($q) {
                $q->where(function ($qq) {
                    $qq->where('user_type', 'teacher')
                        ->orWhereHas('roles', fn($r) => $r->where('name', 'teacher'))
                        ->orWhereHas('teacherProfile');
                });
            })
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('user-admin-all-users', compact('users'));
    }

}
