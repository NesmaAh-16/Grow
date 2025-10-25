<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة أدمن المستخدمين</title>

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
                        <a href="{{ route('user_admin.dashboard') }}">
                            <i class="fas fa-home"></i> لوحة التحكم
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('user_admin.students') ? 'active' : '' }}">
                        <a href="{{ route('user_admin.students') }}">
                            <i class="fas fa-user-graduate"></i> إدارة الطلاب
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('user_admin.teachers') ? 'active' : '' }}">
                        <a href="{{ route('user_admin.teachers') }}">
                            <i class="fas fa-chalkboard-teacher"></i> إدارة المعلمين
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('user_admin.approvals') ? 'active' : '' }}">
                        <a href="{{ route('user_admin.approvals') }}">
                            <i class="fas fa-user-check"></i> الموافقة على الحسابات
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <header class="main-header">
                <div class="header-title">
                    <h1>أدمن المستخدمين</h1>
                    <p class="subtitle">نظرة عامة على المستخدمين في النظام.</p>
                </div>
                <div class="header-actions">
                    {{-- - <button class="nav-btn" title="الإشعارات">
                    <i class="fas fa-bell"></i>
                    <span class="badge">3</span>
                </button>
                <a href="#" class="nav-btn" title="الإعدادات">
                    <i class="fas fa-cog"></i> --}}
                    @role('admin|user-admin')
                        @php
                            // عدد الطلبات المفتوحة عند كل المستخدمين
                            $openAll = \App\Models\SupportMessage::where('status', 'open')->count();
                        @endphp

                        <a href="{{ route('support.index') }}" class="nav-btn" title="الدعم الفني">
                            <i class="fas fa-headset"></i>
                            @if ($openAll > 0)
                                <span class="badge">{{ $openAll }}</span>
                            @endif
                            <span>الدعم الفني</span>
                        </a>
                    @endrole
                    <a href="#" class="logout-btn"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>تسجيل خروج</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">
                        @csrf
                    </form>
                </div>
            </header>

            <section class="stats-grid">
                <div class="stat-card">
                    <div class="card-icon"><i class="fas fa-user-graduate"></i></div>
                    <h3 class="card-value">{{ $studentsCount ?? 0 }}</h3>
                    <p class="card-label">عدد الطلاب</p>
                </div>
                <div class="stat-card">
                    <div class="card-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                    <h3 class="card-value">{{ $teachersCount ?? 0 }}</h3>
                    <p class="card-label">عدد المعلّمين</p>
                </div>
                <div class="stat-card">
                    <div class="card-icon"><i class="fas fa-hourglass-half"></i></div>
                    <h3 class="card-value">{{ $pendingCount ?? 0 }}</h3>
                    <p class="card-label">طلبات معلّقة</p>
                </div>
                <div class="stat-card">
                    <div class="card-icon"><i class="fas fa-user-slash"></i></div>
                    <h3 class="card-value">{{ $inactiveCount ?? 0 }}</h3>
                    <p class="card-label">حسابات معطلة</p>
                </div>
            </section>

            @isset($latestUsers)
                <section class="latest-users">
                    <h2 style="margin: 20px 0 10px">آخر المسجلين</h2>
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
                                @forelse($latestUsers as $u)
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
                                        <td colspan="6">لا يوجد بيانات</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div style="text-align: left; margin-top: 15px;">
                        <a href="{{ route('user_admin.users.all') }}" class="btn-view-all">
                            <i class="fas fa-users"></i>
                            <span>عرض جميع المستخدمين</span>
                        </a>
                    </div>
                </section>
            @endisset
        </main>
    </div>
</body>

</html>
