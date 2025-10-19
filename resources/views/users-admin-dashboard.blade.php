<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة أدمن المستخدمين</title>
    <link rel="icon" href="{{ asset('assets/images/logo2-removebg-preview.png') }}" type="image/x-icon" width = "15px">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/super-admin-dashboard.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/users-admin-dashboard.css') }}" />
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <a class="brand" href="{{ route('home') }}">
                    <img class="logo" src="{{ asset('assets/images/logo2-removebg-preview.png') }}" alt="شعار المنصة" />
                    <img class="brand-name" src="{{ asset('assets/images/edited_color.png') }}" alt="Grow" />
                </a>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li class="active"><a href="{{ route('user_admin.dashboard') }}"><i class="fas fa-home"></i> لوحة التحكم</a></li>
                    <li><a href="{{ route('students-management') }}"><i class="fas fa-user-graduate"></i> إدارة الطلاب</a></li>
                    <li><a href="{{ route('teachers-management') }}"><i class="fas fa-chalkboard-teacher"></i> إدارة المعلمين</a></li>
                    <li><a href="{{ route('account-approval') }}"><i class="fas fa-user-check"></i> الموافقة على الحسابات</a></li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <header class="main-header">
                <div class="header-title">
                    <h1>ادمن المستخدمين</h1>
                    <p class="subtitle">نظرة عامة على المستخدمين في النظام.</p>
                </div>
                <div class="header-actions">
                    <button class="action-btn" title="الإشعارات">
                        <i class="fas fa-bell"></i>
                        <span class="badge">3</span>
                    </button>
                    <button class="action-btn" title="الإعدادات">
                        <i class="fas fa-cog"></i>
                    </button>
                    <a href="#" class="logout-btn"
                        onclick ="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>تسجيل خروج</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">
                        @csrf
                    </form>
                </div>
            </header>

            <section class="stats-grid">
                <div class="stat-card">
                    <div class="card-icon"><i class="fas fa-user-graduate"></i></div>
                    <h3 class="card-value">1300</h3>
                    <p class="card-label">عدد الطلاب</p>
                </div>
                <div class="stat-card">
                    <div class="card-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                    <h3 class="card-value">85</h3>
                    <p class="card-label">عدد المعلّمين</p>
                </div>
                <div class="stat-card">
                    <div class="card-icon"><i class="fas fa-hourglass-half"></i></div>
                    <h3 class="card-value">30</h3>
                    <p class="card-label">طلبات معلّقة</p>
                </div>
                <div class="stat-card">
                    <div class="card-icon"><i class="fas fa-user-slash"></i></div>
                    <h3 class="card-value">12</h3>
                    <p class="card-label">حسابات معطلة</p>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
