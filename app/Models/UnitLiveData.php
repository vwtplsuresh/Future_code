<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UnitLiveData extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'emergency_stop_status',
        'door_limit_switch_status',
        'current_flow',
        'today_flow',
        'panel_lock_status',
        'overload_status',
        'error_code',
        'flow_status',
        'auto_manual',
        'tank_level',
        'kld_limit_send',
        'output_value',
        'rtc_dd',
        'rtc_hh',
        'rtc_mm',
        'ph',
        'tds',
        'pipe_size',
        'totalizer',
        'version',
        'api_key',
    ];

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
}
