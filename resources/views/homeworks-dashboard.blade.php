<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الواجبات المنزلية</title>

    <link rel="icon" href="{{ asset('assets/images/logo2-removebg-preview.png') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/homeworks-dashboard.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700;800&display=swap" rel="stylesheet">
    <style>
        .assignments-table {
            font-family: 'Cairo', sans-serif;
        }

        .actions {
            display: flex;
            gap: 6px;
            align-items: center;
        }

        .btn-sm {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 14px;
            border-radius: 10px;
            font-weight: 800;
            font-size: .95rem;
            border: 1px solid transparent;
            cursor: pointer;
            text-decoration: none;
            transition: .2s ease;
            font-family: 'Cairo', sans-serif;
        }

        .btn-view {
            background: #2563eb;
            color: #fff;
        }

        .btn-view:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
        }

        .btn-delete {
            background: #fff;
            color: #b91c1c;
            border-color: #f3c2c4;
        }

        .btn-delete:hover {
            background: #fff5f5;
        }

        .badge {
            padding: .35rem .7rem;
            border-radius: 999px;
            font-weight: 800;
            font-size: .85rem;
            font-family: 'Cairo', sans-serif;
        }

        .status.active {
            background: rgba(37, 99, 235, .12);
            color: #2563eb;
        }

        .status.ended {
            background: rgba(185, 28, 28, .12);
            color: #b91c1c;
        }
    </style>


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
        </nav>

        <main class="main-content">
            <section class="page-header">
                <h1>الواجبات المنزلية</h1>
                <a href="{{ route('assignments.create') }}" class="btn btn-primary"
                    style="padding:.75rem 1.25rem;border-radius:12px;font-weight:800;background:#2a67f3;color:#fff;text-decoration:none;">
                    <i class="fas fa-plus" style="margin-left:.4rem"></i> إضافة واجب جديد
                </a>
            </section>

            {{-- -
            <section class="form-section">
                <h2 class="section-title">إضافة واجب جديد</h2>
                <form method="POST" action="{{ route('assignments.store') }}" enctype="multipart/form-data" class="create-quiz-form">
                    @csrf
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="grade">الصف</label>
                            <select id="grade" name="grade" required>
                                <option value="" disabled selected>اختر الصف</option>
                                @for ($i = 1; $i <= 11; $i++)
                                    <option value="{{ $i }}">الصف {{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="title">عنوان الواجب</label>
                            <input type="text" id="title" name="title" required>
                        </div>

                        <div class="form-group">
                            <label for="due_date">تاريخ التسليم</label>
                            <input type="datetime-local" id="due_date" name="due_date" required>
                        </div>

                        <div class="form-group full-width">
                            <label for="file">ملف مرفق (اختياري)</label>
                            <input type="file" id="file" name="file">
                        </div>

                        <div class="form-group full-width" style="text-align:left">
                            <button type="submit" class="btn btn-primary">حفظ الواجب</button>
                        </div>
                    </div>
                </form>
            </section> --}}

            <section class="assignments-section" style="margin-top:2rem;">
                <table class="assignments-table">
                    <thead>
                        <tr>
                            <th>الصف</th>
                            <th>عنوان الواجب</th>
                            <th>تاريخ التسليم</th>
                            <th>عدد الطلاب المسلّمين</th>
                            <th>حالة الواجب</th>
                            <th>إجراءات</th>
                        </tr>
                    </thead>

                    <tbody id="assignments-table-body">
                        @forelse ($assignments as $a)
                            <tr data-id="{{ $a->id }}">
                                <td>الصف {{ $a->lesson->grade ?? '—' }}</td>

                                <td>{{ $a->title }}</td>

                                <td>{{ $a->due_at ? $a->due_at->format('Y-m-d H:i') : '—' }}</td>

                                <td>{{ $a->submissions_count ?? 0 }}</td>

                                @php
                                    $s = $a->status_label;
                                    $cls = $s === 'منتهي' ? 'completed' : 'in-review';
                                @endphp

                                <td class="status-cell">
                                    <span class="status-badge {{ $cls }}">{{ $s }}</span>
                                </td>

                                <td>
                                    <div class="actions">
                                        <a href="{{ route('assignments.show', $a->id) }}"
                                            class="btn-sm btn-view">عرض</a>

                                        <form action="{{ route('assignments.destroy', $a->id) }}" method="POST"
                                            onsubmit="return confirm('هل تريد حذف هذا الواجب نهائيًا؟');"
                                            style="display:inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-sm btn-delete">حذف</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">لا توجد واجبات</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </section>
        </main>
    </div>

    <script src="{{ asset('assets/js/homework-dashboard.js') }}"></script>
</body>

</html>
