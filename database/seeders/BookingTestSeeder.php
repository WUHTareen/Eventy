<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class BookingTestSeeder extends Seeder
{
    public function run(): void
    {
        // Customer
        User::firstOrCreate(
            ['email' => 'customer@test.com'],
            ['name' => 'Customer', 'password' => Hash::make('password'), 'role' => 'user']
        );

        // Vendor
        $vendor = User::firstOrCreate(
            ['email' => 'vendor_final@test.com'],
            [
                'name' => 'Vendor Final',
                'password' => Hash::make('password'),
                'role' => 'vendor',
                'is_verified' => true,
                'vendor_type' => 'Home Services'
            ]
        );

        // Service
        if ($vendor->services()->count() == 0) {
            $vendor->services()->create([
                'title' => 'Test Plumbing Service',
                'description' => 'A verified service for testing bookings.',
                'price' => 75.00,
                'image' => null
            ]);
        }
    }
}
