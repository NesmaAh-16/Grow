<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {

        if (\Illuminate\Support\Facades\Schema::hasTable('assignments')) {
            return; // الجدول موجود، لا تعمل شيء
        }

        Schema::create('assignments', function (Blueprint $t) {
            $t->id();
            $t->foreignId('lesson_id')->constrained('lessons')->cascadeOnDelete();
            $t->string('title', 200);
            $t->longText('description')->nullable();
            $t->string('file_path')->nullable(); // مرفقات الواجب
            $t->timestamp('due_at')->nullable();
            $t->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
