<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelRoom extends Model
{
    protected $fillable = [
        'hotel_id', 'name', 'description', 'capacity',
        'price_per_night', 'total_rooms', 'amenities', 'image', 'is_available'
    ];

    protected $casts = [
        'amenities'    => 'array',
        'is_available' => 'boolean',
    ];

    public function hotel()    { return $this->belongsTo(Hotel::class); }
    public function bookings() { return $this->hasMany(HotelBooking::class); }

    public function isAvailableForDates($checkIn, $checkOut)
    {
        $bookedCount = $this->bookings()
            ->where('status', '!=', 'cancelled')
            ->where(function($q) use ($checkIn, $checkOut) {
                $q->whereBetween('check_in', [$checkIn, $checkOut])
                  ->orWhereBetween('check_out', [$checkIn, $checkOut])
                  ->orWhere(function($q2) use ($checkIn, $checkOut) {
                      $q2->where('check_in', '<=', $checkIn)
                         ->where('check_out', '>=', $checkOut);
                  });
            })->count();

        return $bookedCount < $this->total_rooms;
    }
}
