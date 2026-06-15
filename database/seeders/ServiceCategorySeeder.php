<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceCategory;

class ServiceCategorySeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing categories to avoid duplicates/orphans
        ServiceCategory::whereNotNull('parent_id')->delete();
        ServiceCategory::whereNull('parent_id')->delete();

        // Parent Categories
        $parents = [
            'events-management' => [
                'name' => 'Events',
                'icon' => 'fa-calendar-check',
                'description' => 'Corporate events, weddings, concerts, festivals, gala dinners',
                'color' => '#0A3A7A',
                'sort_order' => 1,
            ],
            'exhibitions-expos' => [
                'name' => 'Exhibitions, Expos & Stall Solutions',
                'icon' => 'fa-building-columns',
                'description' => 'Trade shows, stall design, sponsor coordination',
                'color' => '#ED1C24',
                'sort_order' => 2,
            ],
            'conferences-summits' => [
                'name' => 'Corporate Solutions',
                'icon' => 'fa-briefcase',
                'description' => 'International summits, speaker coordination, delegate registration',
                'color' => '#0A3A7A',
                'sort_order' => 3,
            ],
            'travel-hospitality' => [
                'name' => 'Travel Packages',
                'icon' => 'fa-suitcase-rolling',
                'description' => 'International travel, group tours, hotel bookings',
                'color' => '#1e3a5f',
                'sort_order' => 4,
            ],
            'flights-ticketing' => [
                'name' => 'Visa Services',
                'icon' => 'fa-passport',
                'description' => 'Visa processing, Air ticketing, rescheduling, customer support',
                'color' => '#ED1C24',
                'sort_order' => 5,
            ],
            'catering-food' => [
                'name' => 'Catering',
                'icon' => 'fa-utensils',
                'description' => 'Wedding & corporate catering, buffet, menu planning',
                'color' => '#0A3A7A',
                'sort_order' => 6,
            ],
            'transport-logistics' => [
                'name' => 'Transportation',
                'icon' => 'fa-car-side',
                'description' => 'Airport transfers, luxury cars, group transport',
                'color' => '#ED1C24',
                'sort_order' => 7,
            ],
            'venues-coordination' => [
                'name' => 'Hotels',
                'icon' => 'fa-hotel',
                'description' => 'Wedding halls, expo centers, resorts, luxury hotels',
                'color' => '#0A3A7A',
                'sort_order' => 8,
            ],
            'marketing-media' => [
                'name' => 'Brand Activations, Marketing & Media',
                'icon' => 'fa-camera-retro',
                'description' => 'Influencer marketing, photography, drone coverage',
                'color' => '#ED1C24',
                'sort_order' => 9,
            ],
            'branding-design' => [
                'name' => 'Event Branding, Design & Creative',
                'icon' => 'fa-pen-nib',
                'description' => 'Logos, banners, 3D stall design',
                'color' => '#0A3A7A',
                'sort_order' => 10,
            ],
            'vendor-operations' => [
                'name' => 'Vendor, Manpower & Operations',
                'icon' => 'fa-handshake',
                'description' => 'Staffing, security, logistics management',
                'color' => '#ED1C24',
                'sort_order' => 11,
            ],
            'government-mega-projects' => [
                'name' => 'Government, CSR & Mega Projects',
                'icon' => 'fa-landmark',
                'description' => 'Public sector events, awareness campaigns, mega expos',
                'color' => '#0A3A7A',
                'sort_order' => 12,
            ],
        ];

        foreach ($parents as $slug => $data) {
            $parent = ServiceCategory::create(array_merge($data, ['slug' => $slug]));

            // Add comprehensive subcategories for each
            $subs = [];
            switch ($slug) {
                case 'events-management':
                    $subs = [
                        ['name' => 'Corporate Events', 'slug' => 'corporate-events', 'icon' => 'fa-briefcase'],
                        ['name' => 'Weddings & Social', 'slug' => 'weddings-social', 'icon' => 'fa-rings-wedding'],
                        ['name' => 'Concerts & Festivals', 'slug' => 'concerts-festivals', 'icon' => 'fa-microphone'],
                        ['name' => 'Award Ceremonies', 'slug' => 'awards-gala', 'icon' => 'fa-trophy'],
                    ];
                    break;
                case 'exhibitions-expos':
                    $subs = [
                        ['name' => 'Expo Management', 'slug' => 'expo-mgmt', 'icon' => 'fa-tasks'],
                        ['name' => 'Stall Design & Fab', 'slug' => 'stall-fab', 'icon' => 'fa-tools'],
                        ['name' => 'Trade Show Solutions', 'slug' => 'trade-shows', 'icon' => 'fa-building-columns'],
                    ];
                    break;
                case 'conferences-summits':
                    $subs = [
                        ['name' => 'International Summits', 'slug' => 'int-summits', 'icon' => 'fa-earth-americas'],
                        ['name' => 'Delegate Registration', 'slug' => 'delegates', 'icon' => 'fa-id-card'],
                        ['name' => 'Speaker Coordination', 'slug' => 'speakers', 'icon' => 'fa-bullhorn'],
                    ];
                    break;
                case 'travel-hospitality':
                    $subs = [
                        ['name' => 'International Tours', 'slug' => 'int-tours', 'icon' => 'fa-globe-asia'],
                        ['name' => 'Family & Honeymoon', 'slug' => 'family-honeymoon', 'icon' => 'fa-heart'],
                        ['name' => 'VIP Handling', 'slug' => 'vip-hospitality', 'icon' => 'fa-user-tie'],
                    ];
                    break;
                case 'flights-ticketing':
                    $subs = [
                        ['name' => 'Domestic Flights', 'slug' => 'dom-flights', 'icon' => 'fa-plane-arrival'],
                        ['name' => 'Intl Flight Bookings', 'slug' => 'intl-flights', 'icon' => 'fa-plane-departure'],
                    ];
                    break;
                case 'catering-food':
                    $subs = [
                        ['name' => 'Wedding Catering', 'slug' => 'wedding-catering', 'icon' => 'fa-plate-wheat'],
                        ['name' => 'Corporate Buffets', 'slug' => 'corp-buffet', 'icon' => 'fa-hotdog'],
                        ['name' => 'Live Stations', 'slug' => 'live-cooking', 'icon' => 'fa-fire-burner'],
                    ];
                    break;
                case 'transport-logistics':
                    $subs = [
                        ['name' => 'Airport Transfers', 'slug' => 'airport-trans', 'icon' => 'fa-shuttle-van'],
                        ['name' => 'Luxury Car Rentals', 'slug' => 'luxury-cars', 'icon' => 'fa-car-side'],
                        ['name' => 'Guest Logistics', 'slug' => 'guest-transport', 'icon' => 'fa-bus'],
                    ];
                    break;
                case 'venues-coordination':
                    $subs = [
                        ['name' => 'Banquets & Halls', 'slug' => 'banquets', 'icon' => 'fa-landmark-dome'],
                        ['name' => 'Luxury Marquees', 'slug' => 'marquees', 'icon' => 'fa-tent'],
                        ['name' => 'Resort Venues', 'slug' => 'resorts', 'icon' => 'fa-umbrella-beach'],
                    ];
                    break;
                case 'marketing-media':
                    $subs = [
                        ['name' => 'Influencer Marketing', 'slug' => 'influencer-mkt', 'icon' => 'fa-mobile-screen'],
                        ['name' => 'Drone & Photography', 'slug' => 'event-media', 'icon' => 'fa-video'],
                        ['name' => 'Social Promotions', 'slug' => 'social-ads', 'icon' => 'fa-share-nodes'],
                    ];
                    break;
                case 'branding-design':
                    $subs = [
                        ['name' => 'Visual Identity', 'slug' => 'visual-id', 'icon' => 'fa-palette'],
                        ['name' => '3D Renderings', 'slug' => '3d-designs', 'icon' => 'fa-cube'],
                        ['name' => 'Print Media', 'slug' => 'print-media', 'icon' => 'fa-print'],
                    ];
                    break;
                case 'vendor-operations':
                    $subs = [
                        ['name' => 'Security & Protocol', 'slug' => 'security-protocol', 'icon' => 'fa-shield-halved'],
                        ['name' => 'Event Manpower', 'slug' => 'staffing', 'icon' => 'fa-users-gear'],
                        ['name' => 'On-Ground Ops', 'slug' => 'ground-ops', 'icon' => 'fa-clipboard-check'],
                    ];
                    break;
                case 'government-mega-projects':
                    $subs = [
                        ['name' => 'Public Campaigns', 'slug' => 'public-civic', 'icon' => 'fa-flag'],
                        ['name' => 'National Festivals', 'slug' => 'national-events', 'icon' => 'fa-star-of-david'],
                    ];
                    break;
            }

            foreach ($subs as $sub) {
                ServiceCategory::create(array_merge($sub, [
                    'parent_id' => $parent->id,
                    'color' => $parent->color,
                    'is_active' => true
                ]));
            }
        }
    }
}
