<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>تعديل الدرس</title>
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
    .danger{background:#fff;color:#b91c1c;border-color:#f3c2c4}
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
    <h1>تعديل الدرس</h1>

    @if(session('success'))
      <div style="background:#ecfdf5;border:1px solid #a7f3d0;color:#065f46;border-radius:12px;padding:.8rem 1rem;margin-bottom:10px">
        {{ session('success') }}
      </div>
    @endif

    @if($errors->any())
      <div style="background:#fff5f5;border:1px solid #fecaca;color:#991b1b;border-radius:12px;padding:.8rem 1rem;margin-bottom:10px">
        <b>تحقّق من الحقول التالية:</b>
        <ul style="margin:.4rem 0 0 0;padding-inline-start:18px">
          @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('lessons.update', $lesson) }}" enctype="multipart/form-data">
      @csrf @method('PUT')
      <div class="row">
        <div>
          <label>عنوان الدرس</label>
          <input type="text" name="title" value="{{ old('title', $lesson->title) }}" required>
        </div>
        <div>
          <label>المادة</label>
          <input type="text" name="subject" value="{{ old('subject', $lesson->subject) }}">
        </div>
        <div>
          <label>الصف</label>
          <input type="number" min="1" max="12" name="grade" value="{{ old('grade', $lesson->grade) }}">
        </div>
        <div>
          <label>ملف جديد (اختياري)</label>
          <input type="file" name="file" accept=".pdf,.doc,.docx,.ppt,.pptx,.png,.jpg,.jpeg">
          @if($lesson->file_path)
            <div style="margin-top:6px">
              <a href="{{ Storage::disk('public')->url($lesson->file_path) }}" target="_blank">الملف الحالي</a>
              <label style="margin-right:10px">
                <input type="checkbox" name="remove_file" value="1"> حذف الملف الحالي
              </label>
            </div>
          @endif
        </div>
        <div class="full">
          <label>محتوى الدرس</label>
          <textarea name="content" rows="8">{{ old('content', $lesson->content) }}</textarea>
        </div>
      </div>

      <div class="actions" style="margin-top:12px">
        <button class="btn primary" type="submit">حفظ التعديلات</button>
        <a class="btn" href="{{ route('lessons.show', $lesson) }}">إلغاء</a>
      </div>
    </form>

    <form method="POST" action="{{ route('lessons.destroy', $lesson) }}" onsubmit="return confirm('حذف هذا الدرس نهائيًا؟')" style="margin-top:10px">
      @csrf @method('DELETE')
      <button class="btn danger" type="submit"><i class="fa fa-trash"></i> حذف الدرس</button>
    </form>
  </div>
</div>
</body>
</html>
