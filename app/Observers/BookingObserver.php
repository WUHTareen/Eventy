<?php

namespace App\Observers;

use App\Models\Booking;

class BookingObserver
{
    /**
     * Handle the Booking "created" event.
     */
    public function created(Booking $booking): void
    {
        if ($booking->vendor_id) {
            \App\Models\VendorLog::create([
                'vendor_id' => $booking->vendor_id,
                'booking_id' => $booking->id,
                'action' => 'received',
                'description' => 'Vendor received a new order (Booking #' . $booking->id . ')',
            ]);
        }
    }

    /**
     * Handle the Booking "updated" event.
     */
    public function updated(Booking $booking): void
    {
        if ($booking->isDirty('status')) {
            $status = $booking->status;
            if (in_array($status, ['confirmed', 'completed', 'cancelled', 'rejected'])) {
                 \App\Models\VendorLog::create([
                    'vendor_id' => $booking->vendor_id,
                    'booking_id' => $booking->id,
                    'action' => $status,
                    'description' => 'Order ' . ucfirst($status) . ' (Booking #' . $booking->id . ')',
                ]);

                // Phase 1: Send Email Notification
                try {
                    $statusMessages = [
                        'confirmed' => 'Great news! Your booking has been confirmed by the vendor.',
                        'completed' => 'Your booking has been marked as completed. Please rate your experience!',
                        'cancelled' => 'Update: Your booking has been cancelled by the vendor.',
                        'rejected' => 'Update: Your booking request has been rejected by the vendor.',
                    ];

                    \Illuminate\Support\Facades\Mail::to($booking->customer_email)->send(
                        new \App\Mail\BookingNotification(
                            $booking, 
                            'Booking ' . ucfirst($status), 
                            $statusMessages[$status]
                        )
                    );
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error("Failed to send booking email: " . $e->getMessage());
                }

                // Phase 4: Handle Finance logic when completed
                if ($status === 'completed') {
                    $vendor = $booking->vendor;
                    $servicePrice = $booking->service->price;
                    $commissionRate = $vendor->commission_rate ?? 10;
                    
                    $commissionAmount = ($servicePrice * $commissionRate) / 100;
                    $netAmount = $servicePrice - $commissionAmount;

                    // Update vendor balance
                    $vendor->increment('balance', $netAmount);

                    // Optional: Log this transaction for admin records
                    \Illuminate\Support\Facades\Log::info("Commission Processed for Booking #{$booking->id}. Total: {$servicePrice}, Net to Vendor: {$netAmount}, Commission: {$commissionAmount}");
                }
            }
        }
    }

    /**
     * Handle the Booking "deleted" event.
     */
    public function deleted(Booking $booking): void
    {
        //
    }

    /**
     * Handle the Booking "restored" event.
     */
    public function restored(Booking $booking): void
    {
        //
    }

    /**
     * Handle the Booking "force deleted" event.
     */
    public function forceDeleted(Booking $booking): void
    {
        //
    }
}
