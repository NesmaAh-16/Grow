<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $t->foreignId('lesson_id')->constrained('lessons')->cascadeOnDelete();
            $t->timestamp('enrolled_at')->useCurrent();
            $t->unique(['user_id', 'lesson_id']);
        });

    }

   
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
