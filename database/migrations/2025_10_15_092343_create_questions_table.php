<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('questions', function (Blueprint $t) {
            $t->id();
            $t->foreignId('quiz_id')->constrained('quizzes')->cascadeOnDelete();
            $t->string('type', 10);
            $t->text('text');
            $t->json('options')->nullable();
            $t->unsignedTinyInteger('correct')->nullable();
            $t->boolean('correct_tf')->nullable();  
            $t->unsignedSmallInteger('points')->default(1);
            $t->unsignedSmallInteger('ord')->default(1);
            $t->timestamps();
        });

    }


    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
