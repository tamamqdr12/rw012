@extends('layouts.admin')
@section('content')
<h2 class="fw-bold mb-4">Kelola Karang Taruna</h2>

<div class="row g-4">
    {{-- Profile & Program Kerja --}}
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold fs-5 py-3">
                <i class="bi bi-pencil-square text-primary me-2"></i>Profil & Program Kerja
            </div>
            <div class="card-body">
                <form action="{{ route('admin.karang-taruna.update-profile') }}" method="POST">
                    @csrf
                    @method('PUT')

                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label fw-bold">Profil / Tentang Karang Taruna</label>
                        <textarea class="form-control" name="profile_text" rows="5" required>{{ old('profile_text', $profile->profile_text ?? '') }}</textarea>
                        <div class="form-text">Jelaskan visi, misi, dan sejarah singkat Karang Taruna RW 012.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Program Kerja</label>
                        <textarea class="form-control" name="programs_text" rows="6" required>{{ old('programs_text', $profile->programs_text ?? '') }}</textarea>
                        <div class="form-text">Tulis program kerja, satu per baris. Contoh: "1. Kegiatan Kepemudaan"</div>
                    </div>

                    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i> Simpan Profil</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Info Sidebar --}}
    <div class="col-md-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white fw-bold py-3">
                <i class="bi bi-telephone text-success me-2"></i>Kontak Karang Taruna
            </div>
            <div class="card-body">
                @if($contact)
                <p class="mb-1"><strong>{{ $contact->name }}</strong></p>
                <p class="text-muted mb-0">{{ $contact->phone_number }}</p>
                <a href="{{ route('admin.kontak.edit', $contact->id) }}" class="btn btn-sm btn-outline-success mt-2"><i class="bi bi-pencil"></i> Edit Kontak</a>
                @else
                <p class="text-muted">Belum ada data kontak Karang Taruna.</p>
                <a href="{{ route('admin.kontak.create') }}" class="btn btn-sm btn-success">Tambah Kontak</a>
                @endif
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold py-3">
                <i class="bi bi-people text-primary me-2"></i>Pengurus Karang Taruna
            </div>
            <div class="card-body">
                @forelse($members as $member)
                <div class="d-flex align-items-center mb-3">
                    @if($member->photo_path)
                    <img src="{{ asset('storage/' . $member->photo_path) }}" class="rounded-circle me-2" style="width: 40px; height: 40px; object-fit: cover;">
                    @else
                    <div class="bg-primary text-white rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; min-width: 40px;">
                        <i class="bi bi-person"></i>
                    </div>
                    @endif
                    <div>
                        <strong>{{ $member->name ?: 'Belum Diatur' }}</strong>
                        <div class="text-muted small">{{ $member->role }}</div>
                    </div>
                </div>
                @empty
                <p class="text-muted small">Belum ada pengurus. Tambahkan melalui menu <a href="{{ route('admin.pengurus.create') }}">Pengurus</a> dengan mencentang opsi "Karang Taruna".</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    <div class="alert alert-info">
        <i class="bi bi-info-circle me-2"></i>
        <strong>Tips:</strong> Untuk mengelola pengurus Karang Taruna, buka menu <a href="{{ route('admin.pengurus.index') }}" class="alert-link">Pengurus</a> lalu centang opsi "Karang Taruna" saat menambah/edit pengurus. Untuk mengelola kegiatan dan dokumentasi, gunakan menu <a href="{{ route('admin.kegiatan.index') }}" class="alert-link">Kegiatan</a> dan <a href="{{ route('admin.galeri.index') }}" class="alert-link">Galeri</a>.
    </div>
</div>
@endsection
