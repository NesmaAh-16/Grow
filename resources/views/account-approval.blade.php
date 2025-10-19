<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الموافقة على الحسابات - لوحة التحكم</title>
    <link rel="icon" href="{{ asset('assets/images/logo2-removebg-preview.png') }}" type="image/x-icon" width = "15px">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/super-admin-dashboard.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/account-approval.css') }}" />
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
                    <h1>الموافقة على الحسابات</h1>
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

            <section class="toolbar-section">
                <div class="search-bar">
                    <input type="text" placeholder="بحث برقم الهوية">
                    <i class="fas fa-search"></i>
                </div>
            </section>

            <section class="accounts-table-section">
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>الاسم</th>
                                <th>رقم الهوية</th>
                                <th>النوع</th>
                                <th>البريد الإلكتروني</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>امل</td>
                                <td>123456789</td>
                                <td>طالب</td>
                                <td>aa@gmail.com</td>
                                <td>
                                    <button class="action-btn-table approve-btn" onclick="handleApproval('approve')"><i class="fas fa-check-circle"></i> موافقة</button>
                                    <button class="action-btn-table reject-btn" onclick="handleApproval('reject')"><i class="fas fa-times-circle"></i> رفض</button>
                                </td>
                            </tr>
                            <tr>
                                <td>ساره</td>
                                <td>984562379</td>
                                <td>معلم</td>
                                <td>bb@gmail.com</td>
                                <td>
                                    <button class="action-btn-table approve-btn" onclick="handleApproval('approve')"><i class="fas fa-check-circle"></i> موافقة</button>
                                    <button class="action-btn-table reject-btn" onclick="handleApproval('reject')"><i class="fas fa-times-circle"></i> رفض</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <footer class="main-footer">
        <p>جميع الحقوق محفوظة – منصة التعليم.</p>
    </footer>

    <div id="toastNotification" class="toast-notification"></div>

    <script src="assets/js/account-approval.js"></script>
</body>
</html>
