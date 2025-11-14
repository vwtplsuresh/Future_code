<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Zone;
use App\Models\Unit;
use App\Models\Time;

class LockController extends Controller
{
  public function index()
  {
    $locations = Location::all();
    $zones = Zone::all();
    return view('admin.lock.index', ['locations' => $locations, 'zones' => $zones]);
  } 

  public function PhaseAndZoneLock(Request $request)
  {
    $validate = $request->validate([
      'location_id' => 'required|exists:locations,id',
      'action' => 'required',
    ]);

    
    $location_id = $request->input('location_id');
    $zone_id = $request->input('zone_id');
 
   
    $query = Unit::query();

        if (!empty($location_id) && empty($zone_id)) {
            $query->where('location_id', $location_id);
        } elseif (!empty($location_id) && !empty($zone_id)) {
            $query->where('location_id', $location_id)
                ->where('zone_id', $zone_id);
        }

    $units = $query->get();

    if($request->action == 'lock') {

    foreach ($units as $unit) {
        $unittime = Time::where('unit_id',$unit->id)->first();
        if($unittime) {
        $unittime->edit_time = "00-24";
        $unittime->save();

        // $unit->panel_lock = 1; 
        // $unit->save();
        }
    }
    } elseif($request->action == 'unlock') {

      foreach ($units as $unit) {
        $unittime = Time::where('unit_id',$unit->id)->first();
        if($unittime) {
        $unittime->edit_time = $unittime->fixed_time; 
        $unittime->save();

        // $unit->panel_lock = 0; 
        // $unit->save();
        }
      }
    }

    return redirect()->route('admin.lock.index')->with('success', 'Lock statuses updated successfully.');

  }
}
