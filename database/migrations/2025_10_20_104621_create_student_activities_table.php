<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('student_activities', function (Blueprint $t) {
            $t->id();

            $t->foreignId('student_user_id')->constrained('users')->cascadeOnDelete();
            $t->foreignId('teacher_user_id')->nullable()->constrained('users')->nullOnDelete();

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
