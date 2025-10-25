<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>إضافة درس جديد</title>
  <link rel="icon" href="{{ asset('assets/images/logo2-removebg-preview.png') }}" type="image/x-icon">
  <link rel="stylesheet" href="{{ asset('assets/css/navbar.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/class-details.css') }}">
  <style>
    body{font-family:'Cairo',sans-serif;background:#f3f9ff}
    .card{background:#fff;border:1px solid #d7e2ff;border-radius:14px;padding:18px;max-width:900px;margin:16px auto}
    label{font-weight:800}
    input,textarea{width:100%;border:1px solid #d7e2ff;border-radius:12px;padding:.8rem 1rem;background:#f7fbff}
    .row{display:grid;grid-template-columns:1fr 1fr;gap:14px}
    .full{grid-column:1 / -1}
    .actions{display:flex;gap:10px}
    .btn{padding:.75rem 1.1rem;border-radius:12px;border:1px solid #d7e2ff;text-decoration:none}
    .primary{background:#2a67f3;color:#fff;border-color:transparent}
  </style>
</head>
<body>
<div class="page-container">
  <nav>
    <div class="nav-left">
      <a class="brand" href="{{ route('home') }}">
        <img class="logo" src="{{ asset('assets/images/imageedit_2_6635233653.png') }}">
        <img class="brand-name" src="{{ asset('assets/images/logomwhite.png') }}">
      </a>
    </div>
  </nav>

  <div class="card">
    <h1>إضافة درس جديد</h1>

    @if($errors->any())
      <div style="background:#fff5f5;border:1px solid #fecaca;color:#991b1b;border-radius:12px;padding:.8rem 1rem;margin-bottom:10px">
        <b>تحقّق من الحقول التالية:</b>
        <ul style="margin:.4rem 0 0 0;padding-inline-start:18px">
          @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('lessons.store') }}" enctype="multipart/form-data">
      @csrf
      <div class="row">
        <div>
          <label>عنوان الدرس</label>
          <input type="text" name="title" value="{{ old('title') }}" required>
        </div>
        <div>
          <label>المادة</label>
          <input type="text" name="subject" value="{{ old('subject') }}">
        </div>
        <div>
          <label>الصف</label>
          <input type="number" min="1" max="12" name="grade" value="{{ old('grade') }}">
        </div>
        <div>
          <label>ملف الدرس (اختياري)</label>
          <input type="file" name="file" accept=".pdf,.doc,.docx,.ppt,.pptx,.png,.jpg,.jpeg">
        </div>
        <div class="full">
          <label>محتوى الدرس</label>
          <textarea name="content" rows="8" placeholder="نص الدرس / شرح مختصر">{{ old('content') }}</textarea>
        </div>
      </div>

      <div class="actions" style="margin-top:12px">
        <button class="btn primary" type="submit">حفظ</button>
        <a class="btn" href="{{ route('lessons.index') }}">إلغاء</a>
      </div>
    </form>
  </div>
</div>
</body>
</html>
