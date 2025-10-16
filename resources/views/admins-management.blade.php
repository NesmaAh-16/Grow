<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة الإداريين - لوحة التحكم</title>
      <link rel="icon" href="{{ asset('assets/images/logo2-removebg-preview.png') }}" type="image/x-icon" width = "15px">

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css') }}" />
    <!-- Reusing the main dashboard layout styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/super-admin-dashboard.css') }}" />
    <!-- Page-specific styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/admins-management.css') }}" />
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <a class="brand" href="{{ route('home') }}">
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
                    <h1>إدارة الإداريين</h1>
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

            <div class="toolbar">
                <a href="add-admin.html" class="btn btn-primary">➕ إضافة إداري جديد</a>
                <div class="search-container">
                    <input type="text" placeholder="بحث بالبريد الإلكتروني...">
                    <i class="fas fa-search"></i>
                </div>
            </div>

            <div class="table-container">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>الاسم الكامل</th>
                            <th>البريد الإلكتروني</th>
                            <th>نوع الادمن</th>
                            <th>الصلاحيات</th>
                            <th>العمليات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>أحمد محمد</td>
                            <td>Aa@gmail.com</td>
                            <td>ادمن المستخدمين</td>
                            <td><a href="view-permissions.html" class="btn-action btn-view">عرض</a></td>
                            <td>
                                <a href="edit-admin.html" class="btn-action btn-edit">تعديل</a>
                                <button class="btn-action btn-delete">حذف</button>
                            </td>
                        </tr>
                        <tr>
                            <td>أحمد الحسن</td>
                            <td>BB@gmail.com</td>
                            <td>ادمن المحتوى</td>
                            <td><a href="view-permissions.html" class="btn-action btn-view">عرض</a></td>
                            <td>
                                <a href="edit-admin.html" class="btn-action btn-edit">تعديل</a>
                                <button class="btn-action btn-delete">حذف</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
