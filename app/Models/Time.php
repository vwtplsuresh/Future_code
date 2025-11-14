<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Time extends Model
{
    use HasFactory;
    
    protected $table = 'time';

    protected $fillable = [
        'unit_id',
        'fixed_time',
        'edit_time',
    ];

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
}
