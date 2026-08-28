@extends('layouts.admin')
@section('content')
<div class='d-flex justify-content-between mb-4'>
    <h2 class='fw-bold'>Kelola Daily Report</h2>
    <a href="{{ route('admin.daily-report.create') }}" class='btn btn-primary'><i class='bi bi-plus-lg'></i> Tambah Data</a>
</div>
<div class='card border-0 shadow-sm'>
    <div class='card-body'>
        <div class='table-responsive'>
            <table class='table table-bordered table-hover align-middle'>
                <thead class='table-light'>
                    <tr>
                        <th>Title</th>
<th>Date</th>
<th>Category</th>
<th>Writer name</th>
<th>Photo path</th>
<th>Is published</th>

                        <th width='150'>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $item)
                    <tr>
                        <td>{{ Str::limit($item->title, 30) }}</td>
<td>{{ Str::limit($item->date, 30) }}</td>
<td>{{ Str::limit($item->category, 30) }}</td>
<td>{{ Str::limit($item->writer_name, 30) }}</td>
<td>@if($item->photo_path) <img src="{{ asset('storage/'.$item->photo_path) }}" height="50"> @else - @endif</td>
<td>{{ $item->is_published ? 'Ya' : 'Tidak' }}</td>

                        <td>
                            <a href="{{ route('admin.daily-report.edit', $item->id) }}" class='btn btn-sm btn-warning'><i class='bi bi-pencil'></i></a>
                            <form action="{{ route('admin.daily-report.destroy', $item->id) }}" method='POST' class='d-inline' onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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