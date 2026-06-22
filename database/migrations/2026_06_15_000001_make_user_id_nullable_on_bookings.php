<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Allow guest bookings: user_id can be null
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        if (DB::getDriverName() === 'sqlite') {
            // SQLite has no portable ALTER COLUMN; rebuild the table with user_id nullable
            // so local/test environments match the nullable behavior applied on MySQL.
            DB::statement('PRAGMA foreign_keys=OFF');
            $createSql = DB::selectOne("SELECT sql FROM sqlite_master WHERE type='table' AND name='bookings'")->sql;
            $newSql = preg_replace('/"user_id"\s+integer\s+not\s+null/i', '"user_id" integer', $createSql, 1);
            DB::statement(str_replace('"bookings"', '"bookings_tmp"', $newSql));
            $columns = collect(DB::select("PRAGMA table_info(bookings)"))->pluck('name')->implode(', ');
            DB::statement("INSERT INTO bookings_tmp ({$columns}) SELECT {$columns} FROM bookings");
            DB::statement('DROP TABLE bookings');
            DB::statement('ALTER TABLE bookings_tmp RENAME TO bookings');
            DB::statement('PRAGMA foreign_keys=ON');
        } else {
            DB::statement('ALTER TABLE bookings MODIFY user_id BIGINT UNSIGNED NULL');
        }

        Schema::table('bookings', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        DB::statement('ALTER TABLE bookings MODIFY user_id BIGINT UNSIGNED NOT NULL');

        Schema::table('bookings', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }
};
