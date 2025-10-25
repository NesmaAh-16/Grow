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
    <title>تعديل طالب</title>
    <link rel="icon" href="{{ asset('assets/images/logo2-removebg-preview.png') }}" type="image/x-icon"
        width="15">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
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
                    <h1>تعديل طالب</h1>
                    <p class="subtitle">عدّل بيانات الطالب ثم احفظ.</p>
                </div>
                <div class="header-actions">
                    <a href="{{ route('user_admin.students') }}" class="logout-btn" style="gap:8px">
                        <i class="fas fa-arrow-right"></i> <span>رجوع لإدارة الطلاب</span>
                    </a>
                </div>
            </header>

            <section style="max-width:720px;">
                @if ($errors->any())
                    <div class="alert"
                        style="background:#fdecec;border:1px solid #f5c2c7;color:#b02a37;padding:10px;border-radius:10px;margin-bottom:12px">
                        <ul style="margin:0;padding-right:18px">
                            @foreach ($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('user_admin.students.update', $user->id) }}" class="card-form" style="display:grid;gap:12px">
    @csrf
    @method('PUT')

    <div>
        <label>الاسم</label>
        <input name="name" class="input" value="{{ old('name', $user->name) }}" required>
    </div>

    <div>
        <label>البريد الإلكتروني</label>
        <input type="email" name="email" class="input" value="{{ old('email', $user->email) }}" required>
    </div>

    <div>
        <label>رقم الهوية</label>
        <input name="national_id" class="input" value="{{ old('national_id', $user->national_id) }}">
    </div>

    <div>
        <label>الصف</label>
        <input name="grade" class="input" value="{{ old('grade', $grade) }}" placeholder="مثال: التاسع / العاشر / 10">
        {{-- إن حبيت Dropdown لاحقًا بنزبطه --}}
    </div>

    <div>
        <label>الحالة</label>
        <select name="status" class="input" required>
            <option value="active"   {{ old('status', $user->status) === 'active' ? 'selected' : '' }}>مفعّل</option>
            <option value="pending"  {{ old('status', $user->status) === 'pending' ? 'selected' : '' }}>بانتظار</option>
            <option value="inactive" {{ old('status', $user->status) === 'inactive' ? 'selected' : '' }}>غير مفعّل</option>
            <option value="blocked"  {{ old('status', $user->status) === 'blocked' ? 'selected' : '' }}>محظور</option>
        </select>
    </div>

    <div style="display:flex;gap:8px">
        <button class="btn btn-primary" type="submit"><i class="fas fa-save"></i> حفظ</button>
        <a href="{{ route('user_admin.students') }}" class="btn btn-secondary">إلغاء</a>
    </div>
</form>

            </section>
        </main>
    </div>

    <style>
        .card-form .input {
            width: 100%;
            padding: 10px;
            border: 1px solid #e3e6ef;
            border-radius: 10px
        }

        .card-form label {
            display: block;
            margin-bottom: 6px;
            color: #444
        }

        .btn.btn-secondary {
            background: #f1f3f9;
            border: 1px solid #e3e6ef;
            color: #333;
            padding: 10px 14px;
            border-radius: 10px;
            text-decoration: none
        }
    </style>
</body>

</html>
