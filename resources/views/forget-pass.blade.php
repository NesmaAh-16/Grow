<!DOCTYPE html>
<html lang="ar" dir="rtl">
@php
    $email = $email ?? request('email'); //  
@endphp

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>تأكيد استعادة كلمة المرور</title>
    <link rel="icon" href="{{ asset('assets/images/logo2-removebg-preview.png') }}" type="image/x-icon" width = "15px">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800;900&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/forget-pass.css') }}">

</head>

<body>
    <header class="navbar" id="navbar">
        <div class="container nav-inner">
            <a class="brand" href="{{ route('home') }}">
                <img class="logo" src="{{ asset('assets/images/imageedit_2_6635233653.png') }}" alt="شعار المنصة" />
                <img class="brand-name" src="{{ asset('assets/images/logomwhite.png') }}" alt="Grow" />
            </a>
            <div class="nav-actions">
                <a class="btn btn-secondary" href="{{ route('register') }}">
                    <i class="fas fa-user-plus"></i>
                    إنشاء حساب
                </a>
            </div>
        </div>
    </header>

    <div class="confirm-container fade-up">
        <h2 class="delay-1">تأكيد استعادة كلمة المرور</h2>
        <p>أدخل بريدك الإلكتروني لإرسال رمز تحقق مكوّن من 6 أرقام.</p>


        <div class="message-box" id="messageBox"></div>
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
        @if (empty($email))
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <label for="email">البريد الإلكتروني</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                <button type="submit" class="submit-btn">إرسال الرمز</button>
            </form>
        @else
            <form method="POST" action="{{ route('password.otp.verify') }}">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">
                <label for="code">رمز التأكيد</label>
                <input id="code" name="code" type="text" inputmode="numeric" maxlength="6" required>
                <button type="submit" class="submit-btn">تأكيد</button>
            </form>

            <form method="POST" action="{{ route('password.otp.resend') }}" style="margin-top:10px">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">
                <button type="submit" class="resend-link">إعادة إرسال الرمز؟</button>
            </form>
        @endif



        {{-- <form id="confirmForm" class="delay-3" method="POST" action="{{ route('password.otp.verify') }}">
            @csrf


            <input type="hidden" name="email" value="{{ $email }}">

            <label for="code">رمز التأكيد</label>
            <input type="text" id="code" name="code" placeholder="أدخل الرمز هنا (مثال: 123456)"
                maxlength="6" inputmode="numeric" pattern="[0-9]{6}" required>
            <button type="submit" class="submit-btn delay-4">تأكيد</button>
        </form>

        <form method="POST" action="{{ route('password.otp.resend') }}" style="margin-top:10px">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <button type="submit" class="resend-link delay-4">إعادة إرسال الرمز؟</button>
        </form> --}}

    </div>

    {{-- -<script src="assets/js/forget-pass.js"></script> --}}
</body>

</html>
