<?php
// database/migrations/2025_10_20_104527_create_support_messages_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('support_messages', function (Blueprint $t) {
            $t->id();

            // مين أنشأ الرسالة (أي حساب)
            $t->foreignId('created_by_user_id')->constrained('users')->cascadeOnDelete();

            // أطراف الرسالة (اختياري): طالب/معلم/أدمن - كلهم يربطوا على users.id
            $t->foreignId('student_user_id')->nullable()->constrained('users')->nullOnDelete();
            $t->foreignId('teacher_user_id')->nullable()->constrained('users')->nullOnDelete();
            $t->foreignId('admin_user_id')->nullable()->constrained('users')->nullOnDelete();

            $t->string('subject')->nullable();
            $t->text('message');              // نص البلاغ/الاستفسار
            $t->text('response')->nullable(); // رد إداري بسيط (لو بدك ثريد نعمل جدول replies لاحقًا)
            $t->enum('status', ['open','answered','closed'])->default('open');

            $t->timestamps();
            $t->index(['status']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('support_messages');
    }
};
