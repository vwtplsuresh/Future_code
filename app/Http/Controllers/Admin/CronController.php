<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Models\DailyTotailzer;
use App\Models\DiffData;
use App\Models\EveningData;
use App\Models\MorningData;
use App\Models\Time;
use App\Models\Unit;
use App\Models\UnitLiveData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Jobs\SendOverLimitReportJob;


class CronController extends Controller
{
    public function morningFlow(Request $request)
    {
        try {
            $unitLiveData = UnitLiveData::all();
            foreach ($unitLiveData as $unit) {
                try {
                    $morningDataPayload = [
                        'unit_id' => $unit->unit_id,
                        'totalizer' => $unit->totalizer,
                    ];
                    // Log::info("morningDataPayload", $morningDataPayload);
                    MorningData::create($morningDataPayload);
                } catch (Exception $e) {
                    Log::error('Morning Data Insert Error : '.$e->getMessage().' : '.' Unit ID : '.$unit->id.' : Line No. '.$e->getLine());
                }
            }
        } catch (Exception $e) {
            Log::error('Morning callculation error : '.$e->getMessage().' : Line No. '.$e->getLine());
        }
    }

    public function eveningFlow(Request $request)
    {
        try {
            $unitLiveData = UnitLiveData::all();
            foreach ($unitLiveData as $unit) {
                try {
                    $eveningDataPayload = [
                        'unit_id' => $unit->unit_id,
                        'totalizer' => $unit->totalizer,
                        'is_online' => date('Y-m-d', strtotime($unit->updated_at)) === date('Y-m-d', strtotime(now())),
                        'is_panel_lock' => $unit->panel_lock || 0,
                    ];
                    EveningData::create($eveningDataPayload);
                } catch (Exception $e) {
                    Log::error('Evening Data Insert Error : '.$e->getMessage().' : '.' Unit ID : '.$unit->id.' : Line No. '.$e->getLine());
                }
            }
        } catch (Exception $e) {
            Log::error('Evening callculation error : '.$e->getMessage().' : Line No. '.$e->getLine());
        }
    }

    public function dailyDataFlow(Request $request)
    {
        try {
            $unitsData = Unit::all();
            $dateToday = date('Y-m-d');
            $yesterdayDate = date('Y-m-d', strtotime('-1 days'));
            $payloadData = [];
            $TodayData = EveningData::whereDate('created_at', $dateToday)->get();
            $yesterdayData = EveningData::whereDate('created_at', $yesterdayDate)->get();
            if ($TodayData !== null && $yesterdayData !== null) {
                foreach ($unitsData as $unitData) {
                    try {
                        $TodayIndex = collect($TodayData)->search(function ($item) use ($unitData) {
                            return $item['unit_id'] == $unitData->id;
                        });

                        $yesterdayIndex = collect($yesterdayData)->search(function ($item) use ($unitData) {
                            return $item['unit_id'] == $unitData->id;
                        });

                        $todayTotalizer = $TodayData[$TodayIndex]->totalizer;
                        $yesterdayTotalizer = $yesterdayData[$yesterdayIndex]->totalizer;
                        $totalizer = $yesterdayTotalizer;
                        $netFlow = $todayTotalizer - $yesterdayTotalizer;

                        $diffData = new DiffData;
                        $diffData->unit_id = $unitData->id;
                        $diffData->totalizer = $totalizer;
                        $diffData->net_flow = $netFlow;
                        $diffData->is_online = $TodayData[$TodayIndex]->is_online;
                        $diffData->is_panel_lock = $TodayData[$TodayIndex]->is_panel_lock;

                        $diffData->save();

                    } catch (Exception $e) {
                        Log::error('Daily Flow Data Insert Error : '.$e->getMessage().' : '.' Unit ID : '.$unitData->id.' : Line No. '.$e->getLine());
                    }
                }

            }

        } catch (Exception $e) {
            Log::error('Diff callculation error : '.$e->getMessage().' : Line No. '.$e->getLine());
        }

        return 1;
    }

