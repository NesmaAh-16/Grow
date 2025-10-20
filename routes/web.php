<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Teacher\QuizController;
use App\Http\Controllers\SupportMessageController;
use App\Http\Controllers\Teacher\LessonController;
use App\Http\Controllers\StudentActivityController;
use App\Http\Controllers\Teacher\TeacherController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Teacher\QuestionController;
use App\Http\Controllers\Teacher\AssignmentController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Student\StudentDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/


// الصفحة الرئيسية
Route::get('/', [AppController::class, 'index'])->name('home');

Route::get('/redirect-by-role', function () {
    if (auth()->check()) {
        $u = auth()->user();
        if ($u->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }
        if ($u->hasRole('user-admin')) {
            return redirect()->route('user_admin.dashboard');
        }
        if ($u->hasRole('teacher')) {
            return redirect()->route('teacher.dashboard');
        }
        if ($u->hasRole('student')) {
            return redirect()->route('student.dashboard');
        }
    }
    return redirect()->route('login');
})->name('role.redirect')->middleware('auth');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'attempt'])->name('login.attempt');
});

// تسجيل جديد
//Route::get('/register', [AppController::class, 'showRegister'])->name('register');
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register/student', [AuthController::class, 'registerStudent'])->name('register.student');
    Route::post('/register/teacher', [AuthController::class, 'registerTeacher'])->name('register.teacher');
});


// لوحة الطالب (المسار الصحيح: /student/dashboard)
Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/student/dashboard', function () {

        $user = auth()->user();
        $profile = $user->studentProfile;  // علاقة one-to-one

        return view('subjects', compact('user', 'profile')); // تأكد أن لديك ملف resources/views/subjects.blade.php
    })->name('student.dashboard');

    // إعدادات الطالب وإشعاراته (استخدم الـ prefix للمسارات الفرعية)
    Route::prefix('student')->name('student.')->group(function () {
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
        //Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    });
});

Route::middleware(['role:teacher|student'])->group(function () {
    Route::get('/lessons', [LessonController::class, 'index'])->name('lessons.index');
    Route::get('/lessons/details', [LessonController::class, 'details'])->name('lessons.details');//math
    Route::get('/lessons/arabic', [LessonController::class, 'arabic'])->name('lessons.arabic');//arabic
    Route::get('/lessons/english', [LessonController::class, 'english'])->name('lessons.english');//arabic
    Route::get('/lessons/science', [LessonController::class, 'science'])->name('lessons.science');//arabic

});


// لوحة المعلم (المسار الصحيح: /teacher/dashboard)
Route::middleware(['auth', 'role:teacher'])->group(function () {
    Route::get(
        '/teacher/dashboard',
        [TeacherController::class, 'index']
        /* function () {
            return view('teacher');
        }*/
    )->name('teacher.dashboard');

    // الدروس



    // الواجبات
    // Route::prefix('teacher')->middleware(['auth','role:teacher|admin|user-admin'])->group(function () {
    Route::get('/assignments', [AssignmentController::class, 'index'])->name('assignments.index');
    Route::get('/assignments/create', [AssignmentController::class, 'create'])->name('assignments.create');
    Route::post('/assignments', [AssignmentController::class, 'store'])->name('assignments.store');

    Route::get('/assignments/{assignment}', [AssignmentController::class, 'show'])->name('assignments.show');
    Route::get('/assignments/{assignment}/edit', [AssignmentController::class, 'edit'])->name('assignments.edit');
    Route::put('/assignments/{assignment}', [AssignmentController::class, 'update'])->name('assignments.update');
    Route::delete('/assignments/{assignment}', [AssignmentController::class, 'destroy'])->name('assignments.destroy');



    // quizzes
    Route::get('/quizzes', [QuizController::class, 'index'])->name('quizzes.index');
    Route::get('/quizzes/create', [QuizController::class, 'create'])->name('quizzes.create'); //first page quiz create
    //Route::get('/quizzes/createContinue', [QuizController::class, 'createContinue'])->name('quizzes.createContinue'); //second page quiz create
    Route::post('/quizzes', [QuizController::class, 'store'])->name('quizzes.store');

    Route::get('/quizzes/{quiz}/questions/createContinue', [QuestionController::class, 'createContinue'])
        ->whereNumber('quiz')
        ->name('quizzes.questions.createContinue');

    Route::post('/quizzes/{quiz}/questions', [QuestionController::class, 'store'])
        ->whereNumber('quiz')
        ->name('quizzes.questions.store');
    Route::get('/quizzes/{quiz}/edit', [\App\Http\Controllers\Teacher\QuizController::class, 'edit'])->name('quizzes.edit');
    Route::delete('/quizzes/{quiz}', [\App\Http\Controllers\Teacher\QuizController::class, 'destroy'])->name('quizzes.destroy');
    Route::get('/quizzes/{quiz}/attempt', [\App\Http\Controllers\Teacher\QuizController::class, 'attempt'])
        ->whereNumber('quiz')->name('quizzes.attempt');

    Route::post('/quizzes/{quiz}/attempt', [\App\Http\Controllers\Teacher\QuizController::class, 'submitAttempt'])
        ->whereNumber('quiz')->name('quizzes.attempt.submit');

    /*Route::get('/quizzes/results', [\App\Http\Controllers\Teacher\QuizController::class, 'results'])
        ->name('quizzes.results');*/
    Route::get('/quizzes/{quiz}/results', [QuizController::class, 'results'])->name('quizzes.results');
    Route::get('/quizzes/{quiz}', [QuizController::class, 'show'])->name('quizzes.show');


});

