<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use App\Models\VendorLog;

class BackfillVendorLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vendor-logs:backfill';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backfill missing vendor logs for existing bookings';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $bookings = Booking::all();
        $this->info("Found " . $bookings->count() . " bookings to process.");

        $count = 0;
        foreach ($bookings as $booking) {
            // Check if 'received' log already exists
            $exists = VendorLog::where('booking_id', $booking->id)
                ->where('action', 'received')
                ->exists();

            if (!$exists && $booking->vendor_id) {
                VendorLog::create([
                    'vendor_id' => $booking->vendor_id,
                    'booking_id' => $booking->id,
                    'action' => 'received',
                    'description' => 'Vendor received a new order (Booking #' . $booking->id . ')',
                    'created_at' => $booking->created_at,
                ]);
                $count++;
            }

            // Check for status-based logs
            if (in_array($booking->status, ['confirmed', 'completed', 'cancelled', 'rejected'])) {
                $statusExists = VendorLog::where('booking_id', $booking->id)
                    ->where('action', $booking->status)
                    ->exists();

                if (!$statusExists) {
                    VendorLog::create([
                        'vendor_id' => $booking->vendor_id,
                        'booking_id' => $booking->id,
                        'action' => $booking->status,
                        'description' => 'Order ' . ucfirst($booking->status) . ' (Booking #' . $booking->id . ')',
                        'created_at' => $booking->updated_at,
                    ]);
                    $count++;
                }
            }
        }

        $this->info("Backfill complete. Created $count logs.");
    }
}
