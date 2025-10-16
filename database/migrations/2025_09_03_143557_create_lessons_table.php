<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lessons', function (Blueprint $t) {
            $t->id();
            $t->foreignId('teacher_id')->constrained('users')->cascadeOnDelete();//teacher
            $t->string('title', 200);
            $t->string('subject', 120)->nullable();
            $t->longText('content')->nullable();
            $t->string('file_path')->nullable();
            $t->unsignedTinyInteger('grade')->nullable();
            $t->timestamp('published_at')->nullable();
            $t->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
