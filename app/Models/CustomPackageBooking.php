<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomPackageBooking extends Model
{
    protected $fillable = [
        'user_id',
        'custom_package_id',
        'booking_date',
        'status',
        'total_amount',
        'notes',
        'customer_name',
        'customer_phone',
        'customer_email',
        'event_location',
        'event_address',
        'guest_count',
        'budget',
        'special_requests',
        'booking_data',
    ];

    protected $casts = [
        'booking_date' => 'datetime',
        'booking_data' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function customPackage(): BelongsTo
    {
        return $this->belongsTo(CustomPackage::class);
    }
}
