<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إعدادات النظام - لوحة التحكم</title>
      <link rel="icon" href="{{ asset('assets/images/logo2-removebg-preview.png') }}" type="image/x-icon" width = "15px">

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/super-admin-dashboard.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/system-settings.css') }}" />
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
                    <h1>إعدادات النظام</h1>
                </div>
                <div class="header-actions">
                    <button class="action-btn" title="الإشعارات"><i class="fas fa-bell"></i><span class="badge">3</span></button>
                    <button class="action-btn" title="الإعدادات"><i class="fas fa-cog"></i></button>
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

            <div class="settings-card">
                <form class="settings-form" onsubmit="return confirm('هل أنت متأكد من أنك تريد حفظ التغييرات؟');">
                    <div class="form-group">
                        <label for="site-name">اسم الموقع</label>
                        <input type="text" id="site-name" value="منصة التعليم Grow">
                    </div>
                    <div class="form-group">
                        <label for="official-email">البريد الرسمي</label>
                        <input type="email" id="official-email" value="contact@grow.com">
                    </div>
                    <div class="form-group">
                        <label for="default-language">اللغة الافتراضية</label>
                        <select id="default-language">
                            <option value="ar" selected>العربية</option>
                            <option value="en">English</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>التسجيل العام</label>
                        <div class="toggle-switch-container">
                            <span>غير مفعل</span>
                            <label class="toggle-switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                            <span>مفعل</span>
                        </div>
                    </div>
                    <footer class="form-actions">
                        <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                        <a href="super-admin-dashboard.html" class="btn btn-secondary">إلغاء</a>
                    </footer>
                </form>
            </div>
        </main>
    </div>
    <div id="toastNotification" class="toast-notification"></div>

    <script src="assets/js/system-settengs.js"></script>
</body>
</html>
