<?php
// database/migrations/2025_10_20_104528_create_student_activities_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('student_activities', function (Blueprint $t) {
            $t->id();

            // الطرفان الأساسيان كنُسخ من users.id
            $t->foreignId('student_user_id')->constrained('users')->cascadeOnDelete();
            $t->foreignId('teacher_user_id')->nullable()->constrained('users')->nullOnDelete();

            // روابط المحتوى (حسب عندك): ids افتراضيًا
            $t->foreignId('lesson_id')->nullable()->constrained('lessons')->nullOnDelete();
            $t->foreignId('quiz_id')->nullable()->constrained('quizzes')->nullOnDelete();
            $t->foreignId('assignment_id')->nullable()->constrained('assignments')->nullOnDelete();

            $t->enum('status', ['assigned','submitted','graded','late'])->default('assigned');
            $t->decimal('grade',5,2)->nullable();
            $t->timestamp('submitted_at')->nullable();

            $t->timestamps();
            $t->index(['student_user_id','quiz_id']);
            $t->index(['student_user_id','assignment_id']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('student_activities');
    }
};
