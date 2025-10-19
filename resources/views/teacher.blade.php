<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الصفحة الشخصية</title>

    {{-- favicon: لا تضعي width داخل link --}}
    <link rel="icon" href="{{ asset('assets/images/logo2-removebg-preview.png') }}" type="image/x-icon">

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    {{-- ❌ كان: asset('https://cdnjs...') -> هذا يُفسد الرابط --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('assets/css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/teacher.css') }}">
</head>

<body>
    <div class="page-container">
        <nav>
            <div class="nav-left">
                <a class="brand" href="{{ route('home') }}">
                    <img class="logo" src="{{ asset('assets/images/imageedit_2_6635233653.png') }}" alt="شعار المنصة">
                    <img class="brand-name" src="{{ asset('assets/images/logomwhite.png') }}" alt="Grow">
                </a>
            </div>

            <div class="nav-menu">
                <a href="{{ route('home') }}" class="nav-link">
                    <i class="fas fa-home" style="margin-left: 8px"></i>
                    الصفحة الرئيسية
                </a>
            </div>

            <div class="nav-right">
                <button class="nav-btn" title="الإشعارات">
                    <i class="fas fa-bell"></i>
                    <span class="badge">3</span>
                </button>

                <a href="#" class="nav-btn" title="الإعدادات">
                    <i class="fas fa-cog"></i>
                </a>

                <a href="#" class="logout-btn"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>تسجيل خروج</span>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </nav>

        <main class="main-content">
            <section class="hero">
                {{-- مسافة بعد الفاصلة لتحسين الطباعة --}}
                <h1>مرحباً بك، الأستاذة {{ auth()->user()->name }}</h1>
                <p>نتمنى لك يوماً دراسياً مثمراً</p>

                <div class="stats">
                    <div class="stat-card">
                        <div class="value">{{ $classesCount }}</div>
                        <div class="stat-label">الصفوف الدراسية</div>
                    </div>
                    <div class="stat-card">
                        <div class="value">{{ $studentsCount }}</div>
                        <div class="stat-label">الطلاب المسجلين</div>
                    </div>
                </div>
            </section>

            <section class="quick-actions">
                <a href="{{ route('quizzes.index') }}" class="action-btn">
                    <i class="fas fa-file-alt"></i>
                    <span>الاختبارات</span>
                </a>

                @php $firstQuiz = $recentQuizzes->first(); @endphp
                @if ($firstQuiz)
                    {{-- مرِّري الكائن مباشرة في حال وجود Route Model Binding --}}
                    <a href="{{ route('quizzes.results', $firstQuiz->id) }}" class="action-btn">
                        <i class="fas fa-poll"></i><span>نتائج الاختبار</span>
                    </a>
                @else
                    <button type="button" class="action-btn" disabled>
                        <i class="fas fa-poll"></i>
                        <span>لا توجد اختبارات لعرض نتيجتها</span>
                    </button>
                @endif

                <a href="{{ route('assignments.index') }}" class="action-btn">
                    <i class="fas fa-book-open"></i>
                    <span>الواجبات المنزلية</span>
                </a>

                @php
                    $teacherId = optional(auth()->user()->teacher)->id; // لو عندك جدول teachers
                    $userId = auth()->id();

                    $firstAssignment = \App\Models\Assignment::query()
                        ->whereHas('lesson', function ($q) use ($teacherId, $userId) {
                            // غطّي الحالتين:
                            $q->where(function ($qq) use ($teacherId, $userId) {
                                // 1) لو lessons.teacher_id = teachers.id
                                if ($teacherId) {
                                    $qq->orWhere('teacher_id', $teacherId);
                                }
                                // 2) لو lessons.teacher_id = users.id
                                $qq->orWhere('teacher_id', $userId);
                            });
                        })
                        ->first(); // لو وجد أول واجب
                @endphp

                @if ($firstAssignment)
                    <a href="{{ route('assignments.edit', $firstAssignment->id) }}" class="action-btn">
                        <i class="fas fa-edit"></i>
                        <span>تعديل الواجب</span>
                    </a>
                @else
                    <button type="button" class="action-btn" disabled>
                        <i class="fas fa-edit"></i>
                        <span>لا يوجد واجبات لتعديلها</span>
                    </button>
                @endif

                <a href="{{ route('lessons.details') }}" class="action-btn">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <span>تفاصيل الدرس</span>
                </a>
            </section>

            <section class="activities">
                <h2 class="section-title">آخر الأنشطة</h2>

                <table>
                    <thead>
                        <tr>
                            <th>تاريخ الانتهاء</th>
                            <th>نوع النشاط</th>
                            <th>التفاصيل</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- الواجبات --}}
                        @foreach ($recentAssignments as $assignment)
                            <tr>
                                <td>{{ optional($assignment->due_at)->format('d/m/Y') ?? '-' }}</td>
                                <td><span class="activity-type homework">تسليم واجب</span></td>
                                <td>
                                    واجب: {{ $assignment->title }}
                                    —
                                    {{-- نحذف تكرار كلمة "الصف n" من عنوان الدرس --}}
                                    {{ trim(preg_replace('/\s*[-–—]?\s*الصف\s*\d+/u', '', $assignment->lesson->title ?? 'درس غير محدد')) }}
                                    — الصف {{ $assignment->lesson->grade ?? '-' }}
                                </td>
                            </tr>
                        @endforeach

                        {{-- الاختبارات --}}
                        @foreach ($recentQuizzes as $q)
                            <tr>
                                <td>{{ optional($q->available_to)->format('d/m/Y') ?? '-' }}</td>
                                <td><span class="activity-type exam">امتحان</span></td>
                                <td>
                                    اختبار: {{ $q->title }}
                                    —
                                    {{ trim(preg_replace('/\s*[-–—]?\s*الصف\s*\d+/u', '', $q->lesson->title ?? 'درس غير محدد')) }}
                                    - الصف {{ $q->lesson->grade ?? '-' }}
                                </td>
                            </tr>
                        @endforeach



                        {{-- لو ما في أنشطة --}}
                        @if ($recentAssignments->isEmpty() && $recentQuizzes->isEmpty())
                            <tr>
                                <td colspan="3" class="text-center">لا توجد أنشطة حديثة.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </section>
        </main>
    </div>

    <script src="{{ asset('assets/js/teacher.js') }}"></script>
</body>

</html>
