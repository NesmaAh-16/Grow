@if (session('ok'))
    <div class="alert"
        style="background:#e6ffed;border:1px solid #b4f8c8;padding:10px;border-radius:8px;color:#1a7f37;margin-bottom:10px">
        {{ session('ok') }}
    </div>
@endif
@if ($errors->any())
    <div class="alert"
        style="background:#fdecec;border:1px solid #f5c2c7;padding:10px;border-radius:8px;color:#b02a37;margin-bottom:10px">
        <ul style="margin:0">
            @foreach ($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
@endif
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الموافقة على الحسابات - لوحة التحكم</title>
    <link rel="icon" href="{{ asset('assets/images/logo2-removebg-preview.png') }}" type="image/x-icon"
        width = "15px">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/super-admin-dashboard.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/account-approval.css') }}" />
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
                    <li><a href="{{ route('user_admin.dashboard') }}"><i class="fas fa-home"></i> لوحة التحكم</a></li>
                    <li><a href="{{ route('user_admin.students') }}"><i class="fas fa-user-graduate"></i> إدارة
                            الطلاب</a></li>
                    <li><a href="{{ route('user_admin.teachers') }}"><i class="fas fa-chalkboard-teacher"></i> إدارة
                            المعلمين</a></li>
                    <li class="active"><a href="{{ route('user_admin.approvals') }}"><i class="fas fa-user-check"></i>
                            الموافقة على الحسابات</a></li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <header class="main-header">
                <div class="header-title">
                    <h1>الموافقة على الحسابات</h1>
                </div>
                <div class="header-actions">
                    <button class="action-btn" title="الإشعارات">
                        <i class="fas fa-bell"></i>
                        <span class="badge">3</span>
                    </button>
                    <button class="action-btn" title="الإعدادات">
                        <i class="fas fa-cog"></i>
                    </button>
                    <a href="#" class="logout-btn"
                        onclick ="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>تسجيل خروج</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">
                        @csrf
                    </form>
                </div>
            </header>

            <section class="toolbar-section">
                <form method="GET" action="{{ route('user_admin.approvals') }}"
                    style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">

                    <select name="type"
                        style="padding:10px; border:1px solid #e3e6ef; border-radius:10px; min-width:120px;">
                        <option value="">النوع</option>
                        <option value="student" @selected(request('type') === 'student')>طالب</option>
                        <option value="teacher" @selected(request('type') === 'teacher')>معلم</option>
                    </select>

                    <div class="search-bar" style="position:relative; max-width:300px; width:100%;">
                        <input type="text" name="q" value="{{ request('q') }}"
                            placeholder="ابحث برقم الهوية أو الاسم أو البريد">
                        <i class="fas fa-search"></i>
                    </div>

                    @if (request()->hasAny(['q', 'type']))
                        <a href="{{ route('user_admin.approvals') }}"
                            style="padding:10px 12px; border:1px solid #e3e6ef; border-radius:10px; color:#6c757d; text-decoration:none;">
                            مسح
                        </a>
                    @endif
                </form>
            </section>

            <section class="accounts-table-section">
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>الاسم</th>
                                <th>رقم الهوية</th>
                                <th>النوع</th>
                                <th>البريد الإلكتروني</th>
                                <th style="min-width:180px">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pending as $u)
                                <tr>
                                    <td>{{ $u->name }}</td>
                                    <td>{{ $u->national_id ?? '—' }}</td>
                                    <td>{{ $u->user_type === 'student' ? 'طالب' : ($u->user_type === 'teacher' ? 'معلم' : $u->user_type) }}
                                    </td>
                                    <td>{{ $u->email }}</td>
                                    <td>
                                        <form action="{{ route('user_admin.approvals.approve', $u) }}" method="POST"
                                            style="display:inline">
                                            @csrf
                                            <button class="action-btn-table approve-btn" type="submit">
                                                <i class="fas fa-check-circle"></i> موافقة
                                            </button>
                                        </form>

                                        <form action="{{ route('user_admin.approvals.reject', $u) }}" method="POST"
                                            style="display:inline" onsubmit="return confirm('رفض هذا الطلب؟')">
                                            @csrf
                                            <button class="action-btn-table reject-btn" type="submit">
                                                <i class="fas fa-times-circle"></i> رفض
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align:center">لا يوجد طلبات معلّقة.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div style="margin-top:12px;display:flex;justify-content:flex-end">
                        {{ $pending->links() }}
                    </div>
                </div>
            </section>

        </main>
    </div>

    <footer class="main-footer">
        <p>جميع الحقوق محفوظة – منصة التعليم.</p>
    </footer>

    <div id="toastNotification" class="toast-notification"></div>

    <script src="assets/js/account-approval.js"></script>
</body>

</html>
