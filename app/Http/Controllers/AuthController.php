<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\StudentProfile;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            }
            if ($user->hasRole('user-admin')) {
                return redirect()->route('user_admin.dashboard');
            } elseif ($user->hasRole('teacher')) {
                return redirect()->route('teacher.dashboard');
            } elseif ($user->hasRole('student')) {
                return redirect()->route('student.dashboard');
            }
        }
        return view('login');
    }
    private function redirectByRole(User $user)
    {
        if ($user->hasRole('super-admin'))
            return redirect()->route('admin.dashboard');
        if ($user->hasRole('admin'))
            return redirect()->route('admin.dashboard');
        if ($user->hasRole('user-admin'))
            return redirect()->route('user_admin.dashboard');
        if ($user->hasRole('teacher'))
            return redirect()->route('teacher.dashboard');
        if ($user->hasRole('student'))
            return redirect()->route('student.dashboard');

        Auth::logout();
        return redirect()->route('login')->withErrors([
            'email' => 'الحساب لا يملك أي دور مفعّل.'
        ]);
    }

    public function attempt(Request $r)
    {
        $role = $r->input('login_as', 'admin'); // admin | teacher | student
        if ($role === 'student') {
            $r->validate([
                'studentId' => ['required', 'string', 'min:3', 'max:64'],
                'password' => ['required', 'string', 'min:6'],
            ]);

            $profile = StudentProfile::with('user')
                ->where('national_id', $r->studentId)
                ->first();

            if (!$profile || !$profile->user) {
                return back()
                    ->withErrors(['studentId' => 'رقم الهوية غير مسجَّل.'])
                    ->withInput();
            }

            $user = $profile->user;

            if (!Hash::check($r->password, $user->password)) {
                return back()
                    ->withErrors(['password' => 'كلمة المرور غير صحيحة.'])
                    ->withInput();
            }

            if (!$user->hasRole('student')) {
                return back()
                    ->withErrors(['studentId' => 'هذا الحساب ليس لطالب.'])
                    ->withInput();
            }

            Auth::login($user);

            return redirect()->intended(route('student.dashboard'));
        }

        $rules = ['password' => 'required|min:6'];
        if ($role === 'student') {
            $rules['studentId'] = 'required';
        } else {
            $rules['email'] = 'required|email';
        }
        $messages = [
            'email.required' => 'يرجى إدخال البريد الإلكتروني',
            'email.email' => 'صيغة البريد الإلكتروني غير صحيحة',
            'studentId.required' => 'يرجى إدخال رقم الهوية',
            'password.required' => 'يرجى إدخال كلمة المرور',
            'password.min' => 'كلمة المرور يجب أن تكون على الأقل 6 أحرف',
        ];

        $validated = $r->validate($rules, $messages); //
        

        $user = User::where('email', $r->email)->first();

        if (!$user) {
            return back()
                ->withErrors(['email' => 'البريد الإلكتروني غير مسجَّل.'])
                ->withInput();
        }

        if (!Hash::check($r->password, $user->password)) {
            return back()
                ->withErrors(['password' => 'كلمة المرور غير صحيحة.'])
                ->withInput();
        }

        if ($role === 'admin' && !$user->hasAnyRole(['admin', 'user-admin'])) {
            return back()
                ->withErrors(['email' => 'هذا الحساب ليس أدمن.'])
                ->withInput();
        }
        if ($role === 'teacher' && !$user->hasRole('teacher')) {
            return back()
                ->withErrors(['email' => 'هذا الحساب ليس لمعلّم.'])
                ->withInput();
        }

        Auth::login($user);

        if ($user->hasRole('admin'))
            return redirect()->route('admin.dashboard');
        if ($user->hasRole('user-admin'))
            return redirect()->route('user_admin.dashboard');
        if ($user->hasRole('teacher'))
            return redirect()->route('teacher.dashboard');

        return redirect()->route('student.dashboard');
    }


    /*public function login(Request $r)
    {
        $role = $r->input('login_as'); // 'admin' | 'teacher' | 'student'

        if ($role === 'student') {
            $r->validate([
                'studentId' => ['required', 'string', 'min:3', 'max:64'],
                'password' => ['required', 'string', 'min:6'],
            ]);

            $profile = StudentProfile::with('user')
                ->where('national_id', $r->studentId)->first();

            if (!$profile || !$profile->user || !Hash::check($r->password, $profile->user->password)) {
                return back()->withErrors(['studentId' => 'بيانات الطالب غير صحيحة.'])->withInput();
            }

            $user = $profile->user;
            if (!$user->hasRole('student')) {
                return back()->withErrors(['studentId' => 'هذا الحساب ليس طالبًا.']);
            }
        } else {
            $r->validate([
                'email' => ['required', 'email'],
                'password' => ['required', 'string', 'min:6'],
            ]);

            $user = User::where('email', $r->email)->first();
            if (!$user || !Hash::check($r->password, $user->password)) {
                return back()->withErrors(['email' => 'البريد أو كلمة المرور غير صحيحة.'])->withInput();
            }

            if ($role === 'admin' && !$user->hasAnyRole(['admin', 'user-admin'])) {
                return back()->withErrors(['email' => 'هذا الحساب ليس أدمن.']);
            }
            if ($role === 'teacher' && !$user->hasRole('teacher')) {
                return back()->withErrors(['email' => 'هذا الحساب ليس معلّمًا.']);
            }
        }

        Auth::login($user);

        if ($user->hasRole('admin'))
            return redirect()->route('admin.dashboard');
        if ($user->hasRole('user-admin'))
            return redirect()->route('user_admin.dashboard');
        if ($user->hasRole('teacher'))
            return redirect()->route('teacher.dashboard');
        return redirect()->route('student.dashboard');
    }*/


    public function showRegister()
    {
        return view('register');
    }

    public function registerStudent(Request $r)
    {
        $data = $r->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',

            'national_id' => 'required|string|max:64|unique:student_profiles,national_id',
            'grade' => 'nullable|integer|min:1|max:12',
            'semester' => 'nullable|string|max:20',
            'birthdate' => 'nullable|date',
        ]);
        $user = \DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => \Hash::make($data['password']),
            ]);

            StudentProfile::create([
                'user_id' => $user->id,
                'national_id' => $data['national_id'],
                'grade' => $data['grade'] ?? null,
                'semester' => $data['semester'] ?? null,
            ]);

            return $user;
        });

        if (method_exists($user, 'assignRole')) {
            $user->assignRole('student');
        }

        Auth::login($user);
        return redirect()->route('student.dashboard')->with('success', 'تم إنشاء حساب الطالب بنجاح 🎉');
    }


    public function registerTeacher(Request $r)
    {
        $data = $r->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'national_id' => 'required|string|max:64|unique:teacher_profiles,national_id',
            'specialty' => 'required|string|max:100',
            'birthdate' => 'nullable|date',
        ]);

        $user = \DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => \Hash::make($data['password']),
            ]);

            \App\Models\TeacherProfile::create([
                'user_id' => $user->id,
                'national_id' => $data['national_id'],
                'specialty' => $data['specialty'],
                'birthdate' => $data['birthdate'] ?? null,
            ]);

            return $user;
        });

        if (method_exists($user, 'assignRole')) {
            $user->assignRole('teacher');
        }

        \Auth::login($user);
        return redirect()->route('teacher.dashboard')->with('success', 'تم إنشاء حساب المعلّم بنجاح');
    }


    public function logout(Request $r)
    {
        Auth::logout();
        $r->session()->invalidate();
        $r->session()->regenerateToken();
        return redirect()->route('login');
    }
    /*public function show()
    {
        $user = auth()->user();
        $profile = $user->studentProfile; // one-to-one
        return view('dashboard', compact('user', 'profile'));
    }*/
}
