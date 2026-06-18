<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Guard: 'favorites' table is already created by an earlier migration
        // (2025_12_30_154529_create_favorites_table). This duplicate migration
        // is kept only so its record stays in the migrations table; skip if exists.
        if (Schema::hasTable('favorites')) {
            return;
        }

        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
