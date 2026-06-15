<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CorporateDashboardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure we have a corporate user
        $corporate = \App\Models\User::firstOrCreate(
            ['email' => 'corporate@eventy.pk'],
            [
                'name' => 'Enterprise Solutions Inc.',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'corporate',
                'business_name' => 'Enterprise Solutions Inc.',
                'business_type' => 'Head Office',
            ]
        );

        // Ensure cities have provinces and regions
        $isb = \App\Models\City::where('name', 'Islamabad')->first();
        if ($isb) {
            $isb->update(['province' => 'ICT', 'region' => 'North']);
        }

        $lhr = \App\Models\City::where('name', 'Lahore')->first();
        if ($lhr) {
            $lhr->update(['province' => 'Punjab', 'region' => 'Central']);
        }

        $khi = \App\Models\City::where('name', 'Karachi')->first();
        if ($khi) {
            $khi->update(['province' => 'Sindh', 'region' => 'South']);
        }

        // Create sample bookings if they don't exist
        $services = \App\Models\Service::take(5)->get();
        
        foreach ($services as $index => $service) {
            \App\Models\Booking::create([
                'user_id' => $corporate->id,
                'service_id' => $service->id,
                'vendor_id' => $service->user_id,
                'booking_date' => now()->addDays($index * 5),
                'status' => ['pending', 'confirmed', 'in_progress', 'completed', 'cancelled'][$index % 5],
                'total_price' => rand(50000, 500000),
                'department' => ['Logistics', 'Marketing', 'Executive', 'HR'][$index % 4],
                'cost_center' => 'CC-' . rand(100, 999),
                'event_type' => 'Conference',
                'event_size' => 'Medium (50-200)',
                'payout_status' => $index % 2 == 0 ? 'Paid' : 'Pending',
                'corporate_pricing' => true,
            ]);
        }
    }
}
