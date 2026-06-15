<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceCategory;

class BlueprintController extends Controller
{
    public function index()
    {
        $stages = [
            [
                'id' => 1,
                'title' => 'Phase 1: The Foundation',
                'time' => '12-18 Months Out',
                'description' => 'Secure your core assets. Focus on venue and catering to set the date.',
                'categories' => ['Venues', 'Catering'],
                'icon' => 'fa-building-columns'
            ],
            [
                'id' => 2,
                'title' => 'Phase 2: The Moments',
                'time' => '6-9 Months Out',
                'description' => 'Capture the history. Book your visual artists and entertainment.',
                'categories' => ['Media & Coverage', 'Music & DJ'],
                'icon' => 'fa-camera-retro'
            ],
            [
                'id' => 3,
                'title' => 'Phase 3: The Elegance',
                'time' => '3-4 Months Out',
                'description' => 'Refine the atmosphere with decor, floral, and transport.',
                'categories' => ['Decor & Floral', 'Travel & Hospitality'],
                'icon' => 'fa-gem'
            ]
        ];

        // Fetch categories to link to them
        $allCategories = ServiceCategory::all();

        return view('pages.blueprint', compact('stages', 'allCategories'));
    }
}
