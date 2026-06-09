<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelBooking extends Model
{
    protected $fillable = [
        'user_id', 'hotel_id', 'hotel_room_id', 'check_in', 'check_out',
        'nights', 'guests', 'room_price', 'total_amount', 'commission_amount',
        'vendor_amount', 'status', 'payment_status', 'payment_intent_id',
        'special_requests', 'guest_name', 'guest_phone'
    ];

    protected $casts = [
        'check_in'  => 'date',
        'check_out' => 'date',
    ];

    public function user()   { return $this->belongsTo(User::class); }
    public function hotel()  { return $this->belongsTo(Hotel::class); }
    public function room()   { return $this->belongsTo(HotelRoom::class, 'hotel_room_id'); }
}
