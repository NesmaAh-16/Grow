@if (session('ok'))
    <div class="alert"
        style="background:#e6ffed;border:1px solid #b4f8c8;padding:10px;border-radius:8px;color:#1a7f37;margin-bottom:10px;">
        {{ session('ok') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert"
        style="background:#fdecec;border:1px solid #f5c2c7;padding:10px;border-radius:8px;color:#b02a37;margin-bottom:10px;">
        <ul style="margin:0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <title>إدارة الطلاب - لوحة التحكم</title>
    <link rel="icon" href="{{ asset('assets/images/logo2-removebg-preview.png') }}" type="image/x-icon"
        width="15" />
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/super-admin-dashboard.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/students-management.css') }}" />
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
                    <li class="active"><a href="{{ route('user_admin.students') }}"><i class="fas fa-user-graduate"></i>
                            إدارة الطلاب</a></li>
                    <li><a href="{{ route('user_admin.teachers') }}"><i class="fas fa-chalkboard-teacher"></i> إدارة
                            المعلمين</a></li>
                    <li><a href="{{ route('user_admin.approvals') }}"><i class="fas fa-user-check"></i> الموافقة على
                            الحسابات</a></li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <header class="main-header">
                <div class="header-title">
                    <h1>إدارة الطلاب</h1>
                </div>
                <div class="header-actions">
                {{-- - <button class="nav-btn" title="الإشعارات">
                    <i class="fas fa-bell"></i>
                    <span class="badge">3</span>
                </button>
                <a href="#" class="nav-btn" title="الإعدادات">
                    <i class="fas fa-cog"></i>--}}
                    <a href="#" class="logout-btn"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i><span>تسجيل خروج</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">@csrf
                    </form>
                </div>
            </header>

            <section class="toolbar-section" style="display:flex;gap:10px;align-items:center;flex-wrap:wrap">
                <a href="{{ route('user_admin.students.create') }}" class="btn btn-primary add-student-btn">
                    <i class="fas fa-plus"></i> إضافة طالب جديد
                </a>

                <form method="GET" action="{{ route('user_admin.students') }}"
                    style="display:flex;gap:8px;align-items:center;flex:1;justify-content:flex-end">
                    <div class="search-bar" style="position:relative;width:250px;min-width:230px">
                        <input type="text" name="q" value="{{ request('q') }}"
                            placeholder="بحث برقم الهوية أو الاسم أو البريد">
                        <i class="fas fa-search"></i>
                    </div>
                    @if (request()->filled('q'))
                        <a href="{{ route('user_admin.students') }}"
                            style="padding:10px 12px;border:1px solid #e3e6ef;border-radius:10px;text-decoration:none;color:#6c757d">
                            مسح
                        </a>
                    @endif
                </form>
            </section>

            <section class="students-table-section">
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>الاسم</th>
                                <th>رقم الهوية</th>
                                <th>الصف</th>
                                <th>الحالة</th>
                                <th style="min-width:210px">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($students as $u)
<tr>
    {{-- الاسم --}}
    <td>{{ $u->name }}</td>

    {{-- رقم الهوية: users ثم student_profiles --}}
    <td>{{ $u->national_id ?? $u->studentProfile?->national_id ?? '-' }}</td>

    {{-- الصف --}}
    <td>{{ $u->studentProfile?->grade ?? '-' }}</td>

    {{-- الحالة --}}
    <td>
        @switch($u->status)
            @case('active')   <span class="status status-active">مفعّل</span> @break
            @case('pending')  <span class="status status-pending">بانتظار التفعيل</span> @break
            @case('inactive') <span class="status status-inactive">غير مفعّل</span> @break
            @case('blocked')  <span class="status status-inactive">محظور</span> @break
            @default          <span class="status">-</span>
        @endswitch
    </td>

    {{-- الإجراءات --}}
    <td>
        <a class="action-btn-table view-btn" href="{{ route('user_admin.students.show', $u->id) }}">
            <i class="fas fa-eye"></i> عرض
        </a>

        <a class="action-btn-table edit-btn" href="{{ route('user_admin.students.edit', $u->id) }}">
            <i class="fas fa-edit"></i> تعديل
        </a>

        <form action="{{ route('user_admin.students.delete', $u->id) }}" method="POST" style="display:inline"
              onsubmit="return confirm('حذف الطالب؟')">
            @csrf @method('DELETE')
            <button type="submit" class="action-btn-table delete-btn">
                <i class="fas fa-trash"></i> حذف
            </button>
        </form>

        @if ($u->status !== 'active')
            <form action="{{ route('user_admin.students.activate', $u->id) }}" method="POST" style="display:inline">
                @csrf
                <button type="submit" class="action-btn-table" style="background:#e7f7ec;color:#198754;border:1px solid #cfead7">
                    <i class="fas fa-check"></i> تفعيل
                </button>
            </form>
        @else
            <form action="{{ route('user_admin.students.deactivate', $u->id) }}" method="POST" style="display:inline">
                @csrf
                <button type="submit" class="action-btn-table" style="background:#fdecec;color:#dc3545;border:1px solid #f5c2c7">
                    <i class="fas fa-ban"></i> تعطيل
                </button>
            </form>
        @endif
    </td>
</tr>
@empty
<tr>
    <td colspan="5" style="text-align:center">لا يوجد بيانات.</td>
</tr>
@endforelse

                            </tbody>
                        </table>
                    </div>

                    @if ($students->hasPages())
                        <div style="margin-top:12px;display:flex;justify-content:flex-end">
                            {{ $students->appends(request()->query())->links() }}
                        </div>
                    @endif
                </section>

            </main>
        </div>
    </body>

    </html>
