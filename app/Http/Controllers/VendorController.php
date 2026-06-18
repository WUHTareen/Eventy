<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Notification;
use App\Models\Booking;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VendorController extends Controller
{
    public function dashboard(Request $request)
    {
        $services = Auth::user()->services;
        $recentBookings = Auth::user()->receivedBookings()->with(['user', 'service.category'])->latest()->limit(5)->get();
        
        // Optimize earnings calculation using vendor_net_amount (post-commission)
        $totalEarnings = Auth::user()->receivedBookings()
            ->where('status', 'completed')
            ->sum('vendor_net_amount');

        // Chart Data: Last 6 Months Revenue
        $monthlyRevenue = Auth::user()->receivedBookings()
            ->where('status', 'completed')
            ->where('booking_date', '>=', now()->subMonths(6))
            ->selectRaw('SUM(total_price) as total, MONTH(booking_date) as month')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->all();

        // Chart Data: Last 6 Months Bookings
        $monthlyBookings = Auth::user()->receivedBookings()
            ->where('booking_date', '>=', now()->subMonths(6))
            ->selectRaw('COUNT(*) as total, MONTH(booking_date) as month')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->all();
        
        // Format for Chart.js
        $months = [];
        $revenueData = [];
        $bookingsData = [];
        for ($i = 5; $i >= 0; $i--) {
            $m = now()->subMonths($i)->month;
            $months[] = now()->subMonths($i)->format('M');
            $revenueData[] = $monthlyRevenue[$m] ?? 0;
            $bookingsData[] = $monthlyBookings[$m] ?? 0;
        }
        
        $chartData = [
            'labels' => $months,
            'revenue' => $revenueData,
            'bookings' => $bookingsData
        ];
        
        if ($request->header('X-Partial') === 'vendor-stats') {
            return view('vendor.partials.dashboard-stats', compact('services', 'recentBookings', 'totalEarnings'));
        }

        return view('vendor.dashboard', compact('services', 'recentBookings', 'totalEarnings', 'chartData'));
    }

    public function createService()
    {
        if (!Auth::user()->is_verified) {
            return redirect()->route('vendor.dashboard')->with('error', 'You must be verified by an admin to add services.');
        }
        $categories = \App\Models\ServiceCategory::all();
        return view('vendor.create-service', compact('categories'));
    }

    public function storeService(Request $request)
    {
        if (!Auth::user()->is_verified) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'price_type' => 'nullable|string|max:50',
            'category_id' => 'nullable|exists:service_categories,id',
            'location' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'featured_image_index' => 'nullable|integer|min:0',
            'extra' => 'nullable|array',
            'packages' => 'nullable|array',
            'packages.*.name' => 'required_with:packages|string|max:100',
            'packages.*.price' => 'required_with:packages|numeric|min:0',
            'packages.*.description' => 'nullable|string|max:500',
            'add_ons' => 'nullable|array',
            'add_ons.*.name' => 'required_with:add_ons|string|max:100',
            'add_ons.*.price' => 'required_with:add_ons|numeric|min:0',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('services', 'public');
        }

        // Handle multiple images
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('services', 'public');
            }
        }

        // Process extra data
        $extraData = $request->input('extra', []);

        $service = Auth::user()->services()->create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'price_type' => $request->price_type ?? 'fixed',
            'category_id' => $request->category_id,
            'location' => $request->location,
            'extra_data' => $extraData,
            'image' => $imagePath,
            'images' => $imagePaths,
            'featured_image_index' => $request->featured_image_index ?? 0,
            'packages' => $request->packages,
            'add_ons' => $request->add_ons,
            'status' => 'active',
        ]);

        Notification::createServiceNotification(
            Auth::id(),
            'Service Created!',
            'Your service "' . $service->name . '" has been published successfully.',
            route('services.show', $service)
        );

        return redirect()->route('vendor.dashboard')->with('success', 'Service added successfully.');
    }

    public function editService(Service $service)
    {
        if ($service->user_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            abort(403);
        }
        $categories = \App\Models\ServiceCategory::all();
        return view('vendor.edit-service', compact('service', 'categories'));
    }

    public function updateService(Request $request, Service $service)
    {
        if ($service->user_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'nullable|exists:service_categories,id',
            'location' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'featured_image_index' => 'nullable|integer|min:0',
            'removed_indices' => 'nullable|array',
            'packages' => 'nullable|array',
            'packages.*.name' => 'required_with:packages|string|max:100',
            'packages.*.price' => 'required_with:packages|numeric|min:0',
            'packages.*.description' => 'nullable|string|max:500',
            'add_ons' => 'nullable|array',
            'add_ons.*.name' => 'required_with:add_ons|string|max:100',
            'add_ons.*.price' => 'required_with:add_ons|numeric|min:0',
        ]);

        $data = $request->only(['name', 'description', 'price', 'category_id', 'location']);

        // Handle old single image fallback
        if ($request->hasFile('image')) {
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        // Handle Multiple Images
        $currentImages = $service->images ?? [];
        $removedIndices = $request->input('removed_indices', []);

        // 1. Remove files and filter array
        if (!empty($removedIndices)) {
            foreach ($removedIndices as $index) {
                if (isset($currentImages[$index])) {
                    Storage::disk('public')->delete($currentImages[$index]);
                    unset($currentImages[$index]);
                }
            }
            $currentImages = array_values($currentImages); // Re-index
        }

        // 2. Add new images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $currentImages[] = $file->store('services', 'public');
            }
        }

        $data['images'] = $currentImages;
        
        // 3. Update featured index
        $data['featured_image_index'] = $request->input('featured_image_index', 0);
        $data['packages'] = $request->packages;
        $data['add_ons'] = $request->add_ons;
        
        // Ensure featured index is valid
        if ($data['featured_image_index'] >= count($currentImages)) {
            $data['featured_image_index'] = 0;
        }

        $service->update($data);

        $redirectRoute = Auth::user()->hasRole('admin') ? 'admin.services' : 'vendor.dashboard';
        return redirect()->route($redirectRoute)->with('success', 'Service updated successfully.');
    }

    public function destroyService(Service $service)
    {
        if ($service->user_id !== Auth::id()) {
            abort(403);
        }

        // Delete image if exists
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }

        $serviceName = $service->name;
        $service->delete();

        return redirect()->route('vendor.dashboard')->with('success', 'Service "' . $serviceName . '" deleted successfully.');
    }

    public function analytics()
    {
        $user = Auth::user();
        
        // Get monthly booking stats
        $monthlyBookings = Booking::where('vendor_id', $user->id)
            ->whereYear('created_at', now()->year)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count, status')
            ->groupBy('month', 'status')
            ->get();
        
        // Get earnings
        $totalEarnings = $user->receivedBookings()
            ->where('status', 'completed')
            ->join('services', 'bookings.service_id', '=', 'services.id')
            ->sum('services.price');

        $thisMonthEarnings = $user->receivedBookings()
            ->where('status', 'completed')
            ->whereMonth('bookings.created_at', now()->month)
            ->join('services', 'bookings.service_id', '=', 'services.id')
            ->sum('services.price');
        
        // Top services by bookings
        $topServices = $user->services()->withCount('bookings')->orderByDesc('bookings_count')->limit(5)->get();
        
        // Recent bookings
        $recentBookings = $user->receivedBookings()->with(['user', 'service'])->latest()->limit(10)->get();
        
        return view('vendor.analytics', compact(
            'monthlyBookings', 
            'totalEarnings', 
            'thisMonthEarnings', 
            'topServices', 
            'recentBookings'
        ));
    }

    public function customOrders()
    {
        $bookings = Auth::user()->receivedBookings()
            ->whereNotNull('booking_data')
            ->where('booking_data->is_custom_package', true)
            ->with(['user', 'service'])
            ->latest()
            ->paginate(15);
            
        return view('vendor.custom-orders', compact('bookings'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('vendor.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'bio' => 'nullable|string|max:1000',
            'social_links' => 'nullable|array',
            'business_hours' => 'nullable|array',
            'avatar' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['bio', 'social_links', 'business_hours']);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function wallet()
    {
        $user = Auth::user();
        $withdrawals = $user->withdrawals()->latest()->paginate(10);
        return view('vendor.wallet', compact('user', 'withdrawals'));
    }

    public function requestWithdrawal(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'amount' => 'required|numeric|min:500|max:' . $user->balance,
            'payment_method' => 'required|string',
        ]);

        Withdrawal::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'status' => 'pending',
            'payment_method' => $request->payment_method,
        ]);

        $user->decrement('balance', $request->amount);

        return back()->with('success', 'Withdrawal request submitted successfully.');
    }
}


