<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

    protected $fillable = ['category_id', 'user_id', 'name', 'description', 'price', 'price_type', 'location', 'extra_data', 'image', 'images', 'featured_image_index', 'status', 'is_featured', 'cached_rating', 'reviews_count', 'packages', 'add_ons'];

    protected $casts = [
        'extra_data' => 'array',
        'images' => 'array',
        'packages' => 'array',
        'add_ons' => 'array',
    ];

    public function getFeaturedImage()
    {
        if ($this->images && is_array($this->images) && count($this->images) > 0) {
            $index = $this->featured_image_index ?? 0;
            return $this->images[$index] ?? $this->images[0];
        }
        return $this->image; // Fallback to old single image
    }

    public function getAllImages()
    {
        return $this->images ?? ($this->image ? [$this->image] : []);
    }

    public function hasCompletedBookingBy(User $user): bool
    {
        return $user->bookings()
            ->where('service_id', $this->id)
            ->where('status', 'completed')
            ->exists();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function averageRating()
    {
        return round($this->cached_rating ?: 0, 1);
    }

    public function reviewCount()
    {
        return $this->reviews_count;
    }

    /**
     * Update the cached average rating and review count.
     */
    public function updateCachedRating()
    {
        $this->reviews_count = $this->reviews()->count();
        $this->cached_rating = $this->reviews()->avg('rating') ?: 0;
        $this->save();
    }

    // Helper to get extra data attribute
    public function getExtraAttribute($key, $default = null)
    {
        $data = $this->extra_data ?? [];
        return $data[$key] ?? $default;
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    public function isFavoritedBy(User $user)
    {
        return $this->favoritedBy()->where('user_id', $user->id)->exists();
    }

    public function availability()
    {
        return $this->hasMany(ServiceAvailability::class);
    }

    public function isAvailableOn($date)
    {
        // 1. Check if vendor blocked this date
        $isBlocked = $this->availability()
            ->whereDate('unavailable_date', $date)
            ->exists();
            
        if ($isBlocked) return false;

        // 2. Check if already booked (confirmed or pending)
        // Note: Depending on business logic, pending might also block
        $isBooked = $this->bookings()
            ->whereDate('booking_date', $date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();
            
        return !$isBooked;
    }

    public function getTieredPrice($tierName)
    {
        if (empty($this->packages)) return $this->price;
        
        foreach ($this->packages as $package) {
            if ($package['name'] === $tierName) {
                return $package['price'];
            }
        }
        
        return $this->price;
    }

    public function getAddOnPrice($addOnName)
    {
        if (empty($this->add_ons)) return 0;
        
        foreach ($this->add_ons as $addOn) {
            if ($addOn['name'] === $addOnName) {
                return $addOn['price'];
            }
        }
        
        return 0;
    }

    public function city_model()
    {
        return $this->belongsTo(City::class, 'location', 'name');
    }
}
