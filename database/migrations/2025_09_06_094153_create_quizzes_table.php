<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('quizzes', function (Blueprint $t) {
            $t->id();
            $t->foreignId('lesson_id')->constrained('lessons')->cascadeOnDelete();
            $t->string('title', 200);
            $t->unsignedSmallInteger('total_marks')->default(100);
            $t->timestamp('available_from')->nullable();
            $t->timestamp('available_to')->nullable();
            $t->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
