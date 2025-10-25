<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>  نتائج الاختبار</title>
    <link rel="icon" href="{{ asset('assets/images/logo2-removebg-preview.png') }}" type="image/x-icon" width = "15px">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/navbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/quiz-results.css') }}" />
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
                {{-- - <button class="nav-btn" title="الإشعارات">
                    <i class="fas fa-bell"></i>
                    <span class="badge">3</span>
                </button>
                <a href="#" class="nav-btn" title="الإعدادات">
                    <i class="fas fa-cog"></i>--}}
                <a href="#" class="logout-btn"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>تسجيل خروج</span>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </nav>

        <main class="main-content">
            <header class="page-header">
                <h1>الرياضيات</h1>
                <section class="info-cards">
                    <div class="info-card">
                        <span class="label">تاريخ الاختبار</span>
                        <span class="value">2025-07-21</span>
                    </div>
                    <div class="info-card">
                        <span class="label">الطلاب</span>
                        <span class="value">25 / 28</span>
                    </div>
                    <div class="info-card">
                        <span class="label">المتوسط العام</span>
                        <span class="value">80%</span>
                    </div>
                </section>
            </header>

            <div class="table-toolbar">
                <div class="search-container">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="ابحث عن طالب…">
                </div>
            </div>

            <div class="table-container">
                <table class="results-table">
                    <thead>
                        <tr>
                            <th>اسم الطالب</th>
                            <th>الدرجة</th>
                            <th>النسبة المئوية</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>محمد</td>
                            <td>3</td>
                            <td>30%</td>
                            <td><a href="#" class="btn-view">عرض</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <footer class="page-footer">
                <button class="btn btn-secondary">تصدير النتائج</button>
                <a href="{{ route('teacher.dashboard') }}"  class="btn btn-primary">إغلاق</a>
            </footer>
        </main>
    </div>
</body>
</html>
