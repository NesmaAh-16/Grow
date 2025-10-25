<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class AdminUsersController extends Controller
{
    public function index(Request $r)
    {
        $q = trim((string) $r->get('q', ''));

        $admins = User::role('user-admin')
            ->when($q !== '', function ($qq) use ($q) {
                $qq->where(function ($w) use ($q) {
                    $w->where('name', 'like', "%{$q}%")
                      ->orWhere('email', 'like', "%{$q}%");
                });
            })
            ->latest()
            ->paginate(20)
            ->appends(['q' => $q]);

        return view('admins-management', compact('admins', 'q'));
    }

    public function create()
    {
        return view('admins-create');
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'name'     => ['required', 'string', 'max:120'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'status'   => ['nullable', 'in:active,inactive,blocked,pending'],
            'password' => ['nullable', 'min:6'],
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password'] ?? 'admin123'),
            'status'   => $data['status'] ?? 'active',
        ]);

        $user->assignRole('user-admin');

        return redirect()->route('admin.admins.index')->with('ok', 'تم إنشاء الإداري بنجاح.');
    }

    public function show(User $user)
    {
        abort_unless($user->hasRole('user-admin'), 404);
        return view('admins-show', compact('user'));
    }

    public function edit(User $user)
    {
        abort_unless($user->hasRole('user-admin'), 404);
        return view('admins-edit', compact('user'));
    }

    public function update(Request $r, User $user)
    {
        abort_unless($user->hasRole('user-admin'), 404);

        $data = $r->validate([
            'name'     => ['required', 'string', 'max:120'],
            'email'    => ['required', 'email', Rule::unique('users','email')->ignore($user->id)],
            'status'   => ['required', 'in:active,inactive,blocked,pending'],
            'password' => ['nullable', 'min:6'],
        ]);

        $payload = [
            'name'   => $data['name'],
            'email'  => $data['email'],
            'status' => $data['status'],
        ];
        if (!empty($data['password'])) {
            $payload['password'] = Hash::make($data['password']);
        }

        $user->update($payload);
        $user->syncRoles(['user-admin']);

        return redirect()->route('admin.admins.index')->with('ok', 'تم تحديث بيانات الإداري.');
    }

    public function destroy(User $user)
    {
        abort_unless($user->hasRole('user-admin'), 404);
        $user->delete();
        return redirect()->route('admin.admins.index')->with('ok', 'تم حذف الإداري.');
    }
}
