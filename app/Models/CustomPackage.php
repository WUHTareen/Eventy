<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CustomPackage extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'total_price',
        'image',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'custom_package_services');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(CustomPackageBooking::class);
    }
}
