<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم – Super Admin</title>
    <link rel="icon" href="{{asset('assets/images/logo2-removebg-preview.png') }}" type="image/x-icon" width = "15px">

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href= "{{ asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css' ) }}"/>
    <link rel="stylesheet" href= "{{ asset('assets/css/super-admin-dashboard.css') }} "/>
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <a class="brand" href="{{ route('home') }}" >
                    <!-- Make sure this path is correct -->
                    <img class="logo" src="{{ asset('assets/images/logo2-removebg-preview.png') }}" alt="شعار المنصة" />
                    <!-- Make sure this path is correct -->
                    <img class="brand-name" src="{{ asset('assets/images/edited_color.png') }}" alt="Grow" />
                </a>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li class="active"><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> الرئيسية</a></li>
                    <li><a href="{{ route('admin.admins') }}"><i class="fas fa-user-shield"></i> إدارة الاداريين</a></li>
                    <li><a href="{{ route('admin.system.settings') }}"><i class="fas fa-cogs"></i> إعدادات النظام</a></li>
                    <li><a href="{{ route('admin.permissions') }}"><i class="fas fa-key"></i> إدارة الصلاحيات</a></li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <header class="main-header">
                <div class="header-title">
                    <h1>لوحة التحكم</h1>
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

            <section class="welcome-section">
                <h2>أهلاً وسهلاً بك يا أدمن! ما أخبارك؟</h2>
            </section>

            <section class="stats-grid">
                <div class="stat-card">
                    <div class="card-icon"><i class="fas fa-user-graduate"></i></div>
                    <h3 class="card-value">1000</h3>
                    <p class="card-label">عدد الطلاب</p>
                </div>
                <div class="stat-card">
                    <div class="card-icon"><i class="fas fa-book"></i></div>
                    <h3 class="card-value">300</h3>
                    <p class="card-label">عدد الكتب</p>
                </div>
                <div class="stat-card">
                    <div class="card-icon"><i class="fas fa-school"></i></div>
                    <h3 class="card-value">20</h3>
                    <p class="card-label">عدد الفصول الدراسية</p>
                </div>
                <div class="stat-card">
                    <div class="card-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                    <h3 class="card-value">3</h3>
                    <p class="card-label">عدد المعلمين</p>
                </div>
                <div class="stat-card">
                    <div class="card-icon"><i class="fas fa-book-open"></i></div>
                    <h3 class="card-value">400</h3>
                    <p class="card-label">عدد الواجبات</p>
                </div>
                <div class="stat-card">
                    <div class="card-icon"><i class="fas fa-file-alt"></i></div>
                    <h3 class="card-value">500</h3>
                    <p class="card-label">عدد الاختبارات</p>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
