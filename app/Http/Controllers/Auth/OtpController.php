<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class OtpController extends Controller
{
    public function showOtpForm(Request $r)
    {
        $email = $r->query('email');
        abort_unless($email, 404);
        return view('forget-pass', compact('email'));
    }

    public function verifyOtp(Request $r)
    {
        $data = $r->validate([
            'email' => 'required|email',
            'code' => 'required', // سننظّفه يدويًا
        ]);

        $email = trim(strtolower($data['email']));
        $key = 'pwdotp:' . sha1($email);

        // نظّف الرمز من أي غير أرقام (يدعم العربية واللاتينية)
        $submitted = preg_replace('/\D/u', '', (string) $data['code']);
        \Log::info("OTP SUBMITTED {$email} => {$submitted}");

        if (strlen($submitted) !== 6) {
            return back()->withErrors(['code' => 'الرمز يجب أن يكون 6 أرقام.'])->withInput();
        }

        $expected = Cache::get($key);
        \Log::info("OTP EXPECTED {$email} => " . var_export($expected, true));

        if (!$expected || (string) $expected !== (string) $submitted) {
            return back()->withErrors(['code' => 'رمز غير صحيح أو منتهي.'])->withInput();
        }

        Cache::forget($key);

        $user = \App\Models\User::where('email', $email)->firstOrFail();
        $token = \Illuminate\Support\Facades\Password::createToken($user);

        return redirect()->route('password.reset.custom', [
            'email' => $email,
            'token' => $token,   // هذا هو التوكن الخام من Password::createToken($user)
        ]);
    }

    public function resendOtp(Request $r)
    {
        $data = $r->validate(['email' => 'required|email']);
        $email = strtolower($data['email']);

        $user = User::where('email', $email)->firstOrFail();

        $code = random_int(100000, 999999);
        Cache::put("pwdotp:{$email}", $code, now()->addMinutes(10));

        try {
            Mail::raw("رمز استعادة كلمة المرور الجديد: {$code}", function ($m) use ($email) {
                $m->to($email)->subject('رمز جديد لاستعادة كلمة المرور');
            });
        } catch (\Throwable $e) {
        }

        return back()->with('status', 'تم إرسال رمز جديد.');
    }
}
