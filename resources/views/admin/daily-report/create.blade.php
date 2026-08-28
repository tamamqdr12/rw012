@extends('layouts.admin')
@section('content')
<h2 class='fw-bold mb-4'>Tambah Daily Report</h2>
<div class='card border-0 shadow-sm'><div class='card-body'>
<form action="{{ route('admin.daily-report.store') }}" method='POST' enctype='multipart/form-data'>
@csrf

<div class='mb-3'><label class='form-label'>Title</label><input type='text' class='form-control' name='title' value="{{ old('title') }}" required></div>
<div class='mb-3'><label class='form-label'>Date</label><input type='date' class='form-control' name='date' value="{{ old('date') }}" required></div>
<div class='mb-3'><label class='form-label'>Kategori</label><select class='form-select' name='category' required><option value=''>Pilih Kategori</option><option value='Kebersihan' >Kebersihan</option><option value='Keamanan' >Keamanan</option><option value='Sosial' >Sosial</option><option value='Lingkungan' >Lingkungan</option><option value='Kesehatan' >Kesehatan</option><option value='Infrastruktur' >Infrastruktur</option><option value='Kegiatan warga' >Kegiatan warga</option><option value='Lainnya' >Lainnya</option></select></div>
<div class='mb-3'><label class='form-label'>Description</label><textarea class='form-control' name='description' rows='4' required>{{ old('description') }}</textarea></div>
<div class='mb-3'><label class='form-label'>Writer name</label><input type='text' class='form-control' name='writer_name' value="{{ old('writer_name') }}" required></div>
<div class='mb-3'><label class='form-label'>Photo path</label><input type='file' class='form-control' name='photo_path'>
</div>
<div class='mb-3 form-check'><input type='checkbox' class='form-check-input' name='is_published' value='1'  id='is_published'><label class='form-check-label' for='is_published'>Aktif/Tandai</label></div>

<a href="{{ route('admin.daily-report.index') }}" class='btn btn-secondary'>Kembali</a> <button type='submit' class='btn btn-primary'>Simpan</button>
</form>
</div></div>
@endsection