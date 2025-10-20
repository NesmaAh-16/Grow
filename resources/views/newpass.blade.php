<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('assets/images/logo2-removebg-preview.png') }}" type="image/x-icon" width = "15px">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800;900&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <title>إعادة تعيين كلمة المرور</title>
    <link rel="stylesheet" href="{{ asset('assets/css/newpass.css') }}">
</head>

<body>
    <header class="navbar" id="navbar">
        <div class="container nav-inner">
            <a class="brand" href="{{ route('home') }}">
                <img class="logo" src="{{ asset('assets/images/imageedit_2_6635233653.png') }}" alt="شعار المنصة" />
                <img class="brand-name" src="{{ asset('assets/images/logomwhite.png') }}" alt="Grow" />
            </a>
            <div class="nav-actions">
                <a class="btn btn-secondary" href="{{ route('login') }}">
                    <i class="fas fa-sign-in-alt"></i>
                    تسجيل دخول
                </a>
            </div>
        </div>
    </header>
    <div class="reset-password-container">

        <h2>إعادة تعيين كلمة المرور</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ request('token') ?? $token }}">
            <input type="hidden" name="email" value="{{ request('email') ?? $email }}">

            <div class="form-group">
                <label for="password">كلمة المرور الجديدة</label>
                <input id="password" type="password" name="password" class="form-control" minlength="6" required>
            </div>

            <div class="form-group">
                <label for="password_confirmation">تأكيد كلمة المرور</label>
                <input id="password_confirmation" type="password" name="password_confirmation" class="form-control"
                    minlength="6" required>
            </div>

            <button type="submit" class="btn-submit">تأكيد</button>
        </form>


    </div>
</body>

</html>
