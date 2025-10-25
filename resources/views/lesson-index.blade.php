<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>الدروس المضافة</title>

  <link rel="icon" href="{{ asset('assets/images/logo2-removebg-preview.png') }}" type="image/x-icon">
  <link rel="stylesheet" href="{{ asset('assets/css/navbar.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/class-details.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

  <style>
    .flash{background:#ecfdf5;color:#065f46;border:1px solid #a7f3d0;border-radius:12px;padding:.8rem 1rem;margin:10px 0}
    .muted{color:#6b7280}
    .lessons-header {display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:12px}
    .lessons-header h1{font-size:1.4rem;margin:0}
    .lesson-actions{display:flex;gap:8px;align-items:center}
    .lesson-actions form{display:inline}
    .btn-sm{display:inline-flex;align-items:center;gap:6px;padding:8px 12px;border-radius:10px;border:1px solid #e5e7eb;background:#fff;cursor:pointer}
    .btn-view{background:#2563eb;color:#fff;border-color:#2563eb}
    .btn-edit{background:#f8fafc;color:#111827}
    .btn-del{background:#fff;color:#b91c1c;border-color:#f3c2c4}
    .btn-view:hover{background:#1d4ed8}
    .btn-edit:hover{background:#eef2ff}
    .btn-del:hover{background:#fff5f5}
  </style>
</head>
<body>
<div class="page-container">
  <nav>
    <div class="nav-left">
      <a class="brand" href="{{ route('home') }}">
        <img class="logo" src="{{ asset('assets/images/imageedit_2_6635233653.png') }}" alt="شعار المنصة" />
        <img class="brand-name" src="{{ asset('assets/images/logomwhite.png') }}" alt="Grow" />
      </a>
    </div>
    <div class="nav-menu">
      <a href="{{ route('home') }}" class="nav-link"><i class="fas fa-home" style="margin-left:8px"></i> الصفحة الرئيسية</a>
    </div>
    <div class="nav-right">
      <a href="#" class="logout-btn" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
        <i class="fas fa-sign-out-alt"></i><span>تسجيل خروج</span>
      </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">@csrf</form>
    </div>
  </nav>

  <main class="main-content">
    {{-- تنبيه نجاح --}}
    @if(session('success')) <div class="flash"><i class="fa fa-check-circle"></i> {{ session('success') }}</div> @endif

    {{-- الدروس (بدون صندوق تفاصيل الصف) --}}
    <section class="actions-section">
      <div class="lessons-header">
        <h1>الدروس المضافة</h1>
        <a href="{{ route('lessons.create') }}" class="add-lesson-btn">
          <i class="fas fa-plus"></i><span>إضافة درس جديد</span>
        </a>
      </div>

      <ul class="lessons-list">
        @forelse($lessons as $lesson)
          <li class="lesson-item">
            <div class="lesson-title">
              <a href="{{ route('lessons.show', $lesson) }}">{{ $lesson->title }}</a>
            </div>
            <div class="lesson-actions">
              <a href="{{ route('lessons.show', $lesson) }}" class="btn-sm btn-view" title="عرض">
                <i class="fa fa-eye"></i> عرض
              </a>
              <a href="{{ route('lessons.edit', $lesson) }}" class="btn-sm btn-edit" title="تعديل">
                <i class="fa fa-pen"></i> تعديل
              </a>
              <form action="{{ route('lessons.destroy', $lesson) }}" method="POST"
                    onsubmit="return confirm('حذف هذا الدرس نهائيًا؟')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-sm btn-del" title="حذف">
                  <i class="fa fa-trash"></i> حذف
                </button>
              </form>
            </div>
          </li>
        @empty
          <li class="lesson-item"><div class="lesson-title">لا توجد دروس بعد.</div></li>
        @endforelse
      </ul>

      <div style="margin-top:12px">{{ $lessons->withQueryString()->links() }}</div>
    </section>
  </main>
</div>
</body>
</html>
