<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\StudentProfile;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole     = Role::firstOrCreate(['name' => 'admin',      'guard_name' => 'web']);
        $userAdminRole = Role::firstOrCreate(['name' => 'user-admin', 'guard_name' => 'web']);
        $teacherRole   = Role::firstOrCreate(['name' => 'teacher',    'guard_name' => 'web']);
        $studentRole   = Role::firstOrCreate(['name' => 'student',    'guard_name' => 'web']);

        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin', 'password' => Hash::make('Admin#123')]
        );

        $userAdmin = User::updateOrCreate(
            ['email' => 'useradmin@grow.com'],
            ['name' => 'User Admin', 'password' => Hash::make('Grow@123456')]
        );

        $teacher = User::updateOrCreate(
            ['email' => 'teacher@example.com'],
            ['name' => 'Teacher', 'password' => Hash::make('Teacher#123')]
        );

        $student = User::updateOrCreate(
            ['email' => 'student@example.com'],
            ['name' => 'Student', 'password' => Hash::make('Student#123')]
        );

        StudentProfile::updateOrCreate(
            ['user_id' => $student->id],
            ['national_id' => '3012345678', 'grade' => 10, 'semester' => '1']
        );

        $admin->syncRoles([$adminRole]);
        $userAdmin->syncRoles([$userAdminRole]);
        $teacher->syncRoles([$teacherRole]);
        $student->syncRoles([$studentRole]);

    }
}

/*namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\StudentProfile;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole     = Role::firstOrCreate(['name' => 'admin',      'guard_name' => 'admin']);
        $userAdminRole = Role::firstOrCreate(['name' => 'user-admin', 'guard_name' => 'admin']);
        $teacherRole   = Role::firstOrCreate(['name' => 'teacher',    'guard_name' => 'teacher']);
        $studentRole   = Role::firstOrCreate(['name' => 'student',    'guard_name' => 'student']);

        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin', 'password' => Hash::make('Admin#123')]
        );

        $userAdmin = User::updateOrCreate(
            ['email' => 'useradmin@grow.com'],
            ['name' => 'User Admin', 'password' => Hash::make('Grow@123456')]
        );

        $teacher = User::updateOrCreate(
            ['email' => 'teacher@example.com'],
            ['name' => 'Teacher', 'password' => Hash::make('Teacher#123')]
        );

      $student = User::updateOrCreate(
            ['email' => 'student@example.com'],
            ['name' => 'Student', 'password' => Hash::make('Student#123')]
        );

        StudentProfile::updateOrCreate(
            ['user_id' => $student->id],
            [
                'national_id' => '3012345678',
                'grade'       => 10,   // رقم (1..12)
                'semester'    => '1',
            ]
        );

        $admin->guard_name = 'admin';
        $admin->syncRoles([$adminRole]);

        $userAdmin->guard_name = 'admin';
        $userAdmin->syncRoles([$userAdminRole]);

        $teacher->guard_name = 'teacher';
        $teacher->syncRoles([$teacherRole]);

        $student->guard_name = 'student';
        $student->syncRoles([$studentRole]);

        $perms = [
            'manage.users','manage.teachers','manage.students',
            'manage.settings','manage.permissions'
        ];

        foreach ($perms as $p) {
            Permission::firstOrCreate(['name' => $p]);
        }

        $admin->syncPermissions(Permission::all());
    }
}*/

