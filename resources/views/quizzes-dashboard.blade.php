<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الاختبارات </title>
    <link rel="icon" href="{{asset('assets/images/logo2-removebg-preview.png') }}" type="image/x-icon" width = "15px">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="assets/css/navbar.css" />
    <link rel="stylesheet" href="assets/css/quizzes-dashboard.css" />
</head>

<body>
    <div class="page-container">
        <nav>
            <div class="nav-left">
                <a class="brand" href="{{ route('home') }}">
                    <img class="logo" src="assets/images/imageedit_2_6635233653.png" alt="شعار المنصة" />
                    <img class="brand-name" src="assets/images/logomwhite.png" alt="Grow" />
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
                <a href="#" class="nav-btn" title="الإعدادات">
                    <i class="fas fa-cog"></i>
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

        <main class="main-content">
            <section class="page-header">
                <h1>الاختبارات</h1>
                <p class="subtitle">ركن المادة</p>
            </section>

            <section class="quizzes-section">
                <table class="quizzes-table">
                    <thead>
                        <tr>
                            <th>الصف</th>
                            <th>عدد الأسئلة</th>
                            <th>تاريخ البدء</th>
                            <th>تاريخ الانتهاء</th>
                            <th>الحالة</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($quizzes as $q)
                            <tr>
                                <td>{{ $q->lesson->classroom->name ?? '—' }}</td>
                                <td>{{ $q->questions_count ?? $q->questions()->count() }}</td>
                                <td>{{ optional($q->available_from)->format('Y/n/j') ?: '—' }}</td>
                                <td>{{ optional($q->available_to)->format('Y/n/j') ?: '—' }}</td>
                                <td>
                                    @php
                                        $now = now();
                                        $status =
                                            $q->available_from && $now->lt($q->available_from)
                                                ? 'قادم'
                                                : ($q->available_to && $now->gt($q->available_to)
                                                    ? 'منتهي'
                                                    : 'نشط');
                                    @endphp
                                    <span
                                        class="status {{ $status === 'نشط' ? 'active' : ($status === 'قادم' ? 'upcoming' : 'ended') }}">
                                        {{ $status }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('quizzes.show', $q->id) }}" class="btn btn-view">عرض
                                        الاختبار</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">لا توجد اختبارات</td>
                            </tr>
                        @endforelse
                    </tbody>

                    {{-- <tbody>
                        <tr>
                            <td>السابع</td>
                            <td>15</td>
                            <td>2025/8/1</td>
                            <td>2025/8/8</td>
                            <td><span class="status active">نشط</span></td>
                            <td><a href="{{ route('quizzes.show', ['quiz' => $q->id])}}" class="btn btn-view">عرض الاختبار</a>@endforeach</td>
                        </tr>
                    </tbody> --}}
                </table>
            </section>

            <section class="action-buttons">
                <a href="{{ route('quizzes.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i><span>إضافة اختبار جديد</span>
                </a>
                <button class="btn btn-secondary">
                    <i class="fas fa-chart-bar"></i>
                    <span>لحصر النتائج بالكامل</span>
                </button>
            </section>
        </main>
    </div>
</body>

</html>
