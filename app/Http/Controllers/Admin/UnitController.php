<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UnitRequest;
use App\Models\Location;
use App\Models\MorningData;
use App\Models\Time;
use App\Models\Unit;
use App\Models\UnitLiveData;
use App\Models\User;
use App\Models\Zone;
use Illuminate\Support\Facades\Cache;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allUnits = Unit::with('location', 'zone')->get();

        return view('admin.units.index', ['units' => $allUnits]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $locations = Location::all();
        $zones = Zone::all();
        $users = User::with('roles')->get()->filter(
            fn ($user) => $user->roles->where('name', 'user')->toArray()
        )->all();

        return view('admin.units.create', ['locations' => $locations, 'zones' => $zones, 'users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UnitRequest $request)
    {
        $validated = $request->validated();
        $unit = new Unit;
        $unit->user_id = $validated['user_id'];
        $unit->location_id = $validated['location_id'];
        $unit->zone_id = $validated['zone_id'];
        $unit->title = $validated['title'];
        $unit->panel_no = $validated['panel_no'];
        $unit->address = $validated['address'];
        $unit->operator_name = $request->operator_name;
        $unit->operator_mobile = $request->operator_mobile;
        $unit->today_limit = $validated['today_limit'];
        $unit->total_limit = $validated['total_limit'];
        $unit->pipe_size = $validated['pipe_size'];
        $unit->plc_reset = $request->plc_reset;
        $unit->reset_memory = $request->reset_memory;
        $unit->panel_lock = $request->panel_lock;
        $unit->reset_totalizer = $request->reset_totalizer;
        // $unit->panel_unlock_timing = $request->panel_unlock_timing;
        $unit->mode = $request->mode;
        $unit->tds_bit = $request->tds_bit;
        $unit->min_tds = $request->min_tds;
        $unit->max_tds = $request->max_tds;
        $unit->cto = $request->cto;
        $unit->cto_remark = $request->cto_remark;

        $unit->save();

        $liveData = new UnitLiveData;
        $liveData->unit_id = $unit->id;
        $liveData->save();

        $morningData = new MorningData;
        $morningData->unit_id = $unit->id;
        $morningData->totalizer = 0;
        $morningData->save();

        if (! empty($request->panel_unlock_timing)) {
            Time::updateOrCreate(
                ['unit_id' => $unit->id],
                [
                    'fixed_time' => $request->panel_unlock_timing,
                    'edit_time' => $request->panel_unlock_timing,
                ]
            );
            Cache::forget('unit_lock_times');

        }

        return redirect()->route('admin.units.index')->withStatus('Unit added successfully !');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $unit = Unit::with('user', 'location', 'zone', 'liveData', 'monthlyFlow')->findOrFail($id);

        return view('admin.units.show', ['unit' => $unit]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $locations = Location::all();
        $zones = Zone::all();
        $time =Time::all();
        $users = User::with('roles')->get()->filter(
            fn ($user) => $user->roles->where('name', 'user')->toArray()
        )->all();
        // $unit = Unit::findOrFail($id);
        $unit = Unit::with('time')->findOrFail($id);

        return view('admin.units.edit', ['locations' => $locations, 'zones' => $zones, 'users' => $users, 'unit' => $unit ,'time'=>$time]);
    }
   
    /**
     * Update the specified resource in storage.
     */
    public function update(UnitRequest $request, string $id)
    {
        $validated = $request->validated();
        $unit = Unit::where('id', $id)->first();
        $unit->user_id = $validated['user_id'];
        $unit->location_id = $validated['location_id'];
        $unit->zone_id = $validated['zone_id'];
        $unit->title = $validated['title'];
        $unit->panel_no = $validated['panel_no'];
        $unit->address = $validated['address'];
        $unit->operator_name = $request->operator_name;
        $unit->operator_mobile = $request->operator_mobile;
        $unit->today_limit = $validated['today_limit'];
        $unit->total_limit = $validated['total_limit'];
        $unit->pipe_size = $validated['pipe_size'];
        $unit->plc_reset = $request->plc_reset;
        $unit->reset_memory = $request->reset_memory;
        $unit->panel_lock = $request->panel_lock;
        $unit->reset_totalizer = $request->reset_totalizer;
        $unit->panel_unlock_timing = $request->panel_unlock_timing;
        $unit->mode = $request->mode;
        $unit->tds_bit = $request->tds_bit;
        $unit->min_tds = $request->min_tds;
        $unit->max_tds = $request->max_tds;
        $unit->cto = $request->cto;
        $unit->cto_remark = $request->cto_remark;

        $unit->update();

        return redirect()->route('admin.units.index')->withStatus('Unit updated successfully !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


//     public function toggleLock($id)
// {
//     $unit = Unit::findOrFail($id);

//     // Toggle logic
//     $unit->panel_lock = $unit->panel_lock == 1 ? 0 : 1;
//     $unit->save();

//     return response()->json([
//         'success' => true,
//         'status' => $unit->panel_lock,
//         'message' => $unit->panel_lock ? 'Unlocked successfully' : 'Locked successfully'
//     ]);
// }

}
