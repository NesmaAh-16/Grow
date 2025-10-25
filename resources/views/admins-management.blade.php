@if (session('ok'))
  <div class="alert" style="background:#e6ffed;border:1px solid #b4f8c8;padding:10px;border-radius:8px;color:#1a7f37;margin:10px">
    {{ session('ok') }}
  </div>
@endif
@if ($errors->any())
  <div class="alert" style="background:#fdecec;border:1px solid #f5c2c7;padding:10px;border-radius:8px;color:#b02a37;margin:10px">
    <ul style="margin:0;padding-right:18px">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
  </div>
@endif

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>إدارة الإداريين - لوحة التحكم</title>
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
        <li class="active"><a href="{{ route('admin.admins.index') }}"><i class="fas fa-user-shield"></i> إدارة الاداريين</a></li>
        <li><a href="{{ route('admin.system.settings') }}"><i class="fas fa-cogs"></i> إعدادات النظام</a></li>
        <li><a href="{{ route('admin.permissions.index') }}"><i class="fas fa-key"></i> إدارة الصلاحيات</a></li>
      </ul>
    </nav>
  </aside>

  <main class="main-content">
    <header class="main-header">
      <div class="header-title"><h1>إدارة الإداريين</h1></div>
      <div class="header-actions">
        <button class="action-btn" title="الإشعارات"><i class="fas fa-bell"></i><span class="badge">3</span></button>
        <button class="action-btn" title="الإعدادات"><i class="fas fa-cog"></i></button>
        <a href="#" class="logout-btn" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
          <i class="fas fa-sign-out-alt"></i><span>تسجيل خروج</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">@csrf</form>
      </div>
    </header>

    <form method="GET" action="{{ route('admin.admins.index') }}" class="toolbar">
      <a href="{{ route('admin.admins.create') }}" class="btn btn-primary">➕ إضافة إداري جديد</a>
      <div class="search-container">
        <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="بحث بالبريد أو الاسم...">
        <i class="fas fa-search"></i>
      </div>
    </form>

    <div class="table-container">
      <table class="admin-table">
        <thead>
          <tr>
            <th>الاسم</th>
            <th>البريد</th>
            <th>الدور</th>
            <th>الحالة</th>
            <th style="width:180px">إجراءات</th>
          </tr>
        </thead>
        <tbody>
          @forelse($admins as $a)
            <tr>
              <td>{{ $a->name }}</td>
              <td>{{ $a->email }}</td>
              <td>أدمن المستخدمين</td>
              <td><span class="btn-action btn-view" style="cursor:default">{{ $a->status ?? 'active' }}</span></td>
              <td>
                <a href="{{ route('admin.admins.edit', $a->id) }}" class="btn-action btn-edit">تعديل</a>
                <form action="{{ route('admin.admins.delete', $a->id) }}" method="POST" style="display:inline" onsubmit="return confirm('حذف الإداري؟');">
                  @csrf @method('DELETE')
                  <button class="btn-action btn-delete" type="submit">حذف</button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="5" style="text-align:center">لا يوجد إداريون.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if ($admins->hasPages())
      <div style="margin-top:10px">{{ $admins->links() }}</div>
    @endif
  </main>
</div>
</body>
</html>
