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
    <title>إدارة المعلمين - لوحة التحكم</title>
    <link rel="icon" href="{{ asset('assets/images/logo2-removebg-preview.png') }}" type="image/x-icon"
        width = "15px">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/super-admin-dashboard.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/teachers-management.css') }}" />
</head>

<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
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
                    <h1>إدارة المعلمين</h1>
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

            <form method="GET" class="toolbar-section" style="display:flex;gap:12px;align-items:center">
                <div class="search-bar" style="position:relative;width:250px;min-width:230px">
                    <input type="text" name="q" value="{{ request('q') }}"
                        placeholder="ابحث برقم الهوية أو الاسم أو البريد">
                    <i class="fas fa-search"></i>
                </div>

                <a href="{{ route('user_admin.teachers.create') }}" class="btn btn-primary add-teacher-btn">
                    ➕ إضافة معلم جديد
                </a>
            </form>

            <section class="teachers-table-section">
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>رقم الهوية</th>
                                <th>الاسم</th>
                                <th>المواد الدراسية</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($teachers as $u)
                                <tr>
                                    <td>{{ $u->national_id ?? '—' }}</td>
                                    <td>{{ $u->name }}</td>
                                    <td>
                                    <td>{{ $u->teacherProfile?->specialty ?? '-' }}</td>
                                    </td>
                                    <td>
                                        @switch($u->status)
                                            @case('active')
                                                <span class="status status-active">مفعل</span>
                                            @break

                                            @case('pending')
                                                <span class="status status-pending">بانتظار</span>
                                            @break

                                            @case('inactive')
                                                <span class="status status-inactive">غير مفعل</span>
                                            @break

                                            @case('blocked')
                                                <span class="status status-inactive">محظور</span>
                                            @break

                                            @default
                                                <span class="status">—</span>
                                        @endswitch
                                        {{-- - <select name="status" class="input" required>
                                            <option value="active" @selected(old('status', $user->status) === 'active')>مفعّل</option>
                                            <option value="pending" @selected(old('status', $user->status) === 'pending')>بانتظار</option>
                                            <option value="inactive" @selected(old('status', $user->status) === 'inactive')>غير مفعّل</option>
                                            <option value="blocked" @selected(old('status', $user->status) === 'blocked')>محظور</option>
                                        </select> --}}

                                    </td>
                                    <td>
                                        <a class="action-btn-table view-btn"
                                            href="{{ route('user_admin.teachers.show', $u->id) }}">
                                            <i class="fas fa-eye"></i> عرض
                                        </a>
                                        <a class="action-btn-table edit-btn"
                                            href="{{ route('user_admin.teachers.edit', $u->id) }}">
                                            <i class="fas fa-edit"></i> تعديل
                                        </a>
                                        <form action="{{ route('user_admin.teachers.delete', $u->id) }}" method="POST"
                                            style="display:inline" onsubmit="return confirm('حذف هذا المعلم؟')">
                                            @csrf @method('DELETE')
                                            <button class="action-btn-table delete-btn" type="submit">
                                                <i class="fas fa-trash"></i> حذف
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">لا يوجد بيانات.</td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                        @if ($teachers->hasPages())
                            <div style="margin-top:12px">{{ $teachers->links() }}</div>
                        @endif
                    </div>
                </section>
            </main>
        </div>

        <div id="teacherDetailsModal" class="modal">
            <div class="modal-content">
                <span class="close-button">&times;</span>
                <h2>تفاصيل المعلّم</h2>
                <div class="teacher-details-body">
                    <p><strong>رقم الهوية:</strong> <span id="modalTeacherId"></span></p>
                    <p><strong>الاسم:</strong> <span id="modalTeacherName"></span></p>
                    <p><strong>المواد:</strong> <span id="modalTeacherSubjects"></span></p>
                    <p><strong>الحالة:</strong> <span id="modalTeacherStatus"></span></p>
                    <p><strong>تاريخ الإنشاء:</strong> <span id="modalCreationDate"></span></p>
                    <div class="modal-actions">
                        <button class="btn btn-success"><i class="fas fa-check-circle"></i> تفعيل</button>
                        <button class="btn btn-danger"><i class="fas fa-times-circle"></i> تعطيل</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="toastNotification" class="toast-notification"></div>

        <script src="assets/js/teacher-managment.js"></script>
    </body>

    </html>
