@extends('layouts.admin')

@section('content')
<div class='d-flex justify-content-between mb-4'>
    <h2 class='fw-bold'>Kelola Kontak</h2>
    <a href="{{ route('admin.kontak.create') }}" class='btn btn-primary'><i class='bi bi-plus-lg'></i> Tambah Data</a>
</div>
<div class='card border-0 shadow-sm'>
    <div class='card-body'>
        <div class='table-responsive'>
            <table class='table table-bordered table-hover align-middle'>
                <thead class='table-light'>
                    <tr>
                        <th>Name</th>
<th>Phone number</th>

                        <th width='150'>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $item)
                    <tr>
                        <td>{{ Str::limit($item->name, 50) }}</td>
<td>{{ Str::limit($item->phone_number, 50) }}</td>

                        <td>
                            <a href="{{ route('admin.kontak.edit', $item->id) }}" class='btn btn-sm btn-warning'><i class='bi bi-pencil'></i></a>
                            <form action="{{ route('admin.kontak.destroy', $item->id) }}" method='POST' class='d-inline' onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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