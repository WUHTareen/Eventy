<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\User;
use App\Models\Booking;
use App\Http\Controllers\Admin\HomepageController;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Global Query Setup
        $query = Service::query()->with(['user', 'category']);

        // Check if any filtering is active
        $isSearching = $request->filled('category') || $request->filled('search') || 
                      $request->filled('vendor_name') || $request->filled('city') || 
                      $request->filled('event_type') || $request->filled('date') || 
                      $request->filled('dates') || $request->filled('guests');

        // Apply Filters
        if ($request->filled('category')) {
            $slug = $request->get('category');
            $category = \App\Models\ServiceCategory::where('slug', $slug)->first();
            if ($category) {
                $catIds = $category->children()->pluck('id')->push($category->id);
                $query->whereIn('category_id', $catIds);
            }
        }

        if ($request->filled('city')) {
            $city = trim(str_replace([' Hub', ' District', ' Node', ' Core', ' Grid', ' Prime', ' Atoll', ' Marina'], '', $request->city));
            $query->where('location', 'like', "%" . $city . "%");
        }

        if ($request->filled('event_type')) {
            $type = $request->event_type;
            $query->where(function($q) use ($type) {
                $q->whereJsonContains('extra_data->event_types', $type)
                  ->orWhereJsonContains('extra_data->event_types', ucfirst(strtolower($type)))
                  ->orWhereJsonContains('extra_data->event_types', strtolower($type))
                  ->orWhereJsonContains('extra_data->event_types', strtoupper($type))
                  ->orWhere('description', 'like', "%$type%")
                  ->orWhere('name', 'like', "%$type%");
            });
        }

        if ($request->filled('guests')) {
            $query->where(function($q) use ($request) {
                $q->where('extra_data->capacity', '>=', (int)$request->guests)
                  ->orWhereNull('extra_data->capacity');
            });
        }

        // Date filter (Availability)
        $singleDate = $request->input('date');
        $checkin = null;
        $checkout = null;

        if ($request->filled('dates')) {
            $range = explode(' to ', $request->input('dates'));
            $checkin = $range[0] ?? null;
            $checkout = $range[1] ?? null;
            if (!$checkout) $singleDate = $checkin;
        }

        if ($checkin && $checkout) {
            $query->whereDoesntHave('bookings', function($q) use ($checkin, $checkout) {
                $q->where(function($sq) use ($checkin, $checkout) {
                    $sq->whereBetween('booking_date', [$checkin, $checkout])
                       ->orWhereBetween('event_end_date', [$checkin, $checkout]);
                })->whereIn('status', ['pending', 'confirmed']);
            });
        } elseif ($singleDate) {
            $query->whereDoesntHave('bookings', function($q) use ($singleDate) {
                $q->whereDate('booking_date', $singleDate)
                  ->whereIn('status', ['pending', 'confirmed']);
            });
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%");
            });
        }

        // Only show featured by default, but if searching show all matching
        if (!$isSearching) {
            $query->where('is_featured', true);
        }

        $allServices = $query->latest()->get();
        
        $pakistanServices = $allServices->filter(function($service) {
            return str_contains(strtolower($service->location ?? ''), 'pakistan');
        });
        
        if (!$isSearching) $pakistanServices = $pakistanServices->take(12);
        
        $globalServices = $allServices->filter(function($service) {
            return !str_contains(strtolower($service->location ?? ''), 'pakistan');
        });
        
        if (!$isSearching) $globalServices = $globalServices->take(12);

        $categories = \App\Models\ServiceCategory::whereNull('parent_id')
            ->where('is_active', true)
            ->with('children')
            ->orderBy('sort_order')
            ->take(8)
            ->get();
        
        $cities = \App\Models\City::orderBy('name')->get();
        
        $customPackages = auth()->check() 
            ? \App\Models\CustomPackage::where('user_id', auth()->id())->with('services')->latest()->take(3)->get()
            : collect();
        
        // Real stats from database
        $stats = [
            'vendors' => User::where('role', 'vendor')->where('is_verified', true)->count(),
            'services' => Service::count(),
            'bookings' => Booking::where('status', 'completed')->count(),
            'users' => User::where('role', 'user')->count(),
        ];

        // Hardcoded UI Features
        $featureCards = json_decode(json_encode([
            [
                'title' => 'Browse & Compare',
                'description' => 'Explore verified vendors with transparent pricing and reviews.',
                'icon' => 'fa-solid fa-magnifying-glass',
                'delay' => 100,
                'style_blur' => 'bg-purple-500/20',
                'style_bg' => 'from-purple-500 to-indigo-500',
                'style_shadow' => 'shadow-purple-500/50',
                'style_text' => 'group-hover:text-purple-400'
            ],
            [
                'title' => 'Book Instantly',
                'description' => 'Secure your date with a small deposit. No hidden fees.',
                'icon' => 'fa-solid fa-calendar-check',
                'delay' => 200,
                'style_blur' => 'bg-blue-500/20',
                'style_bg' => 'from-blue-500 to-cyan-500',
                'style_shadow' => 'shadow-blue-500/50',
                'style_text' => 'group-hover:text-blue-400'
            ],
            [
                'title' => 'On-Ground Execution',
                'description' => 'Our team manages the event/trip to ensure perfection.',
                'icon' => 'fa-solid fa-clipboard-check',
                'delay' => 300,
                'style_blur' => 'bg-green-500/20',
                'style_bg' => 'from-green-500 to-emerald-500',
                'style_shadow' => 'shadow-green-500/50',
                'style_text' => 'group-hover:text-green-400'
            ]
        ]));

        $testimonialSlides = [
            [
                'stars' => 5,
                'quote' => 'Eventy made planning my wedding absolutely stress-free. The hybrid model is a game changer!',
                'name' => 'Sarah Ahmed',
                'role' => 'Bride (Lahore)',
                'initial' => 'S',
                'color' => 'bg-purple-100 text-purple-600'
            ],
            [
                'stars' => 5,
                'quote' => 'Used their travel desk for a corporate retreat. Everything was handled perfectly.',
                'name' => 'Ali Khan',
                'role' => 'CEO, TechFlow',
                'initial' => 'A',
                'color' => 'bg-blue-100 text-blue-600'
            ],
            [
                'stars' => 5,
                'quote' => 'The vendor verification process gave me so much peace of mind. Highly recommended!',
                'name' => 'Fatima Hassan',
                'role' => 'Event Organizer',
                'initial' => 'F',
                'color' => 'bg-green-100 text-green-600'
            ],
            [
                'stars' => 5,
                'quote' => 'Seamless booking experience and great customer support throughout our trip.',
                'name' => 'Bilal Sheikh',
                'role' => 'Traveler',
                'initial' => 'B',
                'color' => 'bg-orange-100 text-orange-600'
            ]
        ];
        
        // Admin-managed testimonials override the defaults above when configured.
        $dbTestimonials = \App\Models\Testimonial::all();
        if ($dbTestimonials->isNotEmpty()) {
            $colors = ['bg-purple-100 text-purple-600', 'bg-blue-100 text-blue-600', 'bg-pink-100 text-pink-600', 'bg-green-100 text-green-600', 'bg-orange-100 text-orange-600'];
            $testimonialSlides = $dbTestimonials->map(function($t, $i) use ($colors) {
                return [
                    'stars'   => $t->stars,
                    'quote'   => $t->quote,
                    'name'    => $t->name,
                    'role'    => $t->role,
                    'initial' => strtoupper(substr($t->name, 0, 1)),
                    'color'   => $colors[$i % count($colors)],
                ];
            })->all();
        }

        // Homepage CMS content (hero, section headings, steps, CTA) with defaults.
        $hp = HomepageController::content();

        // Admin-managed homepage media (corporate cards, video tiles, landmarks, avatars).
        $media = \App\Models\HomepageMedia::where('is_active', true)->orderBy('sort_order')->orderBy('id')->get()->groupBy('section');

        if ($request->header('X-Partial') === 'stats') {
            return view('partials.home-stats', compact('stats'));
        }

        if ($request->ajax()) {
            return view('partials.home-marketplace', compact('pakistanServices', 'globalServices', 'isSearching'));
        }

        return view('welcome', compact('pakistanServices', 'globalServices', 'stats', 'categories', 'featureCards', 'testimonialSlides', 'customPackages', 'cities', 'isSearching', 'hp', 'media'));
    }

    public function searchSuggestions(Request $request)
    {
        $query = $request->get('q');
        if (strlen($query) < 2) return response()->json([]);

        $services = Service::where('name', 'like', "%$query%")
            ->orWhere('location', 'like', "%$query%")
            ->with('category')
            ->limit(5)
            ->get()
            ->map(function($s) {
                return [
                    'id' => $s->id,
                    'name' => $s->name,
                    'category' => $s->category->name ?? 'Service',
                    'image' => $s->getFeaturedImage() ? (Str::startsWith($s->getFeaturedImage(), ['http', 'https']) ? $s->getFeaturedImage() : asset('storage/' . $s->getFeaturedImage())) : asset('images/placeholder.jpg'),
                    'url' => route('services.show', $s)
                ];
            });

        return response()->json($services);
    }
}
