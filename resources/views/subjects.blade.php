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
                <button class="nav-btn" title="الإشعارات">
                    <i class="fas fa-bell"></i>
                    <span class="badge">3</span>
                </button>
                <a href="{{ route('student.settings') }}" class="nav-btn" title="الإعدادات">
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

        <main>
            <div class="container">
                <section class="hero">
                    <h1>مرحباً {{ auth()->user()->name }}</h1>
                    <p class="text-center">
                        {{ $profile?->grade_arabic ?? 'الصف غير محدد' }} –
                        {{ $profile?->semester_arabic ?? 'الفصل غير محدد' }}
                    </p>
                </section>

                <section class="courses">
                    <div class="course">
                        <h3>اللغة العربية</h3>
                        <img
                            src="https://www.cappasande.de/wp-content/uploads/2023/05/%D9%86%D8%B4%D8%A3%D8%A9-%D8%A7%D9%84%D9%84%D8%BA%D8%A9-%D8%A7%D9%84%D8%B9%D8%B1%D8%A8%D9%8A%D8%A9.jpg" />
                        <p>الأستاذة: امل عدنان</p>
                        <a href="subject-page.html">
                            <i class="fas fa-door-open" style="margin-left: 8px"></i>
                            دخول للصف
                        </a>
                    </div>
                    <div class="course">
                        <h3>اللغة الإنجليزية</h3>
                        <img src="https://successacademy.training/wp-content/uploads/2024/12/preview-1320x933.jpg" />
                        <p>الأستاذة: سارة صالح</p>
                        <a href="subject-page.html">
                            <i class="fas fa-door-open" style="margin-left: 8px"></i>
                            دخول للصف
                        </a>
                    </div>
                    <div class="course">
                        <h3>الرياضيات</h3>
                        <img
                            src="https://images.for9a.com/thumb/max-800-auto-100-webp/ol/blog/2020/04/06/620x377-51586156952771.jpg" />
                        <p>الأستاذة: نسمة أحمد</p>
                        <a href="subject-page.html">
                            <i class="fas fa-door-open" style="margin-left: 8px"></i>
                            دخول للصف
                        </a>
                    </div>
                    <div class="course">
                        <h3>العلوم العامة</h3>
                        <img src="{{ asset('assets/images/scei2.png') }}" />
                        <p>الأستاذ: محمد علي</p>
                        <a href="subject-page.html">
                            <i class="fas fa-door-open" style="margin-left: 8px"></i>
                            دخول للصف
                        </a>
                    </div>
                </section>
            </div>
        </main>
    </div>
</body>

</html>
