<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - RW 012</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7f8;
            color: #24333d;
        }
        .sidebar {
            width: 258px;
            background: #173446;
            color: #fff;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            transition: transform 0.22s ease;
        }
        .sidebar-brand {
            padding: 20px;
            font-size: 1.1rem;
            font-weight: 700;
            border-bottom: 1px solid rgba(255,255,255,.12);
        }
        .nav-link {
            color: #c2d0d6;
            padding: 10px 16px;
            margin: 1px 8px;
            border-radius: 5px;
            font-size: .9rem;
            transition: background .2s ease;
        }
        .nav-link:hover, .nav-link.active {
            color: #fff;
            background: #24516a;
        }
        .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        .main-content {
            margin-left: 258px;
            padding: 0 24px 32px;
            transition: all 0.3s;
        }
        .navbar-top {
            background: #fff;
            border-bottom: 1px solid #dce3e7;
            padding: 16px 24px;
            margin: 0 -24px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
                box-shadow: 8px 0 22px rgba(0,0,0,.18);
            }
            .sidebar.active {
                transform: translateX(0);
                z-index: 999;
            }
            .main-content {
                margin-left: 0;
                padding: 0 16px 24px;
            }
        }
        .card { border: 1px solid #dce3e7; border-radius: 6px; box-shadow: none !important; }
        .btn { border-radius: 5px; font-weight: 600; }
        .btn-primary { background:#145a8d; border-color:#145a8d; }
        .btn-primary:hover { background:#0d4169; border-color:#0d4169; }
        .table { font-size:.9rem; }
        .table > :not(caption) > * > * { border-color:#dce3e7; padding:.8rem .75rem; }
        .table > thead > tr > th { color:#52626e; font-size:.75rem; text-transform:uppercase; letter-spacing:.045em; }
        .form-control,.form-select { border-color:#cbd6dc; border-radius:5px; padding:.6rem .7rem; }
        .form-control:focus,.form-select:focus { border-color:#79a8c4; box-shadow:0 0 0 .2rem rgba(20,90,141,.12); }
        .sidebar-backdrop { display:none; }
        @media(max-width:991.98px) { .navbar-top { margin:0 -16px 20px; padding:14px 16px; } .sidebar-backdrop.active { display:block; position:fixed; inset:0; background:rgba(20,35,44,.35); z-index:998; } }
    </style>
</head>
<body>

    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <i class="bi bi-shield-check text-info"></i> Administrasi RW 012
            <small class="d-block fw-normal mt-1" style="font-size:.72rem;color:#aebfc8">Portal pengurus lingkungan</small>
        </div>
        @php($adminUser = auth()->user())
        <ul class="nav flex-column mt-3">
            <li class="nav-item"><a class="nav-link {{ request()->is('admin') ? 'active' : '' }}" href="{{ route('admin.index') }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
            @if($adminUser->isRwAdmin())
            <li class="nav-item"><a class="nav-link {{ request()->is('admin/rw-profile*') ? 'active' : '' }}" href="{{ route('admin.rw-profile.index') }}"><i class="bi bi-building"></i> Profil RW</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->is('admin/rt*') ? 'active' : '' }}" href="{{ route('admin.rt.index') }}"><i class="bi bi-houses"></i> Data RT</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->is('admin/pengurus*') ? 'active' : '' }}" href="{{ route('admin.pengurus.index') }}"><i class="bi bi-people"></i> Pengurus</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->is('admin/data-warga*') ? 'active' : '' }}" href="{{ route('admin.data-warga.index') }}"><i class="bi bi-bar-chart"></i> Data Warga</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->is('admin/daily-report*') ? 'active' : '' }}" href="{{ route('admin.daily-report.index') }}"><i class="bi bi-journal-text"></i> Daily Report</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->is('admin/pengumuman*') ? 'active' : '' }}" href="{{ route('admin.pengumuman.index') }}"><i class="bi bi-megaphone"></i> Pengumuman</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->is('admin/kegiatan*') ? 'active' : '' }}" href="{{ route('admin.kegiatan.index') }}"><i class="bi bi-calendar-event"></i> Kegiatan</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->is('admin/galeri*') ? 'active' : '' }}" href="{{ route('admin.galeri.index') }}"><i class="bi bi-images"></i> Galeri</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->is('admin/karang-taruna*') ? 'active' : '' }}" href="{{ route('admin.karang-taruna.index') }}"><i class="bi bi-people-fill"></i> Karang Taruna</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->is('admin/map-location*') ? 'active' : '' }}" href="{{ route('admin.map-location.index') }}"><i class="bi bi-geo-alt"></i> Peta / Maps</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->is('admin/aspirasi*') ? 'active' : '' }}" href="{{ route('admin.aspirasi.index') }}"><i class="bi bi-chat-text"></i> Aspirasi</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->is('admin/kontak*') ? 'active' : '' }}" href="{{ route('admin.kontak.index') }}"><i class="bi bi-telephone"></i> Kontak</a></li>
            @elseif($adminUser->rtNumber())
            <li class="nav-item"><a class="nav-link {{ request()->is('admin/pengurus*') ? 'active' : '' }}" href="{{ route('admin.pengurus.index') }}"><i class="bi bi-people"></i> Pengurus RT</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->is('admin/data-warga*') ? 'active' : '' }}" href="{{ route('admin.data-warga.index') }}"><i class="bi bi-bar-chart"></i> Data Warga RT</a></li>
            @elseif($adminUser->isKarangTarunaAdmin())
            <li class="nav-item"><a class="nav-link {{ request()->is('admin/karang-taruna*') ? 'active' : '' }}" href="{{ route('admin.karang-taruna.index') }}"><i class="bi bi-people-fill"></i> Karang Taruna</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->is('admin/pengurus*') ? 'active' : '' }}" href="{{ route('admin.pengurus.index') }}"><i class="bi bi-people"></i> Struktur Pengurus</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->is('admin/kegiatan*') ? 'active' : '' }}" href="{{ route('admin.kegiatan.index') }}"><i class="bi bi-calendar-event"></i> Kegiatan</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->is('admin/galeri*') ? 'active' : '' }}" href="{{ route('admin.galeri.index') }}"><i class="bi bi-images"></i> Galeri Kepemudaan</a></li>
            @endif
            <li class="nav-item"><a class="nav-link" href="{{ route('home') }}" target="_blank"><i class="bi bi-box-arrow-up-right"></i> Lihat Website</a></li>
        </ul>
    </div>

    <div class="main-content" id="main-content">
        <div class="navbar-top">
            <div>
                <button class="btn btn-outline-secondary d-lg-none me-2" id="toggleSidebar" aria-label="Buka menu"><i class="bi bi-list"></i></button>
                <div><span class="fw-bold">Panel administrasi</span><small class="d-block text-secondary">RW 012 / {{ request()->segment(2) ? ucwords(str_replace('-', ' ', request()->segment(2))) : 'Dashboard' }}</small></div>
            </div>
            <div>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-box-arrow-right"></i> Logout</button>
                </form>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @yield('content')
    </div>
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('sidebarBackdrop').classList.toggle('active');
        });
        document.getElementById('sidebarBackdrop').addEventListener('click', function() { document.getElementById('sidebar').classList.remove('active'); this.classList.remove('active'); });
    </script>
</body>
</html>
