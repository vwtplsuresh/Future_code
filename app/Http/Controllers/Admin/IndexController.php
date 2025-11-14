<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Location;
use App\Models\Unit;
use App\Models\UnitLiveData;
use App\Models\Zone;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locations = Location::with('zones', 'units')->get();
        $chartData = [];
        foreach($locations as $location){
            $onlineUnits = UnitLiveData::join('units', 'unit_live_data.unit_id', '=', 'units.id')->where('units.location_id',  $location->id)->whereDate('unit_live_data.updated_at', '=', date('Y-m-d'))->count();
            $oflineUnits = UnitLiveData::join('units', 'unit_live_data.unit_id', '=', 'units.id')->where('units.location_id', $location->id)->whereDate('unit_live_data.updated_at', '!=', date('Y-m-d'))->count();
            $data = ["y" => $location->title, "a" => $onlineUnits, "b" => $oflineUnits];
            $chartData[] = $data;
        }

        $allData = [];
        $i = 0;
        foreach($locations as $location){
            $allData[$i]['location_title'] = $location->title;
            $allData[$i]['total_flow_limit'] = Unit::where('location_id', $location->id)->sum('total_limit');
            $allData[$i]['total_today_flow'] = Unit::join('unit_live_data', 'units.id', '=', 'unit_live_data.unit_id')->where('units.location_id', $location->id)->sum('unit_live_data.today_flow');
            $j = 0;
            foreach($location->zones as $zone){
                $allData[$i]['zones'][$j]['zone_title'] = $zone->title;
                $allData[$i]['zones'][$j]['total_units'] = Unit::where(['location_id' => $location->id,'zone_id' => $zone->id])->count();
                $allData[$i]['zones'][$j]['total_online_units'] = UnitLiveData::join('units', 'unit_live_data.unit_id', '=', 'units.id')->where(['units.location_id' =>  $location->id, "zone_id" => $zone->id])->whereDate('unit_live_data.updated_at', '=', date('Y-m-d'))->count();
                $allData[$i]['zones'][$j]['total_offline_units'] = UnitLiveData::join('units', 'unit_live_data.unit_id', '=', 'units.id')->where(['units.location_id'=> $location->id, "zone_id" => $zone->id])->whereDate('unit_live_data.updated_at', '!=', date('Y-m-d'))->count();
                $allData[$i]['zones'][$j]['total_flow_limit'] = Unit::where(['location_id' => $location->id,'zone_id' => $zone->id])->sum('total_limit');
                $allData[$i]['zones'][$j]['total_today_flow'] = Unit::join('unit_live_data', 'units.id', '=', 'unit_live_data.unit_id')->where(['units.location_id' => $location->id,'units.zone_id' => $zone->id])->sum('unit_live_data.today_flow');
                $j++;
            }

            $i++;
        }
        $tatals = [];
        $totals['total_locations'] = count($locations);
        $totals['total_zones'] = Zone::count();
        $totals['total_units'] = Unit::count();
        $totals['total_online_units'] = UnitLiveData::whereDate('updated_at', '=', date('Y-m-d'))->count();
        $totals['total_offline_units'] = UnitLiveData::whereDate('updated_at', '!=', date('Y-m-d'))->count();
        $totals['total_flow_limit'] = Unit::sum('total_limit');
        $totals['total_today_flow'] = UnitLiveData::sum('today_flow');
        return view('admin.index', ["locations" => $locations, "chartData" => json_encode($chartData), "allData" => $allData, "totals" => $totals]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function contact()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function ContactShow(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
