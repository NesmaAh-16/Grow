<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>العلوم العامة</title>

  <link rel="icon" href="{{ asset('assets/images/logo2-removebg-preview.png') }}" type="image/x-icon">
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <link rel="stylesheet" href="{{ asset('assets/css/navbar.css') }}">

  <style>
    body{font-family:'Cairo',sans-serif;background:#f3f8ff}
    .page-container{padding-top:70px} /* لو الـ navbar ثابت */
    .page-wrap{max-width:980px;margin:32px auto}
    .title{font-size:32px;font-weight:800;color:#1f3b8a;text-align:center}
    .subtitle{color:#667085;text-align:center;margin-top:6px}
    .unit{background:#fff;border-radius:14px;box-shadow:0 8px 24px rgba(16,24,40,.08);margin:20px 0;padding:16px 0}
    .unit-head{font-size:22px;font-weight:800;color:#1f3b8a;text-align:center}
    .divider{height:6px;background:#e9eef9;border-radius:999px;margin:10px 22px}
    .lesson{display:flex;align-items:center;gap:12px;background:#fff;border:1px solid #eef2f7;margin:12px 22px;padding:14px;border-radius:12px}
    .lesson:hover{box-shadow:0 6px 16px rgba(16,24,40,.06)}
    .dot{width:8px;height:8px;background:#c7d2fe;border-radius:999px;margin:0 6px}
    .l-title{font-weight:800;color:#0f172a}
    .meta{color:#667085;font-size:14px;margin-top:4px}
    .type{font-size:13px;background:#eef2ff;color:#3730a3;padding:4px 10px;border-radius:999px;margin-right:auto}
    .dur{display:flex;align-items:center;color:#64748b;font-size:13px}
    .dur i{margin-left:6px}
    .check{margin-right:8px}
  </style>
</head>
<body>
<div class="page-container">
  <nav>
    <div class="nav-left">
      <a class="brand" href="{{ route('home') }}">
        <img class="logo" src="{{ asset('assets/images/imageedit_2_6635233653.png') }}" alt="">
        <img class="brand-name" src="{{ asset('assets/images/logomwhite.png') }}" alt="Grow">
      </a>
    </div>
    <div class="nav-menu">
      <a href="{{ route('home') }}" class="nav-link">
        <i class="fas fa-home" style="margin-left:8px"></i>الصفحة الرئيسية
      </a>
    </div>
    <div class="nav-right">
      <button class="nav-btn" title="الإشعارات"><i class="fas fa-bell"></i><span class="badge">3</span></button>
      <a href="#" class="nav-btn" title="الإعدادات"><i class="fas fa-cog"></i></a>
      <a href="#" class="logout-btn" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
        <i class="fas fa-sign-out-alt"></i><span>تسجيل خروج</span>
      </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">@csrf</form>
    </div>
  </nav>

  <main class="page-wrap">
    <h1 class="title">العلوم العامة</h1>
    <div class="subtitle">الأستاذ/ة محمد علي · الصف الحادي عشر</div>
        {{-- <div class="subtitle">الأستاذ/ة {{ auth()->user()->name ?? '—' }} · الصف الحادي عشر</div> --}}

    {{-- الوحدة 1: الفيزياء --}}
    <section class="unit">
      <div class="unit-head">الوحدة الأولى: الفيزياء</div>
      <div class="divider"></div>

      <article class="lesson">
        <input type="checkbox" class="check">
        <div>
          <a href="#" class="l-title">الدرس الأول: الحركة والقوى (Newton’s Laws)</a>
          <div class="meta">درس مرئي — مفاهيم القوة، الكتلة، التسارع وتطبيقات قانون نيوتن الثاني</div>
        </div>
        <span class="type">درس مرئي</span>
        <div class="dot"></div>
        <div class="dur"><i class="fa-regular fa-clock"></i> 15 دقيقة</div>
      </article>

      <article class="lesson">
        <input type="checkbox" class="check">
        <div>
          <a href="#" class="l-title">الدرس الثاني: الطاقة والشغل والقدرة</a>
          <div class="meta">درس قراءة — صور الطاقة، قانون حفظ الطاقة، أمثلة حسابية</div>
        </div>
        <span class="type">درس قراءة</span>
        <div class="dot"></div>
        <div class="dur"><i class="fa-regular fa-clock"></i> 12 دقيقة</div>
      </article>
    </section>

    {{-- الوحدة 2: الكيمياء --}}
    <section class="unit">
      <div class="unit-head">الوحدة الثانية: الكيمياء</div>
      <div class="divider"></div>

      <article class="lesson">
        <input type="checkbox" class="check">
        <div>
          <a href="#" class="l-title">الدرس الأول: الروابط الكيميائية (أيونية وتساهمية)</a>
          <div class="meta">درس مرئي — الذائبية، القطبية، أشكال الجزيئات VSEPR</div>
        </div>
        <span class="type">درس مرئي</span>
        <div class="dot"></div>
        <div class="dur"><i class="fa-regular fa-clock"></i> 14 دقيقة</div>
      </article>

      <article class="lesson">
        <input type="checkbox" class="check">
        <div>
          <a href="#" class="l-title">الدرس الثاني: المعادلات الكيميائية والمولارية</a>
          <div class="meta">تمرين تفاعلي — موازنة معادلات وحساب تركيز المحاليل</div>
        </div>
        <span class="type">تمرين تفاعلي</span>
        <div class="dot"></div>
        <div class="dur"><i class="fa-regular fa-clock"></i> 20 دقيقة</div>
      </article>
    </section>

    {{-- الوحدة 3: الأحياء --}}
    <section class="unit">
      <div class="unit-head">الوحدة الثالثة: الأحياء</div>
      <div class="divider"></div>

      <article class="lesson">
        <input type="checkbox" class="check">
        <div>
          <a href="#" class="l-title">الدرس الأول: الخلية وبُناها (Cell Structure)</a>
          <div class="meta">درس مرئي — عضيات الخلية، الغشاء البلازمي، النقل عبر الأغشية</div>
        </div>
        <span class="type">درس مرئي</span>
        <div class="dot"></div>
        <div class="dur"><i class="fa-regular fa-clock"></i> 16 دقيقة</div>
      </article>

      <article class="lesson">
        <input type="checkbox" class="check">
        <div>
          <a href="#" class="l-title">الدرس الثاني: الوراثة ومربع بونت</a>
          <div class="meta">درس قراءة — الجينات، الأنماط الجينية والظاهرية، أمثلة سريعة</div>
        </div>
        <span class="type">درس قراءة</span>
        <div class="dot"></div>
        <div class="dur"><i class="fa-regular fa-clock"></i> 10 دقائق</div>
      </article>
    </section>

    {{-- الوحدة 4: الأرض والفضاء --}}
    <section class="unit">
      <div class="unit-head">الوحدة الرابعة: الأرض والفضاء</div>
      <div class="divider"></div>

      <article class="lesson">
        <input type="checkbox" class="check">
        <div>
          <a href="#" class="l-title">الدرس الأول: طبقات الغلاف الجوي والطقس</a>
          <div class="meta">درس مرئي — التروبوسفير، الستراتوسفير، عوامل تكوّن الطقس</div>
        </div>
        <span class="type">درس مرئي</span>
        <div class="dot"></div>
        <div class="dur"><i class="fa-regular fa-clock"></i> 13 دقيقة</div>
      </article>

      <article class="lesson">
        <input type="checkbox" class="check">
        <div>
          <a href="#" class="l-title">الدرس الثاني: المجموعة الشمسية وحركة الكواكب</a>
          <div class="meta">تمرين تفاعلي — مدارات، اليوم والسنة، أطوار القمر</div>
        </div>
        <span class="type">تمرين تفاعلي</span>
        <div class="dot"></div>
        <div class="dur"><i class="fa-regular fa-clock"></i> 18 دقيقة</div>
      </article>
    </section>
  </main>
</div>
</body>
</html>
