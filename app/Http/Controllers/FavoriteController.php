<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the user's favorite services.
     */
    public function index()
    {
        $favorites = Auth::user()->favorites()->with(['category', 'user'])->latest('favorites.created_at')->paginate(12);
        return view('favorites.index', compact('favorites'));
    }

    /**
     * Toggle favorite status for a service.
     */
    public function toggle(Service $service)
    {
        $user = Auth::user();
        
        // Toggle the relationship
        $result = $user->favorites()->toggle($service->id);
        
        $isFavorited = count($result['attached']) > 0;
        
        if (request()->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'favorited' => $isFavorited,
                'message' => $isFavorited ? 'Service added to wishlist' : 'Service removed from wishlist'
            ]);
        }
        
        return back()->with('success', $isFavorited ? 'Service added to wishlist' : 'Service removed from wishlist');
    }
}
