<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrganizationalMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Rt;

class OrganizationalMemberController extends Controller
{
    public function index()
    {
        $query = OrganizationalMember::with('rt')->latest();
        if ($rtId = auth()->user()->assignedRtId()) {
            $query->where('rt_id', $rtId)->where('is_karang_taruna', false);
        } elseif (auth()->user()->isKarangTarunaAdmin()) {
            $query->where('is_karang_taruna', true);
        }
        $data = $query->get();
        return view('admin.pengurus.index', compact('data'));
    }

    public function create()
    {
        $rts = $this->availableRts();
        return view('admin.pengurus.create', compact('rts'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'role' => 'required',
            'period' => 'nullable|string',
            'contact_info' => 'nullable|string',
            'rt_id' => 'nullable|exists:rts,id',
            'photo_path' => 'nullable|image|max:2048',
            'is_active' => 'nullable|boolean'
        ]);

        if ($request->hasFile('photo_path')) {
            $data['photo_path'] = $request->file('photo_path')->store('uploads', 'public');
        }
        $data['is_active'] = $request->has('is_active');
        $data['is_karang_taruna'] = $request->has('is_karang_taruna');
        $this->forceAssignedRt($data);

        OrganizationalMember::create($data);
        return redirect()->route('admin.pengurus.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $item = $this->findAuthorized($id);
        $rts = $this->availableRts();
        return view('admin.pengurus.edit', compact('item', 'rts'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required',
            'role' => 'required',
            'period' => 'nullable|string',
            'contact_info' => 'nullable|string',
            'rt_id' => 'nullable|exists:rts,id',
            'photo_path' => 'nullable|image|max:2048',
            'is_active' => 'nullable|boolean'
        ]);
        
        $item = $this->findAuthorized($id);

        if ($request->hasFile('photo_path')) {
            if ($item->photo_path && Storage::disk('public')->exists($item->photo_path)) { Storage::disk('public')->delete($item->photo_path); }
            $data['photo_path'] = $request->file('photo_path')->store('uploads', 'public');
        }
        $data['is_active'] = $request->has('is_active');
        $data['is_karang_taruna'] = $request->has('is_karang_taruna');
        $this->forceAssignedRt($data);

        $item->update($data);
        return redirect()->route('admin.pengurus.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $item = $this->findAuthorized($id);
        if ($item->photo_path && Storage::disk('public')->exists($item->photo_path)) { Storage::disk('public')->delete($item->photo_path); }
        $item->delete();
        return redirect()->route('admin.pengurus.index')->with('success', 'Data berhasil dihapus');
    }

    private function availableRts()
    {
        if (auth()->user()->isKarangTarunaAdmin()) {
            return collect();
        }
        return ($rtId = auth()->user()->assignedRtId()) ? Rt::whereKey($rtId)->get() : Rt::all();
    }

    private function forceAssignedRt(array &$data): void
    {
        if ($rtId = auth()->user()->assignedRtId()) {
            $data['rt_id'] = $rtId;
            $data['is_karang_taruna'] = false;
        } elseif (auth()->user()->isKarangTarunaAdmin()) {
            $data['rt_id'] = null;
            $data['is_karang_taruna'] = true;
        }
    }

    private function findAuthorized($id): OrganizationalMember
    {
        $item = OrganizationalMember::findOrFail($id);
        if (($rtId = auth()->user()->assignedRtId()) && $item->rt_id !== $rtId) {
            abort(403, 'Data pengurus ini bukan milik RT Anda.');
        }
        if (auth()->user()->isKarangTarunaAdmin() && ! $item->is_karang_taruna) {
            abort(403, 'Data pengurus ini bukan milik Karang Taruna.');
        }
        return $item;
    }
}
