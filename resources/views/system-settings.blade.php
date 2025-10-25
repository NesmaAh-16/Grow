@if (session('ok'))
    <div class="alert"
        style="background:#e6ffed;border:1px solid #b4f8c8;padding:10px;border-radius:8px;color:#1a7f37;margin:10px">
        {{ session('ok') }}
    </div>
@endif
@if ($errors->any())
    <div class="alert"
        style="background:#fdecec;border:1px solid #f5c2c7;padding:10px;border-radius:8px;color:#b02a37;margin:10px">
        <ul style="margin:0;padding-right:18px">
            @foreach ($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
@endif
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إعدادات النظام - لوحة التحكم</title>
    <link rel="icon" href="{{ asset('assets/images/logo2-removebg-preview.png') }}" type="image/x-icon"
        width = "15px">

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet"
        href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/super-admin-dashboard.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/system-settings.css') }}" />
</head>

<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <a class="brand" href="{{ route('home') }}">
                    <img class="logo" src="{{ asset('assets/images/logo2-removebg-preview.png') }}"
                        alt="شعار المنصة" />
                    <img class="brand-name" src="{{ asset('assets/images/edited_color.png') }}" alt="Grow" />
                </a>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> الرئيسية</a></li>
                    <li><a href="{{ route('admin.admins.index') }}"><i class="fas fa-user-shield"></i> إدارة
                            الاداريين</a></li>
                    <li class="active"><a href="{{ route('admin.system.settings') }}"><i class="fas fa-cogs"></i>
                            إعدادات النظام</a></li>
                    <li><a href="{{ route('admin.permissions.index') }}"><i class="fas fa-key"></i> إدارة الصلاحيات</a>
                    </li>
                </ul>
            </nav>
        </aside>
        @if (session('ok'))
            <div class="alert success">{{ session('ok') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert error">
                <ul>
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <main class="main-content">
            <header class="main-header">
                <div class="header-title">
                    <h1>إعدادات النظام</h1>
                </div>
                <div class="header-actions">
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
            </header>

            <div class="settings-card">
                <form method="POST" action="{{ route('admin.system.settings.update') }}" class="settings-form"
                    onsubmit="return confirm('حفظ التعديلات؟');">
                    @csrf @method('PUT')

                    <div class="form-group">
                        <label>اسم الموقع</label>
                        <input type="text" name="site_name"
                            value="{{ old('site_name', $settings->site_name) ?? config('app.name', 'Grow Platform') }}">
                    </div>

                    <div class="form-group">
                        <label>البريد الرسمي</label>
                        <input type="email" name="official_email"
                            value="{{ old('official_email', $settings->official_email) }}">
                    </div>

                    <div class="form-group">
                        <label>اللغة الافتراضية</label>
                        <select name="default_locale" class="form-control">
                            <option value="ar" {{ $settings->default_locale == 'ar' ? 'selected' : '' }}>العربية
                            </option>
                            <option value="en" {{ $settings->default_locale == 'en' ? 'selected' : '' }}>English
                            </option>
                        </select>
                        @error('default_locale')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>التسجيل العام</label>

                        <input type="hidden" name="registration_open" value="0">

                        <label class="toggle-switch">
                            <input type="checkbox" name="registration_open" value="1" @checked(old('registration_open', $settings->registration_open))>
                            <span class="slider"></span>
                        </label>
                    </div>
                    <footer class="form-actions">
                        <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">إلغاء</a>
                    </footer>
                </form>

            </div>
        </main>
    </div>
    <div id="toastNotification" class="toast-notification"></div>

    <script src="assets/js/system-settengs.js"></script>
</body>

</html>
