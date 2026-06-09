<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BudgetRequest extends Model
{
    protected $fillable = [
        'user_id',
        'service_type',
        'location',
        'guests',
        'budget',
        'services_needed',
        'selected_tier',
        'status',
        'notes',
    ];

    protected $casts = [
        'services_needed' => 'array',
        'budget' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
