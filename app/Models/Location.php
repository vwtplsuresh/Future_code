<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    use HasFactory;

    public function zones(): HasMany
    {
        return $this->hasMany(Zone::class);
    }

    public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }
}
