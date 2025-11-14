<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Unit extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'location_id',
        'zone_id',
        'user_id',
        'device_id',
        'panel_lock',
        'panel_unlock_timing',
        'description',
    ];

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function liveData(): HasOne
    {
        return $this->hasOne(UnitLiveData::class);
    }

    public function yesterdayFlow(): HasOne
    {
        return $this->hasOne(DiffData::class)->whereDate('created_at', date('Y-m-d', strtotime('-1 days')));
    }

    public function monthlyFlow(): HasMany
    {
        return $this->hasMany(DiffData::class)->whereMonth('created_at', date('m', strtotime(now())))->whereYear('created_at', date('Y', strtotime(now())));
    }

    public function weeklyFlow(): HasMany
    {
        return $this->hasMany(DiffData::class)->whereDate('created_at', '>=', date('Y-m-d', strtotime('-7 days')));
    }

    public function monthlyTDS(): HasMany
    {
        return $this->hasMany(TDS::class)->whereMonth('created_at', date('m', strtotime(now())))->whereYear('created_at', date('Y', strtotime(now())));
    }

    public function offline(): HasMany
    {
        return $this->hasMany(UnitLiveData::class)->whereDate('updated_at', '!=', Carbon::today());
    }

    // public function alarm(): HasOne
    // {
    //     return $this->hasOne(Alarms::class)->orderBy('updated_at', 'DESC');
    // }

    public function online(): HasMany
    {
        return $this->hasMany(UnitLiveData::class)->whereDate('updated_at', '=', Carbon::today());
    }

    public function lasttds(): HasMany
    {
        return $this->hasMany(DailyTDS::class)->whereDate('created_at', date('Y-m-d H:i:s'))->orderBy('created_at', 'DESC');
    }

    public function time()
    {
        return $this->hasOne(Time::class);
    }
}
