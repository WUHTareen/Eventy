<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Guard: 'site_settings' may already exist on servers where it was
        // created before this migration was recorded. Skip if it exists so
        // the migration can be marked as run without erroring.
        if (Schema::hasTable('site_settings')) {
            return;
        }

        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Default settings
        DB::table('site_settings')->insert([
            ['key' => 'site_name', 'value' => 'Eventy', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'site_email', 'value' => 'info@eventy.pk', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'site_phone', 'value' => '+92 300 0000000', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'site_address', 'value' => 'Pakistan', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'site_logo', 'value' => null, 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'site_favicon', 'value' => null, 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'footer_text', 'value' => '© 2025 Eventy. All rights reserved.', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'facebook_url', 'value' => '', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'instagram_url', 'value' => '', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'twitter_url', 'value' => '', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'whatsapp_number', 'value' => '', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'stripe_key', 'value' => '', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'stripe_secret', 'value' => '', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'commission_rate', 'value' => '10', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'meta_description', 'value' => 'Pakistan premier event management platform', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
