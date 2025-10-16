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
        // php artisan make:migration create_questions_table
        Schema::create('questions', function (Blueprint $t) {
            $t->id();
            $t->foreignId('quiz_id')->constrained('quizzes')->cascadeOnDelete();
            $t->string('type', 10);                 // mc | tf
            $t->text('text');                       // نص السؤال
            $t->json('options')->nullable();        // ["أ","ب","ج","د"] للأسئلة MC
            $t->unsignedTinyInteger('correct')->nullable(); // 1..4 للأسئلة MC
            $t->boolean('correct_tf')->nullable();  // true/false ل TF
            $t->unsignedSmallInteger('points')->default(1);
            $t->unsignedSmallInteger('ord')->default(1);
            $t->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
