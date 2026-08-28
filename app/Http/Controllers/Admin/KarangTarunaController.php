<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KarangTarunaProfile;
use App\Models\OrganizationalMember;
use App\Models\Gallery;
use App\Models\Event;
use App\Models\Contact;
use Illuminate\Http\Request;

class KarangTarunaController extends Controller
{
    public function index()
    {
        $profile = KarangTarunaProfile::first();
        $members = OrganizationalMember::where('is_karang_taruna', true)->where('is_active', true)->get();
        $contact = Contact::where('name', 'Karang Taruna')->first();
        return view('admin.karang-taruna.index', compact('profile', 'members', 'contact'));
    }

    public function updateProfile(Request $request)
    {
        $data = $request->validate([
            'profile_text' => 'required|string',
            'programs_text' => 'required|string',
        ]);

        $profile = KarangTarunaProfile::first();
        if ($profile) {
            $profile->update($data);
        } else {
            KarangTarunaProfile::create($data);
        }

        return redirect()->route('admin.karang-taruna.index')->with('success', 'Profil Karang Taruna berhasil diperbarui');
    }
}
