<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AffiliateController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        
        $stats = [
            'total_earnings' => $user->affiliateCommissions()->where('status', 'paid')->sum('amount'),
            'pending_earnings' => $user->affiliateCommissions()->where('status', 'pending')->sum('amount'),
            'total_leads' => $totalLeads = $user->affiliateLeads()->count(),
            'converted_leads' => $convertedLeads = $user->affiliateLeads()->where('status', 'converted')->count(),
            'conversion_rate' => $totalLeads > 0 ? round(($convertedLeads / $totalLeads) * 100, 1) : 0,
        ];

        $recentLeads = $user->affiliateLeads()->latest()->take(5)->get();

        return view('affiliate.dashboard', compact('stats', 'recentLeads'));
    }

    public function leads()
    {
        $leads = auth()->user()->affiliateLeads()->latest()->paginate(10);
        return view('affiliate.leads', compact('leads'));
    }

    public function commissions()
    {
        $commissions = auth()->user()->affiliateCommissions()->latest()->paginate(10);
        return view('affiliate.commissions', compact('commissions'));
    }

    public function resources()
    {
        $resources = \App\Models\AffiliateResource::all()->groupBy('type');
        return view('affiliate.resources', compact('resources'));
    }
}
