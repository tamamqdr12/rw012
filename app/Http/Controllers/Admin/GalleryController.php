<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $query = Gallery::latest();
        if (auth()->user()->isKarangTarunaAdmin()) {
            $query->where('category', 'Kepemudaan');
        }
        $data = $query->get();
        return view('admin.galeri.index', compact('data'));
    }

    public function create()
    {
        return view('admin.galeri.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'date' => 'nullable|date',
            'description' => 'nullable|string',
            'image_path' => 'required|image|max:5120',
        ]);

        if ($request->hasFile('image_path')) {
            $data['image_path'] = $request->file('image_path')->store('galeri', 'public');
        }

        if (auth()->user()->isKarangTarunaAdmin()) {
            $data['category'] = 'Kepemudaan';
        }

        Gallery::create($data);
        return redirect()->route('admin.galeri.index')->with('success', 'Foto berhasil diunggah ke galeri');
    }

    public function edit($id)
    {
        $item = $this->findAuthorized($id);
        return view('admin.galeri.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'date' => 'nullable|date',
            'description' => 'nullable|string',
            'image_path' => 'nullable|image|max:5120',
        ]);

        $item = $this->findAuthorized($id);

        if ($request->hasFile('image_path')) {
            // Delete old image
            if ($item->image_path && Storage::disk('public')->exists($item->image_path)) {
                Storage::disk('public')->delete($item->image_path);
            }
            $data['image_path'] = $request->file('image_path')->store('galeri', 'public');
        } else {
            unset($data['image_path']);
        }

        if (auth()->user()->isKarangTarunaAdmin()) {
            $data['category'] = 'Kepemudaan';
        }

        $item->update($data);
        return redirect()->route('admin.galeri.index')->with('success', 'Data galeri berhasil diperbarui');
    }

    public function destroy($id)
    {
        $item = $this->findAuthorized($id);
        if ($item->image_path && Storage::disk('public')->exists($item->image_path)) {
            Storage::disk('public')->delete($item->image_path);
        }
        $item->delete();
        return redirect()->route('admin.galeri.index')->with('success', 'Foto berhasil dihapus dari galeri');
    }

    private function findAuthorized($id): Gallery
    {
        $item = Gallery::findOrFail($id);
        if (auth()->user()->isKarangTarunaAdmin() && $item->category !== 'Kepemudaan') {
            abort(403, 'Galeri ini bukan konten Karang Taruna.');
        }
        return $item;
    }
}
