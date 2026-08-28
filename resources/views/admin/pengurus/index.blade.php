@extends('layouts.admin')
@section('content')
<div class='d-flex justify-content-between mb-4'>
    <div><h1 class='h3 fw-bold mb-1'>Kelola pengurus</h1><p class="text-secondary mb-0">Susun anggota dan jabatan pengurus RW, RT, serta Karang Taruna.</p></div>
    <a href="{{ route('admin.pengurus.create') }}" class='btn btn-primary'><i class='bi bi-plus-lg'></i> Tambah Data</a>
</div>
<div class='card border-0 shadow-sm'>
    <div class='card-body'>
        <div class='table-responsive'>
            <table class='table table-bordered table-hover align-middle'>
                <thead class='table-light'>
                    <tr>
                        <th>Nama</th>
<th>Jabatan</th>
<th>Periode</th>
<th>Kontak</th>
<th>Lingkup</th>
<th>Foto</th>
<th>Status</th>

                        <th width='150'>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $item)
                    <tr>
                        <td>{{ Str::limit($item->name, 30) }}</td>
<td>{{ Str::limit($item->role, 30) }}</td>
<td>{{ Str::limit($item->period, 30) }}</td>
<td>{{ Str::limit($item->contact_info, 30) }}</td>
<td>{{ $item->rt ? $item->rt->name : '-' }}</td>
<td>@if($item->photo_path) <img src="{{ asset('storage/'.$item->photo_path) }}" height="50"> @else - @endif</td>
<td>{{ $item->is_active ? 'Aktif' : 'Tidak' }}</td>

                        <td>
                            <a href="{{ route('admin.pengurus.edit', $item->id) }}" class='btn btn-sm btn-warning'><i class='bi bi-pencil'></i></a>
                            <form action="{{ route('admin.pengurus.destroy', $item->id) }}" method='POST' class='d-inline' onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type='submit' class='btn btn-sm btn-danger'><i class='bi bi-trash'></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan='100%' class='text-center'>Data tidak ditemukan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
