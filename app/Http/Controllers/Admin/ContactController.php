<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $data = Contact::latest()->get();
        return view('admin.kontak.index', compact('data'));
    }

    public function create()
    {
        return view('admin.kontak.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'phone_number' => 'required'
        ]);

        Contact::create($data);
        return redirect()->route('admin.kontak.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $item = Contact::findOrFail($id);
        return view('admin.kontak.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required',
            'phone_number' => 'required'
        ]);

        $item = Contact::findOrFail($id);
        $item->update($data);
        return redirect()->route('admin.kontak.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $item = Contact::findOrFail($id);
        $item->delete();
        return redirect()->route('admin.kontak.index')->with('success', 'Data berhasil dihapus');
    }
}
