<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rt;
use Illuminate\Http\Request;

class RtController extends Controller
{
    public function index()
    {
        $data = Rt::latest()->get();
        return view('admin.rt.index', compact('data'));
    }

    public function create()
    {
        return view('admin.rt.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required'
        ]);

        Rt::create($data);
        return redirect()->route('admin.rt.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $item = Rt::findOrFail($id);
        return view('admin.rt.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required'
        ]);

        $item = Rt::findOrFail($id);
        $item->update($data);
        return redirect()->route('admin.rt.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $item = Rt::findOrFail($id);
        $item->delete();
        return redirect()->route('admin.rt.index')->with('success', 'Data berhasil dihapus');
    }
}
