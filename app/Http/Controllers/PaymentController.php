<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function createCheckoutSession(Booking $booking)
    {
        // Authorization
        if (Auth::id() !== $booking->user_id) {
            abort(403);
        }

        // Prevent double payment
        if ($booking->payment && $booking->payment->status === 'completed') {
            return redirect()->back()->with('error', 'This booking is already paid.');
        }

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'pkr',
                    'product_data' => [
                        'name' => $booking->service->name,
                        'description' => 'Booking #' . $booking->id,
                    ],
                    'unit_amount' => $booking->service->price * 100, // Stripe uses cents
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('payment.success', ['booking' => $booking->id]) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payment.cancel', ['booking' => $booking->id]),
            'metadata' => [
                'booking_id' => $booking->id,
                'user_id' => Auth::id(),
            ],
        ]);

        // Create or update pending payment record
        Payment::updateOrCreate(
            ['booking_id' => $booking->id],
            [
                'user_id' => Auth::id(),
                'stripe_session_id' => $session->id,
                'amount' => $booking->service->price,
                'currency' => 'PKR',
                'status' => 'pending',
                'payment_method' => 'stripe'
            ]
        );

        return redirect()->away($session->url);
    }

    public function success(Request $request, Booking $booking)
    {
        $sessionId = $request->get('session_id');

        if (!$sessionId) {
            return redirect()->route('bookings.index')->with('error', 'Invalid payment session.');
        }

        $payment = Payment::where('stripe_session_id', $sessionId)->first();

        if ($payment && $payment->status !== 'completed') {
            $payment->update(['status' => 'completed']);
            // Optionally update booking status if your business logic requires it
            // $booking->update(['status' => 'confirmed']); 
        }

        return redirect()->route('bookings.index')->with('success', 'Payment successful! Your booking is confirmed.');
    }

    public function cancel(Booking $booking)
    {
        return redirect()->route('bookings.index')->with('error', 'Payment was cancelled.');
    }

    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = config('services.stripe.webhook_secret');

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;
            $payment = Payment::where('stripe_session_id', $session->id)->first();
            if ($payment) {
                $payment->update(['status' => 'completed']);
            }
        }

        return response()->json(['status' => 'success']);
    }
}
