<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'icon',
        'color',
        'link',
        'is_read'
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function createBookingNotification($userId, $title, $message, $link = null, $icon = null, $color = null)
    {
        return self::create([
            'user_id' => $userId,
            'type' => 'booking',
            'title' => $title,
            'message' => $message,
            'icon' => $icon ?? 'fa-calendar-check',
            'color' => $color ?? 'green',
            'link' => $link,
        ]);
    }

    public static function createServiceNotification($userId, $title, $message, $link = null)
    {
        return self::create([
            'user_id' => $userId,
            'type' => 'service',
            'title' => $title,
            'message' => $message,
            'icon' => 'fa-concierge-bell',
            'color' => 'purple',
            'link' => $link,
        ]);
    }

    public static function createSystemNotification($userId, $title, $message, $link = null)
    {
        return self::create([
            'user_id' => $userId,
            'type' => 'system',
            'title' => $title,
            'message' => $message,
            'icon' => 'fa-bell',
            'color' => 'blue',
            'link' => $link,
        ]);
    }

    public static function createMessageNotification($userId, $title, $message, $link = null)
    {
        return self::create([
            'user_id' => $userId,
            'type' => 'message',
            'title' => $title,
            'message' => $message,
            'icon' => 'fa-envelope',
            'color' => 'pink',
            'link' => $link,
        ]);
    }
}
