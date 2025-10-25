<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة اختبار جديد</title>
    <link rel="icon" href="{{ asset('assets/images/logo2-removebg-preview.png') }}" type="image/x-icon" width = "15px">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/navbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/create-quiz.css') }}" />
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
            <header class="page-header">
                <div class="step-indicator">الخطوة 1 من 2</div>
                <h1>إعدادات الاختبار</h1>
                <p class="subtitle">ابدأ بإدخال التفاصيل الأساسية وخيارات الاختبار.</p>
            </header>
            @if ($errors->any())
                <div style="background:#fee;color:#900;padding:8px;margin-bottom:10px">
                    <b>Validation failed:</b>
                    <ul>
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="create-quiz-form" method="POST" action="{{ route('quizzes.store') }}">
                @csrf

                <section class="form-section">
                    <h2 class="section-title">بيانات الاختبار الأساسية</h2>
                    <div class="form-grid">

                        <div class="form-group">
                            <label for="grade">الصف</label>
                            <select id="grade" name="grade" required>
                                <option value="" disabled {{ old('grade') ? '' : 'selected' }}>اختر الصف</option>
                                @for ($g = 1; $g <= 11; $g++)
                                    <option value="{{ $g }}" {{ old('grade') == $g ? 'selected' : '' }}>
                                        الصف
                                        {{ $g }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="title">عنوان الاختبار</label>
                            <input type="text" id="title" name="title" value="{{ old('title') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="total_marks">الدرجة الكلية</label>
                            <input type="number" id="total_marks" name="total_marks"
                                value="{{ old('total_marks', 100) }}" min="1">
                        </div>

                        <div class="form-group">
                            <label for="available_from">تاريخ البدء</label>
                            <input type="datetime-local"id="available_from" name="available_from"
                                value="{{ old('available_from') }}">
                        </div>

                        <div class="form-group">
                            <label for="available_to">تاريخ الانتهاء</label>
                            <input type="datetime-local" id="available_to" name="available_to"
                                value="{{ old('available_to') }}">
                        </div>

                        <div class="form-group full-width">
                            <label for="attempts_allowed">عدد المحاولات المسموحة</label>
                            <input type="number" id="attempts_allowed" name="attempts_allowed" min="1"
                                max="20" step="1" value="{{ old('attempts_allowed', 1) }}">
                            @error('attempts_allowed')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </section>

                <footer class="form-actions">
                    <a href="{{ route('quizzes.index') }}" class="btn btn-secondary">إلغاء</a>
                    <button type="submit" class="btn btn-primary">متابعة لإضافة الأسئلة</button>
                </footer>
            </form>
        </main>
    </div>
</body>

</html>
