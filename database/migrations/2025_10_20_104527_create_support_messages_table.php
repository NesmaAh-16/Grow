<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('support_messages', function (Blueprint $t) {
            $t->id();

            $t->foreignId('created_by_user_id')->constrained('users')->cascadeOnDelete();

            $t->foreignId('student_user_id')->nullable()->constrained('users')->nullOnDelete();
            $t->foreignId('teacher_user_id')->nullable()->constrained('users')->nullOnDelete();
            $t->foreignId('admin_user_id')->nullable()->constrained('users')->nullOnDelete();

            $t->string('subject')->nullable();
            $t->text('message');
            $t->text('response')->nullable(); 
            $t->enum('status', ['open','answered','closed'])->default('open');

            $t->timestamps();
            $t->index(['status']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('support_messages');
    }
};
