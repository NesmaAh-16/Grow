<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الواجبات المنزلية</title>
    <link rel="icon" href="assets/images/logo2-removebg-preview.png" type="image/x-icon" width = "15px">
    <link rel="icon" href="assets/images/logo2-removebg-preview.png" type="image/x-icon" width = "15px">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="assets/css/navbar.css">
    <link rel="stylesheet" href="assets/css/homeworks-dashboard.css" />
</head>
<body>
    <div class="page-container">
        <nav>
            <div class="nav-left">
               <a class="brand" href="index.html">
                    <img class="logo" src="assets/images/imageedit_2_6635233653.png" alt="شعار المنصة" />
                    <img class="brand-name" src="assets/images/logomwhite.png" alt="Grow" />
                </a>
            </div>
             <div class="nav-menu">
          <a href="index.html" class="nav-link">
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
                <a href="login.html" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>تسجيل خروج</span>
                </a>
            </div>
        </nav>

        <main class="main-content">
            <section class="page-header">
                <h1>الواجبات المنزلية</h1>
            </section>
            
            <section class="assignments-section">
                <table class="assignments-table">
                    <thead>
                        <tr>
                            <th>الصف</th>
                            <th>عنوان الواجب</th>
                            <th>تاريخ التسليم</th>
                            <th>عدد الطلاب المسلّمين</th>
                            <th>حالة الواجب</th>
                        </tr>
                    </thead>
                    <tbody id="assignments-table-body">
                    </tbody>
                </table>
            </section>

            <button class="add-assignment-btn" id="add-assignment-btn">
                <i class="fas fa-plus"></i>
                <span>إضافة واجب جديد</span>
            </button>
        </main>
    </div>

    <div id="add-assignment-modal" class="modal-overlay">
        <div class="modal-container">
            <div class="modal-header">
                <h3>إضافة واجب جديد</h3>
                <button class="modal-close-btn" id="close-modal-btn">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="assignment-class">اختر الصف</label>
                    <select id="assignment-class" required></select>
                </div>
                <div class="form-group">
                    <label for="assignment-title">عنوان الواجب</label>
                    <input type="text" id="assignment-title" placeholder="أدخل عنوان الواجب" required>
                </div>
                <div class="form-group">
                    <label for="assignment-file">ارفق ملف (اختياري)</label>
                    <input type="file" id="assignment-file">
                </div>
                <div class="form-group">
                    <label for="assignment-due-date">تاريخ التسليم</label>
                    <input type="date" id="assignment-due-date" required>
                </div>
            </div>
            <div class="modal-footer">
                <button class="modal-btn cancel" id="cancel-add-btn">إلغاء</button>
                <button class="modal-btn save" id="save-assignment-btn">حفظ</button>
            </div>
        </div>
    </div>
    
    <div id="message-box" class="message-box"></div>
    
    <script src="assets/js/homework-dashboard.js"></script>
</body>
</html>
