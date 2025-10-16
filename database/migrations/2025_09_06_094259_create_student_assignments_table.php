<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('student_assignments', function (Blueprint $t) {
            $t->id();
            $t->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $t->foreignId('assignment_id')->constrained('assignments')->cascadeOnDelete();
            $t->string('submission_path')->nullable();
            $t->unsignedSmallInteger('score')->nullable();
            $t->timestamp('submitted_at')->nullable();
            $t->unique(['student_id','assignment_id']);
            $t->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('student_assignments');
    }
};
