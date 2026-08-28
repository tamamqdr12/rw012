@extends('layouts.admin')
@section('content')
<div class="d-flex justify-content-between mb-4">
    <h2 class="fw-bold">Kelola Galeri</h2>
    <a href="{{ route('admin.galeri.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Upload Foto</a>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="80">Foto</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Tanggal</th>
                        <th>Deskripsi</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $item)
                    <tr>
                        <td>
                            @if($item->image_path)
                            <img src="{{ asset('storage/' . $item->image_path) }}" height="50" class="rounded">
                            @else - @endif
                        </td>
                        <td>{{ $item->title }}</td>
                        <td><span class="badge bg-primary">{{ $item->category }}</span></td>
                        <td>{{ $item->date ? $item->date->format('d M Y') : '-' }}</td>
                        <td>{{ Str::limit($item->description, 40) }}</td>
                        <td>
                            <a href="{{ route('admin.galeri.edit', $item->id) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.galeri.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus foto ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center">Belum ada foto di galeri</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection