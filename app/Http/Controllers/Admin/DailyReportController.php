<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DailyReportController extends Controller
{
    public function index()
    {
        $data = DailyReport::latest()->get();
        return view('admin.daily-report.index', compact('data'));
    }

    public function create()
    {
        return view('admin.daily-report.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'date' => 'required',
            'category' => 'required',
            'description' => 'required',
            'writer_name' => 'required',
            'photo_path' => 'nullable|image|max:2048',
            'is_published' => 'nullable|boolean'
        ]);

        if ($request->hasFile('photo_path')) {
            $data['photo_path'] = $request->file('photo_path')->store('uploads', 'public');
        }
        $data['is_published'] = $request->has('is_published');

        DailyReport::create($data);
        return redirect()->route('admin.daily-report.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $item = DailyReport::findOrFail($id);
        return view('admin.daily-report.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'required',
            'date' => 'required',
            'category' => 'required',
            'description' => 'required',
            'writer_name' => 'required',
            'photo_path' => 'nullable|image|max:2048',
            'is_published' => 'nullable|boolean'
        ]);
        
        $item = DailyReport::findOrFail($id);

        if ($request->hasFile('photo_path')) {
            if ($item->photo_path && Storage::disk('public')->exists($item->photo_path)) { Storage::disk('public')->delete($item->photo_path); }
            $data['photo_path'] = $request->file('photo_path')->store('uploads', 'public');
        }
        $data['is_published'] = $request->has('is_published');

        $item->update($data);
        return redirect()->route('admin.daily-report.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $item = DailyReport::findOrFail($id);
        if ($item->photo_path && Storage::disk('public')->exists($item->photo_path)) { Storage::disk('public')->delete($item->photo_path); }
        $item->delete();
        return redirect()->route('admin.daily-report.index')->with('success', 'Data berhasil dihapus');
    }
}
