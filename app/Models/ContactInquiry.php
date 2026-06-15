<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactInquiry extends Model
{
    protected $fillable = [
        'name',
        'email',
        'service_type',
        'message',
        // 'status', // Only set if needed for reporting
    ];
}
