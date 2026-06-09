<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceAvailability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorAvailabilityController extends Controller
{
    /**
     * Display the availability calendar for a service.
     */
    public function index(Service $service)
    {
        // Ensure user owns the service
        if ($service->user_id !== Auth::id()) {
            abort(403);
        }

        return view('vendor.availability.index', compact('service'));
    }

    /**
     * Fetch all events (bookings + blocked dates) for the calendar.
     */
    public function fetch(Service $service)
    {
        if ($service->user_id !== Auth::id()) {
            abort(403);
        }

        $events = [];

        // 1. Fetch Blocked Dates
        $blocked = $service->availability()->get();
        foreach ($blocked as $block) {
            $events[] = [
                'id' => $block->id,
                'title' => 'Blocked: ' . ($block->reason ?? 'N/A'),
                'start' => $block->unavailable_date->format('Y-m-d'),
                'display' => 'background',
                'color' => '#ef4444', // Red
                'type' => 'blocked'
            ];
        }

        // 2. Fetch Bookings
        $bookings = $service->bookings()->whereIn('status', ['pending', 'confirmed', 'completed'])->get();
        foreach ($bookings as $booking) {
            $events[] = [
                'id' => 'booking-' . $booking->id,
                'title' => 'Booked: ' . $booking->customer_name,
                'start' => $booking->booking_date->format('Y-m-d'),
                'color' => '#3b82f6', // Blue
                'type' => 'booking',
                'url' => route('vendor.orders') // Link to order details
            ];
        }

        return response()->json($events);
    }

    /**
     * Block a specific date.
     */
    public function store(Request $request, Service $service)
    {
        if ($service->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'reason' => 'nullable|string|max:255'
        ]);

        // Check if already booked
        if (!$service->isAvailableOn($request->date)) {
            return response()->json(['message' => 'Date is already booked or blocked.'], 422);
        }

        $calc = $service->availability()->create([
            'unavailable_date' => $request->date,
            'reason' => $request->reason
        ]);

        return response()->json(['message' => 'Date blocked successfully.', 'id' => $calc->id]);
    }

    /**
     * Unblock a date.
     */
    public function destroy(ServiceAvailability $availability)
    {
        if ($availability->service->user_id !== Auth::id()) {
            abort(403);
        }

        $availability->delete();

        return response()->json(['message' => 'Date unblocked successfully.']);
    }
}
