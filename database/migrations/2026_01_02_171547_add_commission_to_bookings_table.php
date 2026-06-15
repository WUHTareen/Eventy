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
            $table->decimal('commission_fee', 10, 2)->default(0)->after('total_price');
            $table->decimal('vendor_net_amount', 10, 2)->default(0)->after('commission_fee');
            $table->string('payout_status')->default('pending')->after('vendor_net_amount'); // pending, paid
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['commission_fee', 'vendor_net_amount', 'payout_status']);
        });
    }
};
