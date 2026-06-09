<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorLog extends Model
{
    protected $fillable = [
        'vendor_id',
        'booking_id',
        'action',
        'description',
    ];

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
