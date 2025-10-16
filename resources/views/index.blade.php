<!DOCTYPE html>
<html lang="ar" dir="rtl">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>الصفحة الرئيسية</title>
    <meta
      name="description"
      content="منصة Grow التعليمية — الأولى في قطاع غزة"
    />
     <link rel="icon" href="assets/images/logo2-removebg-preview.png" type="image/x-icon" width = "15px">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800;900&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
    <link rel="stylesheet" href="assets/css/style.css">

  </head>
  <body>
    <header class="navbar" id="navbar">
      <div class="container nav-inner">
        <a class="brand" href="{{ route('home') }}">
          <img class="logo" src="assets/images/imageedit_2_6635233653.png" alt="شعار المنصة" />
          <img class="brand-name" src="assets/images/logomwhite.png" alt="Grow" />
        </a>
        <div class="nav-actions">
            <a class="btn btn-secondary" href="{{ route ('login')}}">
              <i class="fas fa-sign-in-alt"></i>
              تسجيل دخول</a>
            <a class="btn btn-secondary" href="{{ route ('register')}}">
              <i class="fas fa-user-plus"></i>
              إنشاء حساب</a>
        </div>
      </div>
    </header>

    <main>
      <section class="hero-card">
        <div>
          <h1 class="hero-title">
            مرحبًا بك في منصة <span style="color: var(--brand)">Grow</span>
            المنصة التعليمية الأولى في قطاع غزة
          </h1>
          <p class="hero-sub">
            طوّر مهاراتك، واكتشف شغفك، وكن جزءًا من مستقبل تعليمي مختلف.
ابدأ رحلتك نحو التميز بخطوات واثقة وإصرار لا يتوقف.
          </p>
          <div class="hero-buttons">
            <a class="btn btn-primary" href="#" id="about-btn">من نحن</a>
          </div>
        </div>
        <aside class="side">
          <img src="assets/images/front-page-pic.png" alt="منصة Grow التعليمية" />
        </aside>
      </section>
    </main>

    <footer>
      <div class="copyright">© 2025 منصة Grow - جميع الحقوق محفوظة</div>
    </footer>

    <div class="modal-overlay" id="about-modal-overlay">
      <div class="modal-content">
        <button class="close-modal" id="close-modal-btn" title="إغلاق">&times;</button>
        <h2>عن منصة Grow</h2>
        <p> نحن منصة تعليمية رقمية تهدف إلى تقديم تجربة تعليمية متكاملة، تفاعلية، وآمنة، تواكب احتياجات الطلاب في الوضع الراهن .
نؤمن بأن التعلم حق للجميع، ونعمل على خلق بيئة تعليمية تُشجّع الفضول، تنمّي المهارات، وتدعم الإبداع، في كل مرحلة من مراحل التعلم.
        </p>
        <p>
          <strong>ميزاتنا:</strong>
          <br/>
          - نخبة من أفضل المعلمين المعتمدين.
          <br/>
          - محتوى تفاعلي وفصول مباشرة.
          <br/>
          - متابعة مستمرة وتقييمات دورية.
        </p>
        <p>
          <strong>خدماتنا:</strong>
          <br/>
          نقدم شروحات مبسطة وتقوية لجميع المراحل الدراسية، بالإضافة إلى برامج متخصصة للمراحل المتقدمة، مع التركيز على بناء المهارات الأساسية لدى الطالب.
        </p>
      </div>
    </div>

    <script src="assets/js/script.js">
    </script>
  </body>
</html>
