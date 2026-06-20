<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'vendor_type',
        'is_verified',
        'is_banned',
        'city_id',
        'category_id',
        'avatar',
        'balance',
        'commission_rate',
        'bio',
        'social_links',
        'business_hours',
        'business_name',
        'business_type',
        'ntn_number',
    ];

    /**
     * Get user avatar URL or default placeholder
     */
    public function getAvatarUrl()
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        
        // Return a UI Avatar or a default placeholder
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=FFFFFF&background=0A3A7A';
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'social_links' => 'array',
            'business_hours' => 'array',
        ];
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class); // As a customer
    }

    public function receivedBookings()
    {
        return $this->hasMany(Booking::class, 'vendor_id'); // As a vendor
    }
    
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function favorites()
    {
        return $this->belongsToMany(Service::class, 'favorites')->withTimestamps();
    }

    public function withdrawals(): HasMany
    {
        return $this->hasMany(Withdrawal::class);
    }

    public function affiliateLeads(): HasMany
    {
        return $this->hasMany(AffiliateLead::class, 'affiliate_id');
    }

    public function affiliateCommissions(): HasMany
    {
        return $this->hasMany(AffiliateCommission::class, 'affiliate_id');
    }
}

