<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Rt;
use App\Models\OrganizationalMember;
use App\Models\ResidentsStatistic;
use App\Models\Announcement;
use App\Models\Event;
use App\Models\DailyReport;
use App\Models\Aspiration;
use App\Models\Gallery;

class AdminController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($rtNumber = $user->rtNumber()) {
            $rtId = $user->assignedRtId();
            $rt = $rtId ? Rt::find($rtId) : null;
            $stats = [
                'warga' => ResidentsStatistic::where('rt_id', $rtId)->sum('total_count'),
                'rt' => $rt ? 1 : 0,
                'pengurus' => OrganizationalMember::where('rt_id', $rtId)->where('is_karang_taruna', false)->count(),
                'pengumuman' => 0,
                'kegiatan' => 0,
                'report' => 0,
                'aspirasi' => 0,
            ];
            $dashboardTitle = 'Dashboard RT ' . str_pad((string) $rtNumber, 3, '0', STR_PAD_LEFT);
            $dashboardDescription = 'Kelola data warga dan pengurus untuk RT Anda.';
            $dashboardLabels = ['Warga RT', 'RT terhubung', 'Pengurus RT', ''];
            return view('admin.dashboard', compact('stats', 'dashboardTitle', 'dashboardDescription', 'dashboardLabels'));
        }

        if ($user->isKarangTarunaAdmin()) {
            $stats = [
                'warga' => OrganizationalMember::where('is_karang_taruna', true)->where('is_active', true)->count(),
                'rt' => Event::where('organizer', 'Karang Taruna RW 012')->count(),
                'pengurus' => Gallery::where('category', 'Kepemudaan')->count(),
                'pengumuman' => 0,
                'kegiatan' => Event::where('organizer', 'Karang Taruna RW 012')->count(),
                'report' => Gallery::where('category', 'Kepemudaan')->count(),
                'aspirasi' => 0,
            ];
            $dashboardTitle = 'Dashboard Karang Taruna';
            $dashboardDescription = 'Kelola kegiatan, galeri, dan profil Karang Taruna RW 012.';
            $dashboardLabels = ['Anggota aktif', 'Kegiatan', 'Galeri kepemudaan', ''];
            return view('admin.dashboard', compact('stats', 'dashboardTitle', 'dashboardDescription', 'dashboardLabels'));
        }

        $stats = [
            'warga' => ResidentsStatistic::sum('total_count'),
            'rt' => Rt::count(),
            'pengurus' => OrganizationalMember::count(),
            'pengumuman' => Announcement::count(),
            'kegiatan' => Event::count(),
            'report' => DailyReport::count(),
            'aspirasi' => Aspiration::count()
        ];
        
        $dashboardTitle = 'Ringkasan administrasi';
        $dashboardDescription = 'Ikhtisar data dan informasi RW 012.';
        $dashboardLabels = ['Total warga', 'Total RT', 'Pengurus', 'Pengumuman'];
        return view('admin.dashboard', compact('stats', 'dashboardTitle', 'dashboardDescription', 'dashboardLabels'));
    }
}
