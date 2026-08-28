@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center" data-aos="fade-up">
        
        {{-- Header --}}
        <div class="col-md-12 text-center mb-5">
            <h2 class="fw-bold mb-3"><i class="bi bi-chat-right-text text-primary me-2"></i>Layanan Aspirasi & Pengaduan</h2>
            <p class="text-muted lead">Sampaikan saran, keluhan, atau masukan untuk perbaikan lingkungan RW 012.</p>
        </div>

        {{-- Form Aspirasi --}}
        <div class="col-md-5 mb-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white fw-bold py-3 fs-5 border-bottom border-primary border-3">
                    <i class="bi bi-pencil-square text-primary me-2"></i>Buat Laporan Baru
                </div>
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger shadow-sm">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('aspirasi.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Laporan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control bg-light" name="title" value="{{ old('title') }}" required placeholder="Contoh: Lampu Jalan Padam di RT 01">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select bg-light" name="category" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach(['Kebersihan', 'Keamanan', 'Infrastruktur', 'Lingkungan', 'Sosial', 'Pelayanan', 'Lainnya'] as $cat)
                                <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Isi Laporan <span class="text-danger">*</span></label>
                            <textarea class="form-control bg-light" name="message" rows="5" required placeholder="Jelaskan detail pengaduan atau aspirasi Anda...">{{ old('message') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Foto Bukti / Lampiran (Opsional)</label>
                            <input type="file" class="form-control bg-light" name="photo_path" accept="image/*">
                            <small class="text-muted">Maksimal ukuran file 5MB (JPG/PNG).</small>
                        </div>

                        <hr class="my-4">
                        <h6 class="fw-bold text-secondary mb-3"><i class="bi bi-person-badge me-2"></i>Data Pelapor (Opsional)</h6>
                        
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control bg-light" name="sender_name" value="{{ old('sender_name') }}" placeholder="Boleh dikosongkan (Anonim)">
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Nomor HP / Email</label>
                            <input type="text" class="form-control bg-light" name="contact_info" value="{{ old('contact_info') }}" placeholder="Hanya dapat dilihat oleh admin (Privasi Terjamin)">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold shadow-sm">Kirim Laporan <i class="bi bi-send ms-2"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Daftar Aspirasi --}}
        <div class="col-md-7 mb-5">
            <div class="card border-0 shadow-sm bg-transparent">
                <div class="card-header bg-transparent border-0 px-0 fw-bold fs-5 mb-2 d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-list-task text-primary me-2"></i>Daftar Pengaduan Warga</span>
                </div>
                <div class="card-body p-0">
                    <div class="row g-3">
                        @forelse($aspirations as $item)
                        <div class="col-12">
                            <div class="card border-0 shadow-sm border-start border-4 
                                {{ $item->status == 'Selesai' ? 'border-success' : ($item->status == 'Diproses' ? 'border-warning' : 'border-secondary') }}">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="fw-bold mb-1">{{ $item->title }}</h5>
                                        @php
                                            $badgeClass = 'bg-secondary';
                                            if ($item->status == 'Diproses') $badgeClass = 'bg-warning text-dark';
                                            if ($item->status == 'Selesai') $badgeClass = 'bg-success';
                                        @endphp
                                        <span class="badge {{ $badgeClass }} px-3 py-2 ms-2 rounded-pill">{{ $item->status }}</span>
                                    </div>
                                    
                                    <div class="mb-3 small text-muted">
                                        <span class="me-3"><i class="bi bi-tag-fill text-primary me-1"></i> {{ $item->category }}</span>
                                        <span class="me-3"><i class="bi bi-person me-1"></i> {{ $item->sender_name ?: 'Anonim' }}</span>
                                        <span><i class="bi bi-calendar3 me-1"></i> {{ $item->created_at->format('d M Y, H:i') }}</span>
                                    </div>

                                    <p class="card-text text-secondary mb-3">{{ $item->message }}</p>

                                    @if($item->photo_path)
                                    <div class="mb-3">
                                        <a href="{{ asset('storage/' . $item->photo_path) }}" target="_blank" class="btn btn-sm btn-outline-secondary"><i class="bi bi-image me-1"></i> Lihat Bukti Foto</a>
                                    </div>
                                    @endif

                                    @if($item->response)
                                    <div class="p-3 bg-light rounded mt-3 border-start border-3 border-primary">
                                        <p class="small fw-bold text-primary mb-1"><i class="bi bi-reply-fill me-1"></i> Tanggapan Pengurus RW:</p>
                                        <p class="small text-dark mb-0">{{ $item->response }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <div class="alert alert-light border text-center p-5">
                                <i class="bi bi-inbox fs-1 text-muted mb-3 d-block"></i>
                                Belum ada laporan aspirasi yang masuk.
                            </div>
                        </div>
                        @endforelse
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $aspirations->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
