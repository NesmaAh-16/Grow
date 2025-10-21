<?php

namespace App\Http\Controllers\UserAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApprovalsController extends Controller
{
    // GET /user-admin/approvals
    public function index(Request $r)
    {
        $q = User::query()
            ->where('status', 'pending')                     // نعرض فقط المعلّقين
            ->when($r->filled('q'), function ($qq) use ($r) { // بحث بالاسم/البريد/الهوية
                $term = trim($r->q);
                $qq->where(function ($w) use ($term) {
                    $w->where('name', 'like', "%{$term}%")
                      ->orWhere('email', 'like', "%{$term}%")
                      ->orWhere('national_id', 'like', "%{$term}%");
                });
            })
            ->when($r->filled('type'), function ($qq) use ($r) { // فلتر النوع اختياري
                $qq->where('user_type', $r->type);
            })
            ->orderByDesc('id');

        $pending = $q->paginate(15)->withQueryString();

        return view('account-approval', compact('pending'));
    }

    // POST /user-admin/approvals/{user}/approve
    public function approve(User $user)
    {
        abort_unless($user->status === 'pending', 404);

        DB::transaction(function () use ($user) {
            $user->update(['status' => 'active']);

            // لو مركّبة Spatie Roles نضمن الرول حسب النوع
            if (method_exists($user, 'assignRole')) {
                if ($user->user_type === 'student')  $user->syncRoles(['student']);
                elseif ($user->user_type === 'teacher') $user->syncRoles(['teacher']);
            }
        });

        return back()->with('ok', 'تمت الموافقة وتفعيل الحساب.');
    }

    // POST /user-admin/approvals/{user}/reject
    public function reject(User $user)
    {
        abort_unless($user->status === 'pending', 404);

        // خياران: إما نعلّمه blocked، أو نحذفه حذفًا ناعمًا
        $user->update(['status' => 'blocked']); // أبسط خيار
        // أو: $user->delete();

        return back()->with('ok', 'تم رفض الطلب.');
    }
}
