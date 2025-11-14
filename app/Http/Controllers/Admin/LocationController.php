<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LocationRequest;
use App\Models\Location;
use App\Models\Unit;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locations = Location::with('zones')->get();

        return view('admin.locations.index', ['locations' => $locations]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.locations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LocationRequest $request)
    {

        $validated = $request->validated();
        $location = new Location;
        $location->title = $validated['title'];
        $location->save();

        return redirect()->route('admin.locations.index')->withStatus('Location added successfully !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $location = Location::with('zones')->findOrFail($id);
        $units = Unit::with('location', 'zone', 'user', 'liveData', 'yesterdayFlow')->where('location_id', $id)->get();
        $sortedData = collect($units)->sortByDesc(function ($item) {
            return $item->liveData->updated_at;
        })->values()->all();

        return view('admin.locations.show', ['location' => $location, 'units' => $sortedData]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $location = Location::with('zones')->findOrFail($id);

        return view('admin.locations.edit', ['location' => $location]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LocationRequest $request, string $id)
    {
        $validated = $request->validated();
        Location::where('id', $id)->update(['title' => $validated['title']]);
        $location = Location::where('id', $id)->first();

        return redirect()->route('admin.locations.index')->withStatus('Location updated successfully !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $location = Location::where('id', $id)->delete();

        return redirect()->route('admin.locations.index')->withStatus('Location deleted successfully !');
    }
}