//attempt quizz
Route::middleware(['auth'])->group(function () {

});
Route::prefix('')
    ->middleware(['auth'])
    ->name('student.')
    ->group(function () {
        Route::get('/dashboard', [StudentDashboardController::class, 'index'])
            ->name('dashboard');
    });


// لوحة المدير
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('super-admin-dashboard');
    })->name('admin.dashboard');

    Route::get('/admin/admins', function () {  //إدارة الإداريين
        return view('admins-management');
    })->name('admin.admins');

    Route::get('/admin/settings', function () {   //إعدادات النظام
        return view('system-settings');
    })->name('admin.system.settings');

    Route::get('/admin/permissions', function () { //إدارة الصلاحيات
        return view('permissions-management');
    })->name('admin.permissions');

});

Route::middleware(['auth', 'role:user-admin'])->group(function () {
    Route::get('/user-admin/dashboard', function () {
        return view('users-admin-dashboard');
    })->name('user_admin.dashboard');
    Route::get('/user-admin/students', function () { //إدارة الصلاحيات الطلاب
        return view('students-management');
    })->name('students-management');

    Route::get('/user-admin/teachers', function () { //إدارة الصلاحيات المعلمين
        return view('teachers-management');
    })->name('teachers-management');

    Route::get('/user-admin/approvals', function () { //إدارة الصلاحيات و تاكيد الحسابات
        return view('account-approval');
    })->name('account-approval');

});

Route::middleware('auth')->group(function () {
    // دعم
    Route::post('/support', [SupportMessageController::class, 'store'])->name('support.store');
    Route::get('/support', [SupportMessageController::class, 'index'])
    ->name('support.index');
    Route::post('/support/{supportMessage}/reply', [SupportMessageController::class, 'reply'])->name('support.reply');

    // نشاط الطالب
    Route::post('/activity/submit', [StudentActivityController::class, 'submit'])->name('activity.submit');
    Route::post('/activity/{activity}/grade', [StudentActivityController::class, 'grade'])->name('activity.grade');
});




// إشعارات الطالب و إعداداته
/*Route::middleware(['auth','role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');          // الإعدادات
    //Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications'); // الإشعارات
});*/

Route::post('/register/student', [AuthController::class, 'registerStudent'])->name('register.student');
Route::post('/register/teacher', [AuthController::class, 'registerTeacher'])->name('register.teacher');


//صفحة نسيت كلمة السر
Route::get('/forgot-password', [ForgotPasswordController::class, 'showEmailForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendOtp'])->name('password.email');

// صفحة الرمز
Route::get('/password/otp', [OtpController::class, 'showOtpForm'])->name('password.otp.show');
Route::post('/password/otp', [OtpController::class, 'verifyOtp'])->name('password.otp.verify');
Route::post('/password/otp/resend', [OtpController::class, 'resendOtp'])->name('password.otp.resend');

// صفحة إعادة التعيين بعد نجاح الرمز
Route::get('/reset-password', [NewPasswordController::class, 'create'])->name('password.reset.custom');
Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');

// تسجيل الخروج
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

/*Route::get('/test-role', function () {
    if (auth()->check()) {
        $user = auth()->user();
        dd($user->email, $user->getRoleNames());
    }
    return "Not logged in";
})->middleware('auth');*/



