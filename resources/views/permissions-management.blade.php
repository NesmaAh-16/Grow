@if (session('ok'))
  <div class="alert"
       style="background:#e6ffed;border:1px solid #b4f8c8;padding:10px;border-radius:8px;color:#1a7f37;margin:10px">
    {{ session('ok') }}
  </div>
@endif
@if ($errors->any())
  <div class="alert"
       style="background:#fdecec;border:1px solid #f5c2c7;padding:10px;border-radius:8px;color:#b02a37;margin:10px">
    <ul style="margin:0;padding-right:18px">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
  </div>
@endif

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>إدارة الصلاحيات - لوحة التحكم</title>

  <link rel="icon" href="{{ asset('assets/images/logo2-removebg-preview.png') }}" type="image/x-icon">
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/css/super-admin-dashboard.css') }}"/>
  <link rel="stylesheet" href="{{ asset('assets/css/permissions-management.css') }}"/>

  <style>
    .permissions-card{background:#fff;border:1px solid #e9ecef;border-radius:14px;padding:18px;margin:18px}
    .permissions-form .form-group{display:flex;gap:10px;align-items:center}
    .divider{height:1px;background:#eef2f7;margin:14px 0}
    .perm-toolbar{display:flex;justify-content:space-between;align-items:center;gap:10px;margin:8px 0 14px}
    .perm-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(230px,1fr));gap:12px;list-style:none;padding:0;margin:0}
    .perm-item{border:1px solid #e5e7eb;border-radius:12px;padding:12px;display:flex;align-items:center;justify-content:space-between}
    .perm-name-ar{font-weight:600}
    .btn{border-radius:10px;padding:10px 14px;border:1px solid transparent;cursor:pointer}
    .btn-primary{background:#3b82f6;color:#fff}
    .btn-secondary{background:#f8fafc;color:#111827;border-color:#e5e7eb}
    .actions{display:flex;gap:10px;align-items:center;justify-content:flex-end;margin-top:10px}
  </style>
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
        <li><a href="{{ route('admin.admins.index') }}"><i class="fas fa-user-shield"></i> إدارة الإداريين</a></li>
        <li><a href="{{ route('admin.system.settings') }}"><i class="fas fa-cogs"></i> إعدادات النظام</a></li>
        <li class="active"><a href="{{ route('admin.permissions.index') }}"><i class="fas fa-key"></i> إدارة الصلاحيات</a></li>
      </ul>
    </nav>
  </aside>

  <main class="main-content">
    <header class="main-header">
      <div class="header-title"><h1>إدارة الصلاحيات</h1></div>
      <div class="header-actions">
        <a href="#" class="logout-btn" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
          <i class="fas fa-sign-out-alt"></i><span>تسجيل خروج</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">@csrf</form>
      </div>
    </header>

    <div class="permissions-card">

      <form method="GET" action="{{ route('admin.permissions.index') }}" class="permissions-form">
        <div class="form-group">
          <label style="min-width:90px">اختر الدور:</label>
          <select name="role_id" onchange="this.form.submit()">
            @foreach ($roles as $r)
              <option value="{{ $r->id }}" @selected(optional($currentRole)->id == $r->id)>{{ $r->name }}</option>
            @endforeach
          </select>
        </div>
      </form>

      <div class="divider"></div>

      <form method="POST" action="{{ route('admin.permissions.store') }}" onsubmit="return confirm('حفظ التغييرات؟');">
        @csrf
        <input type="hidden" name="role_id" value="{{ optional($currentRole)->id }}">

        <div class="perm-toolbar">
          <label style="display:flex;align-items:center;gap:8px;font-size:.95rem">
            <input type="checkbox" id="select-all"> تحديد/إلغاء الكل
          </label>
        </div>

        <ul class="perm-grid">
          @foreach ($permissions as $p)
            <li class="perm-item">
              <div class="perm-name-ar">{{ $labels[$p->name] ?? $p->name }}</div>

              <div style="display:flex; align-items:center; gap:8px">
                <label>
                  <input type="checkbox" name="permissions[]" value="{{ $p->name }}"
                         @checked(in_array($p->name, $rolePermissions ?? []))>
                </label>

                <button type="submit" form="del-{{ md5($p->name) }}" class="btn btn-secondary" title="حذف الصلاحية">🗑️</button>
              </div>
            </li>
          @endforeach
        </ul>

        <div class="actions">
          <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">إلغاء</a>
          <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
        </div>
      </form>

      @foreach ($permissions as $p)
        <form id="del-{{ md5($p->name) }}" method="POST" action="{{ route('admin.permissions.delete') }}"
              onsubmit="return confirm('حذف نهائي لهذه الصلاحية من النظام؟');" style="display:none">
          @csrf @method('DELETE')
          <input type="hidden" name="name" value="{{ $p->name }}">
        </form>
      @endforeach

      <div class="divider"></div>

      <form method="POST" action="{{ route('admin.permissions.add') }}" class="permissions-form" style="gap:8px">
        @csrf
        <input type="hidden" name="role_id" value="{{ optional($currentRole)->id }}">
        <input type="text" name="name" placeholder="اسم الصلاحية (مثال: إدارة التقارير أو manage.reports)" style="flex:1">
        <button type="submit" class="btn btn-primary">إضافة صلاحية</button>
      </form>

    </div>
  </main>
</div>
</body>
</html>
