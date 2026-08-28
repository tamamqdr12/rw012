<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aspiration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AspirationController extends Controller
{
    public function index()
    {
        $data = Aspiration::latest()->get();
        return view('admin.aspirasi.index', compact('data'));
    }

    public function create()
    {
        // Admin doesn't create aspirations here, they are created by public.
        return redirect()->route('admin.aspirasi.index');
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.aspirasi.index');
    }

    public function edit($id)
    {
        $item = Aspiration::findOrFail($id);
        return view('admin.aspirasi.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'status' => 'required|in:Baru,Diproses,Selesai',
            'response' => 'nullable|string',
        ]);

        $item = Aspiration::findOrFail($id);
        $item->update($data);
        return redirect()->route('admin.aspirasi.index')->with('success', 'Status dan Tanggapan Aspirasi berhasil diperbarui');
    }

    public function destroy($id)
    {
        $item = Aspiration::findOrFail($id);
        if ($item->photo_path && Storage::disk('public')->exists($item->photo_path)) {
            Storage::disk('public')->delete($item->photo_path);
        }
        $item->delete();
        return redirect()->route('admin.aspirasi.index')->with('success', 'Aspirasi berhasil dihapus');
    }
}
