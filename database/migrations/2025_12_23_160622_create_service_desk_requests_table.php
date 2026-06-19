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
        // Guard: skip if 'service_desk_requests' already exists (server may have it without a migration record).
        if (Schema::hasTable('service_desk_requests')) {
            return;
        }

        Schema::create('service_desk_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('booking_id')->nullable()->constrained()->onDelete('set null');
            $table->string('reference')->unique();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->string('service_type');
            $table->string('desk_type'); // catering, photography, videography, etc.
            $table->string('priority')->default('medium'); // low, medium, high
            $table->string('status')->default('pending'); // pending, active, closed
            $table->string('event_location')->nullable();
            $table->string('event_address')->nullable();
            $table->dateTime('event_date')->nullable();
            $table->integer('guest_count')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_desk_requests');
    }
};
