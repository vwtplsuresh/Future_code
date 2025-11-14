<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyTotailzer extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'totalizer',
        'is_online',
        'is_panel_lock',
    ];

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
}
