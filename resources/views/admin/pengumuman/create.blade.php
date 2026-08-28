@extends('layouts.admin')
@section('content')
<h2 class='fw-bold mb-4'>Tambah Pengumuman</h2>
<div class='card border-0 shadow-sm'><div class='card-body'>
<form action="{{ route('admin.pengumuman.store') }}" method='POST' enctype='multipart/form-data'>
@csrf

<div class='mb-3'><label class='form-label'>Title</label><input type='text' class='form-control' name='title' value="{{ old('title') }}" required></div>
<div class='mb-3'><label class='form-label'>Publish date</label><input type='datetime-local' class='form-control' name='publish_date' value="{{ old('publish_date') }}" required></div>
<div class='mb-3'><label class='form-label'>Content</label><textarea class='form-control' name='content' rows='4' required>{{ old('content') }}</textarea></div>
<div class='mb-3'><label class='form-label'>Photo path</label><input type='file' class='form-control' name='photo_path'>
</div>
<div class='mb-3 form-check'><input type='checkbox' class='form-check-input' name='is_pinned' value='1'  id='is_pinned'><label class='form-check-label' for='is_pinned'>Aktif/Tandai</label></div>
<div class='mb-3 form-check'><input type='checkbox' class='form-check-input' name='is_active' value='1'  id='is_active'><label class='form-check-label' for='is_active'>Aktif/Tandai</label></div>

<a href="{{ route('admin.pengumuman.index') }}" class='btn btn-secondary'>Kembali</a> <button type='submit' class='btn btn-primary'>Simpan</button>
</form>
</div></div>
@endsection