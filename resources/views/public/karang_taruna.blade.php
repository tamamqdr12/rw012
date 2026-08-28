@extends('layouts.app')

@section('content')
<div class="container py-5">

    {{-- Hero Section --}}
    <div class="text-center mb-5 position-relative" data-aos="fade-up">
        <div class="bg-primary text-white rounded-4 shadow-sm p-5" style="background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));">
            <img src="{{ asset('assets/images/karangtaruna012.jpeg') }}" alt="Logo Karang Taruna" class="mb-4 rounded-circle bg-white p-2 shadow" style="width: 120px; height: 120px; object-fit: cover;">
            <h2 class="fw-bold display-6">Karang Taruna RW 012</h2>
            <p class="lead mb-0">Kelurahan Bugel, Kecamatan Karawaci, Kota Tangerang</p>
        </div>
    </div>

    {{-- Profil --}}
    <div class="row justify-content-center mb-5" data-aos="fade-up" data-aos-delay="100">
        <div class="col-md-10">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-5">
                    <h4 class="fw-bold mb-3"><i class="bi bi-info-circle text-primary me-2"></i>Tentang Kami</h4>
                    <div class="text-secondary lh-lg">
                        {!! nl2br(e($profile->profile_text ?? 'Deskripsi profil Karang Taruna belum ditambahkan oleh admin.')) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Struktur Pengurus --}}
    @php
        $findKtRole = fn ($keyword) => $members->first(fn ($member) => str_contains(strtolower($member->role ?? ''), $keyword));
        $ketuaKt = $findKtRole('ketua');
        $sekretarisKt = $findKtRole('sekretaris');
        $bendaharaKt = $findKtRole('bendahara');
        $coreKtIds = collect([$ketuaKt, $sekretarisKt, $bendaharaKt])->filter()->pluck('id');
        $activeMembers = $members->reject(fn ($member) => $coreKtIds->contains($member->id));
    @endphp
    <style>
        .kt-structure{max-width:900px;margin:auto}.kt-level{display:flex;justify-content:center;gap:1rem;position:relative}.kt-level--core{margin-top:2.5rem}.kt-level--core:before{content:"";position:absolute;top:-1.25rem;height:1.25rem;border-left:1px solid #aac0ce}.kt-node{width:100%;max-width:235px;background:#fff;border:1px solid var(--rw-line);border-top:3px solid var(--rw-blue);border-radius:6px;padding:1rem;text-align:center}.kt-avatar{width:58px;height:58px;border-radius:50%;object-fit:cover;border:1px solid var(--rw-line);padding:2px}.kt-initial{width:58px;height:58px;margin:auto;display:flex;align-items:center;justify-content:center;border-radius:50%;background:#eef4f7;color:var(--rw-blue);font-weight:700;font-size:1.2rem}.kt-role{font-size:.75rem;text-transform:uppercase;letter-spacing:.05em;font-weight:700;color:var(--rw-green);margin-top:.5rem}.kt-name{font-weight:700;margin:.25rem 0}.kt-members{display:grid;grid-template-columns:repeat(3,1fr);gap:.75rem;margin-top:2rem}@media(max-width:767.98px){.kt-level{flex-direction:column;align-items:center}.kt-level--core{margin-top:1rem}.kt-level--core:before{display:none}.kt-members{grid-template-columns:1fr}}
    </style>
    <div class="mb-5" data-aos="fade-up" data-aos-delay="200">
        <div class="text-center mb-4"><div class="section-kicker">Kepengurusan aktif</div><h2 class="h4 fw-bold mb-1">Struktur Karang Taruna</h2><p class="small text-secondary mb-0">Susunan pengurus dan anggota aktif Karang Taruna RW 012.</p></div>
        @if($members->isNotEmpty())
        <div class="content-panel p-3 p-md-4 kt-structure"><div class="kt-level"><article class="kt-node">@if($ketuaKt?->photo_path)<img src="{{ asset('storage/' . $ketuaKt->photo_path) }}" class="kt-avatar" alt="{{ $ketuaKt->name }}">@else<div class="kt-initial">{{ strtoupper(substr($ketuaKt->name ?? 'K', 0, 1)) }}</div>@endif<div class="kt-role">Ketua Karang Taruna</div><div class="kt-name">{{ $ketuaKt->name ?? 'Belum ditetapkan' }}</div></article></div><div class="kt-level kt-level--core"><article class="kt-node">@if($sekretarisKt?->photo_path)<img src="{{ asset('storage/' . $sekretarisKt->photo_path) }}" class="kt-avatar" alt="{{ $sekretarisKt->name }}">@else<div class="kt-initial">{{ strtoupper(substr($sekretarisKt->name ?? 'S', 0, 1)) }}</div>@endif<div class="kt-role">Sekretaris</div><div class="kt-name">{{ $sekretarisKt->name ?? 'Belum ditetapkan' }}</div></article><article class="kt-node">@if($bendaharaKt?->photo_path)<img src="{{ asset('storage/' . $bendaharaKt->photo_path) }}" class="kt-avatar" alt="{{ $bendaharaKt->name }}">@else<div class="kt-initial">{{ strtoupper(substr($bendaharaKt->name ?? 'B', 0, 1)) }}</div>@endif<div class="kt-role">Bendahara</div><div class="kt-name">{{ $bendaharaKt->name ?? 'Belum ditetapkan' }}</div></article></div>@if($activeMembers->isNotEmpty())<div class="kt-members">@foreach($activeMembers as $member)<article class="kt-node" style="max-width:none;border-top-color:#27835c">@if($member->photo_path)<img src="{{ asset('storage/' . $member->photo_path) }}" class="kt-avatar" alt="{{ $member->name }}">@else<div class="kt-initial">{{ strtoupper(substr($member->name, 0, 1)) }}</div>@endif<div class="kt-role">{{ $member->role ?: 'Anggota aktif' }}</div><div class="kt-name">{{ $member->name }}</div>@if($member->period)<div class="small text-secondary">Periode {{ $member->period }}</div>@endif</article>@endforeach</div>@endif</div>
        @else
        <div class="content-panel p-4 text-center text-secondary">Struktur Karang Taruna belum ditambahkan.</div>
        @endif
    </div>

    {{-- Program Kerja --}}
    <div class="row justify-content-center mb-5" data-aos="fade-up" data-aos-delay="300">
        <div class="col-md-10">
            <div class="card border-0 shadow-sm border-start border-4 border-success">
                <div class="card-body p-5">
                    <h4 class="fw-bold mb-3"><i class="bi bi-clipboard-check text-success me-2"></i>Program Kerja</h4>
                    <div class="text-secondary lh-lg">
                        {!! nl2br(e($profile->programs_text ?? 'Program kerja belum ditambahkan oleh admin.')) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Dokumentasi --}}
    @if($galleries->count() > 0)
    <div class="mb-5" data-aos="fade-up" data-aos-delay="400">
        <h4 class="fw-bold text-center mb-4"><i class="bi bi-camera text-primary me-2"></i>Dokumentasi Kegiatan</h4>
        <div class="row g-3">
            @foreach($galleries as $gallery)
            <div class="col-md-4 col-6">
                <div class="rounded overflow-hidden shadow-sm">
                    <img src="{{ asset('storage/' . $gallery->image_path) }}" class="w-100" alt="{{ $gallery->title }}" style="height: 200px; object-fit: cover;" onerror="this.src='https://placehold.co/300x200/e9ecef/6c757d?text=No+Image'">
                </div>
                <p class="small fw-bold mt-2 text-center">{{ $gallery->title }}</p>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-3">
            <a href="{{ route('galeri') }}" class="btn btn-outline-primary rounded-pill px-4">Lihat Semua Galeri <i class="bi bi-arrow-right ms-1"></i></a>
        </div>
    </div>
    @endif

    {{-- Kontak --}}
    @if($contact)
    <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="500">
        <div class="col-md-6 text-center">
            <div class="card border-0 shadow-sm bg-light">
                <div class="card-body p-5">
                    <h4 class="fw-bold mb-3"><i class="bi bi-telephone-fill text-success me-2"></i>Hubungi Karang Taruna</h4>
                    <p class="text-muted mb-3">Silakan hubungi kami melalui WhatsApp</p>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contact->phone_number) }}" class="btn btn-success btn-lg rounded-pill px-5 shadow-sm" target="_blank">
                        <i class="bi bi-whatsapp me-2"></i> {{ $contact->phone_number }}
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>
@endsection
