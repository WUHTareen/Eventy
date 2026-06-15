<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $fillable = ['name', 'slug', 'province', 'region'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
