<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $t) {
            // أضف user_type إذا مش موجود
            if (!Schema::hasColumn('users', 'user_type')) {
                $t->enum('user_type', ['student','teacher','admin'])
                  ->nullable()->index()->after('phone');
            }

            // أضف national_id إذا مش موجود
            if (!Schema::hasColumn('users', 'national_id')) {
                $t->string('national_id', 32)->nullable()->after('username');
                // ملاحظة: إضافة UNIQUE ستكون لاحقاً لو غير موجودة
            }
        });

        // عدّل ENUM للـ status لإضافة pending
        DB::statement("
            ALTER TABLE `users`
            MODIFY `status` ENUM('active','inactive','blocked','pending')
            NOT NULL DEFAULT 'pending'
        ");

        // (اختياري) ضيف UNIQUE لـ national_id لو ما كان موجود
        // MySQL 8.0+ يدعم IF NOT EXISTS
        DB::statement("
            CREATE UNIQUE INDEX IF NOT EXISTS users_national_id_unique
            ON `users` (`national_id`)
        ");
    }

    public function down(): void
    {
        // رجّع status كما كان
        DB::statement("
            ALTER TABLE `users`
            MODIFY `status` ENUM('active','inactive','blocked')
            NOT NULL DEFAULT 'active'
        ");

        Schema::table('users', function (Blueprint $t) {
            if (Schema::hasColumn('users', 'user_type')) {
                $t->dropColumn('user_type');
            }
            // لا أحذف national_id في down إذا كان أصلاً موجود قبل هذه الميجريشن
            // لو أضفناه نحن فقط: احذفيه هنا حسب حاجتك
            // if (Schema::hasColumn('users', 'national_id')) { $t->dropColumn('national_id'); }
        });
    }
};
