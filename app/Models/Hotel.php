<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $fillable = [
        'user_id', 'city_id', 'name', 'description', 'address',
        'phone', 'email', 'star_rating', 'cover_image', 'images',
        'amenities', 'latitude', 'longitude', 'status', 'is_featured'
    ];

    protected $casts = [
        'images'    => 'array',
        'amenities' => 'array',
        'is_featured' => 'boolean',
    ];

    public function user()      { return $this->belongsTo(User::class); }
    public function city()      { return $this->belongsTo(City::class); }
    public function rooms()     { return $this->hasMany(HotelRoom::class); }
    public function bookings()  { return $this->hasMany(HotelBooking::class); }

    public function getCoverImageUrl()
    {
        return $this->cover_image
            ? asset('storage/' . $this->cover_image)
            : asset('images/hotel-placeholder.jpg');
    }

    public function getMinPrice()
    {
        return $this->rooms()->min('price_per_night') ?? 0;
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }
}
