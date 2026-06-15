<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        User::updateOrCreate(
            ['email' => 'admin@eventy.pk'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]
        );

        // Vendor User
        User::updateOrCreate(
            ['email' => 'vendor@eventy.pk'],
            [
                'name' => 'Vendor One',
                'password' => bcrypt('password'),
                'role' => 'vendor',
                'is_verified' => true,
            ]
        );

        // Normal User
        User::updateOrCreate(
            ['email' => 'user@eventy.pk'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
                'role' => 'user',
            ]
        );

        $this->call([
            ServiceCategorySeeder::class,
            ServiceSeeder::class,
        ]);
    }
}
