<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفاصيل الصف </title>
    <link rel="icon" href="assets/images/logo2-removebg-preview.png" type="image/x-icon" width = "15px">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="assets/css/navbar.css">
    <link rel="stylesheet" href="assets/css/class-details.css" />
</head>
<body>
    <div class="page-container">
        <nav>
            <div class="nav-left">
               <a class="brand" href="index.html">
                    <img class="logo" src="assets/images/imageedit_2_6635233653.png" alt="شعار المنصة" />
                    <img class="brand-name" src="assets/images/logomwhite.png" alt="Grow" />
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
            <section class="class-header">
                <h1 id="class-name-title">تفاصيل الصف</h1>
                <div class="class-info">
                    <div class="info-card">
                        <div class="label">عدد الطلاب</div>
                        <div class="value" id="student-count">--</div>
                    </div>
                    <div class="info-card">
                        <div class="label">المادة</div>
                        <div class="value" id="subject-name">--</div>
                    </div>
                </div>
            </section>
            
            <section class="actions-section">
                <h2>
                    <span>الدروس المضافة</span>
                    <a href="#" class="add-lesson-btn" id="add-lesson-btn">
                        <i class="fas fa-plus"></i>
                        <span>إضافة درس جديد</span>
                    </a>
                </h2>
                <ul class="lessons-list">
                    <li class="lesson-item">
                        <div class="lesson-title">الدرس الأول: مقدمة في علوم الأرض</div>
                        <div class="lesson-actions">
                            <i class="fas fa-edit action-icon edit" title="تعديل الدرس"></i>
                            <i class="fas fa-trash-alt action-icon delete" title="حذف الدرس"></i>
                        </div>
                    </li>
                    <li class="lesson-item">
                        <div class="lesson-title">الدرس الثاني: تركيب الخلية الحية</div>
                        <div class="lesson-actions">
                            <i class="fas fa-edit action-icon edit" title="تعديل الدرس"></i>
                            <i class="fas fa-trash-alt action-icon delete" title="حذف الدرس"></i>
                        </div>
                    </li>
                    <li class="lesson-item">
                        <div class="lesson-title">الدرس الثالث: قوانين الحركة لنيوتن</div>
                        <div class="lesson-actions">
                            <i class="fas fa-edit action-icon edit" title="تعديل الدرس"></i>
                            <i class="fas fa-trash-alt action-icon delete" title="حذف الدرس"></i>
                        </div>
                    </li>
                </ul>
            </section>
        </main>
    </div>

    <div id="add-lesson-modal" class="modal-overlay">
        <div class="modal-container">
            <div class="modal-header">
                <h3>إضافة درس جديد</h3>
                <button class="modal-close-btn" id="close-modal-btn">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="lesson-title">عنوان الدرس</label>
                    <input type="text" id="lesson-title" placeholder="أدخل عنوان الدرس" required>
                </div>
                <div class="form-group">
                    <label for="lesson-content">محتوى الدرس</label>
                    <textarea id="lesson-content" placeholder="أدخل محتوى الدرس"></textarea>
                </div>
                <div class="form-group">
                    <label for="lesson-video">رابط فيديو الشرح</label>
                    <input type="url" id="lesson-video" placeholder="الصق رابط الفيديو هنا (YouTube, Vimeo, etc.)">
                </div>
                <div class="form-group">
                    <label for="lesson-pdf">ملف PDF الخاص بالدرس</label>
                    <input type="file" id="lesson-pdf" accept=".pdf">
                </div>
            </div>
            <div class="modal-footer">
                <button class="modal-btn draft" id="save-draft-btn">حفظ كمسودة</button>
                <button class="modal-btn save" id="save-btn">حفظ</button>
            </div>
        </div>
    </div>
    
    <div id="message-box" class="message-box"></div>
    
    <div id="confirmation-modal" class="modal-overlay">
        <div class="confirmation-box">
            <p id="confirmation-message"></p>
            <div class="modal-footer">
                <button class="modal-btn cancel" id="cancel-delete-btn">إلغاء</button>
                <button class="modal-btn save" id="confirm-delete-btn">حذف</button>
            </div>
        </div>
    </div>
    
    <script src="assets/js/class-details.js">  </script>
</body>
</html>
