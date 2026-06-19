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
        // Guard: skip if 'custom_package_services' already exists (server may have it without a migration record).
        if (Schema::hasTable('custom_package_services')) {
            return;
        }

        Schema::create('custom_package_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('custom_package_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_package_services');
    }
};
