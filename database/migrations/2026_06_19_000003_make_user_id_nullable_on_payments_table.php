<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        if (\Illuminate\Support\Facades\DB::getDriverName() === 'sqlite') {
            // SQLite has no portable ALTER COLUMN; rebuild the table with user_id nullable
            // so local/test environments match the nullable behavior applied on MySQL.
            $db = \Illuminate\Support\Facades\DB::class;
            \Illuminate\Support\Facades\DB::statement('PRAGMA foreign_keys=OFF');
            $createSql = \Illuminate\Support\Facades\DB::selectOne("SELECT sql FROM sqlite_master WHERE type='table' AND name='payments'")->sql;
            $newSql = preg_replace('/"user_id"\s+integer\s+not\s+null/i', '"user_id" integer', $createSql, 1);
            \Illuminate\Support\Facades\DB::statement(str_replace('"payments"', '"payments_tmp"', $newSql));
            $columns = collect(\Illuminate\Support\Facades\DB::select("PRAGMA table_info(payments)"))->pluck('name')->implode(', ');
            \Illuminate\Support\Facades\DB::statement("INSERT INTO payments_tmp ({$columns}) SELECT {$columns} FROM payments");
            \Illuminate\Support\Facades\DB::statement('DROP TABLE payments');
            \Illuminate\Support\Facades\DB::statement('ALTER TABLE payments_tmp RENAME TO payments');
            \Illuminate\Support\Facades\DB::statement('PRAGMA foreign_keys=ON');
        } else {
            \Illuminate\Support\Facades\DB::statement(
                'ALTER TABLE payments MODIFY user_id BIGINT UNSIGNED NULL'
            );
        }

        Schema::table('payments', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        \Illuminate\Support\Facades\DB::statement(
            'ALTER TABLE payments MODIFY user_id BIGINT UNSIGNED NOT NULL'
        );

        Schema::table('payments', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }
};
