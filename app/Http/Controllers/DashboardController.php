<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->hasRole('vendor')) {
            return redirect()->route('vendor.dashboard');
        }
        if (Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        if ($request->header('X-Partial') === 'user-stats') {
            return view('partials.user-dashboard-stats');
        }

        return view('dashboard');
    }
}
