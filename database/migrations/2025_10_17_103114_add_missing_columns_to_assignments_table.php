<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('assignments', function (Blueprint $t) {
            if (!Schema::hasColumn('assignments','title')) {
                $t->string('title', 200)->after('lesson_id');
            }
            if (!Schema::hasColumn('assignments','description')) {
                $t->longText('description')->nullable()->after('title');
            }
            if (!Schema::hasColumn('assignments','file_path')) {
                $t->string('file_path')->nullable()->after('description');
            }
            if (!Schema::hasColumn('assignments','due_at')) {
                $t->timestamp('due_at')->nullable()->after('file_path');
            }
        });
    }

    public function down(): void {
        Schema::table('assignments', function (Blueprint $t) {
            if (Schema::hasColumn('assignments','due_at'))      $t->dropColumn('due_at');
            if (Schema::hasColumn('assignments','file_path'))   $t->dropColumn('file_path');
            if (Schema::hasColumn('assignments','description')) $t->dropColumn('description');
            if (Schema::hasColumn('assignments','title'))       $t->dropColumn('title');
        });
    }
};
