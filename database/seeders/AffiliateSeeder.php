<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\AffiliateLead;
use App\Models\AffiliateCommission;

class AffiliateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Affiliate User
        $affiliate = User::create([
            'name' => 'Affiliate User',
            'email' => 'affiliate@eventy.pk',
            'password' => Hash::make('password'),
            'role' => 'affiliate',
        ]);

        // Create some dummy leads
        AffiliateLead::create([
            'affiliate_id' => $affiliate->id,
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'status' => 'new',
            'source' => 'link',
        ]);

        AffiliateLead::create([
            'affiliate_id' => $affiliate->id,
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'status' => 'verified',
            'source' => 'social',
        ]);

        AffiliateLead::create([
            'affiliate_id' => $affiliate->id,
            'name' => 'Completed Client',
            'email' => 'client@example.com',
            'status' => 'converted',
            'source' => 'banner',
        ]);

        // Create dummy commission
        AffiliateCommission::create([
            'affiliate_id' => $affiliate->id,
            'amount' => 1500.00,
            'status' => 'pending',
            'description' => 'Commission for Booking #101',
        ]);

         AffiliateCommission::create([
            'affiliate_id' => $affiliate->id,
            'amount' => 5000.00,
            'status' => 'paid',
            'description' => 'Commission for Booking #99',
        ]);
    }
}
