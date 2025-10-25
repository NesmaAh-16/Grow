@php
    // عدد رسائل الدعم المفتوحة للطالب الحالي (اختياري للبادج)
    $openSupport = \App\Models\SupportMessage::where('created_by_user_id', auth()->id())
                    ->where('status','open')
                    ->count();
@endphp
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>المواد الدراسية </title>
    <link rel="icon" href="{{ asset('assets/images/logo2-removebg-preview.png') }}" type="image/x-icon" width = "15px">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800;900&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet"
        href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/subjects.css') }}">
    <style>.quizzes-section{margin-top:28px}
.section-title{font-size:22px;font-weight:800;color:#1f3fbf;margin-bottom:12px;text-align:center}
.quizzes-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:16px}
.quiz-card{background:#fff;border:1px solid #e6ecff;border-radius:14px;padding:16px;box-shadow:0 8px 20px rgba(31,63,191,.06)}
.quiz-card-muted{opacity:.85}
.quiz-card-head{display:flex;flex-direction:column;gap:4px;margin-bottom:10px}
.quiz-title{font-size:18px;font-weight:800;color:#0a2a88;margin:0}
.quiz-subtitle{font-size:13px;color:#6b7280}
.quiz-meta{list-style:none;padding:0;margin:0 0 12px 0;display:flex;flex-direction:column;gap:6px;color:#374151;font-size:14px}
.btn.w-100{width:100%}
</style>

</head>

<body>
    <div class="page-container">
        <nav>
            <div class="nav-left">
                <a class="brand" href="{{ route('home') }}">
                    <img class="logo" src="{{ asset('assets/images/imageedit_2_6635233653.png') }}"
                        alt="شعار المنصة" />
                    <img class="brand-name" src="{{ asset('assets/images/logomwhite.png') }}" alt="Grow" />
                </a>
            </div>
            <div class="nav-menu">
                <a href="{{ route('home') }}" class="nav-link">
                    <i class="fas fa-home" style="margin-left: 8px"></i>
                    الصفحة الرئيسية
                </a>

            </div>
            <div class="nav-right">
                {{-- - <button class="nav-btn" title="الإشعارات">
                    <i class="fas fa-bell"></i>
                    <span class="badge">3</span>
                </button>
                <a href="#" class="nav-btn" title="الإعدادات">
                    <i class="fas fa-cog"></i> --}}
                <a href="{{ route('student.settings') }}" class="nav-btn" title="الإعدادات">
                    <i class="fas fa-cog"></i>
                </a>
                <a href="{{ route('support.index') }}" class="nav-btn" title="الدعم الفني">
                    <i class="fas fa-headset"></i>
                    @if ($openSupport > 0)
                        <span class="badge">{{ $openSupport }}</span>
                    @endif
                    <span>الدعم الفني</span>
                </a>
                <a href="#" class="logout-btn"
                    onclick ="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>تسجيل خروج</span>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">
                    @csrf
                </form>

            </div>
        </nav>

        <main>
            <div class="container">
                <section class="hero">
                    <h1>مرحباً {{ auth()->user()->name }}</h1>
                    <p class="text-center">
                        {{ $profile?->grade ?? 'الصف غير محدد' }} –
                        {{ $profile && $profile->semester ? $profile->semester_arabic : 'الفصل الأول' }} </p>
                </section>

                <section class="courses">
                    <div class="course">
                        <h3>اللغة العربية</h3>
                        <img
                            src="https://www.cappasande.de/wp-content/uploads/2023/05/%D9%86%D8%B4%D8%A3%D8%A9-%D8%A7%D9%84%D9%84%D8%BA%D8%A9-%D8%A7%D9%84%D8%B9%D8%B1%D8%A8%D9%8A%D8%A9.jpg" />
                        <p>الأستاذة: أمل عدنان</p>
                        <a href="{{ route('lessons.arabic') }}">
                            <i class="fas fa-door-open" style="margin-left: 8px"></i>
                            دخول للصف
                        </a>
                    </div>
                    <div class="course">
                        <h3>اللغة الإنجليزية</h3>
                        <img src="https://successacademy.training/wp-content/uploads/2024/12/preview-1320x933.jpg" />
                        <p>الأستاذة: سارة صالح</p>
                        <a href="{{ route('lessons.english') }}">
                            <i class="fas fa-door-open" style="margin-left: 8px"></i>
                            دخول للصف
                        </a>
                    </div>
                    <div class="course">
                        <h3>الرياضيات</h3>
                        <img
                            src="https://images.for9a.com/thumb/max-800-auto-100-webp/ol/blog/2020/04/06/620x377-51586156952771.jpg" />
                        <p>الأستاذة: نسمة أحمد</p>
                        <a href="{{ route('lessons.details') }}">
                            <i class="fas fa-door-open" style="margin-left: 8px"></i>
                            دخول للصف
                        </a>
                    </div>
                    <div class="course">
                        <h3>العلوم العامة</h3>
                        <img src="{{ asset('assets/images/scei2.png') }}" />
                        <p>الأستاذة: ملاك حسونة</p>
                        <a href="{{ route('lessons.science') }}">
                            <i class="fas fa-door-open" style="margin-left: 8px"></i>
                            دخول للصف
                        </a>
                    </div>
                </section>
                {{-- ===== اختبارات متاحة الآن ===== --}}
@if(!empty($availableQuizzes) && $availableQuizzes->count())
<section class="quizzes-section">
  <h2 class="section-title">اختبارات متاحة الآن</h2>
  <div class="quizzes-grid">
    @foreach ($availableQuizzes as $qz)
      <div class="quiz-card">
        <div class="quiz-card-head">
          <h3 class="quiz-title">{{ $qz->title }}</h3>
          <span class="quiz-subtitle">{{ $qz->lesson?->title ?? '—' }}</span>
        </div>

        <ul class="quiz-meta">
          <li><i class="fa-regular fa-clock"></i> المدة: {{ $qz->duration_minutes ?? 15 }} دقيقة</li>
          @if($qz->end_at)
            <li><i class="fa-solid fa-hourglass-half"></i> ينتهي: {{ \Carbon\Carbon::parse($qz->end_at)->format('Y-m-d H:i') }}</li>
          @endif
        </ul>

        {{-- استخدم روت المعلّم كما هو --}}
        <a class="btn btn-primary w-100" href="{{ route('quizzes.attempt', $qz->id) }}">
          ابدأ الآن
        </a>
      </div>
    @endforeach
  </div>
</section>
@endif

{{-- ===== اختبارات قادمة ===== --}}
@if(!empty($upcomingQuizzes) && $upcomingQuizzes->count())
<section class="quizzes-section" style="margin-top:20px">
  <h2 class="section-title">اختبارات قادمة</h2>
  <div class="quizzes-grid">
    @foreach ($upcomingQuizzes as $qz)
      <div class="quiz-card quiz-card-muted">
        <div class="quiz-card-head">
          <h3 class="quiz-title">{{ $qz->title }}</h3>
          <span class="quiz-subtitle">{{ $qz->lesson?->title ?? '—' }}</span>
        </div>

        <ul class="quiz-meta">
          <li><i class="fa-regular fa-calendar"></i> يبدأ: {{ \Carbon\Carbon::parse($qz->start_at)->format('Y-m-d H:i') }}</li>
          <li><i class="fa-regular fa-clock"></i> المدة: {{ $qz->duration_minutes ?? 15 }} دقيقة</li>
        </ul>

        <button class="btn btn-secondary w-100" disabled>لم يبدأ بعد</button>
      </div>
    @endforeach
  </div>
</section>
@endif
{{-- ===== الواجبات المتاحة الآن ===== --}}
@if (Route::has('student.assignments.index'))
    <section class="quizzes-section" style="margin-top:28px">
        <h2 class="section-title">الواجبات المتاحة الآن</h2>

        @php
            // جلب سريع (لو ما بدك تنقل المنطق للداشبورد) — يُفضَّل الاعتماد على صفحة index
            // الأفضل: اترك هذا العنوان ورابط "عرض الكل"، وخلي القائمة في صفحة مستقلة
        @endphp

        <div style="text-align:center;margin-bottom:10px">
            <a href="{{ route('student.assignments.index') }}" class="btn btn-primary">
                عرض كل الواجبات
            </a>
        </div>
    </section>
@endif


            </div>
        </main>
    </div>
</body>

</html>
