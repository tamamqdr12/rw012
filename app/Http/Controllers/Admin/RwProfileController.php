<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RwProfile;
use Illuminate\Http\Request;

class RwProfileController extends Controller
{
    public function index()
    {
        $data = RwProfile::latest()->get();
        return view('admin.rw-profile.index', compact('data'));
    }

    public function create()
    {
        return view('admin.rw-profile.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'village' => 'required',
            'district' => 'required',
            'city' => 'required'
        ]);

        RwProfile::create($data);
        return redirect()->route('admin.rw-profile.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $item = RwProfile::findOrFail($id);
        return view('admin.rw-profile.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required',
            'village' => 'required',
            'district' => 'required',
            'city' => 'required'
        ]);

        $item = RwProfile::findOrFail($id);
        $item->update($data);
        return redirect()->route('admin.rw-profile.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $item = RwProfile::findOrFail($id);
        $item->delete();
        return redirect()->route('admin.rw-profile.index')->with('success', 'Data berhasil dihapus');
    }
}
