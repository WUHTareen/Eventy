<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'category',
        'is_published',
        'published_at',
        'author_id',
        'views',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_published' => 'boolean',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function getReadTimeAttribute()
    {
        $words = str_word_count(strip_tags($this->content));
        return max(1, ceil($words / 200));
    }

    public function getFeaturedImageUrlAttribute()
    {
        if (empty($this->featured_image)) {
            return null;
        }
        if (Str::startsWith($this->featured_image, ['http://', 'https://'])) {
            return $this->featured_image;
        }
        return asset('storage/' . ltrim($this->featured_image, '/'));
    }
}
