<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $t) {
            if (!Schema::hasColumn('users', 'user_type')) {
                $t->enum('user_type', ['student','teacher','admin','user-admin'])
                  ->nullable()->index()->after('phone');
            }

            if (!Schema::hasColumn('users', 'national_id')) {
                $t->string('national_id', 32)->nullable()->after('username');
            }
        });

        DB::statement("
            ALTER TABLE `users`
            MODIFY `status` ENUM('active','inactive','blocked','pending')
            NOT NULL DEFAULT 'pending'
        ");

        DB::statement("
            CREATE UNIQUE INDEX IF NOT EXISTS users_national_id_unique
            ON `users` (`national_id`)
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE `users`
            MODIFY `status` ENUM('active','inactive','blocked')
            NOT NULL DEFAULT 'active'
        ");

        Schema::table('users', function (Blueprint $t) {
            if (Schema::hasColumn('users', 'user_type')) {
                $t->dropColumn('user_type');
            }
        });
    }
};
