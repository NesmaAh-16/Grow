@if (session('ok'))
    <div class="alert"
        style="background:#e6ffed; border:1px solid #b4f8c8; padding:10px; border-radius:8px; color:#1a7f37; margin-bottom:10px;">
        {{ session('ok') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert"
        style="background:#fdecec; border:1px solid #f5c2c7; padding:10px; border-radius:8px; color:#b02a37; margin-bottom:10px;">
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض المعلم</title>
    <link rel="icon" href="{{ asset('assets/images/logo2-removebg-preview.png') }}" type="image/x-icon"
        width="15">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/super-admin-dashboard.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/teachers-management.css') }}" />
</head>

<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <a class="brand" href="{{ route('home') }}">
                    <!-- Make sure this path is correct -->
                    <img class="logo" src="{{ asset('assets/images/logo2-removebg-preview.png') }}"
                        alt="شعار المنصة" />
                    <!-- Make sure this path is correct -->
                    <img class="brand-name" src="{{ asset('assets/images/edited_color.png') }}" alt="Grow" />
                </a>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="{{ route('user_admin.dashboard') }}"><i class="fas fa-home"></i> لوحة التحكم</a></li>
                    <li><a href="{{ route('user_admin.students') }}"><i class="fas fa-user-graduate"></i> إدارة
                            الطلاب</a></li>
                    <li class="active"><a href="{{ route('user_admin.teachers') }}"><i
                                class="fas fa-chalkboard-teacher"></i> إدارة المعلمين</a></li>
                    <li><a href="{{ route('user_admin.approvals') }}"><i class="fas fa-user-check"></i> الموافقة على
                            الحسابات</a></li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <header class="main-header">
                <div class="header-title">
                    <h1>عرض المعلم</h1>
                    <p class="subtitle">تفاصيل المعلّم المسجّل في النظام.</p>
                </div>
                <div class="header-actions" style="gap:8px">
                    <a href="{{ route('user_admin.teachers') }}" class="logout-btn" style="gap:8px">
                        <i class="fas fa-arrow-right"></i><span>رجوع لإدارة المعلمين</span>
                    </a>
                    <a href="{{ route('user_admin.teachers.edit', $user->id) }}" class="logout-btn" style="gap:8px">
                        <i class="fas fa-edit"></i><span>تعديل</span>
                    </a>

                    @if ($user->status !== 'active')
                        <form action="{{ route('user_admin.teachers.activate', $user->id) }}" method="POST"
                            style="display:inline">
                            @csrf
                            <button type="submit" class="action-btn" title="تفعيل"
                                style="background:#e7f7ec;border:1px solid #cfead7;color:#198754">
                                <i class="fas fa-check"></i>
                            </button>
                        </form>
                    @else
                        <form action="{{ route('user_admin.teachers.deactivate', $user->id) }}" method="POST"
                            style="display:inline">
                            @csrf
                            <button type="submit" class="action-btn" title="تعطيل"
                                style="background:#fdecec;border:1px solid #f5c2c7;color:#dc3545">
                                <i class="fas fa-ban"></i>
                            </button>
                        </form>
                    @endif

                    <form action="{{ route('user_admin.teachers.delete', $user->id) }}" method="POST"
                        onsubmit="return confirm('حذف هذا المعلم؟')" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit" title="حذف">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </header>

            <section style="max-width:900px">
                <div class="table-responsive">
                    <table>
                        <tbody>
                            <tr>
                                <th style="width:220px">الاسم</th>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th>البريد الإلكتروني</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th>رقم الهوية</th>
                                <td>{{ $user->national_id ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>التخصص</th>
                                <td>{{ optional($user->teacherProfile)->national_id ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>تاريخ الميلاد</th>
                                <td>{{ optional($user->teacherProfile?->birthdate)->format('Y-m-d') ?? '—' }}
                            </tr>
                            <tr>
                                <th>الحالة</th>
                                <td>
                                    @switch($user->status)
                                        @case('active')
                                            <span class="status status-active">مفعّل</span>
                                        @break

                                        @case('pending')
                                            <span class="status status-pending">بانتظار</span>
                                        @break

                                        @case('inactive')
                                            <span class="status status-inactive">غير مفعّل</span>
                                        @break

                                        @case('blocked')
                                            <span class="status status-inactive">محظور</span>
                                        @break

                                        @default
                                            <span class="status">—</span>
                                    @endswitch
                                </td>
                            </tr>
                            <tr>
                                <th>تاريخ الإنشاء</th>
                                <td>{{ $user->created_at?->format('Y-m-d H:i') }}</td>
                            </tr>
                            <tr>
                                <th>آخر تحديث</th>
                                <td>{{ $user->updated_at?->format('Y-m-d H:i') }}</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </section>
        </main>
    </div>
</body>

</html>
