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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل اختبار</title>

    <link rel="icon" href="{{ asset('assets/images/logo2-removebg-preview.png') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/create-quiz.css') }}">
    <style>
        .btn-sm {
            padding: .6rem 1.2rem;
            border-radius: 10px;
            font-weight: 700
        }

        .btn-cancel {
            background: #f1f1f1;
            color: #333;
            border: 1px solid #dee2e6;
            text-decoration: none
        }

        .btn-cancel:hover {
            background: #e9ecef
        }
    </style>
</head>

<body>
    <div class="page-container">
        <nav>
            <div class="nav-left">
                <a class="brand" href="{{ route('home') }}">
                    <img class="logo" src="{{ asset('assets/images/imageedit_2_6635233653.png') }}" alt="شعار المنصة">
                    <img class="brand-name" src="{{ asset('assets/images/logomwhite.png') }}" alt="Grow">
                </a>
            </div>
        </nav>

        <main class="main-content">
            <header class="page-header">
                <h1>تعديل اختبار</h1>
                <p class="subtitle">عدّل تفاصيل الاختبار ثم احفظ التغييرات.</p>
            </header>

            <form class="create-quiz-form" method="POST" action="{{ route('quizzes.update', $quiz->id) }}">
                @csrf
                @method('PUT')
                <section class="form-section">
                    <h2 class="section-title">بيانات الاختبار</h2>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="lesson_id">الدرس / الصف</label>
                            <select id="lesson_id" name="lesson_id" required>
                                @foreach ($lessons as $l)
                                    <option value="{{ $l->id }}"
                                        {{ $quiz->lesson_id == $l->id ? 'selected' : '' }}>
                                        {{ $l->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="title">عنوان الاختبار</label>
                            <input type="text" id="title" name="title"
                                value="{{ old('title', $quiz->title) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="total_marks">الدرجة الكلية</label>
                            <input type="number" id="total_marks" name="total_marks" min="1"
                                value="{{ old('total_marks', $quiz->total_marks ?? 100) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="available_from">تاريخ البدء</label>
                            <input type="datetime-local" id="available_from" name="available_from"
                                value="{{ old('available_from', optional($quiz->available_from)->format('Y-m-d\TH:i')) }}">
                        </div>

                        <div class="form-group">
                            <label for="available_to">تاريخ الانتهاء</label>
                            <input type="datetime-local" id="available_to" name="available_to"
                                value="{{ old('available_to', optional($quiz->available_to)->format('Y-m-d\TH:i')) }}">
                        </div>

                        <div class="form-group">
                            <label for="attempts_allowed">عدد المحاولات المسموحة</label>
                            <input type="number" id="attempts_allowed" name="attempts_allowed" min="1"
                                max="20" value="{{ old('attempts_allowed', $quiz->attempts_allowed ?? 1) }}"
                                required>
                        </div>

                    </div>
                </section>

                <div class="form-actions">
                    <a href="{{ route('quizzes.index') }}" class="btn btn-secondary btn-sm btn-cancel">إلغاء</a>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-save"></i> حفظ التغييرات
                    </button>
                </div>
            </form>
        </main>
    </div>
</body>

</html>
