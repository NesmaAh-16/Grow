<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class NewPasswordController extends Controller
{
    public function create(Request $r)
    {

        $token = $r->query('token');
        $email = $r->query('email');
        abort_unless($token && $email, 404);

        return view('newpass', ['token' => $token, 'email' => $email]);
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:6|confirmed',
        ], [
            'password.confirmed' => 'كلمتا المرور غير متطابقتين',
        ]);

        $status = Password::reset(
            $data,
            function ($user, $password) {
                $user->forceFill(['password' => Hash::make($password)])->save();
            }
        );
        /*Log::info('RESET-FORM', [
    'email' => $r->input('email'),
    'token_len' => strlen((string)$r->input('token')),
]);*/
        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'تم تعيين كلمة المرور بنجاح.')
            : back()->withErrors(['email' => __($status)]);
    }
}
