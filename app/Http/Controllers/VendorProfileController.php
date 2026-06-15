<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Service;
use Illuminate\Http\Request;

class VendorProfileController extends Controller
{
    public function show(User $vendor)
    {
        // Ensure the user is a vendor
        if ($vendor->role !== 'vendor') {
            abort(404);
        }

        $services = $vendor->services()->with('category')->paginate(12);
        
        // Calculate vendor-wide average rating
        $avgRating = \App\Models\Review::whereIn('service_id', $vendor->services->pluck('id'))
            ->avg('rating') ?? 0;
            
        $reviewCount = \App\Models\Review::whereIn('service_id', $vendor->services->pluck('id'))
            ->count();

        return view('vendors.show', compact('vendor', 'services', 'avgRating', 'reviewCount'));
    }
}
