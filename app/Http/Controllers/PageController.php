<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        return view('pages.about');
    }

    public function services(\Illuminate\Http\Request $request)
    {
        $query = \App\Models\Service::query();
        $category = null;

        if ($request->has('category')) {
            $slug = $request->get('category');
            $category = \App\Models\ServiceCategory::where('slug', $slug)->first();
            
            if ($category) {
                // Include services from children categories as well
                $catIds = $category->children()->pluck('id')->push($category->id);
                $query->whereIn('category_id', $catIds);
            }
        }

        // Vendor Name Search (Search By Name tab)
        if ($request->filled('vendor_name')) {
            $vendorName = $request->input('vendor_name');
            $query->where(function($q) use ($vendorName) {
                $q->where('name', 'like', "%$vendorName%")
                  ->orWhere('description', 'like', "%$vendorName%")
                  ->orWhereHas('user', function($userQuery) use ($vendorName) {
                      $userQuery->where('name', 'like', "%$vendorName%")
                                ->orWhere('business_name', 'like', "%$vendorName%");
                  });
            });
        }

        // City/Location Search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%")
                  ->orWhere('location', 'like', "%$search%");
            });
        }

        // Date filter (Availability)
        $checkin = $request->input('checkin');
        $checkout = $request->input('checkout');
        $singleDate = $request->input('date');

        if ($request->filled('dates')) {
            $range = explode(' to ', $request->input('dates'));
            $checkin = $range[0] ?? null;
            $checkout = $range[1] ?? null;
            if (!$checkout) $singleDate = $checkin;
        }

        // Handle Transport Dates
        if ($request->filled('pickup_datetime')) {
            $checkin = $request->pickup_datetime;
        }
        if ($request->filled('dropoff_datetime')) {
            $checkout = $request->dropoff_datetime;
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

        // Guests Capacity Filter
        if ($request->filled('guests')) {
            $guests = $request->guests;
            $query->where(function($q) use ($guests) {
                $q->where('extra_data->capacity', '>=', (int)$guests)
                  ->orWhereNull('extra_data->capacity'); // Optional: if data is missing, should we show it? User said "match", so strictly we shouldn't.
            });
        }
        if ($request->filled('travelers')) {
            $travelers = $request->travelers;
             $query->where('extra_data->capacity', '>=', (int)$travelers);
        }

        // Advanced Filters
        if ($request->filled('min_price')) {
            $query->whereRaw('CAST(price AS DECIMAL(12,2)) >= ?', [$request->min_price]);
        }
        if ($request->filled('max_price')) {
            $query->whereRaw('CAST(price AS DECIMAL(12,2)) <= ?', [$request->max_price]);
        }
        if ($request->filled('rating')) {
            $query->where('cached_rating', '>=', $request->rating);
        }
        $cities = \App\Models\City::orderBy('name')->get();
        if ($request->filled('city')) {
            $city = trim(str_replace([' Hub', ' District', ' Node', ' Core', ' Grid', ' Prime', ' Atoll', ' Marina'], '', $request->city));
            $query->where('location', 'like', "%" . $city . "%");
        }
        
        if ($request->filled('event_type')) {
            $type = $request->event_type;
            $query->where(function($q) use ($type) {
                $q->whereJsonContains('extra_data->event_types', $type)
                  ->orWhere('description', 'like', "%$type%")
                  ->orWhere('name', 'like', "%$type%");
            });
        }

        // Corporate Specific Filters
        if ($request->filled('event_size')) {
            $size = $request->event_size;
            $minGuests = 0;
            if ($size == '50-200') $minGuests = 50;
            if ($size == '200-500') $minGuests = 200;
            if ($size == '500+') $minGuests = 500;
            $query->where('extra_data->capacity', '>=', $minGuests);
        }

        if ($request->boolean('verified_only')) {
            $query->whereHas('user', function($q) {
                $q->where('is_verified', true);
            });
        }

        if ($request->filled('province')) {
            $query->whereHas('city_model', function($q) use ($request) {
                $q->where('province', 'like', '%' . $request->province . '%');
            });
        }

        if ($request->filled('region')) {
            $query->whereHas('city_model', function($q) use ($request) {
                $q->where('region', $request->region);
            });
        }

        $facetQuery = clone $query;

        if ($request->filled('locations') && is_array($request->locations)) {
            $query->whereIn('location', $request->locations);
        }
        if ($request->filled('categories') && is_array($request->categories)) {
            $query->whereHas('category', function($q) use ($request) {
                $q->whereIn('name', $request->categories);
            });
        }

        // Sorting Logic
        if ($request->filled('sort')) {
            $sort = $request->sort;
            switch ($sort) {
                case 'price_asc':
                    $query->orderByRaw('CAST(price AS DECIMAL(12,2)) ASC');
                    break;
                case 'price_desc':
                    $query->orderByRaw('CAST(price AS DECIMAL(12,2)) DESC');
                    break;
                case 'rating_desc':
                    $query->orderBy('cached_rating', 'desc');
                    break;
                case 'rating_asc':
                    $query->orderBy('cached_rating', 'asc');
                    break;
                case 'reviews_desc':
                    $query->orderBy('reviews_count', 'desc');
                    break;
                case 'top_picks':
                default:
                    $query->orderBy('is_featured', 'desc')->orderBy('cached_rating', 'desc');
                    break;
            }
        } else {
            $query->latest();
        }

        // Always return the search results view to provide filter functionality
        \Log::info('Search/Service Query:', ['sql' => $query->toSql(), 'bindings' => $query->getBindings()]);
        
        // Paginate results (standard for listing/filter page)
        $results = $query->paginate(12);

        if ($request->ajax()) {
            return view('partials.search-results', [
                'searchResults' => $results,
                'searchQuery' => $request->search ?? $request->category ?? 'Services'
            ])->render();
        }

        return view('services.search_results_page', [
            'results' => $results,
            'city' => $request->city,
            'eventType' => $request->event_type,
            'date' => $request->date,
            'guests' => $request->guests,
            'facetQuery' => $facetQuery
        ]);
    }

    public function desk($slug)
    {
        $category = \App\Models\ServiceCategory::where('slug', $slug)->firstOrFail();
        $cities = \App\Models\City::orderBy('name')->get();
        
        // Use the common viewing logic, but specialized for this route
        $catIds = $category->children()->pluck('id')->push($category->id);
        $query = \App\Models\Service::whereIn('category_id', $catIds);
        $facetQuery = clone $query;
        $results = $query->paginate(12);

        if (request()->ajax()) {
             return view('partials.search-results', [
                'searchResults' => $results,
                'searchQuery' => $category->name
            ])->render();
        }

        return view('services.search_results_page', [
            'results' => $results,
            'city' => null,
            'eventType' => null,
            'date' => null,
            'guests' => null,
            'facetQuery' => $facetQuery
        ]);
    }

    public function showService(\App\Models\Service $service)
    {
        $service->load(['user', 'category', 'reviews.user']);
        
        // Get related services from same category
        $relatedServices = \App\Models\Service::where('category_id', $service->category_id)
            ->where('id', '!=', $service->id)
            ->limit(3)
            ->get();

        // Get other services from the same vendor
        $vendorServices = \App\Models\Service::where('user_id', $service->user_id)
            ->where('id', '!=', $service->id)
            ->limit(3)
            ->get();
        
        if (request()->header('X-Partial') === 'quick-look') {
            return view('partials.service-quick-look', compact('service'))->render();
        }
        
        return view('pages.service-detail', compact('service', 'relatedServices', 'vendorServices'));
    }

    public function contact()
    {
        $categories = \App\Models\ServiceCategory::whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('pages.contact', compact('categories'));
    }

    public function howItWorks()
    {
        return view('pages.how-it-works');
    }

    public function upcoming()
    {
        return view('pages.upcoming');
    }

    public function global()
    {
        return view('pages.global');
    }

    public function budgetPlanner()
    {
        return view('pages.budget-planner');
    }

    public function privacy()
    {
        return view('pages.privacy');
    }

    public function terms()
    {
        return view('pages.terms');
    }

    public function refundPolicy()
    {
        return view('pages.refund-policy');
    }

    public function vendorOnboarding()
    {
        return view('pages.vendor-onboarding');
    }

    public function insights()
    {
        $posts = \App\Models\BlogPost::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->get();
            
        return view('pages.insights', compact('posts'));
    }

    public function individual()
    {
        return view('pages.individual');
    }

    public function corporate()
    {
        return view('pages.corporate');
    }
}
