<?php

namespace App\Http\Controllers;

use App\Models\ServiceDeskRequest;
use Illuminate\Http\Request;

class ServiceDeskController extends Controller
{
    public function index()
    {
        $requests = ServiceDeskRequest::with(['user', 'booking'])
            ->latest()
            ->paginate(20);
            
        return view('service-desk.index', compact('requests'));
    }

    public function store(Request $request)
    {
        // Generate a unique reference for the service desk request
        $reference = 'SD-' . strtoupper(bin2hex(random_bytes(4)));

        $deskRequest = ServiceDeskRequest::create([
            'user_id' => $request->input('user_id'),
            'booking_id' => $request->input('booking_id'),
            'reference' => $reference,
            'customer_name' => $request->input('customer_name'),
            'customer_email' => $request->input('customer_email'),
            'customer_phone' => $request->input('customer_phone'),
            'service_type' => $request->input('service_type'),
            'desk_type' => $request->input('desk_type'),
            'priority' => $request->input('priority', 'medium'),
            'status' => 'pending',
            'event_location' => $request->input('event_location'),
            'event_address' => $request->input('event_address'),
            'event_date' => $request->input('event_date'),
            'guest_count' => $request->input('guest_count'),
            'notes' => $request->input('notes'),
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Service desk request created successfully.',
            'reference' => $reference,
            'data' => $deskRequest
        ], 201);
    }

    public function show($id)
    {
        // Placeholder
        return back();
    }

    public function assign(Request $request, $id)
    {
        // Placeholder
        return back();
    }

    public function updateStatus(Request $request, $id)
    {
        // Placeholder
        return back();
    }
}
