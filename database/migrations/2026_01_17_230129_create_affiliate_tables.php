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
        Schema::create('affiliate_leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('affiliate_id')->constrained('users')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('email')->nullable(); // For tracking potential leads
            $table->string('phone')->nullable();
            $table->string('status')->default('new'); // new, verified, converted
            $table->foreignId('converted_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('source')->nullable(); // link, banner, social
            $table->timestamps();
        });

        Schema::create('affiliate_commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('affiliate_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('booking_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('amount', 12, 2);
            $table->string('status')->default('pending'); // pending, available, paid
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('affiliate_resources', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('type'); // banner, link, template, tutorial
            $table->text('content')->nullable(); // URL or HTML content
            $table->string('thumbnail')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('affiliate_resources');
        Schema::dropIfExists('affiliate_commissions');
        Schema::dropIfExists('affiliate_leads');
    }
};
