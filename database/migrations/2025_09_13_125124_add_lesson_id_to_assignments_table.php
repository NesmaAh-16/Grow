<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('assignments', function (Blueprint $table) {
            if (!Schema::hasColumn('assignments', 'lesson_id')) {
                $table->foreignId('lesson_id')
                      ->nullable()
                      ->constrained('lessons')
                      ->cascadeOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('assignments', function (Blueprint $table) {
            if (Schema::hasColumn('assignments', 'lesson_id')) {
                $table->dropForeign(['lesson_id']);
                $table->dropColumn('lesson_id');
            }
        });
    }
};
