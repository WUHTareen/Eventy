<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            if (! Schema::hasColumn('payments', 'payment_proof')) {
                $table->string('payment_proof')->nullable()->after('payment_method');
            }
            if (! Schema::hasColumn('payments', 'transaction_reference')) {
                $table->string('transaction_reference')->nullable()->after('payment_proof');
            }
            if (! Schema::hasColumn('payments', 'sender_name')) {
                $table->string('sender_name')->nullable()->after('transaction_reference');
            }
            if (! Schema::hasColumn('payments', 'admin_notes')) {
                $table->text('admin_notes')->nullable()->after('sender_name');
            }
            if (! Schema::hasColumn('payments', 'verified_at')) {
                $table->timestamp('verified_at')->nullable()->after('admin_notes');
            }
            if (! Schema::hasColumn('payments', 'verified_by')) {
                $table->unsignedBigInteger('verified_by')->nullable()->after('verified_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn([
                'payment_proof',
                'transaction_reference',
                'sender_name',
                'admin_notes',
                'verified_at',
                'verified_by',
            ]);
        });
    }
};
