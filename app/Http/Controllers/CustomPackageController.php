<?php

namespace App\Http\Controllers;

use App\Models\CustomPackage;
use App\Models\CustomPackageBooking;
use App\Models\Booking;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomPackageController extends Controller
{
    public function index()
    {
        $packages = CustomPackage::where('status', 'published')->with('services')->latest()->paginate(12);
        return view('custom-packages.index', compact('packages'));
    }

    public function create()
    {
        $services = Service::where('status', 'active')->with('category', 'user')->get();
        $categories = ServiceCategory::where('is_active', true)->get();
        return view('custom-packages.create', compact('services', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'services' => 'required|array|min:1',
            'services.*' => 'exists:services,id',
            'image' => 'nullable|image|max:2048',
        ]);

        $services = Service::whereIn('id', $validated['services'])->get();
        $totalPrice = $services->sum('price');

        $package = new CustomPackage();
        $package->user_id = Auth::id();
        $package->name = $validated['name'];
        $package->description = $validated['description'];
        $package->total_price = $totalPrice;
        $package->status = 'published';

        if ($request->hasFile('image')) {
            $package->image = $request->file('image')->store('packages', 'public');
        }

        $package->save();
        $package->services()->attach($validated['services']);

        return redirect()->route('packages.book', $package->id)->with('success', 'Package configuration saved! Finalize your booking below.');
    }

    public function show(CustomPackage $package)
    {
        $package->load('services.category', 'services.user', 'user');
        return view('custom-packages.show', compact('package'));
    }

    public function book(CustomPackage $package)
    {
        return view('custom-packages.book', compact('package'));
    }

    public function storeBooking(Request $request, CustomPackage $package)
    {
        $validated = $request->validate([
            'booking_date' => 'required|date|after:now',
            'event_end_date' => 'nullable|date|after:booking_date',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'required|email|max:255',
            'event_location' => 'required|string|max:255',
            'event_address' => 'nullable|string',
            'guest_count' => 'required|integer|min:1',
            'budget' => 'nullable|numeric',
            'notes' => 'nullable|string',
            'special_requests' => 'nullable|string',
            'booking_data' => 'nullable|array',
        ]);

        $booking = new CustomPackageBooking();
        $booking->user_id = Auth::id();
        $booking->custom_package_id = $package->id;
        $booking->booking_date = $validated['booking_date'];
        $booking->event_end_date = $validated['event_end_date'] ?? null;
        $booking->total_amount = $package->total_price;
        $booking->customer_name = $validated['customer_name'];
        $booking->customer_phone = $validated['customer_phone'];
        $booking->customer_email = $validated['customer_email'];
        $booking->event_location = $validated['event_location'];
        $booking->event_address = $validated['event_address'] ?? $validated['event_location'];
        $booking->guest_count = $validated['guest_count'];
        $booking->budget = $validated['budget'] ?? 0;
        $booking->notes = $validated['notes'];
        $booking->special_requests = $validated['special_requests'];
        $booking->booking_data = $validated['booking_data'] ?? [];
        $booking->status = 'pending';
        $booking->save();

        // Create individual vendor bookings
        foreach ($package->services as $service) {
            Booking::create([
                'user_id' => Auth::id(),
                'service_id' => $service->id,
                'vendor_id' => $service->user_id,
                'booking_date' => $validated['booking_date'],
                'event_end_date' => $validated['event_end_date'] ?? null,
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'customer_email' => $validated['customer_email'],
                'event_location' => $validated['event_location'],
                'event_address' => $validated['event_address'] ?? $validated['event_location'],
                'guest_count' => $validated['guest_count'],
                'budget' => $service->price,
                'notes' => "Package Component: [{$package->name}] - " . ($validated['notes'] ?? ''),
                'special_requests' => $validated['special_requests'] ?? '',
                'status' => 'pending',
                'booking_data' => array_merge($validated['booking_data'] ?? [], [
                    'package_booking_id' => $booking->id,
                    'is_custom_package' => true
                ])
            ]);
        }

        // Notify User
        \App\Models\Notification::createBookingNotification(
            Auth::id(),
            'Ensemble Deployment Scheduled',
            'Your multi-vendor package "' . $package->name . '" has been submitted for verification. Status: [Pending Node Approval].',
            route('bookings.index'),
            'fa-boxes-packing',
            'indigo'
        );

        // Notify each vendor
        foreach ($package->services as $service) {
            \App\Models\Notification::createBookingNotification(
                $service->user_id,
                'New Ensemble Component!',
                'Your service "' . $service->name . '" has been booked as part of the "' . $package->name . '" package by ' . $validated['customer_name'] . '.',
                route('vendor.orders'),
                'fa-puzzle-piece',
                'blue'
            );
        }

        return redirect()->route('bookings.index')->with('success', 'Multi-vendor ensemble booking sent with specific requirements!');
    }

    public function myPackages()
    {
        $bookings = \App\Models\CustomPackageBooking::where('user_id', Auth::id())
            ->with(['customPackage.services'])
            ->latest()
            ->paginate(10);
            
        return view('custom-packages.my-packages', compact('bookings'));
    }

    public function showBooking(\App\Models\CustomPackageBooking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }
        
        $booking->load(['customPackage.services', 'customPackage.services.category']);
        
        // Find child vendor bookings
        $childBookings = \App\Models\Booking::where('booking_data->package_booking_id', $booking->id)
            ->with(['vendor', 'service'])
            ->get();
            
        return view('custom-packages.order-details', compact('booking', 'childBookings'));
    }
}
