<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة المعلمين - لوحة التحكم</title>
          <link rel="icon" href="{{ asset('assets/images/logo2-removebg-preview.png') }}" type="image/x-icon" width = "15px">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/super-admin-dashboard.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/teachers-management.css') }}" />
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
                    <h1>إدارة المعلمين</h1>
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
                    <input type="text" placeholder="ابحث برقم الهوية">
                    <i class="fas fa-search"></i>
                </div>
                <button class="btn btn-primary add-teacher-btn">➕ إضافة معلم جديد</button>
            </section>

            <section class="teachers-table-section">
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>رقم الهوية</th>
                                <th>الاسم</th>
                                <th>المواد الدراسية</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>402589123</td>
                                <td>أحمد</td>
                                <td>
                                    <span class="subject-badge">الرياضيات</span>
                                </td>
                                <td><span class="status status-active">مفعل</span></td>
                                <td>
                                    <button class="action-btn-table view-btn" onclick="showTeacherDetails()"><i class="fas fa-eye"></i> عرض</button>
                                    <button class="action-btn-table edit-btn"><i class="fas fa-edit"></i> تعديل</button>
                                    <button class="action-btn-table delete-btn"><i class="fas fa-trash"></i> حذف</button>
                                </td>
                            </tr>
                            <tr>
                                <td>409872345</td>
                                <td>خالد</td>
                                <td>
                                    <span class="subject-badge">اللغة العربية</span>
                                    <span class="subject-badge">التاريخ</span>
                                </td>
                                <td><span class="status status-pending">بانتظار</span></td>
                                <td>
                                    <button class="action-btn-table view-btn" onclick="showTeacherDetails()"><i class="fas fa-eye"></i> عرض</button>
                                    <button class="action-btn-table edit-btn"><i class="fas fa-edit"></i> تعديل</button>
                                    <button class="action-btn-table delete-btn"><i class="fas fa-trash"></i> حذف</button>
                                </td>
                            </tr>
                            <tr>
                                <td>401112223</td>
                                <td>سامي</td>
                                <td>
                                    <span class="subject-badge">العلوم</span>
                                </td>
                                <td><span class="status status-inactive">غير مفعل</span></td>
                                <td>
                                    <button class="action-btn-table view-btn" onclick="showTeacherDetails()"><i class="fas fa-eye"></i> عرض</button>
                                    <button class="action-btn-table edit-btn"><i class="fas fa-edit"></i> تعديل</button>
                                    <button class="action-btn-table delete-btn"><i class="fas fa-trash"></i> حذف</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <div id="teacherDetailsModal" class="modal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <h2>تفاصيل المعلّم</h2>
            <div class="teacher-details-body">
                <p><strong>رقم الهوية:</strong> <span id="modalTeacherId"></span></p>
                <p><strong>الاسم:</strong> <span id="modalTeacherName"></span></p>
                <p><strong>المواد:</strong> <span id="modalTeacherSubjects"></span></p>
                <p><strong>الحالة:</strong> <span id="modalTeacherStatus"></span></p>
                <p><strong>تاريخ الإنشاء:</strong> <span id="modalCreationDate"></span></p>
                <div class="modal-actions">
                    <button class="btn btn-success"><i class="fas fa-check-circle"></i> تفعيل</button>
                    <button class="btn btn-danger"><i class="fas fa-times-circle"></i> تعطيل</button>
                </div>
            </div>
        </div>
    </div>

    <div id="toastNotification" class="toast-notification"></div>

    <script src="assets/js/teacher-managment.js"></script>
</body>
</html>
