<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>تسجيل الدخول </title>
  <link rel="icon" href="assets/images/logo2-removebg-preview.png" type="image/x-icon" width = "15px">
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800;900&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="assets/css/login.css">
  <style>

  </style>
</head>
<body>
  <header class="navbar" id="navbar">
    <div class="container nav-inner">
      <a class="brand" href="{{ route('home') }}">
          <img class="logo" src="assets/images/imageedit_2_6635233653.png" alt="شعار المنصة"  />
          <img class="brand-name" src="assets/images/logomwhite.png" alt="Grow" />
        </a>
      <div class="nav-actions">
        <a class="btn btn-secondary" href="{{ route('register') }}">
          <i class="fas fa-user-plus"></i>
          إنشاء حساب
        </a>
      </div>
    </div>
  </header>

  <div class="login-container fade-up">
  <h2 class="delay-1">تسجيل الدخول</h2>
  <div class="user-type-buttons">
  <div class="user-type-btn active" data-type="admin">أدمن</div>
  <div class="user-type-btn" data-type="teacher">معلم</div>
  <div class="user-type-btn" data-type="student">طالب</div>
</div>

  @if ($errors->any())
    <div class="error-message" id="error" style="display:block;">
      {{ $errors->first() }}
    </div>
  @endif
  <form id="loginForm" class="delay-3" method="POST" action="{{ route('login.attempt') }}">
    @csrf
    <input type="hidden" name="login_as" id="login_as" value="admin">

    <div id="emailField">
      <label for="email">البريد الإلكتروني</label>
      <input type="email" id="email" name="email" placeholder="example@email.com"
             value="{{ old('email') }}">
    </div>

    <div id="idField" style="display:none;">
      <label for="studentId">رقم الهوية</label>
      <input type="text" id="studentId" name="studentId" placeholder="رقم الهوية"
             value="{{ old('studentId') }}">
    </div>

    <label for="password">كلمة المرور</label>
    <input type="password" id="password" name="password" placeholder="••••••••">

    <a href="{{ route('password.request') }}" class="forgot-password">نسيت كلمة المرور؟</a>
    <button type="submit" class="submit-btn">دخول</button>
  </form>
</div>


 {{-- <div class="login-container fade-up">
    <h2 class="delay-1">تسجيل الدخول</h2>
    <div class="user-type-buttons delay-2">
      <div class="user-type-btn active" data-type="admin">أدمن</div>
      <div class="user-type-btn" data-type="teacher">معلم</div>
      <div class="user-type-btn" data-type="student">طالب</div>
    </div>
    <div class="error-message" id="error">الرجاء إدخال جميع الحقول المطلوبة بشكل صحيح.</div>
    <form id="loginForm" class="delay-3" method="POST" action="{{ route('login.attempt') }}">
        @csrf
        <input type="hidden" name="login_as" id="login_as" value="admin">
        <div id="emailField">
        <label for="email">البريد الإلكتروني</label>
        <input type="email" id="email" name="email" placeholder="example@email.com">
      </div>
      <div id="idField" style="display:none;">
        <label for="studentId">رقم الهوية</label>
        <input type="text" id="studentId" name="studentId" placeholder="رقم الهوية">
      </div>
      <label for="password">كلمة المرور</label>
      <input type="password" id="password" name="password" placeholder="••••••••">

      <a href="{{ route('password.request') }}" class="forgot-password">نسيت كلمة المرور؟</a>

      <button type="submit" class="submit-btn">دخول</button>
    </form>
  </div>--}}

<script src="assets/js/login.js"></script>
</body>
</html>
