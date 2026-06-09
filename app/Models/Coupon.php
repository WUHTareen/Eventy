<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code', 'type', 'value', 'min_order_amount', 'usage_limit', 'used_count', 'expires_at', 'is_active', 'vendor_id'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function isValidFor($amount, $vendorId = null)
    {
        if (!$this->is_active) return false;
        if ($this->expires_at && $this->expires_at->isPast()) return false;
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) return false;
        if ($amount < $this->min_order_amount) return false;
        
        // If vendor_id is set, it's a vendor-specific coupon. Otherwise, platform-wide.
        if ($this->vendor_id && $this->vendor_id != $vendorId) return false;

        return true;
    }

    public function calculateDiscount($amount)
    {
        if ($this->type === 'fixed') {
            return min($this->value, $amount);
        }
        
        return ($amount * $this->value) / 100;
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }
}
