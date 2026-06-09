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
        Schema::create('budget_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('service_type'); // wedding, corporate, birthday, tour, destination, other
            $table->string('location');
            $table->integer('guests')->nullable();
            $table->decimal('budget', 12, 2);
            $table->json('services_needed')->nullable(); // venue, catering, decor, photography, transport, hotel, flights, entertainment
            $table->string('status')->default('pending'); // pending, quoted, booked, completed
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budget_requests');
    }
};
