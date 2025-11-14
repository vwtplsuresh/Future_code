<?php

namespace App\Http\Controllers\Operator;

use App\Exports\ExportReport;
use App\Http\Controllers\Controller;
use App\Http\Requests\SingleUnitReportRequest;
use App\Models\DiffData;
use App\Models\Location;
use App\Models\Unit;
use App\Models\Zone;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('operator.reports.index');
    }

    public function monthlyFlow()
    {
        $locations = Location::all();
        $zones = Zone::all();
        $units = Unit::all();
        return view('operator.reports.monthlyFlow', ["locations" => $locations, "zones" => $zones, "units" => $units]);
    }

    public function getMonthlyFlow(Request $request)
    {
        // Retrieve the query parameters from the request
        $month = $request->month;
        $locationId = $request->location;
        $zoneId = $request->zone;
        $unitId = $request->unit;

        // Build the initial query
        $units = Unit::with('location', 'zone');

        if (!empty($locationId)) {
            $units->where('location_id', $locationId);
        }
        if (!empty($zoneId)) {
            $units->where('zone_id', $zoneId);
        }
        if (!empty($unitId)) {
            $units->where('id', $unitId);
        }

        // Execute the query and retrieve the results
        $units = $units->get();

        if (!empty($month)) {
            $maxDays = date('t', strtotime($month));
        } else {
            $maxDays = date('j') - 1;
        }

        foreach ($units as $unit) {
            $monthlyFlow = [];
            for ($i = 1; $i <= $maxDays; $i++) {
                if (!empty($month)) {
                    $monthlyFlow[] = DiffData::where('unit_id', $unit->id)->whereDate('created_at', date('Y-m', strtotime($month)) . "-" .sprintf("%02d", $i))->get();
                }else{
                    $monthlyFlow[] = DiffData::where('unit_id', $unit->id)->whereDate('created_at', date('Y-m') . "-" .sprintf("%02d", $i))->get();
                }
            }
            $unit['monthlyFlow'] = $monthlyFlow;
        }

        $locations = Location::all();
        $zones = Zone::all();
        $allUnits = Unit::all();
        return view('operator.reports.monthlyFlow', ["locations" => $locations, "zones" => $zones, "units" => $allUnits, "monthlyFlow" => $units, "month" => $month]);
    }

    public function exportCSVFile(Request $request, $month, $unit, $location, $zone)
    {
        return (new ExportReport($month, $unit, $location, $zone))->download('users.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    public function singleUnitMonthlyFlow(){
        $locations = Location::all();
        $zones = Zone::all();
        $units = Unit::all();
        return view('operator.reports.singleUnitMonthlyFlow', ["locations" => $locations, "zones" => $zones, "units" => $units]);
    }

    public function getSingleUnitMonthlyFlow(SingleUnitReportRequest $request){
        $validated = $request->validated();

        $unit = Unit::with('location','zone')->where('id', $validated['unit'])->first();
        $report = DiffData::where('unit_id', $validated['unit'])->whereYear('created_at', date('Y', strtotime($validated['month'])))->whereMonth('created_at', date('m', strtotime($validated['month'])))->get();
        $unit['report_data'] = $report;

        return view('operator.reports.singleUnitMonthlyFlow', ['report' => $unit]);

    }


}