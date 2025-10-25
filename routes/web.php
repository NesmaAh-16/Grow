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
use App\Http\Controllers\Admin\ADashboardController;
use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Teacher\QuestionController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Teacher\AssignmentController;
use App\Http\Controllers\Teacher\AttachmentController;
use App\Http\Controllers\UserAdmin\StudentsController;
use App\Http\Controllers\UserAdmin\TeachersController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\UserAdmin\ApprovalsController;
use App\Http\Controllers\UserAdmin\DashboardController;
use App\Http\Controllers\Admin\SystemSettingsController;
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

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register/student', [AuthController::class, 'registerStudent'])->name('register.student');
    Route::post('/register/teacher', [AuthController::class, 'registerTeacher'])->name('register.teacher');
});



Route::middleware(['role:teacher|student'])->prefix('lessons')->name('lessons.')->group(function () {
    //Route::get('/lessons', [LessonController::class, 'index'])->name('lessons.index');
    Route::get('/details', [LessonController::class, 'details'])->name('details');//math
    Route::get('/arabic', [LessonController::class, 'arabic'])->name('arabic');//arabic
    Route::get('/english', [LessonController::class, 'english'])->name('english');//arabic
    Route::get('/science', [LessonController::class, 'science'])->name('science');//arabic

    Route::get('/', [LessonController::class, 'index'])->name('index');   //
    Route::get('/create', [LessonController::class, 'create'])->name('create'); // فحة
    Route::post('/', [LessonController::class, 'store'])->name('store');   // حفظ جديد
    Route::get('/{lesson}', [LessonController::class, 'show'])->name('show');     // عرض
    Route::get('/{lesson}/edit', [LessonController::class, 'edit'])->name('edit');   // صفحة تعديل
    Route::put('/{lesson}', [LessonController::class, 'update'])->name('update'); // حفظ تعديل
    Route::delete('/{lesson}', [LessonController::class, 'destroy'])->name('destroy'); // حذف
});




Route::middleware(['auth', 'role:teacher'])->group(function () {
    Route::get(
        '/teacher/dashboard',
        [TeacherController::class, 'index']
    )->name('teacher.dashboard');




    Route::get('/assignments', [AssignmentController::class, 'index'])->name('assignments.index');
    Route::get('/assignments/create', [AssignmentController::class, 'create'])->name('assignments.create');
    Route::post('/assignments', [AssignmentController::class, 'store'])->name('assignments.store');

    Route::get('/assignments/{assignment}', [AssignmentController::class, 'show'])->name('assignments.show');
    Route::get('/assignments/{assignment}/edit', [AssignmentController::class, 'edit'])->name('assignments.edit');
    Route::put('/assignments/{assignment}', [AssignmentController::class, 'update'])->name('assignments.update');
    Route::delete('/assignments/{assignment}', [AssignmentController::class, 'destroy'])->name('assignments.destroy');
    Route::delete(
        '/assignments/{assignment}/attachments/{attachment}',
        [AttachmentController::class, 'destroy']
    )->name('assignments.attachments.destroy');


    Route::get('/quizzes', [QuizController::class, 'index'])->name('quizzes.index');
    Route::get('/quizzes/create', [QuizController::class, 'create'])->name('quizzes.create'); //first page quiz create
    Route::post('/quizzes', [QuizController::class, 'store'])->name('quizzes.store');

    Route::get('/quizzes/{quiz}/questions/createContinue', [QuestionController::class, 'createContinue'])
        ->whereNumber('quiz')
        ->name('quizzes.questions.createContinue');

    Route::post('/quizzes/{quiz}/questions', [QuestionController::class, 'store'])
        ->whereNumber('quiz')
        ->name('quizzes.questions.store');
    Route::get('/quizzes/{quiz}/edit', [\App\Http\Controllers\Teacher\QuizController::class, 'edit'])->name('quizzes.edit');
    Route::put('/quizzes/{quiz}', [QuizController::class, 'update'])->name('quizzes.update');
    Route::delete('/quizzes/{quiz}', [\App\Http\Controllers\Teacher\QuizController::class, 'destroy'])->name('quizzes.destroy');
    Route::get('/quizzes/{quiz}/attempt', [\App\Http\Controllers\Teacher\QuizController::class, 'attempt'])
        ->whereNumber('quiz')->name('quizzes.attempt');

    Route::post('/quizzes/{quiz}/attempt', [\App\Http\Controllers\Teacher\QuizController::class, 'submitAttempt'])
        ->whereNumber('quiz')->name('quizzes.attempt.submit');

    Route::get('/quizzes/{quiz}/results', [QuizController::class, 'results'])->name('quizzes.results');
    Route::get('/quizzes/{quiz}', [QuizController::class, 'show'])->name('quizzes.show');


});

