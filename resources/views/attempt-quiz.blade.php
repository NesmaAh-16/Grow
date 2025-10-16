{{-- resources/views/attempt-quiz.blade.php --}}
@if ($errors->any())
  <div class="alert alert-danger">
    <ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
  </div>
@endif
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>بدء الاختبار - {{ $quiz->title }}</title>

  <link rel="icon" href="{{ asset('assets/images/logo2-removebg-preview.png') }}" type="image/x-icon">
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800;900&display=swap" rel="stylesheet" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="{{ asset('assets/css/navbar.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/attempt-quiz.css') }}" />
</head>
<body>
  <div class="page-container">
    <nav>
      <div class="nav-left">
        <a class="brand" href="{{ route('home') }}">
          <img class="logo" src="{{ asset('assets/images/imageedit_2_6635233653.png') }}" alt="شعار المنصة" />
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
        <button class="nav-btn" title="الإشعارات">
          <i class="fas fa-bell"></i>
          <span class="badge">3</span>
        </button>
        <a href="#" class="nav-btn" title="الإعدادات"><i class="fas fa-cog"></i></a>
        <a href="{{ route('logout') }}" class="logout-btn"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <i class="fas fa-sign-out-alt"></i>
          <span>تسجيل خروج</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">@csrf</form>
      </div>
    </nav>

    <main class="main-content">
      {{-- لوحة جانبية --}}
      <aside class="quiz-dashboard">
        <div class="dashboard-header">
          <span class="label">الوقت المتبقي</span>
          <div id="timer" class="timer">--:--</div>
        </div>

        <div class="questions-nav-header">الانتقال السريع للأسئلة</div>
        <div id="questions-nav" class="questions-nav">
          @foreach($quiz->questions as $idx => $q)
            <a href="#q{{ $q->id }}" class="q-nav" data-q="{{ $q->id }}">{{ $idx+1 }}</a>
          @endforeach
        </div>

        {{-- زر التسليم يرسل الفورم الرئيسي --}}
        <button id="submit-btn" class="btn btn-success submit-btn" form="attempt-form">
          إنهاء و تسليم الاختبار
        </button>
      </aside>

      {{-- منطقة الأسئلة (فورم واحد) --}}
      <section id="question-area" class="question-area">
        <form id="attempt-form" method="POST" action="{{ route('quizzes.attempt.submit', $quiz->id) }}">
          @csrf

          <h1 class="quiz-title">{{ $quiz->title }}</h1>

          @foreach($quiz->questions as $i => $q)
            <article class="question-card" id="q{{ $q->id }}">
              <header class="question-head">
                <span class="q-number">سؤال {{ $i+1 }}</span>
                <span class="q-points">{{ $q->points ?? 1 }} نقطة</span>
              </header>

              <p class="q-text">{{ $q->text }}</p>

              @if($q->type === 'mc')
                @php $opts = $q->options ?? []; @endphp
                @foreach($opts as $k => $opt)
                  <label class="answer-option">
                    <input type="radio" name="answers[{{ $q->id }}]" value="{{ $k+1 }}">
                    <span>{{ $opt }}</span>
                  </label>
                @endforeach
              @else
                <label class="answer-option">
                  <input type="radio" name="answers[{{ $q->id }}]" value="1"> صح
                </label>
                <label class="answer-option">
                  <input type="radio" name="answers[{{ $q->id }}]" value="0"> خطأ
                </label>
              @endif
            </article>
          @endforeach

          {{-- إرسالي أيضاً من هنا احتياطاً --}}
          <div class="form-actions">
            <button type="submit" class="btn btn-primary">تسليم</button>
          </div>
        </form>
      </section>
    </main>
  </div>

  {{-- متغيّرات لسكربت التايمر لو بدك --}}
  <script>
    // مدة الامتحان بالدقائق (لو عندك مدة خزّنيها؛ وإلا حطي قيمة ثابتة)
    window.QUIZ_DURATION_MIN = {{ $durationMinutes ?? 15 }};
  </script>

  {{-- JS الخاص فيك (لو عندك سكربت يبني الأسئلة، يمكنك تجاهل ما فوق واستعمال JSON) --}}
  <script src="{{ asset('assets/js/attempt-quiz.js') }}"></script>
</body>
</html>
