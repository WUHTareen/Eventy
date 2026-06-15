<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PublicVendorController extends Controller
{
    public function show(\App\Models\User $vendor)
    {
        if ($vendor->role !== 'vendor') {
            abort(404);
        }

        // Eager load services and reviews count for better performance
        $vendor->load(['services' => function($query) {
            $query->where('status', 'active');
        }, 'city', 'category']);

        // Calculate vendor-wide stats
        $serviceIds = $vendor->services->pluck('id');
        $reviewStats = \App\Models\Review::whereIn('service_id', $serviceIds)
            ->selectRaw('COUNT(*) as total, AVG(rating) as average')
            ->first();

        $reviewCount = $reviewStats->total;
        $avgRating = round($reviewStats->average, 1);

        return view('pages.vendor-profile', compact('vendor', 'reviewCount', 'avgRating'));
    }
}
