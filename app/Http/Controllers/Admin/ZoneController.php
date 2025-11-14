<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ZoneRequest;
use App\Models\Location;
use App\Models\Unit;
use App\Models\Zone;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $zones = Zone::with('location')->get();

        return view('admin.zones.index', ['zones' => $zones]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $locations = Location::all();

        return view('admin.zones.create', ['locations' => $locations]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ZoneRequest $request)
    {
        $validated = $request->validated();
        $zone = new Zone;
        $zone->location_id = $validated['location'];
        $zone->title = $validated['title'];
        $zone->save();

        return redirect()->route('admin.zones.index')->withStatus('Zone added successfully !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $Zone = Zone::with('location')->findOrFail($id);
        $units = Unit::with('location', 'zone', 'user', 'liveData', 'yesterdayFlow')->where('location_id', $Zone->location->id)->where('zone_id', $id)->get();
        $sortedData = collect($units)->sortByDesc(function ($item) {
            return $item->liveData->updated_at;
        })->values()->all();

        return view('admin.zones.show', ['zone' => $Zone, 'units' => $sortedData]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $locations = Location::all();
        $Zone = Zone::with('location')->findOrFail($id);

        return view('admin.zones.edit', ['zone' => $Zone, 'locations' => $locations]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ZoneRequest $request, string $id)
    {
        $validated = $request->validated();
        Zone::where('id', $id)->update(['location_id' => $validated['location'], 'title' => $validated['title']]);
        $zone = Zone::findOrFail($id);

        return redirect()->route('admin.zones.index')->withStatus('Zone updated successfully !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $Zone = Zone::where('id', $id)->delete();

        return redirect()->route('admin.zones.index')->withStatus('Zone deleted successfully !');
    }
}
