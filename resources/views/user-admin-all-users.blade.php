<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>جميع المستخدمين - أدمن المستخدمين</title>

    <link rel="icon" href="{{ asset('assets/images/logo2-removebg-preview.png') }}" type="image/x-icon" width="15">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <link rel="stylesheet" href="{{ asset('assets/css/super-admin-dashboard.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/users-admin-dashboard.css') }}" />

</head>

<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <a class="brand" href="{{ route('home') }}">
                    <img class="logo" src="{{ asset('assets/images/logo2-removebg-preview.png') }}"
                        alt="شعار المنصة" />
                    <img class="brand-name" src="{{ asset('assets/images/edited_color.png') }}" alt="Grow" />
                </a>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li class="{{ request()->routeIs('user_admin.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('user_admin.dashboard') }}"><i class="fas fa-home"></i> لوحة التحكم</a>
                    </li>
                    <li class="{{ request()->routeIs('user_admin.students') ? 'active' : '' }}">
                        <a href="{{ route('user_admin.students') }}"><i class="fas fa-user-graduate"></i> إدارة
                            الطلاب</a>
                    </li>
                    <li class="{{ request()->routeIs('user_admin.teachers') ? 'active' : '' }}">
                        <a href="{{ route('user_admin.teachers') }}"><i class="fas fa-chalkboard-teacher"></i> إدارة
                            المعلمين</a>
                    </li>
                    <li class="{{ request()->routeIs('user_admin.approvals') ? 'active' : '' }}">
                        <a href="{{ route('user_admin.approvals') }}"><i class="fas fa-user-check"></i> الموافقة على
                            الحسابات</a>
                    </li>
                </ul>
            </nav>
        </aside>
        <main class="main-content">
            <header class="main-header">
                <div class="header-title">
                    <h1>جميع المستخدمين</h1>
                    <p class="subtitle">قائمة كاملة بجميع المستخدمين في النظام.</p>
                </div>
                <div class="header-actions">
                    <a href="{{ route('user_admin.dashboard') }}" class="logout-btn" style="gap:8px">
                        <i class="fas fa-arrow-right"></i>
                        <span>رجوع للوحة التحكم</span>
                    </a>
                </div>
            </header>

            <section class="filters-bar" style="margin: 10px 0 15px;">
                <form method="GET" action="{{ route('user_admin.users.all') }}"
                    style="display: flex; gap: 8px; align-items: center; flex-wrap: nowrap;">

                    <button type="submit"
                        style="padding:10px 16px; border:0; border-radius:10px; background:#0d6efd; color:#fff; flex-shrink:0;">
                        تطبيق
                    </button>

                    <select name="status"
                        style="padding:10px; border:1px solid #e3e6ef; border-radius:10px; min-width:120px; flex-shrink:0;">
                        <option value="">كل الحالات</option>
                        <option value="active" @selected(request('status') === 'active')>active</option>
                        <option value="inactive" @selected(request('status') === 'inactive')>inactive</option>
                        <option value="blocked" @selected(request('status') === 'blocked')>blocked</option>
                        <option value="pending" @selected(request('status') === 'pending')>pending</option>
                    </select>

                    <select name="type"
                        style="padding:10px; border:1px solid #e3e6ef; border-radius:10px; min-width:120px; flex-shrink:0;">
                        <option value="">كل الأنواع</option>
                        <option value="student" @selected(request('type') === 'student')>طالب</option>
                        <option value="teacher" @selected(request('type') === 'teacher')>معلم</option>
                    </select>

                    <div style="flex:1; position:relative; max-width:350px;">
                        <input type="text" name="q" value="{{ request('q') }}"
                            placeholder="بحث بالاسم أو البريد أو رقم الهوية"
                            style="width:100%; padding:10px 36px 10px 12px; border:1px solid #e3e6ef; border-radius:10px;">
                        <i class="fas fa-search"
                            style="position:absolute; right:10px; top:50%; transform:translateY(-50%); opacity:0.6;"></i>
                    </div>

                </form>
            </section>
            <section class="table-section">
                <div class="table-wrapper">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>الاسم</th>
                                <th>البريد</th>
                                <th>النوع</th>
                                <th>الحالة</th>
                                <th>تاريخ الإنشاء</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $u)
                                <tr>
                                    <td>{{ $u->id }}</td>
                                    <td>{{ $u->name }}</td>
                                    <td>{{ $u->email }}</td>
                                    <td>
    @php
        // نعطي أولوية: أدمن > أدمن المستخدمين > معلم > طالب
        $typeLabel =
            ($u->hasRole('admin') ? 'أدمن النظام' :
            ($u->hasRole('user-admin') ? 'أدمن المستخدمين' :
            (
                ($u->user_type === 'teacher' || $u->hasRole('teacher') || $u->teacherProfile) ? 'معلم' :
                (($u->user_type === 'student' || $u->hasRole('student') || $u->studentProfile) ? 'طالب' : '-')
            )));
    @endphp
    {{ $typeLabel }}
</td>

                                    <td>{{ $u->status ?? '-' }}</td>
                                    <td>{{ $u->created_at?->format('Y-m-d H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">لا يوجد بيانات.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div style="margin-top:12px;display:flex;justify-content:flex-end">
                    {{ $users->appends(request()->query())->links() }}
                </div>
            </section>
        </main>
    </div>
</body>

</html>
