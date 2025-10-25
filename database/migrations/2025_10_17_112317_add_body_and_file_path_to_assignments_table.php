<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    
    public function up(): void
    {
        if (!Schema::hasColumn('assignments', 'body')) {
            Schema::table('assignments', function (Blueprint $table) {
                $table->text('body')->nullable()->after('title');
            });
        }

        if (!Schema::hasColumn('assignments', 'file_path')) {
            Schema::table('assignments', function (Blueprint $table) {
                $table->string('file_path')->nullable()->after('body');
            });
        }
    }

    public function down(): void
    {
        Schema::table('assignments', function (Blueprint $table) {
            if (Schema::hasColumn('assignments', 'body')) {
                $table->dropColumn('body');
            }
            if (Schema::hasColumn('assignments', 'file_path')) {
                $table->dropColumn('file_path');
            }
        });
    }

};
