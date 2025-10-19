
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفاصيل الواجب</title>
    < <title>إضافة اختبار جديد</title>
    <link rel="icon" href="{{ asset('assets/images/logo2-removebg-preview.png') }}" type="image/x-icon" width = "15px">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/navbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/create-quiz.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/homework-detials.css') }}" />
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
                <a href="#" class="nav-btn" title="الإعدادات">
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
            <section class="page-header">
                <h1>تفاصيل الواجب</h1>
            </section>

            <section class="details-card">
                <div class="details-grid">
                    <div class="detail-item">
                        <span class="detail-label">اسم الواجب</span>
                        <span class="detail-value" id="assignment-title"></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">الصف</span>
                        <span class="detail-value" id="assignment-class"></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">تاريخ النشر</span>
                        <span class="detail-value" id="assignment-publish-date"></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">تاريخ التسليم</span>
                        <span class="detail-value" id="assignment-due-date"></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">عدد الطلاب المسلّمين</span>
                        <span class="detail-value"><span class="progress-text" id="assignment-submitted-count"></span> / <span id="assignment-total-count"></span></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">المرفقات</span>
                        <ul class="attachments-list" id="assignment-attachments"></ul>
                    </div>
                </div>
            </section>

            <section class="edit-assignment-section" id="edit-assignment-section" style="display: none;">
                <h2>تعديل الواجب</h2>
                <div class="form-group">
                    <label for="edit-title">عنوان الواجب</label>
                    <input type="text" id="edit-title" required>
                </div>
                <div class="form-group">
                    <label for="edit-class">الصف</label>
                    <input type="text" id="edit-class" disabled>
                </div>
                <div class="form-group">
                    <label for="edit-due-date">تاريخ التسليم</label>
                    <input type="date" id="edit-due-date" required>
                </div>
                <div class="form-group">
                    <label>المرفقات الحالية</label>
                    <ul class="file-list" id="edit-attachments-list">
                    </ul>
                </div>
                <div class="form-group">
                    <label for="add-new-file">إضافة ملفات جديدة</label>
                    <input type="file" id="add-new-file" multiple>
                </div>
                <div class="edit-actions">
                    <button class="modal-btn cancel" id="cancel-edit-btn">إلغاء</button>
                    <button class="modal-btn save" id="save-edit-btn">حفظ</button>
                </div>
            </section>

            <section class="submissions-section">
                <h2>قائمة الطلاب المسلمين</h2>
                <table class="submissions-table">
                    <thead>
                        <tr>
                            <th>اسم الطالب</th>
                            <th>تاريخ التسليم</th>
                            <th>التقييم (من 10)</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody id="submissions-table-body">

                    </tbody>
                </table>
            </section>

            <button class="edit-assignment-btn" id="edit-assignment-btn-trigger">
                <i class="fas fa-edit"></i>
                <span>تعديل الواجب</span>
            </button>
        </main>
    </div>


    <div id="message-box" class="message-box"></div>

    <script src="{{ asset('assets/js/homework-details.js') }}"></script>
</body>
</html>
