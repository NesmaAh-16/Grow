@if ($errors->any())
    <div class="alert alert-danger" style="margin:12px 0">
        <ul class="mb-0" style="padding-right:18px">
            @foreach ($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> إنشاء حساب </title>
    <link rel="icon" href="assets/images/logo2-removebg-preview.png" type="image/x-icon" width="15px">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800;900&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="assets/css/register.css">
</head>

<body>
    <header class="navbar" id="navbar">
        <div class=" container nav-inner">
            <a class="brand" href="{{ route('home') }}">
                <img class="logo" src="assets/images/imageedit_2_6635233653.png" alt="Grow Logo">
                <img class="brand-name" src="assets/images/logomwhite.png" />
            </a>
            <div class="nav-actions">
                <a class="btn btn-secondary" href="{{ route('login') }}">
                    <i class="fas fa-sign-in-alt"></i>
                    تسجيل دخول
                </a>
            </div>
        </div>
    </header>

    <main>
        <div class="tabs">
            <div class="tab" data-tab="student">تسجيل الطالب</div>
            <div class="tab active" data-tab="teacher">تسجيل المعلم</div>
        </div>

        <form id="student-form" style="display:none" method="POST" action="{{ route('register.student') }}">
            @csrf
            <input type="text" placeholder="الاسم الكامل" name="name" value="{{ old('name') }}" required />
            <input type="email" placeholder="البريد الإلكتروني"name="email" value="{{ old('email') }}" required />
            <input type="text" placeholder="رقم الهوية"name="national_id" value="{{ old('national_id') }}" required />
            <input type="date" placeholder="تاريخ الميلاد" name="birth_date" value="{{ old('birth_date') }}"required />
            <select name="final_stage"value="{{ old('final_stage') }}" required>
                <option value="">اختر آخر مرحلة دراسية</option>
                <option>الصف الأول</option>
                <option>الصف الثاني</option>
                <option>الصف الثالث</option>
                <option>الصف الرابع</option>
                <option>الصف الخامس</option>
                <option>الصف السادس</option>
                <option>الصف السابع</option>
                <option>الصف الثامن</option>
                <option>الصف التاسع</option>
                <option>الصف العاشر</option>
            </select>
            <input type="password" placeholder="كلمة المرور"name="password" required />
            <input type="password" placeholder="تأكيد كلمة المرور" name="password_confirmation"required />
            <button type="submit" class="btn btn-primary">تسجيل الطالب الجديد</button>
            <div class="success-box">
                <i class="fas fa-check-circle"></i> شكراً للتسجيل.
            </div>
        </form>

        <form id="teacher-form" style="display:flex" method="POST" action="{{ route('register.teacher') }}">
            @csrf
            <input type="text" placeholder="الاسم الكامل"name="name" value="{{ old('name') }}" required />
            <input type="text" placeholder="التخصص" name="specialty" value="{{ old('specialty') }}" required />
            <input type="email" placeholder="البريد الإلكتروني"name="email" value="{{ old('email') }}" required />
            <input type="text" placeholder="رقم الهوية"name="national_id" value="{{ old('national_id') }}" required />
            <input type="date" placeholder="تاريخ الميلاد" name="birth_date" value="{{ old('birth_date') }}"required />
            <input type="password" placeholder="كلمة المرور" name="password" required />
            <input type="password" placeholder="تأكيد كلمة المرور"name="password_confirmation" required />
            <button type="submit" class="btn btn-primary">تسجيل المعلم الجديد</button>
            <div class="success-box">
                <i class="fas fa-check-circle"></i> شكراً للتسجيل.
            </div>
        </form>
    </main>

    <script src="assets/js/register.js"></script>
</body>

</html>
