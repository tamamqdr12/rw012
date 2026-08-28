<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MapLocation;
use Illuminate\Http\Request;

class MapLocationController extends Controller
{
    public function index()
    {
        $data = MapLocation::latest()->get();
        return view('admin.map-location.index', compact('data'));
    }

    public function create()
    {
        return view('admin.map-location.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'type' => 'required',
            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string',
            'description' => 'required'
        ]);
        
        MapLocation::create($data);
        return redirect()->route('admin.map-location.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $item = MapLocation::findOrFail($id);
        return view('admin.map-location.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required',
            'type' => 'required',
            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string',
            'description' => 'required'
        ]);
        
        $item = MapLocation::findOrFail($id);
        $item->update($data);
        return redirect()->route('admin.map-location.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $item = MapLocation::findOrFail($id);
        $item->delete();
        return redirect()->route('admin.map-location.index')->with('success', 'Data berhasil dihapus');
    }
}
