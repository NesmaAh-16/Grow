<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $lesson->title }}</title>
  <link rel="icon" href="{{ asset('assets/images/logo2-removebg-preview.png') }}" type="image/x-icon">
  <link rel="stylesheet" href="{{ asset('assets/css/navbar.css') }}">
  <style>
    body{font-family:'Cairo',sans-serif;background:#f6f9ff;margin:0}
    .page{max-width:900px;margin:0 auto;padding:20px}
    .card{background:#fff;border:1px solid #d7e2ff;border-radius:14px;padding:16px}
    .muted{color:#6b7280}
    .actions{display:flex;gap:10px;margin-bottom:10px}
    .btn{padding:.6rem .9rem;border-radius:10px;border:1px solid #d7e2ff;text-decoration:none}
    .primary{background:#2a67f3;color:#fff;border-color:transparent}
  </style>
</head>
<body>
<div class="page">
  @if(session('success'))
    <div style="background:#ecfdf5;border:1px solid #a7f3d0;color:#065f46;border-radius:12px;padding:.8rem 1rem;margin-bottom:10px">
      {{ session('success') }}
    </div>
  @endif

  <div class="actions">
    <a class="btn" href="{{ route('lessons.index') }}">الرجوع للقائمة</a>
    <a class="btn primary" href="{{ route('lessons.edit', $lesson) }}"><i class="fa fa-edit"></i> تعديل</a>
  </div>

  <div class="card">
    <h1 style="margin:0 0 6px">{{ $lesson->title }}</h1>
    <div class="muted" style="margin-bottom:8px">المادة: {{ $lesson->subject ?? '—' }} — الصف {{ $lesson->grade ?? '—' }}</div>
    <div>{!! nl2br(e($lesson->content)) !!}</div>
    @if($lesson->file_path)
      <div style="margin-top:10px">
        <a href="{{ Storage::disk('public')->url($lesson->file_path) }}" target="_blank">تحميل/عرض الملف</a>
      </div>
    @endif
  </div>
</div>
</body>
</html>
