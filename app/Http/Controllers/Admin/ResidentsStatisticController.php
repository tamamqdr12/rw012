<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ResidentsStatistic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Rt;

class ResidentsStatisticController extends Controller
{
    public function index()
    {
        $query = ResidentsStatistic::with('rt')->latest();
        if ($rtId = auth()->user()->assignedRtId()) {
            $query->where('rt_id', $rtId);
        }
        $data = $query->get();
        return view('admin.data-warga.index', compact('data'));
    }

    public function create()
    {
        $rts = $this->availableRts();
        return view('admin.data-warga.create', compact('rts'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'rt_id' => 'nullable|exists:rts,id',
            'total_kk' => 'required',
            'male_count' => 'required',
            'female_count' => 'required',
            'total_count' => 'required'
        ]);

        $this->forceAssignedRt($data);


        ResidentsStatistic::create($data);
        return redirect()->route('admin.data-warga.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $item = $this->findAuthorized($id);
        $rts = $this->availableRts();
        return view('admin.data-warga.edit', compact('item', 'rts'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'rt_id' => 'nullable|exists:rts,id',
            'total_kk' => 'required',
            'male_count' => 'required',
            'female_count' => 'required',
            'total_count' => 'required'
        ]);
        
        $item = $this->findAuthorized($id);

        $this->forceAssignedRt($data);


        $item->update($data);
        return redirect()->route('admin.data-warga.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $item = $this->findAuthorized($id);
        $item->delete();
        return redirect()->route('admin.data-warga.index')->with('success', 'Data berhasil dihapus');
    }

    private function availableRts()
    {
        return ($rtId = auth()->user()->assignedRtId()) ? Rt::whereKey($rtId)->get() : Rt::all();
    }

    private function forceAssignedRt(array &$data): void
    {
        if ($rtId = auth()->user()->assignedRtId()) {
            $data['rt_id'] = $rtId;
        }
    }

    private function findAuthorized($id): ResidentsStatistic
    {
        $item = ResidentsStatistic::findOrFail($id);
        if (($rtId = auth()->user()->assignedRtId()) && $item->rt_id !== $rtId) {
            abort(403, 'Data warga ini bukan milik RT Anda.');
        }
        return $item;
    }
}
