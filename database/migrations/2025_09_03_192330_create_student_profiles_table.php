<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create("student_profiles", function (Blueprint $t) {
            $t->id();
            $t->foreignId("user_id")->unique()->constrained("users")->cascadeOnDelete();
            $t->string("national_id", 64)->unique();
            $t->unsignedTinyInteger("grade")->nullable();
            $t->string("semester", 20)->nullable();
            $t->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists("student_profiles");
    }
};
