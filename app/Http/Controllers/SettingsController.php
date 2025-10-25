<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
class SettingsController extends Controller
{
    public function index()
    {
        $user    = auth()->user();
        $profile = $user->studentProfile; // تأكد العلاقة موجودة في موديل User

        return view('student-setting', compact('user','profile'));
    }

  public function updateProfile(Request $request)
{
    \Log::info('profile_update', $request->only('name','birth_date','grade'));
    $user = auth()->user();

    $data = $request->validate([
        'name'       => ['required','string','max:190'],
        'birth_date' => ['nullable','date'],
        'grade'      => ['nullable','integer','min:1','max:12'],
    ], [], [
        'name'       => 'الاسم الكامل',
        'birth_date' => 'تاريخ الميلاد',
        'grade'      => 'الصف الدراسي',
    ]);

    // اسم المستخدم
    $user->name = $data['name'];
    $user->save();

    // حمّل/أنشئ البروفايل
    $profile = $user->studentProfile()->firstOrNew(['user_id' => $user->id]);

    // فرض تنسيق التاريخ ليكون Y-m-d إن وصل
    $profile->birth_date = $request->filled('birth_date')
        ? \Carbon\Carbon::parse($request->input('birth_date'))->format('Y-m-d')
        : null;

    $profile->grade = $data['grade'] ?? null;
    $profile->save();

    // مهم: اعرض القيم المحدثة بعد الحفظ
    $user->refresh();
    $profile->refresh();

    return back()->with('success_profile', 'تم تحديث المعلومات الشخصية.')
                 ->with('tab','profile');
}


}
