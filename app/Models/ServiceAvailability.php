<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceAvailability extends Model
{
    protected $table = 'service_availability';

    protected $fillable = [
        'service_id',
        'unavailable_date',
        'reason',
    ];

    protected $casts = [
        'unavailable_date' => 'date',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
