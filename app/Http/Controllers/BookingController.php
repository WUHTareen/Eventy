<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Booking;
use App\Models\Service;
use App\Models\Notification;
use App\Models\Coupon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingReceipt;
use App\Mail\BookingNotification;
use Barryvdh\DomPDF\Facade\Pdf;

class BookingController extends Controller
{
    // User: Show booking form
    public function create(Service $service)
    {
        return view('bookings.create', compact('service'));
    }

    // User: Check availability (AJAX)
    public function checkAvailability(Request $request, Service $service)
    {
        $date = $request->query('date');
        if (!$date) return response()->json(['available' => false]);
        
        $isAvailable = $service->isAvailableOn($date);
        
        return response()->json([
            'available' => $isAvailable,
            'message' => $isAvailable ? 'Date is available.' : 'This date is unavailable.'
        ]);
    }

    // User: Get all unavailable dates (AJAX for Calendar)
    public function getUnavailableDates(Service $service)
    {
        // 1. Get explicitly blocked dates
        $blockedDates = $service->availability()
            ->whereDate('unavailable_date', '>=', now())
            ->pluck('unavailable_date')
            ->toArray();

        // 2. Get fully booked dates
        // For simplicity, we assume 1 booking blocks the day. 
        // If multiple bookings per day are allowed, this logic needs refinement (checking against capacity).
        // For now, based on "double-booking prevent", 1 booking = blocked.
        $bookedDates = $service->bookings()
            ->whereDate('booking_date', '>=', now())
            ->whereIn('status', ['pending', 'confirmed'])
            ->pluck('booking_date')
            ->map(function ($date) {
                return $date->format('Y-m-d');
            })
            ->toArray();

        // Merge and unique
        $allUnavailable = array_values(array_unique(array_merge($blockedDates, $bookedDates)));

        return response()->json($allUnavailable);
    }

