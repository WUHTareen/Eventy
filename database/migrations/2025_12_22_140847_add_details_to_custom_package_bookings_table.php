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
        Schema::table('custom_package_bookings', function (Blueprint $table) {
            $table->string('customer_name')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('event_location')->nullable();
            $table->text('event_address')->nullable();
            $table->integer('guest_count')->nullable();
            $table->decimal('budget', 15, 2)->nullable();
            $table->text('special_requests')->nullable();
            $table->json('booking_data')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('custom_package_bookings', function (Blueprint $table) {
            $table->dropColumn([
                'customer_name',
                'customer_phone',
                'customer_email',
                'event_location',
                'event_address',
                'guest_count',
                'budget',
                'special_requests',
                'booking_data'
            ]);
        });
    }
};
