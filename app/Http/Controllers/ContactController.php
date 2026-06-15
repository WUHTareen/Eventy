<?php

namespace App\Http\Controllers;

use App\Models\ContactInquiry;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'service_type' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        // Desk routing config
        $deskMap = [
            'Flights Booking' => ['desk_type' => 'flights', 'email' => 'flights@eventy.pk'],
            'Hotel Reservation' => ['desk_type' => 'hotels', 'email' => 'hotels@eventy.pk'],
            'Visa Consultancy' => ['desk_type' => 'visa', 'email' => 'visa@eventy.pk'],
            'Tour Packages' => ['desk_type' => 'tours', 'email' => 'tours@eventy.pk'],
            'Cab/Transportation' => ['desk_type' => 'cabs', 'email' => 'cab@eventy.pk'],
            'Catering Services' => ['desk_type' => 'catering', 'email' => 'events@eventy.pk'],
            'Photography Services' => ['desk_type' => 'photography', 'email' => 'events@eventy.pk'],
            'Videography Services' => ['desk_type' => 'videography', 'email' => 'events@eventy.pk'],
            'Drone Coverage' => ['desk_type' => 'drone', 'email' => 'events@eventy.pk'],
            'Live Streaming' => ['desk_type' => 'live_streaming', 'email' => 'events@eventy.pk'],
        ];
        $serviceType = $validated['service_type'] ?? null;
        $deskConfig = $deskMap[$serviceType] ?? null;

        if ($deskConfig) {
            // Create ServiceDeskRequest and trigger mail classes
            $serviceDeskController = app(\App\Http\Controllers\ServiceDeskController::class);
            $deskRequest = $serviceDeskController->store(new Request([
                'customer_name' => $validated['name'],
                'customer_email' => $validated['email'],
                'customer_phone' => $request->input('phone', ''),
                'service_type' => $serviceType,
                'desk_type' => $deskConfig['desk_type'],
                'priority' => 'medium',
                'message' => $validated['message'],
                // Add all request fields for desk-specific models
                ...$request->except(['_token']),
            ]));
            // Optionally persist a lightweight ContactInquiry for reporting
            ContactInquiry::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'service_type' => $serviceType,
                'message' => $validated['message'],
                'status' => 'desk_routed',
            ]);
            return redirect()->route('contact')->with('success', 'Your request has been routed to the relevant service desk. Reference: #' . ($deskRequest->getData()->reference ?? ''));
        } else {
            // General inquiry
            ContactInquiry::create($validated);
            return redirect()->route('contact')->with('success', 'Your message has been sent successfully! We will get back to you soon.');
        }
    }
}
