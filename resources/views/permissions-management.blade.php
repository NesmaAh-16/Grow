
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة الصلاحيات - لوحة التحكم</title>
    <link rel="icon" href="{{ asset('assets/images/logo2-removebg-preview.png') }}" type="image/x-icon" width = "15px">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/super-admin-dashboard.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/permissions-management.css') }}" />
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
                    <h1>إدارة الصلاحيات</h1>
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

            <div class="permissions-card">
                <form class="permissions-form" onsubmit="return confirm('هل أنت متأكد من حفظ التغييرات؟');">
                    <div class="form-group">
                        <label for="role-select">اختر المستخدم / الدور</label>
                        <select id="role-select">
                            <option value="user-admin">أدمن المستخدمين</option>
                            <option value="content-admin">أدمن المحتوى</option>
                        </select>
                    </div>

                    <div class="permissions-list-container">
                        <div class="permissions-header">
                            <h2>قائمة الصلاحيات</h2>
                            <div class="select-all-container">
                                <input type="checkbox" id="select-all">
                                <label for="select-all">تحديد الكل / إلغاء التحديد</label>
                            </div>
                        </div>
                        <ul class="permissions-list">
                            <li><label><input type="checkbox" name="perm-delete-user"> حذف مستخدم</label></li>
                            <li><label><input type="checkbox" name="perm-add-user"> إضافة مستخدم</label></li>
                            <li><label><input type="checkbox" name="perm-disable-user"> تعطيل مستخدم</label></li>
                            <li><label><input type="checkbox" name="perm-manage-roles"> إدارة الأدوار</label></li>
                            <li><label><input type="checkbox" name="perm-manage-classes"> إدارة الفصول</label></li>
                            <li><label><input type="checkbox" name="perm-manage-exams"> إدارة الامتحانات</label></li>
                            <li><label><input type="checkbox" name="perm-view-reports"> عرض التقارير</label></li>
                        </ul>
                        <div class="add-permission-section" style="display: none;">
                            <input type="text" id="new-permission-input" placeholder="اكتب اسم الصلاحية الجديدة هنا" class="form-control">
                            <button type="button" class="btn btn-primary" id="confirm-add-permission">إضافة</button>
                            <button type="button" class="btn btn-secondary" id="cancel-add-permission">إلغاء</button>
                        </div>
                        <button type="button" class="btn-add-permission" id="show-add-permission-input">➕ إضافة صلاحية جديدة</button>
                    </div>

                    <footer class="form-actions">
                        <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                        <a href="super-admin-dashboard.html" class="btn btn-secondary">إلغاء</a>
                    </footer>
                </form>
            </div>
        </main>
    </div>

    <div id="toastNotification" class="toast-notification"></div>

    <script src="assets/js/permissions-managment.js"></script>
</body>
</html>
