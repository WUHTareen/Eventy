<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffiliateLead extends Model
{
    protected $fillable = [
        'affiliate_id',
        'name',
        'email',
        'phone',
        'status',
        'converted_user_id',
        'source',
    ];

    public function affiliate()
    {
        return $this->belongsTo(User::class, 'affiliate_id');
    }

    public function convertedUser()
    {
        return $this->belongsTo(User::class, 'converted_user_id');
    }
}
