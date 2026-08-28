<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $query = Event::latest();
        if (auth()->user()->isKarangTarunaAdmin()) {
            $query->where('organizer', 'Karang Taruna RW 012');
        }
        $data = $query->get();
        return view('admin.kegiatan.index', compact('data'));
    }

    public function create()
    {
        return view('admin.kegiatan.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'event_date' => 'required',
            'event_time' => 'required',
            'location' => 'required',
            'organizer' => auth()->user()->isKarangTarunaAdmin() ? 'nullable|string' : 'required',
            'description' => 'required',
            'photo_path' => 'nullable|image|max:2048',
            'status' => 'required'
        ]);

        if ($request->hasFile('photo_path')) {
            $data['photo_path'] = $request->file('photo_path')->store('uploads', 'public');
        }

        if (auth()->user()->isKarangTarunaAdmin()) {
            $data['organizer'] = 'Karang Taruna RW 012';
        }

        Event::create($data);
        return redirect()->route('admin.kegiatan.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $item = $this->findAuthorized($id);
        return view('admin.kegiatan.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'required',
            'event_date' => 'required',
            'event_time' => 'required',
            'location' => 'required',
            'organizer' => auth()->user()->isKarangTarunaAdmin() ? 'nullable|string' : 'required',
            'description' => 'required',
            'photo_path' => 'nullable|image|max:2048',
            'status' => 'required'
        ]);
        
        $item = $this->findAuthorized($id);

        if ($request->hasFile('photo_path')) {
            if ($item->photo_path && Storage::disk('public')->exists($item->photo_path)) { Storage::disk('public')->delete($item->photo_path); }
            $data['photo_path'] = $request->file('photo_path')->store('uploads', 'public');
        }

        if (auth()->user()->isKarangTarunaAdmin()) {
            $data['organizer'] = 'Karang Taruna RW 012';
        }

        $item->update($data);
        return redirect()->route('admin.kegiatan.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $item = $this->findAuthorized($id);
        if ($item->photo_path && Storage::disk('public')->exists($item->photo_path)) { Storage::disk('public')->delete($item->photo_path); }
        $item->delete();
        return redirect()->route('admin.kegiatan.index')->with('success', 'Data berhasil dihapus');
    }

    private function findAuthorized($id): Event
    {
        $item = Event::findOrFail($id);
        if (auth()->user()->isKarangTarunaAdmin() && $item->organizer !== 'Karang Taruna RW 012') {
            abort(403, 'Kegiatan ini bukan konten Karang Taruna.');
        }
        return $item;
    }
}
