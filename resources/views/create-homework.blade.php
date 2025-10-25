<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <title>إضافة واجب جديد</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('assets/images/logo2-removebg-preview.png') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/homeworks-dashboard.css') }}">
    <style>
        :root {
            --bg: #f5f8ff;
            --card: #ffffff;
            --ink: #0f172a;
            --muted: #6b7280;
            --brand: #2563eb;
            --brand-600: #1d4ed8;
            --success: #16a34a;
            --border: #e5e7eb;
            --input: #f7f9ff;
            --shadow: 0 10px 25px rgba(2, 6, 23, .06);
        }

        body {
            background: var(--bg);
            color: var(--ink)
        }

        .create-quiz-form {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 28px;
            box-shadow: var(--shadow);
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(240px, 1fr));
            gap: 18px 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-group label {
            font-weight: 800;
            font-size: .95rem;
            color: var(--muted);
        }

        .form-group input[type="text"],
        .form-group input[type="datetime-local"],
        .form-group input[type="file"],
        .form-group select,
        .form-group textarea {
            width: 100%;
            appearance: none;
            background: var(--input);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 12px 14px;
            font-family: 'Cairo', sans-serif;
            font-size: 1rem;
            transition: .2s ease;
        }

        .form-group textarea {
            min-height: 140px;
            resize: vertical;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--brand);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, .15);
            background: #fff;
        }

        /* زرار */
        .form-actions {
            margin-top: 10px;
            padding-top: 16px;
            border-top: 1px solid var(--border);
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border-radius: 12px;
            padding: 12px 22px;
            font-weight: 900;
            font-size: 1rem;
            cursor: pointer;
            text-decoration: none;
            border: 1px solid transparent;
            transition: .2s ease;
        }

        .btn-primary {
            background: var(--brand);
            color: #fff;
        }

        .btn-primary:hover {
            background: var(--brand-600);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: #fff;
            color: var(--ink);
            border-color: var(--border);
        }

        .btn-secondary:hover {
            background: #f8fafc;
        }

        .badge {
            padding: .35rem .65rem;
            border-radius: 999px;
            font-weight: 800;
            font-size: .85rem
        }

        .status.active {
            background: rgba(37, 99, 235, .1);
            color: var(--brand)
        }

        .status.ended {
            background: rgba(22, 163, 74, .1);
            color: var(--success)
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-actions {
                justify-content: stretch;
            }

            .btn {
                width: 100%;
            }
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
                <h1>إضافة واجب جديد</h1>
            </section>

            @if ($errors->any())
                <div
                    style="background:#fee;border:1px solid #f5c2c7;color:#842029;padding:10px;border-radius:8px;margin-bottom:12px">
                    <b>حدثت أخطاء:</b>
                    <ul style="margin:6px 0 0 0">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('assignments.store') }}" enctype="multipart/form-data"
                class="create-quiz-form">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label for="grade">الصف</label>
                        <select id="grade" name="grade" required>
                            <option value="" disabled {{ old('grade') ? '' : 'selected' }}>اختر الصف</option>
                            @for ($i = 1; $i <= 11; $i++)
                                <option value="{{ $i }}" {{ old('grade') == $i ? 'selected' : '' }}>الصف
                                    {{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="title">عنوان الواجب</label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="due_at">تاريخ التسليم</label>
                        <input type="datetime-local" id="due_at" name="due_at" value="{{ old('due_at') }}"
                            required>
                    </div>

                    <div class="form-group full-width">
                        <label for="files">مرفقات (اختياري)</label>
                        <input type="file" id="files" name="files[]" multiple>
                        @error('files.*')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group full-width">
                        <label for="body">تعليمات (اختياري)</label>
                        <textarea id="body" name="body" rows="4">{{ old('body') }}</textarea>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('assignments.index') }}" class="btn btn-secondary">إلغاء</a>
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
            </form>
        </main>
    </div>
</body>

</html>
