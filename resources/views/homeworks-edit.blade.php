<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل الواجب</title>

    <link rel="icon" href="{{ asset('assets/images/logo2-removebg-preview.png') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/homeworks-dashboard.css') }}">

    <style>
        .form-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 8px 24px rgba(16, 24, 40, .08);
            padding: 22px
        }

        .page-header h1 {
            margin-bottom: .5rem
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px
        }

        .full-width {
            grid-column: 1 / -1
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            color: #334155;
            font-weight: 800
        }

        .form-group input[type="text"],
        .form-group input[type="date"],
        .form-group input[type="datetime-local"],
        .form-group input[type="file"] {
            width: 100%;
            padding: 12px 14px;
            border-radius: 10px;
            border: 1px solid #e4e9f3;
            background: #f3f6fb;
            outline: none
        }

        .readonly {
            background: #f3f6fb;
            color: #6b7280
        }

        .actions {
            display: flex;
            gap: 10px;
            align-items: center
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: .75rem 1.25rem;
            border-radius: 12px;
            font-weight: 800;
            border: 1px solid transparent;
            cursor: pointer;
            text-decoration: none;
            transition: .2s
        }

        .btn-primary {
            background: #2a67f3;
            color: #fff
        }

        .btn-ghost {
            background: #fff;
            border-color: #e5e7eb;
            color: #374151
        }

        .btn-danger {
            background: #fff;
            color: #b91c1c;
            border-color: #f3c2c4;
            padding: .45rem .7rem;
            border-radius: 10px
        }

        .badge {
            padding: .35rem .7rem;
            border-radius: 999px;
            font-weight: 800;
            font-size: .85rem
        }

        .alert {
            padding: 12px 14px;
            border-radius: 10px;
            margin-bottom: 12px
        }

        .alert-success {
            background: #eaf8ee;
            color: #18794e
        }

        .alert-danger {
            background: #ffe9ea;
            color: #b42318
        }

        .attach-line {
            display: flex;
            gap: 8px;
            align-items: center;
            margin-bottom: 8px
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
                    <i class="fas fa-home" style="margin-left:8px"></i> الصفحة الرئيسية
                </a>
            </div>
            <div class="nav-right">
                <button class="nav-btn" title="الإشعارات"><i class="fas fa-bell"></i><span
                        class="badge">3</span></button>
                <a href="#" class="nav-btn" title="الإعدادات"><i class="fas fa-cog"></i></a>
                <a href="#" class="logout-btn"
                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i><span>تسجيل خروج</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">@csrf</form>
            </div>
        </nav>

        <main class="main-content">
            <section class="page-header" style="align-items:flex-start">
                <div>
                    <h1>تعديل الواجب</h1>
                    <div class="badge" style="background:#eef2ff;color:#3730a3">
                        الصف {{ $assignment->lesson->grade ?? '—' }} — {{ $assignment->lesson->title ?? 'غير محدد' }}
                    </div>
                </div>
                <a href="{{ route('assignments.index') }}" class="btn btn-ghost">
                    <i class="fa-solid fa-arrow-rotate-left" style="margin-left:.4rem"></i> رجوع للواجبات
                </a>
            </section>

            <section class="form-card">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul style="margin:0;padding-inline-start:20px">
                            @foreach ($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('assignments.update', $assignment) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-grid">
                        <div class="form-group full-width">
                            <label>عنوان الواجب</label>
                            <input type="text" name="title" value="{{ old('title', $assignment->title) }}">
                        </div>

                        <div class="form-group">
                            <label>الصف</label>
                            <input class="inp readonly" type="text"
                                value="الصف {{ optional($assignment->lesson)->grade ?? '—' }}" readonly>
                        </div>

                        <div class="form-group">
                            <label>تاريخ التسليم</label>
                            <input class="inp" type="datetime-local" name="due_at"
                                value="{{ old('due_at', optional($assignment->due_at)->format('Y-m-d\TH:i')) }}">
                        </div>

                        <div class="form-group full-width">
                            <label>المرفقات الحالية</label>
                            @forelse(($assignment->attachments ?? collect()) as $att)
                                {{-- سطور المرفق --}}
                            @empty
                                <input class="inp readonly" type="text" value="لا توجد مرفقات." readonly>
                            @endforelse
                            @forelse($assignment->attachments as $att)
                                <div class="attach-line">
                                    <form method="POST" action="{{ route('assignments.attachments.destroy', $att) }}">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger">✖</button>
                                    </form>
                                    <input type="text" class="readonly" value="{{ $att->original_name }}" readonly>
                                    <a href="{{ Storage::disk('public')->url($att->file_path) }}" target="_blank"
                                        class="btn btn-ghost" style="padding:.45rem .7rem">عرض</a>
                                </div>
                            @empty
                                <input type="text" class="readonly" value="لا توجد مرفقات." readonly>
                            @endforelse
                        </div>

                        <div class="form-group full-width">
                            <label>إضافة ملفات جديدة</label>
                            <input type="file" name="files[]" multiple>
                            <div style="font-size:12px;color:#64748b;margin-top:6px">
                                الصيغ: pdf, doc, docx, png, jpg, jpeg, zip — الحد 10MB لكل ملف.
                            </div>
                        </div>

                        <div class="form-group full-width" style="text-align:left">
                            <div class="actions">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa-solid fa-floppy-disk" style="margin-left:.4rem"></i> حفظ التعديلات
                                </button>
                                <a href="{{ route('assignments.index') }}" class="btn btn-ghost">إلغاء</a>
                            </div>
                        </div>
                    </div>
                </form>
            </section>
        </main>
    </div>

    <script src="{{ asset('assets/js/homework-dashboard.js') }}"></script>
</body>

</html>
