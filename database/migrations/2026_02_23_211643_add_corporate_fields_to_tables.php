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
            if (!Schema::hasColumn('cities', 'province')) {
                $table->string('province')->nullable()->after('name');
            }
            if (!Schema::hasColumn('cities', 'region')) {
                $table->string('region')->nullable()->after('province');
            }
        });

        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'department')) {
                $table->string('department')->nullable();
                $table->string('cost_center')->nullable();
                $table->string('approval_level')->default('Level 1');
                $table->foreignId('assigned_admin_id')->nullable()->constrained('users')->onDelete('set null');
                $table->boolean('corporate_pricing')->default(false);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tables', function (Blueprint $table) {
            //
        });
    }
};
