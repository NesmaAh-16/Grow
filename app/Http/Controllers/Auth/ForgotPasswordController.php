<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class ForgotPasswordController extends Controller
{

    public function showEmailForm()
    {
        return view('forget-pass'); 
    }

    public function sendOtp(Request $r)
    {

        $data = $r->validate(['email' => 'required|email']);
        $email = trim(strtolower($data['email']));
        $user = User::where('email', $email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'لا يوجد مستخدم بهذا البريد.'])->withInput();
        }

        $key = 'pwdotp:' . sha1($email);

        $code = random_int(100000, 999999);
        Cache::put($key, $code, now()->addMinutes(10));

        \Log::info("OTP SET {$email} = {$code}"); // تشخيص
        return redirect()->route('password.otp.show', ['email' => $email])
            ->with('status', 'تم إرسال رمز مكوّن من 6 أرقام إلى بريدك.');


    }
}

