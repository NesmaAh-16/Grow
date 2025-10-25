<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{
    protected array $rolePermissionMap = [
        'admin'      => ['manage.users','manage.settings','manage.permissions'],
        'student'    => ['lessons.attend','homeworks.solve','exams.attempt','profile.update'],
        'teacher'    => ['homeworks.manage','exams.manage','lessons.manage'],
        'user-admin' => ['manage.students','manage.teachers','accounts.approve'],
    ];

    protected array $labels = [
        'manage.users'      => 'إدارة المستخدمين',
        'manage.settings'   => 'إعدادات النظام',
        'manage.permissions'=> 'إدارة الصلاحيات',

        'lessons.attend'    => 'حضور الدروس',
        'homeworks.solve'   => 'حل الواجبات',
        'exams.attempt'     => 'تقديم الاختبارات',
        'profile.update'    => 'تعديل الإعدادات الشخصية',

        'homeworks.manage'  => 'إدارة الواجبات',
        'exams.manage'      => 'إدارة الاختبارات',
        'lessons.manage'    => 'إدارة الدروس',

        'manage.students'   => 'إدارة الطلاب',
        'manage.teachers'   => 'إدارة المعلمين',
        'accounts.approve'  => 'الموافقة على الحسابات',
    ];

    public function index(Request $r)
    {
        $guard = config('auth.defaults.guard','web');

        $roles = Role::query()
            ->where('guard_name',$guard)
            ->select('id','name','guard_name')
            ->orderBy('name')->get()
            ->unique('name')->values();

        $currentRole = $r->filled('role_id') ? Role::find($r->role_id) : ($roles->first() ?? null);

        $suggested = $currentRole ? ($this->rolePermissionMap[$currentRole->name] ?? []) : [];

        $currentRolePerms = $currentRole
            ? $currentRole->permissions()->pluck('name')->toArray()
            : [];

        $names = array_values(array_unique(array_merge($suggested, $currentRolePerms)));

        if ($show = $r->query('show')) {
            if (Permission::where('name',$show)->where('guard_name',$guard)->exists()) {
                $names[] = $show;
            }
        }
        $names = array_values(array_unique($names));

        $permissions = Permission::where('guard_name',$guard)
            ->when(!empty($names), fn($q) => $q->whereIn('name',$names))
            ->orderBy('name')->get();

        $labels = $this->labels;

        $rolePermissions = $currentRole ? $currentRole->permissions->pluck('name')->toArray() : [];

        return view('permissions-management', compact('roles','permissions','currentRole','rolePermissions','labels'));
    }

    public function storePermission(Request $r)
    {
        $data = $r->validate([
            'name'       => ['required','string','max:190'],
            'role_id'    => ['nullable','exists:roles,id'],
            'guard_name' => ['nullable','string','max:50'],
        ]);

        $guard = $data['guard_name'] ?? config('auth.defaults.guard','web');

        $perm = Permission::firstOrCreate(
            ['name' => trim($data['name']), 'guard_name' => $guard],
            []
        );

        return redirect()
            ->route('admin.permissions.index', [
                'role_id' => $data['role_id'] ?? null,
                'show'    => $perm->name,
            ])
            ->with('ok','تمت إضافة الصلاحية.');
    }

    public function assignToRole(Request $r)
    {
        $data = $r->validate([
            'role_id'       => ['required','exists:roles,id'],
            'permissions'   => ['array'],
            'permissions.*' => ['string','exists:permissions,name'],
        ]);

        $role = Role::findOrFail($data['role_id']);
        $role->syncPermissions($data['permissions'] ?? []);

        return redirect()
            ->route('admin.permissions.index', ['role_id' => $role->id])
            ->with('ok','تم حفظ التغييرات بنجاح.');
    }

    public function deletePermission(Request $r)
    {
        $data = $r->validate([
            'name' => ['required','string','exists:permissions,name'],
        ]);

        $perm = Permission::where('name',$data['name'])
            ->where('guard_name',config('auth.defaults.guard','web'))
            ->firstOrFail();

        $perm->delete();

        return back()->with('ok','تم حذف الصلاحية نهائيًا.');
    }
}
