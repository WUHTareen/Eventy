<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = ['key', 'value'];

    public static function get($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function set($key, $value)
    {
        return static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    public static function getAllSettings()
    {
        return static::all()->pluck('value', 'key')->toArray();
    }

    public static function getJson($key, $default = [])
    {
        $value = static::get($key);
        if (!$value) return $default;
        $decoded = json_decode($value, true);
        return is_array($decoded) ? $decoded : $default;
    }

    public static function setJson($key, $value)
    {
        return static::set($key, json_encode(array_values($value)));
    }
}
