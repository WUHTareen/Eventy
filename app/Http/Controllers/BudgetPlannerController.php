<?php

namespace App\Http\Controllers;

use App\Models\BudgetRequest;
use App\Models\Service;
use App\Models\CustomPackage;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetPlannerController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has(['budget', 'service'])) {
            // Keep original behavior if needed, or we can remove the session flash if we rely on AJAX now.
            // But let's keep it for compatibility with direct links.
            $budget = (float) $request->budget;
            $service = $request->service;
            $guests = 100; // Default estimate
            
            // Generate quick synthesis for preview
            $synthesis = $this->calculateSynthesis($budget, $guests);

            session()->flash('synthesis_result', $synthesis);
        }

        return view('pages.budget-planner');
    }

    public function preview(Request $request)
    {
        $budget = (float) $request->budget;
        $serviceSlug = $request->service;
        $guests = 100; // Default estimate

        $synthesis = $this->calculateSynthesis($budget, $guests);


        // Initialize matches
        $matchingServices = collect();

        if ($serviceSlug) {
             // 1. Strict Search by Category
             $category = ServiceCategory::where('slug', $serviceSlug)->first();
             if ($category) {
                 $catIds = $category->children()->pluck('id')->push($category->id);
                 $matchingServices = Service::whereIn('category_id', $catIds) // Strict Category
                    ->where('price', '<=', $budget * 2.0) // Broader upper limit
                    ->with('user')
                    ->latest()
                    ->take(20)
                    ->get();
             }
        } else {
            // 2. Broad Search (Only if no category selected)
            $matchingServices = Service::where('price', '<=', $budget * 2.0)
                ->with('user')
                ->latest()
                ->take(20)
                ->get();
        }

        // Fetch Matching Packages
        $matchingPackages = CustomPackage::where('total_price', '<=', $budget * 2.0)
            ->with(['services', 'user'])
            ->latest()
            ->take(6)
            ->get();

        return view('partials.budget-planner-preview', compact('synthesis', 'serviceSlug', 'budget', 'matchingServices', 'matchingPackages'));
    }

    private function calculateSynthesis($budget, $guests)
    {
        return [
            'economy' => [
                'total' => $budget * 0.6,
                'per_guest' => ($budget * 0.6) / $guests,
                'features' => ['Essential Venues', 'Basic Decor', 'Standard Catering'],
                'label' => 'Standard Essence'
            ],
            'premium' => [
                'total' => $budget,
                'per_guest' => $budget / $guests,
                'features' => ['Premium Logistics', 'Full Media Strip', 'Enhanced Catering', 'Live Entertainment'],
                'label' => 'Elite Fusion'
            ],
            'luxury' => [
                'total' => $budget * 1.8,
                'per_guest' => ($budget * 1.8) / $guests,
                'features' => ['VVIP Access', 'Bespoke Scenography', 'Celebrity Appearance', 'Global Logistics', 'Security Detail'],
                'label' => 'Absolute Authority'
            ]
        ];
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_type' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'guests' => 'required|integer|min:1',
            'budget' => 'required|numeric|min:1000',
            'services_needed' => 'required|array|min:1',
        ]);

        $budget = $validated['budget'];
        $services = $validated['services_needed'];
        $guests = $validated['guests'];

        // Neural Synthesis Logic (Mock AI Partitioning)
        $synthesis = [
            'economy' => [
                'total' => number_format($budget * 0.6, 0),
                'per_guest' => number_format(($budget * 0.6) / $guests, 0),
                'features' => array_slice($services, 0, 3), // Core essentials
                'label' => 'Standard Essence',
            ],
            'premium' => [
                'total' => number_format($budget, 0),
                'per_guest' => number_format($budget / $guests, 0),
                'features' => $services, // All requested
                'label' => 'Elite Fusion',
            ],
            'luxury' => [
                'total' => number_format($budget * 1.8, 0),
                'per_guest' => number_format(($budget * 1.8) / $guests, 0),
                'features' => array_merge($services, ['Concierge Liaison', 'VVIP Priority']),
                'label' => 'Absolute Luxury',
            ]
        ];

        $validated['user_id'] = Auth::id();
        $validated['services_needed'] = $services;
        $validated['status'] = 'processed';

        $budgetRequest = BudgetRequest::create($validated);

        return redirect()->route('budget-planner')
            ->with('synthesis_result', $synthesis)
            ->with('request_id', $budgetRequest->id)
            ->with('success', 'Neural Synthesis Complete! Your Strategic Manifests are ready below.');
    }

    public function acquire(Request $request, BudgetRequest $budgetRequest)
    {
        $validated = $request->validate([
            'tier' => 'required|string|in:economy,premium,luxury',
            'notes' => 'nullable|string|max:1000', // Assuming 'notes' might be added to the validation
        ]);

        $budgetRequest->update([
            'selected_tier' => $validated['tier'],
            'status' => 'quoted',
            'notes' => $validated['notes'] ?? null, // Update notes if provided
        ]);

        // Notify all admins about the acquisition
        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::createSystemNotification(
                $admin->id,
                'New Budget Manifest Acquired!',
                ($budgetRequest->user ? $budgetRequest->user->name : 'A customer') . ' has acquired a ' . ucfirst($validated['tier']) . ' manifest for ' . $budgetRequest->service_type . ' (PKR ' . number_format($budgetRequest->budget) . ')',
                route('admin.budget-requests')
            );
        }

        return redirect()->route('budget-planner')
            ->with('success', 'Manifest Acquired! Our elite human strategists have been notified and will contact you shortly to finalize your ' . ucfirst($validated['tier']) . ' package.');
    }
}
