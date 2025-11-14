<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SingleUnitReportRequest;
use App\Http\Requests\TotalizerReportRequest;
use App\Http\Requests\DailyTotalizerReportRequest;
use App\Models\DiffData;
use App\Models\Location;
use App\Models\Unit;
use App\Models\Zone;
use App\Models\EveningData;
use App\Models\DailyTotailzer;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    private $locations;

    private $zones;

    private $allUnits;

    public function __construct()
    {
        $this->allUnits = Unit::all();
        $this->locations = Location::all();
        $this->zones = Zone::all();
    }

    public function index()
    {
        return view('admin.reports.index');
    }

    public function monthlyFlow()
    {
        return view('admin.reports.monthlyFlow', ['locations' => $this->locations, 'zones' => $this->zones, 'units' => $this->allUnits]);
    }

    public function getMonthlyFlow(Request $request)
    {
        // Retrieve the query parameters from the request
        $month = $request->month;
        $locationId = $request->location;
        $zoneId = $request->zone;
        $unitId = $request->unit;

        if (! empty($month)) {
            $maxDays = date('t', strtotime($month));
        } else {
            $maxDays = date('j') - 1;
        }

        $units = Unit::with('location', 'zone');

        if (! empty($locationId)) {
            $units->where('location_id', $locationId);
        }
        if (! empty($zoneId)) {
            $units->where('zone_id', $zoneId);
        }
        if (! empty($unitId)) {
            $units->where('id', $unitId);
        }

        // Execute the query and retrieve the results
        $units = $units->get();

        foreach ($units as $unit) {
            $monthlyFlow = [];

            for ($i = 1; $i <= $maxDays; $i++) {
                if (! empty($month)) {
                    $monthlyFlow[] = DiffData::where('unit_id', $unit->id)->whereDate('created_at', date('Y-m', strtotime($month)).'-'.sprintf('%02d', $i))->get();
                } else {
                    $monthlyFlow[] = DiffData::where('unit_id', $unit->id)->whereDate('created_at', date('Y-m').'-'.sprintf('%02d', $i))->get();
                }
            }

            $unit['monthlyFlow'] = $monthlyFlow;
        }

        // return $units;

        return view('admin.reports.monthlyFlow', ['locations' => $this->locations, 'zones' => $this->zones, 'units' => $this->allUnits, 'monthlyFlow' => $units, 'month' => $month]);
    }

    public function editMonthlyFlow(Request $request, $month, $unit, $location, $zone)
    {
        $unitData = Unit::with('location', 'zone')->where('id', $unit)->first();
        $monthlyFlow = DiffData::whereYear('created_at', date('Y', strtotime($month)))->whereMonth('created_at', date('m', strtotime($month)))->where('unit_id', $unit)->get();

        return view('admin.reports.editMonthlyFlow', ['month' => $month, 'unit' => $unitData, 'monthlyFlow' => $monthlyFlow]);
    }

    public function updateMonthlyFlow(Request $request, $month, $unit, $location, $zone)
    {
        $flowIds = $request->flow_id;
        $netFlows = $request->net_flow;
        foreach ($flowIds as $index => $flowId) {
            $flow = DiffData::where('id', $flowId)->first();
            if ($flow) {
                $flow->net_flow = $netFlows[$index];
                $flow->update();
            }
        }

        return redirect('/admin/reports/editMonthlyFlow/'.$month.'/'.$unit.'/'.$location.'/'.$zone)->withStatus('Flow Updated!');
    }

    public function exportCSVFile(Request $request, $month, $unit, $location, $zone)
    {
        return (new ExportReport($month, $unit, $location, $zone))->download('users.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    public function singleUnitMonthlyFlow()
    {
        return view('admin.reports.singleUnitMonthlyFlow', ['locations' => $this->locations, 'zones' => $this->zones, 'units' => $this->allUnits]);
    }

    public function getSingleUnitMonthlyFlow(SingleUnitReportRequest $request)
    {
        $validated = $request->validated();

        $unit = Unit::with('location', 'zone')->where('id', $validated['unit'])->first();
        $report = DiffData::where('unit_id', $validated['unit'])->whereYear('created_at', date('Y', strtotime($validated['month'])))->whereMonth('created_at', date('m', strtotime($validated['month'])))->get();
        $unit['report_data'] = $report;

        return view('admin.reports.singleUnitMonthlyFlow', ['report' => $unit]);

    }

    public function eveningTotalizerReport()
    {
        return view('admin.reports.EveningTotalizer', ['locations' => $this->locations, 'zones' => $this->zones]);
    }

    public function getEveningTotalizerReport(TotalizerReportRequest $request)
    {
        $validated = $request->validated();
        $report = EveningData::with('unit')->whereDate('created_at', $validated['date'])->get();

        return view('admin.reports.EveningTotalizer', ['report' => $report, 'locations' => $this->locations, 'zones' => $this->zones]);
    }

     public function DailyTotalizerReport(){
        return view('admin.reports.DailyTotalizer', ["locations" => $this->locations, "zones" => $this->zones, "units" => $this->allUnits]);
    }

    public function getDailyTotalizerReport(DailyTotalizerReportRequest $request){
        $validated = $request->validated();
        $report = Unit::with('location','zone')->where('id', $validated['unit'])->first();
        $data = DailyTotailzer::where('unit_id', $validated['unit'])->whereDate('created_at', $validated['date'])->get();
        $report['report_data'] = $data;
        return view('admin.reports.DailyTotalizer', ['report' => $report,"locations" => $this->locations, "zones" => $this->zones, "units" => $this->allUnits]);
    }

}
