<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'booking_id',
        'user_id',
        'stripe_session_id',
        'amount',
        'currency',
        'status',
        'payment_method',
        'payment_proof',
        'transaction_reference',
        'sender_name',
        'admin_notes',
        'verified_at',
        'verified_by',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isAwaitingVerification(): bool
    {
        return $this->status === 'awaiting_verification';
    }
}
