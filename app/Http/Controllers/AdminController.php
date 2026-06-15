<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Service;
use App\Models\Booking;
use App\Models\Notification;
use App\Models\City;
use App\Models\ServiceCategory;
use App\Models\BudgetRequest;
use App\Models\ServiceDeskRequest;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $totalBookings = Booking::count();
        $totalServices = Service::count();
        $totalBudgetRequests = BudgetRequest::count();
        
        // Financial Intelligence
        $totalPlatformRevenue = Booking::where('status', 'completed')->sum('total_price');
        $totalCommissionEarned = Booking::where('status', 'completed')->sum('commission_fee');
        
        $serviceDeskPendingCount = ServiceDeskRequest::where('status', 'pending')->count();
        $recentBookings = Booking::with(['user', 'service'])->latest()->limit(5)->get();
        
        $users = User::all();
        $recentClients = User::where('role', 'user')->latest()->limit(5)->get();
        $pendingVendors = User::where('role', 'vendor')->where('is_verified', false)->latest()->get();
        $pendingVendorsCount = $pendingVendors->count();

        // Handle AJAX Polling
        if ($request->header('X-Partial') === 'stats') {
            return view('admin.partials.dashboard-stats', [
                'users' => $users ?? \App\Models\User::all(),
                'totalBookings' => $totalBookings ?? \App\Models\Booking::count(),
                'totalServices' => $totalServices ?? \App\Models\Service::count(),
                'recentBookings' => $recentBookings ?? \App\Models\Booking::latest()->limit(5)->get(),
                'pendingVendors' => $pendingVendorsCount ?? \App\Models\User::where('role', 'vendor')->where('is_verified', false)->count(),
                'totalBudgetRequests' => $totalBudgetRequests ?? \App\Models\BudgetRequest::count(),
                'serviceDeskPendingCount' => $serviceDeskPendingCount ?? \App\Models\ServiceDeskRequest::where('status', 'pending')->count(),
                'totalPlatformRevenue' => $totalPlatformRevenue ?? \App\Models\Booking::where('status', 'completed')->sum('total_price'),
                'totalCommissionEarned' => $totalCommissionEarned ?? \App\Models\Booking::where('status', 'completed')->sum('commission_fee'),
            ]);
        }
        
        if ($request->header('X-Partial') === 'clients') {
            return view('admin.partials.recent-clients-table', compact('recentClients'));
        }

        if ($request->header('X-Partial') === 'vendors') {
            return view('admin.partials.pending-vendors-table', compact('pendingVendors'));
        }

        return view('admin.dashboard', [
            'users' => $users,
            'recentClients' => $recentClients,
            'pendingVendors' => $pendingVendors,
            'totalBookings' => $totalBookings,
            'totalServices' => $totalServices,
            'recentBookings' => $recentBookings,
            'pendingVendorsCount' => $pendingVendorsCount,
            'totalBudgetRequests' => $totalBudgetRequests,
            'serviceDeskPendingCount' => $serviceDeskPendingCount,
            'totalPlatformRevenue' => $totalPlatformRevenue,
            'totalCommissionEarned' => $totalCommissionEarned,
        ]);
    }

    public function budgetRequests()
    {
        $requests = BudgetRequest::with('user')->latest()->paginate(20);
        return view('admin.budget-requests', compact('requests'));
    }

    public function createUser()
    {
        $cities = City::all();
        $categories = ServiceCategory::whereNull('parent_id')->get();
        return view('admin.users.create', compact('cities', 'categories'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:user,vendor,admin'],
            'city_id' => $request->role === 'vendor' ? ['required', 'exists:cities,id'] : ['nullable'],
            'category_id' => $request->role === 'vendor' ? ['required', 'exists:service_categories,id'] : ['nullable'],
        ]);

        $vendorType = null;
        if ($request->role === 'vendor' && $request->category_id) {
            $category = ServiceCategory::find($request->category_id);
            $vendorType = $category ? $category->name : null;
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => $request->role,
            'vendor_type' => $vendorType,
            'city_id' => $request->city_id,
            'category_id' => $request->category_id,
            'is_verified' => $request->role !== 'vendor', // Vendors might still need manual verification or we can auto-verify here
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'User created successfully.');
    }

    public function verifyVendor($id)
    {
        $user = User::findOrFail($id);
        if ($user->role === 'vendor') {
            $user->is_verified = true;
            $user->save();
            
            // Notify the vendor
            Notification::createSystemNotification(
                $user->id,
                'Account Verified!',
                'Congratulations! Your vendor account has been verified. You can now create and publish services.',
                route('vendor.dashboard')
            );
        }
        return redirect()->back()->with('success', 'Vendor verified successfully.');
    }

    public function services()
    {
        $services = Service::with(['user', 'category'])->latest()->paginate(20);
        return view('admin.services', compact('services'));
    }

    public function bookings()
    {
        $bookings = Booking::with(['user', 'service', 'vendor'])->latest()->paginate(20);
        return view('admin.bookings', compact('bookings'));
    }


    public function customPackages()
    {
        $bookings = \App\Models\CustomPackageBooking::with(['user', 'customPackage'])->latest()->paginate(20);
        return view('admin.custom-packages', compact('bookings'));
    }

    public function showCustomPackage(\App\Models\CustomPackageBooking $booking)
    {
        $booking->load(['user', 'customPackage.services', 'customPackage.services.category']);
        // Load the child bookings associated with this package booking
        // Assuming there isn't a direct relationship yet, we can find them via filtered booking_data or we should have added a parent_id to bookings table?
        // Wait, the design was "unconnected" initially according to summary, but filtered data passed.
        // Actually, we should check if we can link them easily. 
        // For now, let's just show the package booking details. 
        // Use a heuristic: Booking where distinct booking_data->package_booking_id matches.
        
        $childBookings = \App\Models\Booking::where('booking_data->package_booking_id', $booking->id)->with(['vendor', 'service'])->get();

        return view('admin.custom-packages.show', compact('booking', 'childBookings'));
    }


    public function deleteService(Service $service)
    {
        $service->delete();
        return redirect()->back()->with('success', 'Service deleted successfully.');
    }

    public function toggleFeature(Service $service)
    {
        $service->is_featured = !$service->is_featured;
        $service->save();
        $status = $service->is_featured ? 'marked as featured' : 'removed from featured';
        return redirect()->back()->with('success', "Service {$status} successfully.");
    }

    public function vendorLogs(\Illuminate\Http\Request $request)
    {
        $query = \App\Models\VendorLog::with(['vendor', 'booking']);

        if ($request->has('vendor_id') && $request->vendor_id) {
            $query->where('vendor_id', $request->vendor_id);
        }

        $logs = $query->latest()->paginate(20);
        $vendors = User::where('role', 'vendor')->get();

        return view('admin.vendor-logs', compact('logs', 'vendors'));
    }
    public function withdrawals()
    {
        $withdrawals = Withdrawal::with('user')->latest()->paginate(20);
        return view('admin.withdrawals', compact('withdrawals'));
    }

    public function updateWithdrawalStatus(Request $request, Withdrawal $withdrawal)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,paid',
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $oldStatus = $withdrawal->status;
        $withdrawal->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
        ]);

        // If rejected, refund the vendor balance
        if ($request->status === 'rejected' && $oldStatus !== 'rejected') {
            $withdrawal->user->increment('balance', $withdrawal->amount);
        }

        Notification::createSystemNotification(
            $withdrawal->user_id,
            'Withdrawal Update',
            "Your withdrawal request for PKR {$withdrawal->amount} has been updated to: " . strtoupper($request->status),
            route('vendor.wallet')
        );

        return back()->with('success', 'Withdrawal status updated successfully.');
    }
}

