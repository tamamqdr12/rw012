@extends('layouts.admin')
@section('content')
<h2 class='fw-bold mb-4'>Tambah Kegiatan</h2>
<div class='card border-0 shadow-sm'><div class='card-body'>
<form action="{{ route('admin.kegiatan.store') }}" method='POST' enctype='multipart/form-data'>
@csrf

<div class='mb-3'><label class='form-label'>Title</label><input type='text' class='form-control' name='title' value="{{ old('title') }}" required></div>
<div class='mb-3'><label class='form-label'>Event date</label><input type='date' class='form-control' name='event_date' value="{{ old('event_date') }}" required></div>
<div class='mb-3'><label class='form-label'>Event time</label><input type='time' class='form-control' name='event_time' value="{{ old('event_time') }}" required></div>
<div class='mb-3'><label class='form-label'>Location</label><input type='text' class='form-control' name='location' value="{{ old('location') }}" required></div>
<div class='mb-3'><label class='form-label'>Organizer</label><input type='text' class='form-control' name='organizer' value="{{ old('organizer') }}" required></div>
<div class='mb-3'><label class='form-label'>Description</label><textarea class='form-control' name='description' rows='4' required>{{ old('description') }}</textarea></div>
<div class='mb-3'><label class='form-label'>Photo path</label><input type='file' class='form-control' name='photo_path'>
</div>
<div class='mb-3'><label class='form-label'>Status</label><select class='form-select' name='status' required><option value='Akan Datang' >Akan Datang</option><option value='Berlangsung' >Berlangsung</option><option value='Selesai' >Selesai</option></select></div>

<a href="{{ route('admin.kegiatan.index') }}" class='btn btn-secondary'>Kembali</a> <button type='submit' class='btn btn-primary'>Simpan</button>
</form>
</div></div>
@endsection