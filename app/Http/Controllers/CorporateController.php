<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CorporateController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        
        $query = \App\Models\Booking::where(function($q) use ($user) {
            $q->where('user_id', $user->id)
              ->orWhere('assigned_admin_id', $user->id);
        });

        // 1. Location Filters
        if ($request->filled('city')) {
            $query->whereHas('service', function($q) use ($request) {
                $q->where('location', 'like', '%' . $request->city . '%');
            });
        }
        if ($request->filled('province')) {
            $query->whereHas('service.city_model', function($q) use ($request) {
                $q->where('province', 'like', '%' . $request->province . '%');
            });
        }
        if ($request->filled('region')) {
            $query->whereHas('service.city_model', function($q) use ($request) {
                $q->where('region', $request->region);
            });
        }

        // 2. Event Filters
        if ($request->filled('corporate_event_type')) {
            $query->where('event_type', $request->corporate_event_type);
        }
        if ($request->filled('event_size')) {
            $query->where('event_size', $request->event_size);
        }
        if ($request->filled('event_status')) {
            $query->where('status', $request->event_status);
        }
        if ($request->filled('event_date_range')) {
            $range = explode(' to ', $request->event_date_range);
            if (isset($range[0])) {
                $query->where('booking_date', '>=', $range[0]);
            }
            if (isset($range[1])) {
                $query->where('booking_date', '<=', $range[1]);
            }
        }

        // 3. Finance & Budget
        if ($request->filled('max_price')) {
            $query->where('total_price', '<=', $request->max_price);
        }
        if ($request->filled('payment_status')) {
            $query->where('payout_status', $request->payment_status);
        }
        if ($request->filled('cost_center')) {
            $query->where('cost_center', $request->cost_center);
        }
        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }
        if ($request->filled('corporate_pricing_applied')) {
            $query->where('corporate_pricing', $request->corporate_pricing_applied);
        }

        // 4. Vendor Filters (Filtering Bookings by Vendor attributes)
        if ($request->filled('vendor_category')) {
            $query->whereHas('service.category', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->vendor_category . '%');
            });
        }
        if ($request->filled('vendor_rating')) {
            $query->whereHas('service', function($q) use ($request) {
                $q->where('cached_rating', '>=', $request->vendor_rating);
            });
        }
        if ($request->filled('verified_only')) {
            $query->whereHas('service.user', function($q) {
                $q->where('is_verified', true);
            });
        }

        // 5. Admin & Access
        if ($request->filled('created_by')) {
            // Simplified logic: filter by user meta or roles
            if ($request->created_by == 'head_office') {
                $query->whereHas('user', function($q) {
                    $q->where('business_type', 'Head Office');
                });
            }
        }
        if ($request->filled('assigned_admin')) {
            $query->where('assigned_admin_id', $request->assigned_admin);
        }
        if ($request->filled('approval_level')) {
            $query->where('approval_level', $request->approval_level);
        }

        $bookings = $query->with(['service', 'service.category', 'service.user'])->latest()->paginate(10);

        $stats = [
            'total_orders' => $user->bookings()->count(),
            'active_orders' => $user->bookings()->whereIn('status', ['pending', 'confirmed', 'in_progress'])->count(),
            'total_spent' => $user->bookings()->where('status', 'completed')->sum('total_price'),
        ];
        
        return view('corporate.dashboard', compact('user', 'stats', 'bookings'));
    }
}
