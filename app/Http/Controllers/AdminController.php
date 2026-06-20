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
use App\Models\Payment;
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

    /**
     * Show the admin "create service" form (admin assigns the service to a vendor).
     */
    public function createService()
    {
        $vendors = User::where('role', 'vendor')->orderBy('name')->get();
        $categories = ServiceCategory::all();
        return view('admin.services.create', compact('vendors', 'categories'));
    }

    /**
     * Store a service created by the admin on behalf of a selected vendor.
     */
    public function storeService(Request $request)
    {
        $validated = $request->validate([
            'user_id'      => 'required|exists:users,id',
            'name'         => 'required|string|max:255',
            'description'  => 'required|string',
            'price'        => 'required|numeric|min:0',
            'price_type'   => 'nullable|string|max:50',
            'category_id'  => 'nullable|exists:service_categories,id',
            'location'     => 'nullable|string|max:255',
            'images.*'     => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'featured_image_index' => 'nullable|integer|min:0',
            'extra'        => 'nullable|array',
            'packages'     => 'nullable|array',
            'packages.*.name'  => 'required_with:packages|string|max:100',
            'packages.*.price' => 'required_with:packages|numeric|min:0',
            'packages.*.description' => 'nullable|string|max:500',
            'add_ons'      => 'nullable|array',
            'add_ons.*.name'  => 'required_with:add_ons|string|max:100',
            'add_ons.*.price' => 'required_with:add_ons|numeric|min:0',
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('services', 'public');
            }
        }

        $service = Service::create([
            'user_id'              => $validated['user_id'],
            'name'                 => $validated['name'],
            'description'          => $validated['description'],
            'price'                => $validated['price'],
            'price_type'           => $validated['price_type'] ?? 'fixed',
            'category_id'          => $validated['category_id'] ?? null,
            'location'             => $validated['location'] ?? null,
            'extra_data'           => $request->input('extra', []),
            'image'                => $imagePaths[0] ?? null,
            'images'               => $imagePaths,
            'featured_image_index' => $request->featured_image_index ?? 0,
            'packages'             => $request->packages,
            'add_ons'              => $request->add_ons,
            'status'               => 'active',
        ]);

        // Notify the vendor that the admin published a service for them
        Notification::createServiceNotification(
            $service->user_id,
            'Service Published by Admin',
            'A new service "' . $service->name . '" has been added to your account by the admin.',
            route('services.show', $service)
        );

        return redirect()->route('admin.services')->with('success', 'Service created successfully.');
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
        return redirect()->back()->with('success', 'Service moved to trash.');
    }

    public function trashedServices()
    {
        $services = Service::onlyTrashed()->with(['user', 'category'])->latest('deleted_at')->paginate(20);
        return view('admin.services-trash', compact('services'));
    }

    public function restoreService($id)
    {
        $service = Service::onlyTrashed()->findOrFail($id);
        $service->restore();
        return redirect()->back()->with('success', 'Service restored successfully.');
    }

    public function forceDeleteService($id)
    {
        $service = Service::onlyTrashed()->findOrFail($id);
        $service->forceDelete();
        return redirect()->back()->with('success', 'Service permanently deleted.');
    }

    public function deleteBooking(Booking $booking)
    {
        $booking->delete();
        return redirect()->back()->with('success', 'Booking moved to trash.');
    }

    public function trashedBookings()
    {
        $bookings = Booking::onlyTrashed()->with(['user', 'service', 'vendor'])->latest('deleted_at')->paginate(20);
        return view('admin.bookings-trash', compact('bookings'));
    }

    public function restoreBooking($id)
    {
        $booking = Booking::onlyTrashed()->findOrFail($id);
        $booking->restore();
        return redirect()->back()->with('success', 'Booking restored successfully.');
    }

    public function forceDeleteBooking($id)
    {
        $booking = Booking::onlyTrashed()->findOrFail($id);
        $booking->forceDelete();
        return redirect()->back()->with('success', 'Booking permanently deleted.');
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

    /**
     * List manual payments, prioritising those awaiting verification.
     */
    public function payments(Request $request)
    {
        $filter = $request->get('status', 'awaiting_verification');

        $query = Payment::with(['booking.service', 'user'])
            ->whereIn('payment_method', ['bank', 'jazzcash', 'easypaisa']);

        if (in_array($filter, ['awaiting_verification', 'completed', 'failed'])) {
            $query->where('status', $filter);
        }

        $payments = $query->latest()->paginate(20)->withQueryString();

        $pendingCount = Payment::whereIn('payment_method', ['bank', 'jazzcash', 'easypaisa'])
            ->where('status', 'awaiting_verification')->count();

        return view('admin.payments.index', compact('payments', 'filter', 'pendingCount'));
    }

    /**
     * Approve a manual payment after verifying the uploaded proof.
     */
    public function verifyPayment(Payment $payment)
    {
        $payment->update([
            'status'      => 'completed',
            'verified_at' => now(),
            'verified_by' => auth()->id(),
        ]);

        if ($payment->user_id) {
            Notification::createSystemNotification(
                $payment->user_id,
                'Payment Confirmed',
                "Your payment for Booking #{$payment->booking_id} has been verified. Thank you!",
                route('bookings.index')
            );
        }

        return back()->with('success', 'Payment verified and marked as paid.');
    }

    /**
     * Revert a verified payment back to awaiting verification.
     */
    public function unverifyPayment(Payment $payment)
    {
        if ($payment->status !== 'completed') {
            return back()->with('error', 'Only verified payments can be un-verified.');
        }

        $payment->update([
            'status'      => 'awaiting_verification',
            'verified_at' => null,
            'verified_by' => null,
        ]);

        return back()->with('success', 'Payment reverted to awaiting verification.');
    }

    /**
     * Reject a manual payment (e.g. invalid/insufficient proof).
     */
    public function rejectPayment(Request $request, Payment $payment)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $payment->update([
            'status'      => 'failed',
            'admin_notes' => $request->admin_notes,
            'verified_at' => now(),
            'verified_by' => auth()->id(),
        ]);

        if ($payment->user_id) {
            Notification::createSystemNotification(
                $payment->user_id,
                'Payment Rejected',
                "Your payment proof for Booking #{$payment->booking_id} could not be verified. " . ($request->admin_notes ? "Reason: {$request->admin_notes}" : 'Please re-submit.'),
                route('bookings.index')
            );
        }

        return back()->with('success', 'Payment rejected. Customer has been notified.');
    }

    /**
     * Admin override for a booking's status (accept, un-accept, reject) at any stage.
     */
    public function updateBookingStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $booking->update(['status' => $request->status]);

        if ($booking->user_id) {
            Notification::createBookingNotification(
                $booking->user_id,
                'Booking Status Updated',
                "Your booking #{$booking->id} for [" . optional($booking->service)->name . "] has been updated to: " . strtoupper($request->status) . " by the admin.",
                route('bookings.index')
            );
        }

        return redirect()->back()->with('success', 'Booking status updated successfully.');
    }
}

