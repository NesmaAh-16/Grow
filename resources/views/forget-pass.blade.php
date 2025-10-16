<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>تأكيد استعادة كلمة المرور</title>
  <link rel="icon" href="assets/images/logo2-removebg-preview.png" type="image/x-icon" width = "15px">
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800;900&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="assets/css/forget-pass.css">

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

  <div class="confirm-container fade-up">
    <h2 class="delay-1">تأكيد استعادة كلمة المرور</h2>
    <p class="delay-2">لقد أرسلنا رمز تأكيد مكونًا من 6 أرقام إلى بريدك الإلكتروني. الرجاء إدخاله أدناه للمتابعة.</p>

    <div class="message-box" id="messageBox"></div>

    <form id="confirmForm" class="delay-3">
      <label for="confirmationCode">رمز التأكيد</label>
      <input type="text" id="confirmationCode" name="confirmationCode" placeholder="أدخل الرمز هنا (مثال: 123456)" maxlength="6" inputmode="numeric" pattern="[0-9]*">

      <a href="#" class="resend-link delay-4" id="resendCodeLink">إعادة إرسال الرمز؟</a>

      <button type="submit" class="submit-btn delay-4">تأكيد</button>
    </form>
  </div>

  <script src="assets/js/forget-pass.js"></script>
</body>
</html>
