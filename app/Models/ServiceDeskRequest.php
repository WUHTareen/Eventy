<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceDeskRequest extends Model
{
    protected $fillable = [
        'user_id',
        'booking_id',
        'reference',
        'customer_name',
        'customer_email',
        'customer_phone',
        'service_type',
        'desk_type',
        'priority',
        'status',
        'event_location',
        'event_address',
        'event_date',
        'guest_count',
        'notes',
    ];

    protected $casts = [
        'event_date' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }
}
