<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('student_quizzes', function (Blueprint $t) {
            $t->id();
            $t->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $t->foreignId('quiz_id')->constrained('quizzes')->cascadeOnDelete();
            $t->unsignedSmallInteger('score')->nullable();
            $t->timestamp('attempted_at')->useCurrent();
            $t->unique(['student_id','quiz_id']);
            $t->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('student_quizzes');
    }
};
