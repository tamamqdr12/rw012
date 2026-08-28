@extends('layouts.admin')
@section('content')
<h2 class='fw-bold mb-4'>Edit Daily Report</h2>
<div class='card border-0 shadow-sm'><div class='card-body'>
<form action="{{ route('admin.daily-report.update', $item->id) }}" method='POST' enctype='multipart/form-data'>
@csrf
@method('PUT')
<div class='mb-3'><label class='form-label'>Title</label><input type='text' class='form-control' name='title' value="{{ old('title', $item->title) }}" required></div>
<div class='mb-3'><label class='form-label'>Date</label><input type='date' class='form-control' name='date' value="{{ old('date', $item->date) }}" required></div>
<div class='mb-3'><label class='form-label'>Kategori</label><select class='form-select' name='category' required><option value=''>Pilih Kategori</option><option value='Kebersihan' {{ $item->category == 'Kebersihan' ? 'selected' : '' }}>Kebersihan</option><option value='Keamanan' {{ $item->category == 'Keamanan' ? 'selected' : '' }}>Keamanan</option><option value='Sosial' {{ $item->category == 'Sosial' ? 'selected' : '' }}>Sosial</option><option value='Lingkungan' {{ $item->category == 'Lingkungan' ? 'selected' : '' }}>Lingkungan</option><option value='Kesehatan' {{ $item->category == 'Kesehatan' ? 'selected' : '' }}>Kesehatan</option><option value='Infrastruktur' {{ $item->category == 'Infrastruktur' ? 'selected' : '' }}>Infrastruktur</option><option value='Kegiatan warga' {{ $item->category == 'Kegiatan warga' ? 'selected' : '' }}>Kegiatan warga</option><option value='Lainnya' {{ $item->category == 'Lainnya' ? 'selected' : '' }}>Lainnya</option></select></div>
<div class='mb-3'><label class='form-label'>Description</label><textarea class='form-control' name='description' rows='4' required>{{ old('description', $item->description) }}</textarea></div>
<div class='mb-3'><label class='form-label'>Writer name</label><input type='text' class='form-control' name='writer_name' value="{{ old('writer_name', $item->writer_name) }}" required></div>
<div class='mb-3'><label class='form-label'>Photo path</label><input type='file' class='form-control' name='photo_path'>
@if($item->photo_path) <div class='mt-2'><img src="{{ asset('storage/'.$item->photo_path) }}" height='100'></div> @endif
</div>
<div class='mb-3 form-check'><input type='checkbox' class='form-check-input' name='is_published' value='1' {{ $item->is_published ? 'checked' : '' }} id='is_published'><label class='form-check-label' for='is_published'>Aktif/Tandai</label></div>

<a href="{{ route('admin.daily-report.index') }}" class='btn btn-secondary'>Kembali</a> <button type='submit' class='btn btn-primary'>Simpan</button>
</form>
</div></div>
@endsection