<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('services', 'slug')) {
            Schema::table('services', function (Blueprint $table) {
                $table->string('slug')->nullable()->unique()->after('name');
            });
        }

        // Backfill slugs for existing services from their name, keeping them unique.
        $used = [];
        DB::table('services')->select('id', 'name', 'slug')->orderBy('id')->each(function ($service) use (&$used) {
            if (! empty($service->slug)) {
                $used[$service->slug] = true;
                return;
            }

            $base = Str::slug($service->name) ?: 'service';
            $slug = $base;
            $i = 2;
            while (isset($used[$slug]) || DB::table('services')->where('slug', $slug)->where('id', '!=', $service->id)->exists()) {
                $slug = $base . '-' . $i;
                $i++;
            }

            $used[$slug] = true;
            DB::table('services')->where('id', $service->id)->update(['slug' => $slug]);
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('services', 'slug')) {
            Schema::table('services', function (Blueprint $table) {
                $table->dropUnique(['slug']);
                $table->dropColumn('slug');
            });
        }
    }
};
