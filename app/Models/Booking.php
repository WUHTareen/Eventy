<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'tracking_token',
        'user_id',
        'service_id',
        'vendor_id',
        'booking_date',
        'status',
        'notes',
        // New fields
        'customer_name',
        'customer_phone',
        'customer_email',
        'event_type',
        'event_size',
        'event_end_date',
        'event_location',
        'event_address',
        'guest_count',
        'budget',
        'special_requests',
        'booking_data',
        'total_price',
        'commission_fee',
        'vendor_net_amount',
        'payout_status',
        'department',
        'cost_center',
        'approval_level',
        'assigned_admin_id',
        'corporate_pricing',
    ];

    protected $casts = [
        'booking_date' => 'datetime',
        'event_end_date' => 'datetime',
        'booking_data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function service()
    {
        return $this->belongsTo(Service::class)->withTrashed();
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'vendor_id')->withTrashed();
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }

    public function siblings()
    {
        if (empty($this->booking_data['package_booking_id'])) {
            return collect();
        }
        
        return Booking::where('booking_data->package_booking_id', $this->booking_data['package_booking_id'])
            ->where('id', '!=', $this->id)
            ->with(['service', 'vendor'])
            ->get();
    }
}

