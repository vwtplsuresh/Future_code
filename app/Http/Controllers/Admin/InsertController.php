<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyTotailzer;
use App\Models\Unit;
use App\Models\UnitLiveData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;


class InsertController extends Controller
{
    public function insert(Request $request)
    {
        date_default_timezone_set('asia/kolkata');
        $unit_id = $request->ID;
        $current_flow = $request->A;
        $totalizer = $request->B;
        $door_limit_switch_status = $request->C;
        $today_flow = $request->D;
        $tank_level = $request->E;
        $panel_lock_status = $request->F;
        $overload_status = $request->G;
        $flow_status = $request->H;
        $auto_manual = $request->I;
        $ph = $request->J;
        $tds = $request->K;
        $kld_limit_send = $request->L;
        $rtc_dd = $request->M;
        $rtc_hh = $request->N;
        $rtc_mm = $request->O;
        $version = $request->P;
        $api_key = $request->Q;
        $error_code = $request->R;
        $emergency_stop_status = $request->S ?? 0;
        $pipe_size = $request->T ?? 0;

        try {
            if (! $unit_id) {
                throw new Exception('Unit ID missing!');
            }

            $unitData = Unit::find($unit_id);
            if (! $unitData) {
                throw new Exception('Unit not found!');
            }
            $dailyTotalizerDataPayload = [
                'unit_id' => $unit_id,
                'totalizer' => $totalizer / 100,
                'is_online' => 1,
                'is_panel_lock' => $panel_lock_status,
            ];

            DailyTotailzer::create($dailyTotalizerDataPayload);

            $updatePayload = [
                'current_flow' => $current_flow,
                'totalizer' => $totalizer / 100,
                'door_limit_switch_status' => $door_limit_switch_status,
                'today_flow' => $today_flow,
                'tank_level' => $tank_level,
                'panel_lock_status' => $panel_lock_status,
                'overload_status' => $overload_status,
                'flow_status' => $flow_status,
                'auto_manual' => $auto_manual,
                'ph' => $ph !== null ? (string) $ph : null,
                'tds' => $tds !== null ? (string) $tds : null,
                'kld_limit_send' => $kld_limit_send,
                'rtc_dd' => $rtc_dd,
                'rtc_hh' => $rtc_hh,
                'rtc_mm' => $rtc_mm,
                'version' => $version,
                'api_key' => $api_key,
                'error_code' => $error_code,
                'emergency_stop_status' => $emergency_stop_status,
                'pipe_size' => $pipe_size,
                'updated_at' => now(),
            ];

            $updateLiveData = UnitLiveData::updateOrCreate(['unit_id' => $unit_id], $updatePayload);
            $updateLiveData->touch();

            $responseString = $this->unitData($unit_id);
            $this->panelAutoLockUnlock();

            return response($responseString, 200)->header('Content-Type', 'text/plain');

        } catch (Exception $e) {
            \Log::error('InsertController Error: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Insert Error: '.$e->getMessage(),
                'line' => $e->getLine(),
            ], 500);
        }
    }

    protected function unitData($id)
    {
        try {
            $data = Unit::where('id', $id)->first();

            $returnString = '';
            $zero = 0;
            $num = $data->total_limit;
            $str_arr = explode('.', $num);
            $numlength = strlen((string) $str_arr[0]);

            if ($numlength == 1) {

                if ($num > 0 && $num < 1) {
                    $returnString .= $zero;
                }
                $returnString .= $zero;
                $returnString .= $zero;
                $returnString .= $num;
            }
            if ($numlength == 2) {
                $returnString .= $zero;
                $returnString .= $num;
            }
            if ($numlength > 2) {
                $returnString .= $num;
            }

            $returnString .= ',';
            $returnString .= $data->panel_lock;
            $returnString .= ',';
            $returnString .= $data->mode;
            $returnString .= ',';
            // Single and double character of date
            $dd = date('d');
            $dd_length = strlen((string) $dd);
            if ($dd_length == 2) {
                $returnString .= $dd;
            }
            if ($dd_length == 1) {
                $returnString .= $zero;
                $returnString .= $dd; // 09
            }
            $returnString .= ',';
            $hh = date('H');
            $hh_length = strlen((string) $hh);
            if ($hh_length == 2) {
                $returnString .= $hh;
            }
            if ($hh_length == 1) {
                $returnString .= $zero;
                $returnString .= $hh;
            }
            $returnString .= ',';
            $mm = date('i');
            $mm_length = strlen((string) $mm);
            if ($mm_length == 2) {
                $returnString .= $mm;
            }
            if ($mm_length == 1) {
                $returnString .= $zero;
                $returnString .= $mm;
            }
            $returnString .= ',';
            $returnString .= $data->plc_reset;  // 0 or 1
            $returnString .= ',';
            $returnString .= $data->reset_totalizer; // 0 or 1

            $returnString .= ' '.$data->PlcMicrocontroler;

            return $returnString;
        } catch (Exception $e) {
            Log::error('Unit data fetch Error : '.$e->getMessage().' Line No. : '.$e->getLine());

            return false;
        }

    }

    protected function panelAutoLockUnlock()
    {
         $now = now();
            $minute = (int)$now->format('i');
            $second = (int)$now->format('s');

            // Only run exactly on 00, 15, 30, 45 minute mark — and only when second = 0
            if (!in_array($minute % 15, [0]) || $second !== 0) {
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

}
