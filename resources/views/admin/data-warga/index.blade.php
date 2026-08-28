@extends('layouts.admin')
@section('content')
<div class='d-flex justify-content-between mb-4'>
    <h2 class='fw-bold'>Kelola Data Warga</h2>
    <a href="{{ route('admin.data-warga.create') }}" class='btn btn-primary'><i class='bi bi-plus-lg'></i> Tambah Data</a>
</div>
<div class='card border-0 shadow-sm'>
    <div class='card-body'>
        <div class='table-responsive'>
            <table class='table table-bordered table-hover align-middle'>
                <thead class='table-light'>
                    <tr>
                        <th>Rt id</th>
<th>Total kk</th>
<th>Male count</th>
<th>Female count</th>
<th>Total count</th>

                        <th width='150'>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $item)
                    <tr>
                        <td>{{ $item->rt ? $item->rt->name : '-' }}</td>
<td>{{ Str::limit($item->total_kk, 30) }}</td>
<td>{{ Str::limit($item->male_count, 30) }}</td>
<td>{{ Str::limit($item->female_count, 30) }}</td>
<td>{{ Str::limit($item->total_count, 30) }}</td>

                        <td>
                            <a href="{{ route('admin.data-warga.edit', $item->id) }}" class='btn btn-sm btn-warning'><i class='bi bi-pencil'></i></a>
                            <form action="{{ route('admin.data-warga.destroy', $item->id) }}" method='POST' class='d-inline' onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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