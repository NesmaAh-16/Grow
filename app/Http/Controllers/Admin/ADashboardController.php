<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class ADashboardController extends Controller
{
    public function index()
    {
        /*
        $teachersCount     = User::role('teacher')->count();
        $studentsCount     = User::role('student')->count();
        $pureAdminsCount   = User::role('admin')->count();
        $userAdminsCount   = User::role('user-admin')->count();
        */
        $teachersCount = User::where(function ($q) {
            $q->where('user_type', 'teacher')
                ->orWhereHas('roles', fn($r) => $r->where('name', 'teacher'))
                ->orWhereHas('teacherProfile');
        })->count();

        $studentsCount = User::where(function ($q) {
            $q->where('user_type', 'student')
                ->orWhereHas('roles', fn($r) => $r->where('name', 'student'))
                ->orWhereHas('studentProfile');
        })->count();

        $pureAdminsCount = User::whereHas('roles', fn($q) => $q
            ->where('name', 'admin')->where('guard_name', 'web'))
            ->distinct('users.id')->count('users.id');

        $userAdminsCount = User::where(function ($q) {
            $q->where('user_type', 'user-admin')
                ->orWhereHas('roles', fn($r) => $r->where('name', 'user-admin'))
            ;
        })->count();
        
        return view('super-admin-dashboard', compact(
            'teachersCount',
            'studentsCount',
            'pureAdminsCount',
            'userAdminsCount'
        ));
    }
}