    // User: Store booking
    public function store(Request $request, Service $service)
    {
        // 1. Availability Check (Optimistic first check)
        if (!$service->isAvailableOn($request->booking_date)) {
            return back()->with('error', 'The selected date is no longer available. Please choose another date.');
        }

        $rules = [
            // Contact Info
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'required|email|max:255',
            // Event Details
            'event_type' => 'required|string|max:100',
            'booking_date' => 'required|date|after:now',
            'event_end_date' => 'nullable|date|after:booking_date',
            'event_location' => 'required|string|max:255',
            'event_address' => 'nullable|string|max:500',
            'guest_count' => 'nullable|integer|min:1',
            // Requirements
            'budget' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'special_requests' => 'nullable|string',
            'booking_data' => 'nullable|array',
            'package_name' => 'nullable|string|max:100',
            'selected_addons' => 'nullable|array',
            'total_price' => 'nullable|numeric|min:0',
        ];

        $request->validate($rules);

        // Recalculate/Verify Price
        $finalPrice = $service->price; // Default base price
        
        if ($request->package_name) {
            $finalPrice = $service->getTieredPrice($request->package_name) ?? $service->price;
        }

        if ($request->selected_addons) {
            foreach ($request->selected_addons as $addonName) {
                $finalPrice += $service->getAddOnPrice($addonName);
            }
        }

        // Dynamic Pricing Multiplier based on Category
        $categorySlug = $service->category->slug ?? 'misc';

        if (in_array($categorySlug, ['catering', 'wedding-catering', 'corporate-lunch'])) {
            $guests = max(1, (int) $request->guest_count);
            $finalPrice *= $guests;
        } elseif (in_array($categorySlug, ['transport', 'luxury-rentals', 'coasters-buses', 'protocol-jeeps'])) {
            $duration = max(1, (int) $request->input('booking_data.duration_days', 1));
            if ($request->event_type === 'daily' || $categorySlug === 'luxury-rentals') {
                 $finalPrice *= $duration;
            }
        } elseif (in_array($categorySlug, ['hotels', '5-star', 'resorts', 'guest-houses', 'hotels-stays'])) {
            $rooms = max(1, (int) $request->input('booking_data.room_count', 1));
            $finalPrice *= $rooms;
        } elseif (in_array($categorySlug, ['umrah', 'travel', 'group-tours'])) {
            $guests = max(1, (int) $request->guest_count);
            $finalPrice *= $guests;
        }

        // Apply Coupon if provided
        $discount = 0;
        $appliedCoupon = null;
        if ($request->coupon_code) {
            $appliedCoupon = Coupon::where('code', $request->coupon_code)->first();
            if ($appliedCoupon && $appliedCoupon->isValidFor($finalPrice, $service->user_id)) {
                $discount = $appliedCoupon->calculateDiscount($finalPrice);
                $finalPrice -= $discount;
            }
        }

        // Specialized Validation Rules based on Category
        // Specialized Validation Rules
        // $categorySlug is already defined above
        
        if (in_array($categorySlug, ['transport', 'luxury-rentals', 'coasters-buses', 'protocol-jeeps'])) {
            $rules['booking_data.passengers'] = 'required|integer|min:1';
            $rules['booking_data.luggage'] = 'nullable|integer|min:0';
            $rules['booking_data.pickup_location'] = 'required|string|max:255';
            $rules['booking_data.dropoff_location'] = 'required|string|max:255';
        } elseif (in_array($categorySlug, ['umrah', 'travel', 'group-tours'])) {
            $rules['guest_count'] = 'required|integer|min:1';
            $rules['booking_data.duration_days'] = 'required|integer|min:1';
        } elseif (in_array($categorySlug, ['catering', 'wedding-catering', 'corporate-lunch'])) {
            $rules['guest_count'] = 'required|integer|min:1';
            $rules['booking_data.menu_preference'] = 'required|string';
        } elseif ($categorySlug === 'visa') {
            $rules['booking_data.passport_no'] = 'required|string|max:50';
            $rules['booking_data.nationality'] = 'required|string|max:100';
        } elseif (in_array($categorySlug, ['photography', 'videography', 'drone', 'media', 'wedding-photography', 'event-videography', 'drone-shoots'])) {
            $rules['booking_data.coverage_hours'] = 'required|integer|min:1';
            $rules['booking_data.deliverables'] = 'nullable|array';
        } elseif (in_array($categorySlug, ['hotels', '5-star', 'resorts', 'guest-houses', 'hotels-stays'])) {
            $rules['booking_data.room_type'] = 'required|string';
            $rules['booking_data.room_count'] = 'required|integer|min:1';
        }

        if ($request->event_type === 'daily') {
            $rules['booking_data.duration_days'] = 'required|integer|min:1';
        }

        $request->validate($rules);

        // Initialize booking_data
        $bookingData = $request->input('booking_data', []);
        $bookingData['package_name'] = $request->package_name;
        $bookingData['selected_addons'] = $request->selected_addons ?? [];
        if ($appliedCoupon) {
            $bookingData['coupon_code'] = $appliedCoupon->code;
            $bookingData['discount_amount'] = $discount;
        }

        try {
            $booking = DB::transaction(function () use ($request, $service, $bookingData, $finalPrice, $appliedCoupon) {
                // Re-fetch service with lock to prevent race conditions
                $lockedService = Service::lockForUpdate()->find($service->id);
                
                // Double-check availability within lock
                if (!$lockedService->isAvailableOn($request->booking_date)) {
                    throw new \Exception('Slot taken just now. Please try another date.');
                }

                // 5. Calculate Commission (10%)
                $commissionRate = 0.10;
                $commissionFee = $finalPrice * $commissionRate;
                $vendorNet = $finalPrice - $commissionFee;

                // 6. Create Booking Record
                $booking = Booking::create([
                    'tracking_token' => Str::random(48),
                    'user_id' => Auth::id(),
                    'service_id' => $service->id,
                    'vendor_id' => $service->user_id,
                    'booking_date' => $request->booking_date,
                    'status' => 'pending', // Pending vendor approval
                    'notes' => $request->notes,
                    'customer_name' => $request->customer_name,
                    'customer_phone' => $request->customer_phone,
                    'customer_email' => $request->customer_email,
                    'event_type' => $request->event_type,
                    'event_end_date' => $request->event_end_date,
                    'event_location' => $request->event_location ?? ($request->pickup_location ?? 'N/A'),
                    'event_address' => $request->event_address ?? $request->event_location,
                    'guest_count' => $request->guest_count, // Generic mapping
                    'budget' => $request->budget,
                    'special_requests' => $request->special_requests,
                    'booking_data' => $bookingData,
                    'total_price' => $finalPrice,
                    'commission_fee' => $commissionFee,
                    'vendor_net_amount' => $vendorNet,
                    'payout_status' => 'pending',
                ]);

                // Increment coupon usage if valid
                if ($appliedCoupon) {
                    $appliedCoupon->increment('used_count');
                }

                // Service desk assignment
                $deskCategories = [
                    'catering' => 'catering',
                    'photography' => 'photography',
                    'videography' => 'videography',
                    'drone' => 'drone',
                    'live_streaming' => 'live_streaming',
                ];
                $categorySlug = $service->category->slug ?? null;
                
                if ($categorySlug && isset($deskCategories[$categorySlug])) {
                     $this->assignToDesk($booking, $deskCategories[$categorySlug]);
                }
                
                return $booking;
            });

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
        // Notify the vendor about new booking with details
        $countLabel = in_array($categorySlug, ['catering', 'wedding-catering', 'corporate-lunch']) ? 'plates' : 'guests';
        $specializedInfo = '';
        if ($categorySlug === 'transport') {
            $specializedInfo = ' (' . ($booking->booking_data['passengers'] ?? 0) . ' passengers, ' . ($booking->booking_data['pickup_location'] ?? 'N/A') . ' to ' . ($booking->booking_data['dropoff_location'] ?? 'N/A') . ')';
        } elseif ($categorySlug === 'visa') {
            $specializedInfo = ' (Nationality: ' . ($booking->booking_data['nationality'] ?? 'N/A') . ')';
        } elseif ($categorySlug === 'umrah' || $categorySlug === 'travel') {
            $specializedInfo = ' (' . ($booking->guest_count ?? 0) . ' travelers, ' . ($booking->booking_data['duration_days'] ?? 0) . ' days)';
        }

        Notification::createBookingNotification(
            $service->user_id,
            'New Portfolio Booking!',
            'Protocol Initiated by ' . $request->customer_name . ' for "' . $service->name . '". Mission Date: ' . \Carbon\Carbon::parse($request->booking_date)->format('M d, Y') . '. Status: Awaiting Approval.',
            route('vendor.orders'),
            'fa-clipboard-check',
            'indigo'
        );

        // Notify the user about their booking (only for logged-in customers)
        if (Auth::check()) {
            Notification::createBookingNotification(
                Auth::id(),
                'Deployment Scheduled',
                'Your booking for "' . $service->name . '" has been submitted for verification. Current Status: [Pending Node Approval].',
                route('bookings.index'),
                'fa-clock',
                'orange'
            );
        }

        // Send Email Receipt to the customer
        try {
            Mail::to($request->customer_email)->send(new BookingReceipt($booking));
        } catch (\Exception $e) {
            // Log mail error but don't stop flow
            \Illuminate\Support\Facades\Log::error('Customer receipt mail failed: ' . $e->getMessage());
        }

        // Notify the vendor by email about the new booking
        try {
            $vendorEmail = optional($service->user)->email;
            if ($vendorEmail) {
                Mail::to($vendorEmail)->send(new BookingNotification(
                    $booking,
                    'New Booking Received: ' . $service->name,
                    'You have a new booking from ' . $request->customer_name
                        . ' (' . $request->customer_phone . '). Please review and confirm it from your orders dashboard.'
                ));
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Vendor notification mail failed: ' . $e->getMessage());
        }

        // Notify platform admins by email
        try {
            $adminEmails = \App\Models\User::where('role', 'admin')->pluck('email')->filter()->all();
            if (!empty($adminEmails)) {
                Mail::to($adminEmails)->send(new BookingNotification(
                    $booking,
                    'New Booking on Eventy: ' . $service->name,
                    'A new booking (#' . $booking->id . ') was placed by ' . $request->customer_name
                        . ' for "' . $service->name . '".'
                ));
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Admin notification mail failed: ' . $e->getMessage());
        }

        if (Auth::check()) {
            return redirect()->route('home')->with('success', 'Thank you! Your booking protocol has been initiated safely.');
        }

        // Guests have no login, so send them to a public tracking page
        // (also emailed to them) where they can check status and pay.
        return redirect()->route('bookings.track', ['booking' => $booking->id, 'token' => $booking->tracking_token])
            ->with('success', 'Thank you! Your booking has been received. Save this link to track it or pay.');
    }

    /**
     * Public booking status/payment page for guests who booked without an account.
     * Access is gated by the per-booking tracking token, not auth.
     */
    public function track(Request $request, Booking $booking)
    {
        if (! $request->query('token') || $request->query('token') !== $booking->tracking_token) {
            abort(403);
        }

        $booking->load(['service', 'payment']);

        return view('bookings.track', compact('booking'));
    }

    /**
     * Assign booking to service desk and create ServiceDeskRequest
     */
    public function assignToDesk(Booking $booking, string $deskType)
    {
        $serviceDeskController = app(\App\Http\Controllers\ServiceDeskController::class);
        $deskRequest = $serviceDeskController->store(new \Illuminate\Http\Request([
            'customer_name' => $booking->customer_name,
            'customer_email' => $booking->customer_email,
            'customer_phone' => $booking->customer_phone,
            'service_type' => $booking->event_type,
            'desk_type' => $deskType,
            'priority' => 'medium',
            'booking_id' => $booking->id,
            'event_location' => $booking->event_location,
            'event_address' => $booking->event_address,
            'event_date' => $booking->booking_date,
            'guest_count' => $booking->guest_count,
        ]));

        // Handle JSON response correctly
        if (method_exists($deskRequest, 'getData')) {
            $data = $deskRequest->getData();
            return $data->reference ?? null;
        }

        return null;
    }

    // User: My Bookings
    public function index()
    {
        $bookings = Auth::user()->bookings()->with(['service', 'review'])->latest()->get();
        return view('bookings.index', compact('bookings'));
    }

    // Vendor: Manage Orders
    public function vendorIndex()
    {
        $bookings = Auth::user()->receivedBookings()->with(['user', 'service', 'payment'])->latest()->get();
        return view('vendor.orders', compact('bookings'));
    }

    // Vendor: Verify a manual payment submitted for one of their bookings
    public function vendorVerifyPayment(Booking $booking)
    {
        if (Auth::id() !== $booking->vendor_id) {
            abort(403);
        }

        $payment = $booking->payment;
        if (!$payment || $payment->status !== 'awaiting_verification') {
            return redirect()->back()->with('error', 'No payment is awaiting verification for this booking.');
        }

        $payment->update([
            'status'      => 'completed',
            'verified_at' => now(),
            'verified_by' => Auth::id(),
        ]);

        if ($booking->user_id) {
            Notification::createSystemNotification(
                $booking->user_id,
                'Payment Confirmed',
                "Your payment for Booking #{$booking->id} has been verified. Thank you!",
                route('bookings.index')
            );
        }

        return redirect()->back()->with('success', 'Payment verified successfully.');
    }

    // Vendor: Reject a manual payment submitted for one of their bookings
    public function vendorRejectPayment(Request $request, Booking $booking)
    {
        if (Auth::id() !== $booking->vendor_id) {
            abort(403);
        }

        $request->validate([
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $payment = $booking->payment;
        if (!$payment || $payment->status !== 'awaiting_verification') {
            return redirect()->back()->with('error', 'No payment is awaiting verification for this booking.');
        }

        $payment->update([
            'status'      => 'failed',
            'admin_notes' => $request->admin_notes,
            'verified_at' => now(),
            'verified_by' => Auth::id(),
        ]);

        if ($booking->user_id) {
            Notification::createSystemNotification(
                $booking->user_id,
                'Payment Rejected',
                "Your payment proof for Booking #{$booking->id} could not be verified. " . ($request->admin_notes ? "Reason: {$request->admin_notes}" : 'Please re-submit.'),
                route('bookings.index')
            );
        }

        return redirect()->back()->with('success', 'Payment rejected. Customer has been notified.');
    }

    // Vendor: Update Status
    public function updateStatus(Request $request, Booking $booking)
    {
        if (Auth::id() !== $booking->vendor_id) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:confirmed,completed,cancelled',
        ]);

        $oldStatus = $booking->status;

        DB::transaction(function () use ($request, $booking, $oldStatus) {
            $booking->update(['status' => $request->status]);

            // Handle Wallet logic: If moved to completed, add net amount to vendor balance
            if ($request->status === 'completed' && $oldStatus !== 'completed') {
                $vendor = $booking->vendor;
                $vendor->increment('balance', $booking->vendor_net_amount);
            }
        });

        // Notify the customer about status change
        $statusMessages = [
            'confirmed' => 'Great news! Your booking has been confirmed by the vendor.',
            'completed' => 'Your booking has been marked as completed. Please rate your experience!',
            'cancelled' => 'Update: Your booking has been cancelled by the vendor.',
        ];

        $colors = [
            'confirmed' => 'green',
            'completed' => 'blue',
            'cancelled' => 'red',
        ];

        $icons = [
            'confirmed' => 'fa-calendar-check',
            'completed' => 'fa-check-double',
            'cancelled' => 'fa-circle-xmark',
        ];

        // Notify the customer only if they have a registered account (guests have no user_id)
        if ($booking->user_id) {
            Notification::createBookingNotification(
                $booking->user_id,
                'Protocol Update: ' . ucfirst($request->status),
                'The asset node [' . $booking->service->name . '] has updated your mission status to: ' . strtoupper($request->status) . '.',
                route('bookings.index'),
                $icons[$request->status],
                $colors[$request->status]
            );
        }

        // Notify vendor about their own action (confirmation)
        Notification::createBookingNotification(
            Auth::id(),
            'Mission Record Updated',
            'You have ' . $request->status . ' the booking for ' . $booking->customer_name . '.',
            route('vendor.orders'),
            'fa-check-circle',
            'blue'
        );

        // Email the customer about the status change
        try {
            if ($booking->customer_email) {
                Mail::to($booking->customer_email)->send(new BookingNotification(
                    $booking,
                    'Booking ' . ucfirst($request->status) . ': ' . $booking->service->name,
                    $statusMessages[$request->status] ?? ('Your booking status is now ' . $request->status . '.')
                ));
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Status update mail failed: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Order status updated.');
    }

    public function downloadInvoice(Booking $booking)
    {
        // Authorization: User/Vendor/Admin can download
        if (Auth::id() !== $booking->user_id && Auth::id() !== $booking->vendor_id && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $booking->load(['service', 'vendor', 'user']);
        
        $pdf = Pdf::loadView('admin.booking-invoice', compact('booking'));
        
        return $pdf->download('Invoice-' . $booking->id . '.pdf');
    }
}