    public function dailyTotalizerFlowDelete()
    {
        try {
            DailyTotailzer::whereDate('created_at', '<=', now()->subDays(3))->delete();
        } catch (Exception $e) {
            Log::error('Daily Totalizer before 3 days data delete error : '.$e->getMessage().' : Line No. '.$e->getLine());
        }

        return 1;
    }

    public function panelLock()
    {
        $currentTime = Carbon::now()->format('H');
        $times = Time::with('unit')->get();

        foreach ($times as $time) {
            $ranges = explode(',', $time->fixed_time);
            $isInRange = false;

            foreach ($ranges as $range) {
                [$start, $end] = explode('-', $range);
                $start = (int) $start;
                $end = (int) $end;
                $now = (int) $currentTime;

                if ($start <= $end) {
                    if ($now >= $start && $now < $end) {
                        $isInRange = true;
                        break;
                    }
                } else {

                    if ($now >= $start || $now < $end) {
                        $isInRange = true;
                        break;
                    }
                }
            }
            if ($time->unit) {
                $time->unit->panel_lock = $isInRange ? 0 : 1;
                $time->unit->save();
            }
        }

        return 'Panel lock updated successfully';
    }

public function panelAutoLockUnlock()
{
       $now = now();
    $minute = (int)$now->format('i');
    $second = (int)$now->format('s');

    // Only run exactly on 00, 15, 30, 45 minute mark — and only when second = 0
    if (!in_array($minute % 5, [0]) || $second !== 0) {
        log::info("⏭️ Skipping panel auto lock/unlock at minute {$minute}");
        return;
    }


    $now = Carbon::now()->format('H:i');
    try {
        $timeRecords = DB::table('time')
            ->whereNotNull('edit_time')
            ->select('unit_id', 'edit_time')
            ->get()
            ->toArray();

        $activeUnits = [];

        foreach ($timeRecords as $record) {
            if (empty($record->edit_time)) continue;

            $shouldLock = false;
            $slots = explode(',', str_replace(' ', '', $record->edit_time));

            foreach ($slots as $slot) {
                if (empty($slot)) continue;
                $timeRange = explode('-', $slot);
                if (count($timeRange) != 2) continue;

                [$start, $end] = $timeRange;

                if (!str_contains($start, ':')) $start .= ':00';
                if (!str_contains($end, ':')) $end .= ':00';

                $start = Carbon::createFromFormat('H:i', $start)->format('H:i');
                $end   = Carbon::createFromFormat('H:i', $end)->format('H:i');

                if ($now >= $start && $now <= $end) {
                    $shouldLock = true;
                    break;
                }
            }

            if ($shouldLock) {
                DB::table('units')
                    ->where('id', $record->unit_id)
                    ->update(['panel_lock' => 1]);
                Log::info("🔒 Unit {$record->unit_id} locked at {$now}");
            } else {
                DB::table('units')
                    ->where('id', $record->unit_id)
                    ->update(['panel_lock' => 0]);
                Log::info("🔓 Unit {$record->unit_id} unlocked at {$now}");
            }

            $activeUnits[] = $record->unit_id;
        }

        Log::info("✅ {$now} - Active Units: " . count($activeUnits));
    } catch (\Throwable $e) {
        Log::error('🔥 Panel AutoLock Cron Failed: ' . $e->getMessage());
    }

    return 'Panel lock/unlock cron executed successfully.';
}

public function sendOverLimitReport()
    {
        $units = Unit::all();
        
        foreach ($units as $unit) {

            $todayData = DailyTotailzer::where('unit_id', $unit->id)
                ->whereDate('created_at', today())
                ->first();

            if (!$todayData) {

                continue;
            }

            if ($todayData->totalizer > $unit->today_limit) {

                $overLimitData[] = [
                'unit_id'     => $unit->id,
                'unit_name'   => $unit->title,
                'today_limit' => $unit->today_limit,
                'total_flow'  => $todayData->totalizer,
                'over_flow'   => $todayData->totalizer - $unit->today_limit,
            ];
               
            }
        }
       
if(count($overLimitData) > 0){
         SendOverLimitReportJob::dispatch($overLimitData);
}
        return "Controller Cron Executed Successfully";
    }


}
