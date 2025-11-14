<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AutoPanelLock extends Command
{
    protected $signature = 'panel:auto-lock';
    protected $description = 'Automatically lock/unlock panels based on multiple timing slots';

    public function handle()
    {
        $this->info('Auto Panel Lock Scheduler Running...');
        $units = Unit::whereNotNull('panel_unlock_timing')->get();
        $now = Carbon::now()->format('H:i');

        foreach ($units as $unit) {
            $shouldUnlock = false;
            $slots = explode(',', str_replace(' ', '', $unit->panel_unlock_timing)); // remove spaces and split by comma

            foreach ($slots as $slot) {
                if (empty($slot)) continue;
                $timeRange = explode('-', $slot);
                if (count($timeRange) != 2) continue;

                [$start, $end] = $timeRange;

                if ($now >= $start && $now <= $end) {
                    $shouldUnlock = true;
                    break;
                }
            }

            // 🔓 Unlock Condition
            if ($shouldUnlock && $unit->panel_lock != 1) {
                $unit->update(['panel_lock' => 1]);
                $this->sendDeviceCommand($unit, 'on');
                Log::info("Unit {$unit->id} UNLOCKED at {$now}");
                $this->info("Unit {$unit->id} UNLOCKED ✅");
            }

            // 🔒 Lock Condition
            if (!$shouldUnlock && $unit->panel_lock != 0) {
                $unit->update(['panel_lock' => 0]);
                // $this->sendDeviceCommand($unit, 'off');
                Log::info("Unit {$unit->id} LOCKED at {$now}");
                $this->info("Unit {$unit->id} LOCKED 🔒");
            }
        }

        $this->info('Auto Panel Lock Scheduler Completed.');
    }

    // 🔌 API call for live device
    // protected function sendDeviceCommand($unit, $status)
    // {
    //     try {
    //         $apiUrl = "http://localhost:8000/api/unit-control"; // change for live
    //         $response = Http::post($apiUrl, [
    //             'unit_id' => $unit->id,
    //             'status' => $status
    //         ]);

    //         if ($response->successful()) {
    //             Log::info("API success for Unit {$unit->id} → {$status}");
    //         } else {
    //             Log::warning("API failed for Unit {$unit->id}");
    //         }
    //     } catch (\Exception $e) {
    //         Log::error("API Exception for Unit {$unit->id}: " . $e->getMessage());
    //     }
    // }
}
