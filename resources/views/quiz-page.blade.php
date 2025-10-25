@if (session('ok'))
  <div class="alert"
       style="background:#e6ffed;border:1px solid #b4f8c8;padding:10px;border-radius:8px;color:#1a7f37;margin-bottom:10px;">
    {{ session('ok') }}
  </div>
@endif

@if ($errors->any())
  <div class="alert"
       style="background:#fdecec;border:1px solid #f5c2c7;padding:10px;border-radius:8px;color:#b02a37;margin-bottom:10px;">
    <ul style="margin:0">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> بدء الاختبار</title>
    <link rel="icon" href="{{ asset('assets/images/logo2-removebg-preview.png') }}" type="image/x-icon" width = "15px">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800;900&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/quiz-page.css') }}" />

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
                    <i class="fas fa-cog"></i>--}}
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

        <main class="main-content">
            <div class="quiz-card">
                <h1>اختبار قصير : <span>{{ $quiz->title }}</span></h1>
                <div class="info-section">
                    <div class="info-item">
                        <div class="info-item-text">
                            <span class="label">عدد الأسئلة :</span>
                            <span class="value">{{ $quiz->questions_count }} أسئلة</span>
                        </div>
                        <span class="icon">❓</span>
                    </div>
                    <div class="info-item">
                        <div class="info-item-text">
                            <span class="label">الزمن المتاح :</span>
                            <span class="value">{{ $quiz->duration_minutes ?? 0 }}
                                دقيقة</span>
                        </div>
                        <span class="icon">⏱️</span>
                    </div>
                    <?php

                     ?>
                    <div class="info-item">
                        <div class="info-item-text">
                            <span class="label">عدد المحاولات :</span>
                            @php $a = (int)($quiz->attempts_allowed ?? 1); @endphp
                            <span class="value">
                                @if ($a === 1)
                                    محاولة واحدة
                                @elseif ($a === 2)
                                    محاولتان
                                @else
                                    {{ $a }} محاولات
                                @endif
                            </span>
                        </div>
                        <div class="info-item">
                            <div class="info-item-text">
                                <span class="label">الدرجة :</span>
                                <span class="value">من {{ $quiz->total_marks }}</span>
                            </div>
                            <span class="icon">⭐</span>
                        </div>
                    </div>

                    <div class="action-section">
                        <div class="pledge-section">
                            <input type="checkbox" id="pledge-checkbox" onchange="toggleButton()" />
                            <label for="pledge-checkbox">أتعهد بأنني لن أقوم بالغش وسأعتمد على نفسي فقط.</label>
                        </div>
                        <a id="start-quiz-btn" class="start-btn pulse-anim"
                            href="{{ route('quizzes.attempt', $quiz->id) }}"
                            onclick="if(!document.getElementById('pledge-checkbox').checked){ alert('فعّل التعهّد أولاً'); return false; }">
                            🚀 ابدأ الاختبار
                        </a>
                    </div>
                </div>
        </main>
    </div>

    <script src="assets/js/quiz-page.js"></script>
    <script>
        window.QUIZ_DURATION_MIN = {{ $quiz->duration_minutes ?? 0 }};
    </script>
</body>

</html>
