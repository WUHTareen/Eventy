<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\User;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure we have a vendor
        $vendor = User::where('role', 'vendor')->first();
        if (!$vendor) {
             $vendor = User::create([
                'name' => 'Demo Vendor',
                'email' => 'vendor@eventy.pk',
                'password' => bcrypt('password'),
                'role' => 'vendor',
                'vendor_type' => 'Event Management',
                'is_verified' => true,
            ]);
        }

        // Create Services for specific categories
        $services = [
            [
                'cat_slug' => 'weddings-social',
                'name' => 'Heritage Haveli Wedding Experience',
                'description' => 'A royal wedding experience in a restored 17th-century haveli in Old Lahore with traditional decor and ambiance.',
                'price' => 1200000,
                'location' => 'Lahore, Pakistan',
                'image_url' => 'https://images.unsplash.com/photo-1519225421980-715cb0215aed?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'cat_slug' => 'int-tours',
                'name' => 'Hunza Valley Luxury Expedition',
                'description' => '7-day luxury tour of Hunza Valley including Attabad Lake, Altit Fort, and Eagle’s Nest stay.',
                'price' => 250000,
                'location' => 'Hunza, Pakistan',
                'image_url' => 'https://images.unsplash.com/photo-1627914041003-8515089e92d7?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'cat_slug' => 'wedding-catering',
                'name' => 'Mughlai Royal Catering Buffet',
                'description' => 'Authentic Mughlai cuisine featuring Nali Nihari, Dum Pukht Biryani, and traditional Sheer Khurma.',
                'price' => 3500,
                'location' => 'Karachi, Pakistan',
                'image_url' => 'https://images.unsplash.com/photo-1545231027-63b6f0a6d20f?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'cat_slug' => 'luxury-cars',
                'name' => 'Range Rover Vogue Protocol Service',
                'description' => 'Executive protocol service with Range Rover Vogue and trained security detail for high-profile events.',
                'price' => 45000,
                'location' => 'Islamabad, Pakistan',
                'image_url' => 'https://images.unsplash.com/photo-1541899481282-d53bffe3c35d?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'cat_slug' => 'resorts',
                'name' => 'Traditional Swati Boutique Resort',
                'description' => 'Boutique resort stay in Swat featuring traditional wooden architecture and riverside views.',
                'price' => 18000,
                'location' => 'Swat, Pakistan',
                'image_url' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'cat_slug' => 'event-media',
                'name' => 'Cinematic Drone & 8K Wedding Filmery',
                'description' => 'State-of-the-art 8K cinematography with FPV drone coverage for grand wedding celebrations.',
                'price' => 280000,
                'location' => 'Lahore, Pakistan',
                'image_url' => 'https://images.unsplash.com/photo-1502920917128-1aa500764cbd?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'cat_slug' => 'int-tours',
                'name' => 'Bolan Desert Safari & Cultural Night',
                'description' => 'Thrilling desert safari in Bolan followed by a traditional Balochi Sajji night under the stars.',
                'price' => 65000,
                'location' => 'Quetta, Pakistan',
                'image_url' => 'https://images.unsplash.com/photo-1451186859696-371d9477be93?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'cat_slug' => 'stall-fab',
                'name' => 'Artisan Expo Pavilion Design',
                'description' => 'Customized exhibition stall fabrication featuring traditional Pakistani artisan motifs and modern ergonomics.',
                'price' => 450000,
                'location' => 'Faisalabad, Pakistan',
                'image_url' => 'https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'cat_slug' => 'concerts-festivals',
                'name' => 'Khowar Folk Music & Sufi Night',
                'description' => 'Soulful evening of Khowar folk music and Sufi Qawwali featuring renowned local artists from Chitral.',
                'price' => 120000,
                'location' => 'Chitral, Pakistan',
                'image_url' => 'https://images.unsplash.com/photo-1541689592655-f5f52827a3b1?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'cat_slug' => 'security-protocol',
                'name' => 'Executive Event Security Detail',
                'description' => 'Elite security and crowd management services for corporate galas and high-profile private events.',
                'price' => 75000,
                'location' => 'Karachi, Pakistan',
                'image_url' => 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=800&q=80',
            ],
        ];

        foreach ($services as $data) {
            $catSlug = $data['cat_slug'];
            // Try to find subcategory first
            $category = ServiceCategory::where('slug', $catSlug)->first();
            
            // If not found, map to a parent loosely (Transport example)
            if (!$category && $catSlug == 'car-rentals') {
                $category = ServiceCategory::where('slug', 'transport')->first();
            }

            if ($category) {
                Service::create([
                    'user_id' => $vendor->id,
                    'category_id' => $category->id,
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'price' => $data['price'],
                    'location' => $data['location'],
                    'image' => $data['image_url'] ?? null, // Use URL directly in image column for now
                    'status' => 'active',
                    'is_featured' => true,
                ]);
            }
        }
    }
}
