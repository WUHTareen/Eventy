<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffiliateResource extends Model
{
    protected $fillable = [
        'title',
        'type',
        'content',
        'thumbnail',
    ];
}
