@extends('layouts.admin')

@section('content')
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-end gap-2 mb-4">
    <div><h1 class="h3 fw-bold mb-1">{{ $dashboardTitle }}</h1><p class="text-secondary mb-0">{{ $dashboardDescription }}</p></div>
    <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-secondary btn-sm"><i class="bi bi-box-arrow-up-right me-1"></i>Lihat website</a>
</div>
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3"><div class="card h-100 border-top border-3 border-primary"><div class="card-body"><div class="text-secondary small">{{ $dashboardLabels[0] }}</div><div class="h2 fw-bold mb-0 mt-2">{{ $stats['warga'] ?? 0 }}</div></div></div></div>
    <div class="col-6 col-lg-3"><div class="card h-100 border-top border-3 border-success"><div class="card-body"><div class="text-secondary small">{{ $dashboardLabels[1] }}</div><div class="h2 fw-bold mb-0 mt-2">{{ $stats['rt'] }}</div></div></div></div>
    <div class="col-6 col-lg-3"><div class="card h-100 border-top border-3 border-primary"><div class="card-body"><div class="text-secondary small">{{ $dashboardLabels[2] }}</div><div class="h2 fw-bold mb-0 mt-2">{{ $stats['pengurus'] }}</div></div></div></div>
    @if($dashboardLabels[3])<div class="col-6 col-lg-3"><div class="card h-100 border-top border-3 border-warning"><div class="card-body"><div class="text-secondary small">{{ $dashboardLabels[3] }}</div><div class="h2 fw-bold mb-0 mt-2">{{ $stats['pengumuman'] }}</div></div></div></div>@endif
</div>
@if(auth()->user()->isRwAdmin())<div class="card"><div class="card-body"><h2 class="h5 fw-bold mb-1">Konten yang dikelola</h2><p class="small text-secondary mb-4">Akses cepat untuk memperbarui informasi warga.</p><div class="row g-0 border-top border-start"><div class="col-md-4 border-end border-bottom p-3"><div class="small text-secondary">Kegiatan</div><div class="d-flex align-items-center justify-content-between"><strong class="fs-4">{{ $stats['kegiatan'] }}</strong><a href="{{ route('admin.kegiatan.index') }}" class="small">Kelola</a></div></div><div class="col-md-4 border-end border-bottom p-3"><div class="small text-secondary">Daily report</div><div class="d-flex align-items-center justify-content-between"><strong class="fs-4">{{ $stats['report'] }}</strong><a href="{{ route('admin.daily-report.index') }}" class="small">Kelola</a></div></div><div class="col-md-4 border-end border-bottom p-3"><div class="small text-secondary">Aspirasi warga</div><div class="d-flex align-items-center justify-content-between"><strong class="fs-4">{{ $stats['aspirasi'] }}</strong><a href="{{ route('admin.aspirasi.index') }}" class="small">Tinjau</a></div></div></div></div></div>@endif
@endsection
