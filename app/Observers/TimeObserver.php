<?php
namespace App\Observers;

use App\Models\Time;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class TimeObserver
{
    public function saved(Time $time)
    {
        Cache::forget('unit_lock_times');
        Log::info("♻️ Cache cleared due to Time ID {$time->id} update.");
    }

    public function deleted(Time $time)
    {
        Cache::forget('unit_lock_times');
        Log::info("🗑️ Cache cleared due to Time ID {$time->id} deletion.");
    }
}
