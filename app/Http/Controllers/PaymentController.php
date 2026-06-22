<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\SiteSetting;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
                    'unit_amount' => (int) round(($booking->total_price ?: $booking->service->price) * 100), // Stripe uses cents
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
                'amount' => $booking->total_price ?: $booking->service->price,
                'currency' => 'PKR',
                'status' => 'pending',
                'payment_method' => 'stripe'
            ]
        );

        return redirect()->away($session->url);
    }

    /**
     * Authorize access to a booking's payment for either the logged-in
     * owner, or a guest presenting the booking's tracking token.
     */
    private function authorizeBookingAccess(Request $request, Booking $booking): void
    {
        if (Auth::id() === $booking->user_id && Auth::id() !== null) {
            return;
        }

        $token = $request->query('token') ?? $request->input('token');
        if ($booking->user_id === null && $token && $token === $booking->tracking_token) {
            return;
        }

        abort(403);
    }

    /**
     * Show the manual / bank transfer payment page where the customer can
     * see the platform's account details and upload proof of payment.
     */
    public function showManual(Request $request, Booking $booking)
    {
        $this->authorizeBookingAccess($request, $booking);

        if ($booking->payment && $booking->payment->status === 'completed') {
            $redirect = $booking->user_id ? redirect()->route('bookings.index') : redirect()->route('bookings.track', ['booking' => $booking->id, 'token' => $booking->tracking_token]);
            return $redirect->with('error', 'This booking is already paid.');
        }

        $accounts = [
            'bank_name'        => SiteSetting::get('bank_name'),
            'bank_title'       => SiteSetting::get('bank_account_title'),
            'bank_account'     => SiteSetting::get('bank_account_number'),
            'bank_iban'        => SiteSetting::get('bank_iban'),
            'jazzcash_number'  => SiteSetting::get('jazzcash_number'),
            'easypaisa_number' => SiteSetting::get('easypaisa_number'),
            'instructions'     => SiteSetting::get('payment_instructions'),
        ];

        $amount = $booking->total_price ?: optional($booking->service)->price;
        $token = $request->query('token');

        return view('bookings.pay-manual', compact('booking', 'accounts', 'amount', 'token'));
    }

    /**
     * Store the customer's manual payment submission (proof + reference) and
     * mark it as awaiting admin verification.
     */
    public function submitManual(Request $request, Booking $booking)
    {
        $this->authorizeBookingAccess($request, $booking);

        if ($booking->payment && $booking->payment->status === 'completed') {
            $redirect = $booking->user_id ? redirect()->route('bookings.index') : redirect()->route('bookings.track', ['booking' => $booking->id, 'token' => $booking->tracking_token]);
            return $redirect->with('error', 'This booking is already paid.');
        }

        $validated = $request->validate([
            'payment_method'        => 'required|in:bank,jazzcash,easypaisa',
            'sender_name'           => 'required|string|max:120',
            'transaction_reference' => 'required_unless:payment_method,bank|nullable|string|max:120',
            'payment_proof'         => 'required|image|mimes:png,jpg,jpeg|max:4096',
        ]);

        $proofPath = $request->file('payment_proof')->store('payment-proofs', 'public');

        $amount = $booking->total_price ?: optional($booking->service)->price;

        Payment::updateOrCreate(
            ['booking_id' => $booking->id],
            [
                'user_id'               => $booking->user_id ?? Auth::id(),
                'amount'                => $amount,
                'currency'              => 'PKR',
                'status'                => 'awaiting_verification',
                'payment_method'        => $validated['payment_method'],
                'payment_proof'         => $proofPath,
                'transaction_reference' => $validated['transaction_reference'] ?? null,
                'sender_name'           => $validated['sender_name'],
                'admin_notes'           => null,
                'verified_at'           => null,
                'verified_by'           => null,
            ]
        );

        // Notify all admins that a payment needs verification
        foreach (User::where('role', 'admin')->pluck('id') as $adminId) {
            Notification::createSystemNotification(
                $adminId,
                'Payment Verification Needed',
                "Payment proof submitted for Booking #{$booking->id} (PKR " . number_format($amount) . ").",
                route('admin.payments.index')
            );
        }

        if ($booking->user_id) {
            return redirect()->route('bookings.index')
                ->with('success', 'Payment proof submitted! Our team will verify it shortly.');
        }

        return redirect()->route('bookings.track', ['booking' => $booking->id, 'token' => $booking->tracking_token])
            ->with('success', 'Payment proof submitted! Our team will verify it shortly.');
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
