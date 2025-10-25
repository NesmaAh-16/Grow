<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اللغة الإنجليزية</title>

    <link rel="icon" href="{{ asset('assets/images/logo2-removebg-preview.png') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/navbar.css') }}">

    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background: #f3f8ff
        }

        .page-wrap {
            max-width: 980px;
            margin: 32px auto
        }

        .title {
            font-size: 32px;
            font-weight: 800;
            color: #1f3b8a;
            text-align: center
        }

        .subtitle {
            color: #667085;
            text-align: center;
            margin-top: 6px
        }

        .unit {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 8px 24px rgba(16, 24, 40, .08);
            margin: 20px 0;
            padding: 16px 0
        }

        .unit-head {
            font-size: 22px;
            font-weight: 800;
            color: #1f3b8a;
            text-align: center
        }

        .divider {
            height: 6px;
            background: #e9eef9;
            border-radius: 999px;
            margin: 10px 22px
        }

        .lesson {
            display: flex;
            align-items: center;
            gap: 12px;
            background: #fff;
            border: 1px solid #eef2f7;
            margin: 12px 22px;
            padding: 14px;
            border-radius: 12px
        }

        .lesson:hover {
            box-shadow: 0 6px 16px rgba(16, 24, 40, .06)
        }

        .dot {
            width: 8px;
            height: 8px;
            background: #c7d2fe;
            border-radius: 999px;
            margin: 0 6px
        }

        .l-title {
            font-weight: 800;
            color: #0f172a
        }

        .meta {
            color: #667085;
            font-size: 14px;
            margin-top: 4px
        }

        .type {
            font-size: 13px;
            background: #eef2ff;
            color: #3730a3;
            padding: 4px 10px;
            border-radius: 999px;
            margin-right: auto
        }

        .dur {
            display: flex;
            align-items: center;
            color: #64748b;
            font-size: 13px
        }

        .dur i {
            margin-left: 6px
        }

        .check {
            margin-right: 8px
        }

        .page-container {
            padding-top: 70px
        }
    </style>
</head>

<body>
    <div class="page-container">
        <nav>
            <div class="nav-left">
                <a class="brand" href="{{ route('home') }}">
                    <img class="logo" src="{{ asset('assets/images/imageedit_2_6635233653.png') }}" alt="">
                    <img class="brand-name" src="{{ asset('assets/images/logomwhite.png') }}" alt="Grow">
                </a>
            </div>
            <div class="nav-menu">
                <a href="{{ route('home') }}" class="nav-link">
                    <i class="fas fa-home" style="margin-left:8px"></i>الصفحة الرئيسية
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
                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i><span>تسجيل خروج</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">@csrf</form>
            </div>
        </nav>

        <main class="page-wrap">
            <h1 class="title">اللغة الإنجليزية</h1>
            <div class="subtitle">الأستاذ/ة سارة صالح · الصف الحادي عشر</div>

            <section class="unit">
                <div class="unit-head">الوحدة الأولى: قواعد اللغة (Grammar)</div>
                <div class="divider"></div>

                <article class="lesson">
                    <input type="checkbox" class="check">
                    <div>
                        <a href="#" class="l-title">الدرس الأول: Present Simple vs. Present Continuous</a>
                        <div class="meta">درس مرئي — الاستخدام، الإشارات الدالّة، أمثلة وتمارين سريعة</div>
                    </div>
                    <span class="type">درس مرئي</span>
                    <div class="dot"></div>
                    <div class="dur"><i class="fa-regular fa-clock"></i> 15 دقيقة</div>
                </article>

                <article class="lesson">
                    <input type="checkbox" class="check">
                    <div>
                        <a href="#" class="l-title">الدرس الثاني: Past Simple & Past Continuous</a>
                        <div class="meta">درس قراءة — تكوين الماضي البسيط والمستمر، when/while</div>
                    </div>
                    <span class="type">درس قراءة</span>
                    <div class="dot"></div>
                    <div class="dur"><i class="fa-regular fa-clock"></i> 12 دقيقة</div>
                </article>

                <article class="lesson">
                    <input type="checkbox" class="check">
                    <div>
                        <a href="#" class="l-title">الدرس الثالث: Modals (can, could, must, have to)</a>
                        <div class="meta">تمرين تفاعلي — القدرة، الإلزام، الاحتمال مع أمثلة تطبيقية</div>
                    </div>
                    <span class="type">تمرين تفاعلي</span>
                    <div class="dot"></div>
                    <div class="dur"><i class="fa-regular fa-clock"></i> 20 دقيقة</div>
                </article>
            </section>

            <section class="unit">
                <div class="unit-head">الوحدة الثانية: فهم المقروء (Reading)</div>
                <div class="divider"></div>

                <article class="lesson">
                    <input type="checkbox" class="check">
                    <div>
                        <a href="#" class="l-title">الدرس الأول: Skimming & Scanning</a>
                        <div class="meta">درس مرئي — استراتيجيات القراءة السريعة لاستخراج الأفكار الرئيسية والتفاصيل
                        </div>
                    </div>
                    <span class="type">درس مرئي</span>
                    <div class="dot"></div>
                    <div class="dur"><i class="fa-regular fa-clock"></i> 14 دقيقة</div>
                </article>

                <article class="lesson">
                    <input type="checkbox" class="check">
                    <div>
                        <a href="#" class="l-title">الدرس الثاني: Inference & Context Clues</a>
                        <div class="meta">درس قراءة — الاستدلال من السياق وفهم معاني الكلمات</div>
                    </div>
                    <span class="type">درس قراءة</span>
                    <div class="dot"></div>
                    <div class="dur"><i class="fa-regular fa-clock"></i> 10 دقائق</div>
                </article>
            </section>

            <section class="unit">
                <div class="unit-head">الوحدة الثالثة: الكتابة (Writing)</div>
                <div class="divider"></div>

                <article class="lesson">
                    <input type="checkbox" class="check">
                    <div>
                        <a href="#" class="l-title">الدرس الأول: Paragraph Structure</a>
                        <div class="meta">درس مرئي — Topic Sentence، الدّعم، الخاتمة</div>
                    </div>
                    <span class="type">درس مرئي</span>
                    <div class="dot"></div>
                    <div class="dur"><i class="fa-regular fa-clock"></i> 16 دقيقة</div>
                </article>

                <article class="lesson">
                    <input type="checkbox" class="check">
                    <div>
                        <a href="#" class="l-title">الدرس الثاني: Opinion Essay</a>
                        <div class="meta">تمرين تفاعلي — تخطيط، صياغة الحجج، الوصلات الانتقالية</div>
                    </div>
                    <span class="type">تمرين تفاعلي</span>
                    <div class="dot"></div>
                    <div class="dur"><i class="fa-regular fa-clock"></i> 20 دقيقة</div>
                </article>
            </section>

            <section class="unit">
                <div class="unit-head">الوحدة الرابعة: المفردات (Vocabulary)</div>
                <div class="divider"></div>

                <article class="lesson">
                    <input type="checkbox" class="check">
                    <div>
                        <a href="#" class="l-title">الدرس الأول: Collocations & Phrasal Verbs</a>
                        <div class="meta">درس قراءة — شائعة الاستخدام في الحياة الأكاديمية واليومية</div>
                    </div>
                    <span class="type">درس قراءة</span>
                    <div class="dot"></div>
                    <div class="dur"><i class="fa-regular fa-clock"></i> 12 دقيقة</div>
                </article>
            </section>
        </main>
    </div>
</body>

</html>
