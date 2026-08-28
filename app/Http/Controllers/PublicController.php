<?php

namespace App\Http\Controllers;

use App\Models\RwProfile;
use App\Models\Rt;
use App\Models\OrganizationalMember;
use App\Models\ResidentsStatistic;
use App\Models\MapLocation;
use App\Models\DailyReport;
use App\Models\Announcement;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\Aspiration;
use App\Models\Contact;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {
        $profile = RwProfile::first();
        $rts = Rt::with('residentsStatistic')->get();
        
        $announcements = Announcement::where('is_active', true)
            ->where(function($q) {
                $q->whereNull('publish_date')->orWhere('publish_date', '<=', now());
            })
            ->orderBy('is_pinned', 'desc')
            ->latest()
            ->take(3)
            ->get();
            
        $events = Event::orderByRaw("FIELD(status, 'Berlangsung', 'Akan Datang', 'Selesai')")
            ->orderBy('event_date', 'asc')
            ->take(3)
            ->get();
            
        $reports = DailyReport::where('is_published', true)->latest()->take(3)->get();
        $galleries = Gallery::latest()->take(4)->get();
        $rwContact = Contact::where('name', 'RW 012')->first();
        $totalWarga = $rts->sum(fn($rt) => $rt->residentsStatistic ? $rt->residentsStatistic->total_count : 0);

        return view('public.index', compact('profile', 'rts', 'announcements', 'events', 'reports', 'galleries', 'rwContact', 'totalWarga'));
    }

    public function profil()
    {
        $profile = RwProfile::first();
        return view('public.profil', compact('profile'));
    }

    public function peta()
    {
        $locations = MapLocation::all();
        return view('public.peta', compact('locations'));
    }

    public function struktur()
    {
        $rwMembers = OrganizationalMember::whereNull('rt_id')
            ->where('is_karang_taruna', false)
            ->where('is_active', true)
            ->orderBy('role')
            ->get();
        $rtMembers = OrganizationalMember::with('rt')->whereNotNull('rt_id')->where('is_active', true)->get();
        $rts = Rt::orderBy('name')->get();
        $karangTarunaMembers = OrganizationalMember::where('is_karang_taruna', true)
            ->where('is_active', true)
            ->orderBy('role')
            ->get();
        return view('public.struktur', compact('rwMembers', 'rtMembers', 'rts', 'karangTarunaMembers'));
    }

    public function dailyReport()
    {
        $reports = DailyReport::where('is_published', true)->latest()->paginate(10);
        return view('public.daily_report', compact('reports'));
    }

    public function pengumuman()
    {
        $announcements = Announcement::where('is_active', true)
            ->where(function($q) {
                $q->whereNull('publish_date')->orWhere('publish_date', '<=', now());
            })
            ->orderBy('is_pinned', 'desc')
            ->latest()
            ->paginate(10);
        return view('public.pengumuman', compact('announcements'));
    }

    public function dataWarga()
    {
        $statistics = ResidentsStatistic::with('rt')->get();
        return view('public.data_warga', compact('statistics'));
    }

    public function rt($id)
    {
        $rt = Rt::with(['residentsStatistic', 'organizationalMembers'])->findOrFail($id);
        $contact = Contact::where('name', $rt->name)->first();
        return view('public.rt', compact('rt', 'contact'));
    }

    public function karangTaruna()
    {
        $profile = \App\Models\KarangTarunaProfile::first();
        $members = OrganizationalMember::where('is_karang_taruna', true)->where('is_active', true)->get();
        $contact = Contact::where('name', 'Karang Taruna')->first();
        $galleries = Gallery::where('category', 'Kepemudaan')->latest()->take(6)->get();
        return view('public.karang_taruna', compact('profile', 'members', 'contact', 'galleries'));
    }

    public function kegiatan()
    {
        $events = Event::orderByRaw("FIELD(status, 'Berlangsung', 'Akan Datang', 'Selesai')")
            ->orderBy('event_date', 'asc')
            ->paginate(9);
        return view('public.kegiatan', compact('events'));
    }

    public function galeri()
    {
        $galleries = Gallery::latest()->paginate(12);
        return view('public.galeri', compact('galleries'));
    }

    public function aspirasi()
    {
        // Get aspirations to show publicly (hide sensitive contact info in view)
        $aspirations = Aspiration::latest()->paginate(10);
        return view('public.aspirasi', compact('aspirations'));
    }

    public function storeAspirasi(Request $request)
    {
        $request->validate([
            'sender_name' => 'nullable|string|max:100',
            'contact_info' => 'nullable|string|max:100',
            'category' => 'required|string|max:50',
            'title' => 'required|string|max:200',
            'message' => 'required|string|max:2000',
            'photo_path' => 'nullable|image|max:5120',
        ]);

        $data = [
            'sender_name' => $request->sender_name ?: 'Warga Anonim',
            'contact_info' => $request->contact_info,
            'category' => $request->category,
            'title' => $request->title,
            'message' => $request->message,
            'status' => 'Baru'
        ];

        if ($request->hasFile('photo_path')) {
            $data['photo_path'] = $request->file('photo_path')->store('aspirasi', 'public');
        }

        Aspiration::create($data);

        return back()->with('success', 'Aspirasi/Pengaduan Anda berhasil dikirim dan akan segera diproses.');
    }

    public function kontak()
    {
        $contacts = Contact::all();
        return view('public.kontak', compact('contacts'));
    }
}
