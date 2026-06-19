<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Guard: skip if 'hotels' already exists (server may have it without a migration record).
        if (Schema::hasTable('hotels')) {
            return;
        }

        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // vendor user
            $table->foreignId('city_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('star_rating')->default('3'); // 1-5 stars
            $table->string('cover_image')->nullable();
            $table->json('images')->nullable();
            $table->json('amenities')->nullable(); // wifi, pool, parking etc
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });

        Schema::create('hotel_rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained()->onDelete('cascade');
            $table->string('name'); // Deluxe, Standard, Suite etc
            $table->text('description')->nullable();
            $table->integer('capacity')->default(2); // max persons
            $table->decimal('price_per_night', 10, 2);
            $table->integer('total_rooms')->default(1);
            $table->json('amenities')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });

        Schema::create('hotel_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // customer
            $table->foreignId('hotel_id')->constrained()->onDelete('cascade');
            $table->foreignId('hotel_room_id')->constrained()->onDelete('cascade');
            $table->date('check_in');
            $table->date('check_out');
            $table->integer('nights');
            $table->integer('guests')->default(1);
            $table->decimal('room_price', 10, 2);
            $table->decimal('total_amount', 10, 2);
            $table->decimal('commission_amount', 10, 2)->default(0);
            $table->decimal('vendor_amount', 10, 2)->default(0);
            $table->string('status')->default('pending'); // pending, confirmed, cancelled, completed
            $table->string('payment_status')->default('unpaid'); // unpaid, paid
            $table->string('payment_intent_id')->nullable();
            $table->text('special_requests')->nullable();
            $table->string('guest_name')->nullable();
            $table->string('guest_phone')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hotel_bookings');
        Schema::dropIfExists('hotel_rooms');
        Schema::dropIfExists('hotels');
    }
};
