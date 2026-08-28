<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    public function index()
    {
        $data = Announcement::latest()->get();
        return view('admin.pengumuman.index', compact('data'));
    }

    public function create()
    {
        return view('admin.pengumuman.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'publish_date' => 'required',
            'content' => 'required',
            'photo_path' => 'nullable|image|max:2048',
            'is_pinned' => 'nullable|boolean',
            'is_active' => 'nullable|boolean'
        ]);

        if ($request->hasFile('photo_path')) {
            $data['photo_path'] = $request->file('photo_path')->store('uploads', 'public');
        }
        $data['is_pinned'] = $request->has('is_pinned');
        $data['is_active'] = $request->has('is_active');

        Announcement::create($data);
        return redirect()->route('admin.pengumuman.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $item = Announcement::findOrFail($id);
        return view('admin.pengumuman.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'required',
            'publish_date' => 'required',
            'content' => 'required',
            'photo_path' => 'nullable|image|max:2048',
            'is_pinned' => 'nullable|boolean',
            'is_active' => 'nullable|boolean'
        ]);
        
        $item = Announcement::findOrFail($id);

        if ($request->hasFile('photo_path')) {
            if ($item->photo_path && Storage::disk('public')->exists($item->photo_path)) { Storage::disk('public')->delete($item->photo_path); }
            $data['photo_path'] = $request->file('photo_path')->store('uploads', 'public');
        }
        $data['is_pinned'] = $request->has('is_pinned');
        $data['is_active'] = $request->has('is_active');

        $item->update($data);
        return redirect()->route('admin.pengumuman.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $item = Announcement::findOrFail($id);
        if ($item->photo_path && Storage::disk('public')->exists($item->photo_path)) { Storage::disk('public')->delete($item->photo_path); }
        $item->delete();
        return redirect()->route('admin.pengumuman.index')->with('success', 'Data berhasil dihapus');
    }
}
