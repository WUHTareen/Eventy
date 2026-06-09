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
        Schema::table('bookings', function (Blueprint $table) {
            // Contact Information
            $table->string('customer_name')->nullable()->after('notes');
            $table->string('customer_phone')->nullable()->after('customer_name');
            $table->string('customer_email')->nullable()->after('customer_phone');
            
            // Event Details
            $table->string('event_type')->nullable()->after('customer_email');
            $table->dateTime('event_end_date')->nullable()->after('event_type');
            $table->string('event_location')->nullable()->after('event_end_date');
            $table->string('event_address')->nullable()->after('event_location');
            
            // Guest & Budget
            $table->integer('guest_count')->nullable()->after('event_address');
            $table->decimal('budget', 12, 2)->nullable()->after('guest_count');
            
            // Additional Info
            $table->text('special_requests')->nullable()->after('budget');
            $table->json('booking_data')->nullable()->after('special_requests');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'customer_name', 'customer_phone', 'customer_email',
                'event_type', 'event_end_date', 'event_location', 'event_address',
                'guest_count', 'budget', 'special_requests', 'booking_data'
            ]);
        });
    }
};

