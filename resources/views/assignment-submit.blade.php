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
  <title>إضافة تسليم - {{ $assignment->title }}</title>
  <link rel="stylesheet" href="{{ asset('assets/css/navbar.css') }}">
  <style>
    .wrap{max-width:860px;margin:18px auto}
    .card{background:#fff;border:1px solid #e6ecff;border-radius:14px;box-shadow:0 8px 20px rgba(31,63,191,.06)}
    .head{padding:18px 20px;border-bottom:1px solid #eef2ff}
    .title{font-size:26px;font-weight:800;color:#0a2a88;margin:0;text-align:center}
    .body{padding:16px 20px}
    .dropzone{border:2px dashed #c7d2fe;border-radius:12px;padding:24px;text-align:center;color:#6b7280}
    .btn-primary{background:#2f54eb;color:#fff;border:none;border-radius:10px;padding:10px 14px;cursor:pointer}
    .btn-secondary{background:#f1f3f9;border:1px solid #e3e6ef;color:#333;border-radius:10px;padding:10px 14px;text-decoration:none}
    .actions{display:flex;gap:10px;justify-content:flex-start;margin-top:12px}
    input[type=file]{display:none}
    label.file-btn{display:inline-block}
  </style>
</head>
<body>
  <div class="wrap card">
    <div class="head">
      <h1 class="title">الواجبات الدراسية</h1>
      <p style="text-align:center;color:#6b7280;margin:6px 0 0">عرض وتقديم الواجبات المطلوبة في الدروس المختلفة</p>
    </div>
    <div class="body">
      <h3 style="text-align:center;margin-bottom:16px">إضافة تسليم الواجب</h3>

      <form method="POST" action="{{ route('student.assignments.submit.store', $assignment->id) }}" enctype="multipart/form-data">
        @csrf

        <div class="dropzone">
          اسحب الملفات وأفلِتها هنا أو قم باختيارها من جهازك
          <div style="margin-top:12px">
            <label class="file-btn btn-primary">
              اختر ملفًا
              <input type="file" name="file" required>
            </label>
          </div>
          <p style="font-size:12px;color:#9ca3af;margin-top:8px">الأنواع المسموحة: pdf, doc, docx, ppt, pptx, zip, jpg, png (حتى 20MB)</p>
        </div>

        <div style="margin-top:12px">
          <label>ملاحظة (اختياري)</label>
          <textarea name="note" class="input" style="width:100%;min-height:90px;border:1px solid #e3e6ef;border-radius:10px;padding:10px"></textarea>
        </div>

        <div class="actions">
          <button class="btn-primary" type="submit">حفظ التسليم ✓</button>
          <a class="btn-secondary" href="{{ route('student.assignments.show', $assignment->id) }}">إلغاء ✗</a>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
