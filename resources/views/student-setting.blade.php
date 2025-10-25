<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>الإعدادات</title>

  <link rel="icon" href="{{ asset('assets/images/logo2-removebg-preview.png') }}" type="image/x-icon">
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

  <style>
    :root{
      --ink:#0f2f72; --muted:#6b7280; --primary:#2563eb;
      --card:#fff; --bg:#f5f8ff; --border:#e7edf8; --ok:#10b981; --danger:#dc2626;
    }
    *{box-sizing:border-box}
    body{font-family:'Cairo',sans-serif;background:var(--bg);margin:0}
    .page{max-width:1100px;margin:0 auto;padding:20px}
    .nav{display:flex;align-items:center;justify-content:space-between;margin-bottom:14px}
    .nav a{color:var(--ink);text-decoration:none;font-weight:700}
    .card{background:var(--card);border:1px solid var(--border);border-radius:16px;box-shadow:0 6px 24px rgba(15,47,114,.06);padding:18px}
    h1{margin:0 0 14px;color:var(--ink);font-weight:900}
    label{display:block;font-weight:800;color:var(--ink);margin-bottom:6px}
    .row{display:grid;grid-template-columns:1fr 1fr;gap:14px}
    .full{grid-column:1 / -1}
    input,select{
      width:100%;background:#f7fbff;border:1px solid var(--border);
      padding:.85rem 1rem;border-radius:12px;font-size:1rem;outline:none
    }
    input[readonly]{background:#f2f6ff;color:#6b7280}
    .actions{display:flex;gap:10px;margin-top:10px}
    .btn{display:inline-flex;align-items:center;gap:8px;padding:.8rem 1.2rem;border-radius:12px;border:1px solid transparent;cursor:pointer;font-weight:800}
    .btn-primary{background:var(--primary);color:#fff}
    .btn-primary:hover{filter:brightness(.98)}
    .flash{border-radius:12px;padding:.85rem 1rem;margin:10px 0}
    .ok{background:#ecfdf5;border:1px solid #a7f3d0;color:#065f46}
    .err{background:#fff5f5;border:1px solid #fecaca;color:#991b1b}
    @media (max-width:860px){ .row{grid-template-columns:1fr} }
  </style>
</head>
<body>
<div class="page">

  <div class="nav">
    <a href="{{ route('home') }}"><i class="fa fa-home" style="margin-left:8px"></i>الصفحة الرئيسية</a>
    <a href="{{ route('student.dashboard') }}"><i class="fa fa-chalkboard" style="margin-left:8px"></i>لوحة الطالب</a>
  </div>

  {{-- رسائل --}}
  @if ($errors->any())
    <div class="flash err">
      <b>تحقّق من الحقول التالية:</b>
      <ul style="margin:.4rem 0 0 0; padding-inline-start:18px">
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
      </ul>
    </div>
  @endif

  @if (session('success_profile'))
    <div class="flash ok"><i class="fa fa-check-circle"></i> {{ session('success_profile') }}</div>
  @endif

  <section class="card">
    <h1>المعلومات الشخصية</h1>

    <form method="POST" action="{{ route('student.settings.profile') }}">
      @csrf

      <div class="row">
        <div class="full">
          <label>الاسم الكامل</label>
          <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
        </div>

        <div>
          <label>رقم الهوية</label>
          <input type="text" value="{{ $profile?->national_id ?? '—' }}" readonly>
        </div>

        <div>
          <label>تاريخ الميلاد</label>
          <input type="date" name="birth_date"
       value="{{ old('birth_date', optional($profile->birth_date)->format('Y-m-d')) }}">
        </div>

        <div class="full">
          <label>الصف الدراسي</label>
          <select name="grade">
            <option value="">— اختر الصف —</option>
            @for ($i=1;$i<=12;$i++)
              <option value="{{ $i }}" {{ (string)old('grade', $profile->grade ?? '') === (string)$i ? 'selected' : '' }}>
                الصف {{ $i }}
              </option>
            @endfor
          </select>
        </div>
      </div>

      <div class="actions">
        <button class="btn btn-primary"><i class="fa fa-save"></i> حفظ التغييرات</button>
      </div>
    </form>
  </section>
</div>
</body>
</html>
