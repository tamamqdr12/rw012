@extends('layouts.admin')
@section('content')
<h2 class="fw-bold mb-4">Tindak Lanjut Aspirasi Warga</h2>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-bold py-3">Detail Laporan Warga</div>
            <div class="card-body">
                <table class="table table-borderless table-sm">
                    <tr><th width="130" class="text-muted">Tanggal Masuk</th><td>: {{ $item->created_at->format('d M Y H:i') }}</td></tr>
                    <tr><th class="text-muted">Status Saat Ini</th><td>: <span class="badge bg-primary">{{ $item->status }}</span></td></tr>
                    <tr><th class="text-muted">Nama Pelapor</th><td>: {{ $item->sender_name ?: 'Anonim' }}</td></tr>
                    <tr><th class="text-muted">Kontak</th><td>: {{ $item->contact_info ?: '-' }}</td></tr>
                    <tr><th class="text-muted">Kategori</th><td>: {{ $item->category }}</td></tr>
                    <tr><th class="text-muted">Judul Laporan</th><td>: <strong>{{ $item->title }}</strong></td></tr>
                </table>
                <hr>
                <p class="fw-bold text-muted mb-1">Isi Laporan:</p>
                <div class="p-3 bg-light rounded text-dark mb-3" style="white-space: pre-wrap;">{{ $item->message }}</div>
                
                @if($item->photo_path)
                <p class="fw-bold text-muted mb-1">Lampiran Foto:</p>
                <img src="{{ asset('storage/' . $item->photo_path) }}" class="img-fluid rounded shadow-sm">
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100 border-start border-4 border-info">
            <div class="card-header bg-white fw-bold py-3 text-info"><i class="bi bi-reply-fill me-2"></i>Berikan Tanggapan & Status</div>
            <div class="card-body">
                <form action="{{ route('admin.aspirasi.update', $item->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Ubah Status Laporan</label>
                        <select class="form-select" name="status" required>
                            <option value="Baru" {{ $item->status == 'Baru' ? 'selected' : '' }}>Baru</option>
                            <option value="Diproses" {{ $item->status == 'Diproses' ? 'selected' : '' }}>Diproses (Sedang Ditangani)</option>
                            <option value="Selesai" {{ $item->status == 'Selesai' ? 'selected' : '' }}>Selesai (Sudah Terselesaikan)</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Tanggapan Pengurus RW (Opsional)</label>
                        <textarea class="form-control" name="response" rows="6" placeholder="Tulis tanggapan atau solusi untuk laporan ini. Tanggapan ini akan bisa dibaca oleh warga di halaman publik.">{{ old('response', $item->response) }}</textarea>
                    </div>

                    <a href="{{ route('admin.aspirasi.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan & Perbarui</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection