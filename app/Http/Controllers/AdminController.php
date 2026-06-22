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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
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

    public function analytics(Request $request)
    {
        // ---- Resolve the selected date range -------------------------------
        $range = $request->input('range', '12m');
        $now   = now();

        switch ($range) {
            case '7d':  $start = $now->copy()->subDays(6)->startOfDay();   $end = $now->copy()->endOfDay(); break;
            case '30d': $start = $now->copy()->subDays(29)->startOfDay();  $end = $now->copy()->endOfDay(); break;
            case '90d': $start = $now->copy()->subDays(89)->startOfDay();  $end = $now->copy()->endOfDay(); break;
            case 'ytd': $start = $now->copy()->startOfYear();              $end = $now->copy()->endOfDay(); break;
            case 'custom':
                $start = $request->filled('from') ? \Carbon\Carbon::parse($request->input('from'))->startOfDay() : $now->copy()->subDays(29)->startOfDay();
                $end   = $request->filled('to')   ? \Carbon\Carbon::parse($request->input('to'))->endOfDay()    : $now->copy()->endOfDay();
                if ($end->lt($start)) { [$start, $end] = [$end->copy()->startOfDay(), $start->copy()->endOfDay()]; }
                break;
            case '12m':
            default:
                $range = '12m';
                $start = $now->copy()->subMonths(11)->startOfMonth();
                $end   = $now->copy()->endOfDay();
                break;
        }

        // Daily buckets for short spans, monthly for long ones.
        $spanDays    = $start->diffInDays($end) + 1;
        $granularity = $spanDays <= 92 ? 'day' : 'month';

        // Previous period of equal length, immediately before the current one.
        $prevEnd   = $start->copy()->subSecond();
        $prevStart = $prevEnd->copy()->subDays($spanDays - 1)->startOfDay();

        // ---- Build empty buckets (oldest -> newest) ------------------------
        $buckets = collect();
        $cursor  = $start->copy();
        while ($cursor->lte($end)) {
            if ($granularity === 'day') {
                $key = $cursor->format('Y-m-d'); $label = $cursor->format('M j');
                $cursor->addDay();
            } else {
                $cursor = $cursor->startOfMonth();
                $key = $cursor->format('Y-m');   $label = $cursor->format('M Y');
                $cursor->addMonth();
            }
            $buckets->put($key, ['label' => $label, 'revenue' => 0.0, 'bookings' => 0, 'users' => 0]);
        }
        $bucketKey = fn ($date) => $granularity === 'day' ? $date->format('Y-m-d') : $date->format('Y-m');

        // ---- Fill buckets from bookings + users in range -------------------
        Booking::whereBetween('created_at', [$start, $end])
            ->get(['created_at', 'status', 'total_price'])
            ->each(function ($b) use ($buckets, $bucketKey) {
                $key = $bucketKey($b->created_at);
                if (!$buckets->has($key)) return;
                $bucket = $buckets->get($key);
                $bucket['bookings']++;
                if ($b->status === 'completed') $bucket['revenue'] += (float) $b->total_price;
                $buckets->put($key, $bucket);
            });

        User::whereBetween('created_at', [$start, $end])
            ->get(['created_at'])
            ->each(function ($u) use ($buckets, $bucketKey) {
                $key = $bucketKey($u->created_at);
                if (!$buckets->has($key)) return;
                $bucket = $buckets->get($key);
                $bucket['users']++;
                $buckets->put($key, $bucket);
            });

        $monthLabels    = $buckets->pluck('label')->values();
        $revenueSeries  = $buckets->pluck('revenue')->values();
        $bookingsSeries = $buckets->pluck('bookings')->values();
        $usersSeries    = $buckets->pluck('users')->values();

        // ---- Range-scoped totals (current vs previous for growth %) --------
        $curRevenue  = (float) Booking::where('status', 'completed')->whereBetween('created_at', [$start, $end])->sum('total_price');
        $curComm     = (float) Booking::where('status', 'completed')->whereBetween('created_at', [$start, $end])->sum('commission_fee');
        $curBookings = Booking::whereBetween('created_at', [$start, $end])->count();
        $curCompleted= Booking::where('status', 'completed')->whereBetween('created_at', [$start, $end])->count();
        $curCancelled= Booking::where('status', 'cancelled')->whereBetween('created_at', [$start, $end])->count();
        $curUsers    = User::where('role', 'user')->whereBetween('created_at', [$start, $end])->count();

        $prevRevenue  = (float) Booking::where('status', 'completed')->whereBetween('created_at', [$prevStart, $prevEnd])->sum('total_price');
        $prevBookings = Booking::whereBetween('created_at', [$prevStart, $prevEnd])->count();
        $prevUsers    = User::where('role', 'user')->whereBetween('created_at', [$prevStart, $prevEnd])->count();

        $growth = fn ($cur, $prev) => $prev > 0 ? round(($cur - $prev) / $prev * 100, 1) : ($cur > 0 ? 100.0 : 0.0);

        // ---- Doughnut: booking status (in range) ---------------------------
        $statusCounts = Booking::whereBetween('created_at', [$start, $end])
            ->selectRaw('status, COUNT(*) as c')->groupBy('status')->pluck('c', 'status');
        $statusOrder  = ['pending', 'confirmed', 'completed', 'cancelled'];
        $statusLabels = collect($statusOrder)->merge($statusCounts->keys())->unique()->values();
        $statusData   = $statusLabels->map(fn ($s) => (int) ($statusCounts[$s] ?? 0));

        // ---- Top categories (in range) -------------------------------------
        $topCategories = Booking::whereBetween('bookings.created_at', [$start, $end])
            ->join('services', 'bookings.service_id', '=', 'services.id')
            ->leftJoin('service_categories', 'services.category_id', '=', 'service_categories.id')
            ->selectRaw("COALESCE(service_categories.name, 'Uncategorized') as name, COUNT(*) as c")
            ->groupBy('name')->orderByDesc('c')->limit(6)->pluck('c', 'name');

        // ---- Top services (in range) ---------------------------------------
        $topServices = Booking::whereBetween('bookings.created_at', [$start, $end])
            ->join('services', 'bookings.service_id', '=', 'services.id')
            ->selectRaw('services.name as name, COUNT(*) as c')
            ->groupBy('services.name')->orderByDesc('c')->limit(6)->pluck('c', 'name');

        // ---- Top vendors by completed revenue (in range) -------------------
        $topVendors = Booking::where('bookings.status', 'completed')
            ->whereBetween('bookings.created_at', [$start, $end])
            ->join('users', 'bookings.vendor_id', '=', 'users.id')
            ->selectRaw('users.name as name, SUM(bookings.total_price) as total')
            ->groupBy('users.name')->orderByDesc('total')->limit(6)->pluck('total', 'name');

        // ---- City-wise revenue (in range) — service.location maps to city --
        $topCities = Booking::where('bookings.status', 'completed')
            ->whereBetween('bookings.created_at', [$start, $end])
            ->join('services', 'bookings.service_id', '=', 'services.id')
            ->whereNotNull('services.location')->where('services.location', '!=', '')
            ->selectRaw('services.location as name, SUM(bookings.total_price) as total, COUNT(*) as c')
            ->groupBy('services.location')->orderByDesc('total')->limit(6)->get();

        // ---- Cash-flow: withdrawals / payouts ------------------------------
        $pendingPayouts      = (float) Withdrawal::whereIn('status', ['pending', 'approved'])->sum('amount');
        $pendingPayoutsCount = Withdrawal::whereIn('status', ['pending', 'approved'])->count();
        $paidPayouts         = (float) Withdrawal::where('status', 'paid')->sum('amount');

        // ---- Vendor verification funnel ------------------------------------
        $vendorsTotal    = User::where('role', 'vendor')->count();
        $vendorsVerified = User::where('role', 'vendor')->where('is_verified', true)->count();
        $vendorsPending  = $vendorsTotal - $vendorsVerified;

        // ---- KPI cards -----------------------------------------------------
        $cancelRate = $curBookings > 0 ? round($curCancelled / $curBookings * 100, 1) : 0.0;
        $kpis = [
            'revenue'    => $curRevenue,
            'commission' => $curComm,
            'aov'        => $curCompleted > 0 ? $curRevenue / $curCompleted : 0.0,
            'bookings'   => $curBookings,
            'completed'  => $curCompleted,
            'users'      => $curUsers,
            'cancel_rate'=> $cancelRate,
            'pending_payouts' => $pendingPayouts,
            // growth %
            'g_revenue'  => $growth($curRevenue, $prevRevenue),
            'g_bookings' => $growth($curBookings, $prevBookings),
            'g_users'    => $growth($curUsers, $prevUsers),
        ];

        $funnel = [
            'vendors_total'    => $vendorsTotal,
            'vendors_verified' => $vendorsVerified,
            'vendors_pending'  => $vendorsPending,
            'pending_payouts'  => $pendingPayouts,
            'pending_payouts_count' => $pendingPayoutsCount,
            'paid_payouts'     => $paidPayouts,
        ];

        $rangeMeta = [
            'range' => $range,
            'from'  => $start->format('Y-m-d'),
            'to'    => $end->format('Y-m-d'),
            'label' => $start->format('M j, Y') . ' – ' . $end->format('M j, Y'),
        ];

        return view('admin.analytics', compact(
            'monthLabels', 'revenueSeries', 'bookingsSeries', 'usersSeries',
            'statusLabels', 'statusData', 'topCategories', 'topServices',
            'topVendors', 'topCities', 'kpis', 'funnel', 'rangeMeta'
        ));
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
     * Store a service created by the admin on behalf of a selected vendor (or the admin themselves).
     */
    public function storeService(Request $request)
    {
        // Drop empty package / add-on rows submitted by the dynamic form before validating.
        $request->merge([
            'packages' => collect($request->input('packages', []))
                ->filter(fn ($p) => filled($p['name'] ?? null) || filled($p['price'] ?? null))
                ->values()
                ->all(),
            'add_ons' => collect($request->input('add_ons', []))
                ->filter(fn ($a) => filled($a['name'] ?? null) || filled($a['price'] ?? null))
                ->values()
                ->all(),
        ]);

        $validated = $request->validate([
            'user_id'      => 'required|exists:users,id',
            'name'         => 'required|string|max:255',
            'description'  => 'required|string',
            'price'        => 'required|numeric|min:0',
            'price_type'   => 'nullable|string|max:50',
            'category_id'  => 'nullable|exists:service_categories,id',
            'new_category_name' => 'nullable|string|max:100',
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

        $categoryId = $validated['category_id'] ?? null;
        if (!empty($validated['new_category_name'])) {
            $category = ServiceCategory::create([
                'name'      => $validated['new_category_name'],
                'slug'      => Str::slug($validated['new_category_name']),
                'is_active' => true,
            ]);
            $categoryId = $category->id;
        }

        $featuredPath = null;
        if ($request->hasFile('featured_image')) {
            $featuredPath = $request->file('featured_image')->store('services', 'public');
        }

        $galleryPaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $galleryPaths[] = $image->store('services', 'public');
            }
        }

        $imagePaths = $featuredPath ? array_merge([$featuredPath], $galleryPaths) : $galleryPaths;

        $service = Service::create([
            'user_id'              => $validated['user_id'],
            'name'                 => $validated['name'],
            'description'          => $validated['description'],
            'price'                => $validated['price'],
            'price_type'           => $validated['price_type'] ?? 'fixed',
            'category_id'          => $categoryId,
            'location'             => $validated['location'] ?? null,
            'extra_data'           => $request->input('extra', []),
            'image'                => $imagePaths[0] ?? null,
            'images'               => $imagePaths,
            'featured_image_index' => 0,
            'packages'             => $request->packages,
            'add_ons'              => $request->add_ons,
            'status'               => 'active',
        ]);

        // Notify the vendor that the admin published a service for them (skip if admin made it for themselves)
        if ($service->user_id !== Auth::id()) {
            Notification::createServiceNotification(
                $service->user_id,
                'Service Published by Admin',
                'A new service "' . $service->name . '" has been added to your account by the admin.',
                route('services.show', $service)
            );
        }

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

