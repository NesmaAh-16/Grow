@if (session('ok'))
  <div class="alert" style="background:#e6ffed;border:1px solid #b4f8c8;padding:10px;border-radius:8px;color:#1a7f37;margin-bottom:10px">
    {{ session('ok') }}
  </div>
@endif

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <title>الواجبات الدراسية</title>
  <link rel="stylesheet" href="{{ asset('assets/css/navbar.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/subjects.css') }}">
  <style>
    .assignments-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:16px}
    .ass-card{background:#fff;border:1px solid #e6ecff;border-radius:14px;padding:16px;box-shadow:0 8px 20px rgba(31,63,191,.06)}
    .ass-title{font-size:18px;font-weight:800;color:#0a2a88;margin:0 0 6px}
    .ass-lesson{font-size:13px;color:#6b7280;margin-bottom:10px}
    .ass-meta{list-style:none;padding:0;margin:0 0 12px;display:flex;flex-direction:column;gap:6px;color:#374151;font-size:14px}
    .badge-done{background:#e7f7ec;color:#198754;border:1px solid #cfead7;padding:2px 8px;border-radius:999px;font-size:12px}
    .badge-pending{background:#fdecec;color:#b02a37;border:1px solid #f5c2c7;padding:2px 8px;border-radius:999px;font-size:12px}
  </style>
</head>
<body>
  <div class="page-container">
    @include('partials.student-topbar') {{-- إن كان عندك ناف بار مشترك --}}
    <main class="container">
      <h1 style="text-align:center;margin:12px 0 18px">الواجبات المتاحة الآن</h1>

      @if($assignments->isEmpty())
        <p style="text-align:center;color:#6b7280">لا يوجد واجبات متاحة حاليًا.</p>
      @else
        <div class="assignments-grid">
          @foreach ($assignments as $a)
            <div class="ass-card">
              <h3 class="ass-title">{{ $a->title }}</h3>
              <div class="ass-lesson">{{ $a->lesson?->title ?? '—' }}</div>

              <ul class="ass-meta">
                @if($a->published_at)
                  <li>تاريخ النشر: {{ \Carbon\Carbon::parse($a->published_at)->format('Y-m-d H:i') }}</li>
                @endif
                @if($a->due_at)
                  <li>موعد التسليم: {{ \Carbon\Carbon::parse($a->due_at)->format('Y-m-d H:i') }}</li>
                @endif
                <li>
                  الحالة:
                  @if($a->submitted_by_me > 0)
                    <span class="badge-done">تم التسليم</span>
                  @else
                    <span class="badge-pending">لم يتم التسليم</span>
                  @endif
                </li>
              </ul>

              <a class="btn btn-primary w-100" href="{{ route('student.assignments.show', $a->id) }}">
                عرض وتسليم
              </a>
            </div>
          @endforeach
        </div>
      @endif
    </main>
  </div>
</body>
</html>
