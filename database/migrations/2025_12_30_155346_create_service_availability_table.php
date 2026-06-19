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
        // Guard: skip if 'service_availability' already exists (server may have it without a migration record).
        if (Schema::hasTable('service_availability')) {
            return;
        }

        Schema::create('service_availability', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->date('unavailable_date');
            $table->string('reason')->nullable();
            $table->timestamps();

            $table->unique(['service_id', 'unavailable_date']); // Prevent duplicate blocks for same day
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_availability');
    }
};