Route::middleware(['auth'])->group(function () {

});
/*Route::prefix('')
    ->middleware(['auth'])
    ->name('student.')
    ->group(function () {
        Route::get('/dashboard', [StudentDashboardController::class, 'index'])
            ->name('dashboard');
    });*/

    Route::middleware(['auth','role:student'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Student\StudentDashboardController::class, 'index'])
        ->name('student.dashboard');

    Route::prefix('student')->name('student.')->group(function () {
        Route::get('/settings',              [SettingsController::class, 'index'])->name('settings');
        Route::post('/settings/profile',     [SettingsController::class, 'updateProfile'])->name('settings.profile');
    });
    Route::middleware(['auth','role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/assignments', [StudentAssignmentController::class, 'index'])->name('assignments.index');
    Route::get('/assignments/{assignment}', [StudentAssignmentController::class, 'show'])->name('assignments.show');
    Route::get('/assignments/{assignment}/submit', [StudentAssignmentController::class, 'createSubmission'])->name('assignments.submit');
    Route::post('/assignments/{assignment}/submit', [StudentAssignmentController::class, 'storeSubmission'])->name('assignments.submit.store');
});

});


Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [ADashboardController::class, 'index'])->name('dashboard');

    Route::prefix('admins')->name('admins.')->group(function () {
        Route::get('/', [AdminUsersController::class, 'index'])->name('index');
        Route::get('/create', [AdminUsersController::class, 'create'])->name('create');
        Route::post('/', [AdminUsersController::class, 'store'])->name('store');
        Route::get('/{user}', [AdminUsersController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [AdminUsersController::class, 'edit'])->name('edit');
        Route::put('/{user}', [AdminUsersController::class, 'update'])->name('update');
        Route::delete('/{user}', [AdminUsersController::class, 'destroy'])->name('delete');
    });

    Route::get('/settings', [SystemSettingsController::class, 'edit'])->name('system.settings');
    Route::put('/settings', [SystemSettingsController::class, 'update'])->name('system.settings.update');

    Route::prefix('permissions')->name('permissions.')->group(function () {
        Route::get('/', [PermissionsController::class, 'index'])->name('index');
        Route::post('/sync', [PermissionsController::class, 'assignToRole'])->name('store');
        Route::post('/add', [PermissionsController::class, 'storePermission'])->name('add');
        Route::delete('/delete', [PermissionsController::class, 'deletePermission'])->name('delete');
    });
});


Route::middleware(['auth', 'role:user-admin'])
    ->prefix('user-admin')
    ->name('user_admin.')
    ->group(function () {


        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/users/all', [DashboardController::class, 'allUsers'])
            ->name('users.all');

        Route::get('/students', [StudentsController::class, 'index'])->name('students');
        Route::get('/students/create', [StudentsController::class, 'create'])->name('students.create');
        Route::post('/students', [StudentsController::class, 'store'])->name('students.store');

        Route::get('/students/{user}', [StudentsController::class, 'show'])->name('students.show');
        Route::get('/students/{user}/edit', [StudentsController::class, 'edit'])->name('students.edit');
        Route::put('/students/{user}', [StudentsController::class, 'update'])->name('students.update');
        Route::delete('/students/{user}', [StudentsController::class, 'destroy'])->name('students.delete');

        Route::post('/students/{user}/activate', [StudentsController::class, 'activate'])->name('students.activate');
        Route::post('/students/{user}/deactivate', [StudentsController::class, 'deactivate'])->name('students.deactivate');


        Route::get('/teachers', [TeachersController::class, 'index'])->name('teachers');

        Route::get('/teachers/create', [TeachersController::class, 'create'])->name('teachers.create');
        Route::post('/teachers', [TeachersController::class, 'store'])->name('teachers.store');

        Route::get('/teachers/{user}', [TeachersController::class, 'show'])->name('teachers.show');
        Route::get('/teachers/{user}/edit', [TeachersController::class, 'edit'])->name('teachers.edit');
        Route::put('/teachers/{user}', [TeachersController::class, 'update'])->name('teachers.update');
        Route::delete('/teachers/{user}', [TeachersController::class, 'destroy'])
            ->name('teachers.delete');
        Route::post('/teachers/{user}/activate', [TeachersController::class, 'activate'])->name('teachers.activate');
        Route::post('/teachers/{user}/deactivate', [TeachersController::class, 'deactivate'])->name('teachers.deactivate');

        Route::get('/approvals', [ApprovalsController::class, 'index'])->name('approvals');
        Route::post('/approvals/{user}/approve', [ApprovalsController::class, 'approve'])->name('approvals.approve');
        Route::post('/approvals/{user}/reject', [ApprovalsController::class, 'reject'])->name('approvals.reject');
    });

Route::middleware('auth')->group(function () {

    Route::post('/support', [SupportMessageController::class, 'store'])->name('support.store');
    Route::get('/support', [SupportMessageController::class, 'index'])
        ->name('support.index');
    Route::post('/support/{supportMessage}/reply', [SupportMessageController::class, 'reply'])->name('support.reply');

    Route::post('/activity/submit', [StudentActivityController::class, 'submit'])->name('activity.submit');
    Route::post('/activity/{activity}/grade', [StudentActivityController::class, 'grade'])->name('activity.grade');
});

Route::post('/register/student', [AuthController::class, 'registerStudent'])->name('register.student');
Route::post('/register/teacher', [AuthController::class, 'registerTeacher'])->name('register.teacher');

Route::get('/forgot-password', [ForgotPasswordController::class, 'showEmailForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendOtp'])->name('password.email');

Route::get('/password/otp', [OtpController::class, 'showOtpForm'])->name('password.otp.show');
Route::post('/password/otp', [OtpController::class, 'verifyOtp'])->name('password.otp.verify');
Route::post('/password/otp/resend', [OtpController::class, 'resendOtp'])->name('password.otp.resend');

Route::get('/reset-password', [NewPasswordController::class, 'create'])->name('password.reset.custom');
Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');


