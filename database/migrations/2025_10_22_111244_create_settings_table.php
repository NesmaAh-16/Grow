<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $t) {
            $t->id();
            $t->string('site_name',190)->default('منصة التعليم Grow');
            $t->string('official_email',190)->default('contact@grow.com');
            $t->string('default_locale',5)->default('ar');
            $t->boolean('registration_open')->default(true);
            $t->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
