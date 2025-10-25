@if (session('ok'))
  <div class="alert" style="background:#e6ffed;border:1px solid #b4f8c8;padding:10px;border-radius:8px;color:#1a7f37;margin:12px">
    {{ session('ok') }}
  </div>
@endif
@if ($errors->any())
  <div class="alert" style="background:#fdecec;border:1px solid #f5c2c7;color:#b02a37;padding:10px;border-radius:10px;margin:12px">
    <ul style="margin:0">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
  </div>
@endif

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <title>واجب: {{ $assignment->title }}</title>
  <link rel="stylesheet" href="{{ asset('assets/css/navbar.css') }}">
  <style>
    .page{max-width:960px;margin:18px auto;background:#fff;border-radius:14px;border:1px solid #e6ecff;box-shadow:0 8px 20px rgba(31,63,191,.06)}
    .head{padding:18px 20px;border-bottom:1px solid #eef2ff}
    .title{font-size:26px;font-weight:800;color:#0a2a88;margin:0}
    .body{padding:16px 20px}
    .row{display:grid;grid-template-columns:220px 1fr;gap:10px;padding:12px 0;border-bottom:1px dashed #eef2ff}
    .row:last-child{border-bottom:0}
    .label{color:#6b7280}
    .btn-primary{display:inline-block;background:#2f54eb;color:#fff;text-decoration:none;border:none;border-radius:10px;padding:12px 16px}
    .btn-disabled{opacity:.6;cursor:not-allowed}
  </style>
</head>
<body>
  <div class="page">
    <div class="head">
      <h1 class="title">واجب في درس: {{ $assignment->lesson?->title ?? '—' }}: <span style="color:#0a2a88">{{ $assignment->title }}</span></h1>
    </div>
    <div class="body">
      <div class="row">
        <div class="label">حالة التسليم</div>
        <div>
          @if($mySubmission)
            <span style="color:#198754">تم التسليم</span>
          @else
            <span style="color:#b02a37">لم يتم التسليم</span>
          @endif
        </div>
      </div>
      @if($assignment->published_at)
      <div class="row">
        <div class="label">تاريخ النشر</div>
        <div>{{ \Carbon\Carbon::parse($assignment->published_at)->translatedFormat('l d F Y, h:i a') }}</div>
      </div>
      @endif
      @if($assignment->due_at)
      <div class="row">
        <div class="label">موعد التسليم</div>
        <div>{{ \Carbon\Carbon::parse($assignment->due_at)->translatedFormat('l d F Y, h:i a') }}</div>
      </div>
      @endif
      <div class="row">
        <div class="label">معلومات الواجب</div>
        <div>{!! nl2br(e($assignment->instructions ?? '—')) !!}</div>
      </div>

      <div style="padding-top:16px">
        @if($available)
          <a class="btn-primary" href="{{ route('student.assignments.submit', $assignment->id) }}">إضافة تسليم +</a>
        @else
          <button class="btn-primary btn-disabled" disabled>انتهت مهلة التسليم</button>
        @endif
      </div>
    </div>
  </div>
</body>
</html>
