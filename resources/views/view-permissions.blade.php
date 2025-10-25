<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض الصلاحيات - لوحة التحكم</title>
    <link rel="icon" href="{{asset('assets/images/logo2-removebg-preview.png') }}" type="image/x-icon" width = "15px"/>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/super-admin-dashboard.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/view-permissions.css')}}" />
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <a class="brand" href="{{ route('home') }}" >
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
                    <h1>عرض الصلاحيات</h1>
                </div>
                <div class="header-actions">
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
            </header>

            <div class="admin-info-card">
                <div class="info-item">
                    <span class="info-label">اسم الإداري:</span>
                    <span class="info-value">أحمد حسني مقداد</span>
                </div>
                <div class="info-item">
                    <span class="info-label">نوع الأدمن:</span>
                    <span class="info-value">ادمن المستخدمين</span>
                </div>
            </div>

            <form class="permissions-form">
                <div class="permissions-list-container">
                    <div class="permissions-header">
                        <h2>قائمة الصلاحيات</h2>
                        <div class="select-all-container">
                            <input type="checkbox" id="select-all">
                            <label for="select-all">تحديد الكل / إلغاء التحديد</label>
                        </div>
                    </div>
                    <ul class="permissions-list">
                        <li><label><input type="checkbox" name="perm-delete-user" checked> حذف مستخدم</label></li>
                        <li><label><input type="checkbox" name="perm-edit-user" checked> تعديل معلومات مستخدم</label></li>
                        <li><label><input type="checkbox" name="perm-view-reports"> عرض التقارير</label></li>
                        <li><label><input type="checkbox" name="perm-manage-content" checked> إدارة المحتوى</label></li>
                        <li><label><input type="checkbox" name="perm-manage-exams"> إدارة الاختبارات</label></li>
                        <li><label><input type="checkbox" name="perm-system-settings"> الوصول لإعدادات النظام</label></li>
                    </ul>
                </div>

                <footer class="form-actions">
                    <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                    <a href="admins-management.html" class="btn btn-secondary">إلغاء</a>
                </footer>
            </form>
        </main>
    </div>

    <script src="{{asset('assets/js/view-permission.js')}}"></script>
</body>
</html>
