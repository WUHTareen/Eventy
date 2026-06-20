<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('homepage_media')) {
            return;
        }

        Schema::create('homepage_media', function (Blueprint $table) {
            $table->id();
            $table->string('section')->index(); // corporate_card | video_tile | landmark | avatar
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('badge')->nullable();
            $table->string('tag')->nullable();
            $table->string('price')->nullable();
            $table->string('link')->nullable();
            $table->string('image')->nullable();
            $table->string('video')->nullable();
            $table->string('poster')->nullable();
            $table->json('meta')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('homepage_media');
    }
};
