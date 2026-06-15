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
        Schema::table('cities', function (Blueprint $table) {
            $table->index('province');
            $table->index('region');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->index('status');
            $table->index('booking_date');
            $table->index('total_price');
            $table->index('event_type');
            $table->index('department');
            $table->index('approval_level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('corporate_fields', function (Blueprint $table) {
            //
        });
    }
};
