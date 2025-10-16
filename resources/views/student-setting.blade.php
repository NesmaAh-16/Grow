<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الإعدادات</title>
    <link rel="icon" href="assets/images/logo2-removebg-preview.png" type="image/x-icon" width = "15px">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset ('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css')}}" />
    <link rel="stylesheet" href="{{ asset ('assets/css/student-setting.css')}}" />
</head>

<body>
    <div class="page-container">
        <nav class="navbar">
            <div class="nav-left">
                <a class="brand" href="{{ route('home') }}">
                    <img class="logo" src="{{ asset ('assets/images/imageedit_2_6635233653.png')}}" alt="شعار المنصة" />
                    <img class="brand-name" src="{{ asset ('assets/images/logomwhite.png')}}" alt="Grow" />
                </a>
            </div>
            <div class="nav-menu">
                <a href="{{ route('home') }}" class="nav-link">
                    <i class="fas fa-home" style="margin-left: 8px"></i>
                    الصفحة الرئيسية
                </a>

            </div>
            <div class="nav-right">
                <form method="POST" action="">
                    @csrf
                    <button class="nav-btn" href="#" title="الإشعارات">
                        <i class="fas fa-bell"></i>
                        <span class="badge">3</span>
                    </button>
                     </form>
                    <a href="{{ route('student.dashboard') }}" class="nav-btn" title="الإعدادات">
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
            <div class="settings-container">
                <nav class="tabs-nav">
                    <button class="tab-btn active" data-tab="profile">
                        <i class="fas fa-user"></i>
                        المعلومات الشخصية
                    </button>
                    <button class="tab-btn" data-tab="password">
                        <i class="fas fa-lock"></i>
                        تغيير كلمة المرور
                    </button>
                    <button class="tab-btn" data-tab="language">
                        <i class="fas fa-globe"></i>
                        اللغة والمنطقة
                    </button>
                </nav>

                <div class="tab-content-area">
                    <div class="tab-content">
                        <div id="profile" class="tab-pane active">
                            <h2>المعلومات الشخصية</h2>
                            <div class="profile-pic-section">
                                <img src="https://via.placeholder.com/120" alt="صورة الملف الشخصي" class="profile-pic">
                                <span class="change-pic-btn">تغيير الصورة</span>
                            </div>
                            <div class="form-group">
                                <label for="full-name">الاسم الكامل</label>
                                <input type="text" id="full-name" class="form-input" value="عبدالله محمد" readonly>
                            </div>
                            <div class="form-group">
                                <label for="national-id">رقم الهوية</label>
                                <input type="text" id="national-id" class="form-input" value="1012345678" readonly>
                            </div>
                            <div class="form-group">
                                <label for="birth-date">تاريخ الميلاد</label>
                                <input type="date" id="birth-date" class="form-input" value="2010-05-15">
                            </div>
                            <div class="form-group">
                                <label for="grade">الصف الدراسي</label>
                                <input type="text" id="grade" class="form-input" value="الأول ثانوي" readonly>
                            </div>
                        </div>

                        <div id="password" class="tab-pane">
                            <h2>تغيير كلمة المرور</h2>
                            <div class="form-group">
                                <label for="current-password">كلمة المرور الحالية</label>
                                <input type="password" id="current-password" class="form-input">
                            </div>
                            <div class="form-group">
                                <label for="new-password">كلمة المرور الجديدة</label>
                                <input type="password" id="new-password" class="form-input">
                            </div>
                            <div class="form-group">
                                <label for="confirm-password">تأكيد كلمة المرور الجديدة</label>
                                <input type="password" id="confirm-password" class="form-input">
                            </div>
                        </div>

                        <div id="language" class="tab-pane">
                            <h2>الغة والمنطقة</h2>
                            <div class="form-group">
                                <label for="interface-language">لغة الواجهة</label>
                                <select id="interface-language" class="form-select">
                                    <option value="ar" selected>العربية</option>
                                    <option value="en">English</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="timezone">المنطقة الزمنية</label>
                                <select id="timezone" class="form-select">
                                    <option value="Asia/Riyadh" selected>(GMT+03:00) الرياض</option>
                                    <option value="Asia/Dubai">(GMT+04:00) دبي</option>
                                    <option value="Africa/Cairo">(GMT+02:00) القاهرة</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button class="save-btn">
                            <i class="fas fa-save"></i>
                            حفظ التغييرات
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="assets/js/std-settings.js"></script>
</body>

</html>
