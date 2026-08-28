@extends('layouts.admin')
@section('content')
<div class="d-flex justify-content-between mb-4">
    <h2 class="fw-bold">Kelola Aspirasi & Pengaduan Warga</h2>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Pelapor</th>
                        <th>Kategori</th>
                        <th>Judul & Isi</th>
                        <th>Status</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $item)
                    <tr>
                        <td><small>{{ $item->created_at->format('d M Y H:i') }}</small></td>
                        <td>
                            <strong>{{ $item->sender_name ?: 'Anonim' }}</strong><br>
                            <small class="text-muted">{{ $item->contact_info ?: 'Tidak ada kontak' }}</small>
                        </td>
                        <td><span class="badge bg-primary">{{ $item->category }}</span></td>
                        <td>
                            <strong>{{ $item->title }}</strong><br>
                            <small>{{ Str::limit($item->message, 50) }}</small>
                            @if($item->photo_path)
                            <div class="mt-1"><a href="{{ asset('storage/' . $item->photo_path) }}" target="_blank" class="badge bg-secondary text-decoration-none"><i class="bi bi-image"></i> Lampiran</a></div>
                            @endif
                        </td>
                        <td>
                            @php
                                $badge = 'bg-secondary';
                                if($item->status == 'Diproses') $badge = 'bg-warning text-dark';
                                if($item->status == 'Selesai') $badge = 'bg-success';
                            @endphp
                            <span class="badge {{ $badge }}">{{ $item->status }}</span>
                        </td>
                        <td>
                            <a href="{{ route('admin.aspirasi.edit', $item->id) }}" class="btn btn-sm btn-info text-white" title="Tanggapi/Ubah Status"><i class="bi bi-reply-fill"></i> Proses</a>
                            <form action="{{ route('admin.aspirasi.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center">Belum ada aspirasi masuk</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection