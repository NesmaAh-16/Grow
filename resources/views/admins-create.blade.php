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
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>إضافة إداري جديد</title>
  <link rel="icon" href="{{ asset('assets/images/logo2-removebg-preview.png') }}" type="image/x-icon" width="15">
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <link rel="stylesheet" href="{{ asset('assets/css/super-admin-dashboard.css') }}"/>
  <link rel="stylesheet" href="{{ asset('assets/css/admins-management.css') }}"/>
</head>
<body>
<div class="dashboard-container">
  <aside class="sidebar">
    <div class="sidebar-header">
      <a class="brand" href="{{ route('home') }}">
        <img class="logo" src="{{ asset('assets/images/logo2-removebg-preview.png') }}" alt="شعار المنصة"/>
        <img class="brand-name" src="{{ asset('assets/images/edited_color.png') }}" alt="Grow"/>
      </a>
    </div>
    <nav class="sidebar-nav">
      <ul>
        <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> الرئيسية</a></li>
        <li class="active"><a href="{{ route('admin.admins.index') }}"><i class="fas fa-user-shield"></i> إدارة الإداريين</a></li>
        <li><a href="{{ route('admin.system.settings') }}"><i class="fas fa-cogs"></i> إعدادات النظام</a></li>
        <li><a href="{{ route('admin.permissions.index') }}"><i class="fas fa-key"></i> إدارة الصلاحيات</a></li>
      </ul>
    </nav>
  </aside>

  <main class="main-content">
    <header class="main-header">
      <div class="header-title">
        <h1>إضافة إداري جديد</h1>
        <p class="subtitle">أدخل بيانات الإداري وسيُمنح دور <strong>أدمن المستخدمين</strong> تلقائيًا.</p>
      </div>
      <div class="header-actions">
        <a href="{{ route('admin.admins.index') }}" class="logout-btn" style="gap:8px">
          <i class="fas fa-arrow-right"></i> <span>رجوع لإدارة الإداريين</span>
        </a>
      </div>
    </header>

    <section style="max-width:720px;">
      <form method="POST" action="{{ route('admin.admins.store') }}" class="card-form" style="display:grid;gap:12px">
        @csrf

        <div>
          <label>الاسم</label>
          <input type="text" name="name" class="input" value="{{ old('name') }}" required>
        </div>

        <div>
          <label>البريد</label>
          <input type="email" name="email" class="input" value="{{ old('email') }}" required>
        </div>

        <div>
          <label>الحالة</label>
          <select name="status" class="input">
            <option value="active" {{ old('status','active')==='active'?'selected':'' }}>فعال</option>
            <option value="inactive" {{ old('status')==='inactive'?'selected':'' }}>غير فعال</option>
            <option value="blocked" {{ old('status')==='blocked'?'selected':'' }}>محظور</option>
            <option value="pending" {{ old('status')==='pending'?'selected':'' }}>معلّق</option>
          </select>
        </div>

        <div>
          <label>كلمة المرور (اختياري)</label>
          <input type="password" name="password" class="input" placeholder="إن تركته فارغًا تُعيّن admin123">
        </div>

        <div style="display:flex;gap:8px">
          <button class="btn btn-primary" type="submit"><i class="fas fa-save"></i> حفظ</button>
          <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary">رجوع</a>
        </div>
      </form>
    </section>
  </main>
</div>

<style>
  .card-form .input{width:100%;padding:10px;border:1px solid #e3e6ef;border-radius:10px}
  .card-form label{display:block;margin-bottom:6px;color:#444}
  .btn.btn-secondary{background:#f1f3f9;border:1px solid #e3e6ef;color:#333;padding:10px 14px;border-radius:10px;text-decoration:none}
</style>
</body>
</html>
