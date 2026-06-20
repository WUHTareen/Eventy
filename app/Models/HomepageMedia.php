<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageMedia extends Model
{
    protected $table = 'homepage_media';

    protected $fillable = [
        'section', 'title', 'subtitle', 'badge', 'tag', 'price',
        'link', 'image', 'video', 'poster', 'meta', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'meta'      => 'array',
        'is_active' => 'boolean',
    ];

    public function scopeSection($query, $section)
    {
        return $query->where('section', $section)->where('is_active', true)->orderBy('sort_order');
    }
}
