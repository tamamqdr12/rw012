@extends('layouts.admin')
@section('content')
<h2 class='fw-bold mb-4'>Edit Kegiatan</h2>
<div class='card border-0 shadow-sm'><div class='card-body'>
<form action="{{ route('admin.kegiatan.update', $item->id) }}" method='POST' enctype='multipart/form-data'>
@csrf
@method('PUT')
<div class='mb-3'><label class='form-label'>Title</label><input type='text' class='form-control' name='title' value="{{ old('title', $item->title) }}" required></div>
<div class='mb-3'><label class='form-label'>Event date</label><input type='date' class='form-control' name='event_date' value="{{ old('event_date', $item->event_date) }}" required></div>
<div class='mb-3'><label class='form-label'>Event time</label><input type='time' class='form-control' name='event_time' value="{{ old('event_time', $item->event_time) }}" required></div>
<div class='mb-3'><label class='form-label'>Location</label><input type='text' class='form-control' name='location' value="{{ old('location', $item->location) }}" required></div>
<div class='mb-3'><label class='form-label'>Organizer</label><input type='text' class='form-control' name='organizer' value="{{ old('organizer', $item->organizer) }}" required></div>
<div class='mb-3'><label class='form-label'>Description</label><textarea class='form-control' name='description' rows='4' required>{{ old('description', $item->description) }}</textarea></div>
<div class='mb-3'><label class='form-label'>Photo path</label><input type='file' class='form-control' name='photo_path'>
@if($item->photo_path) <div class='mt-2'><img src="{{ asset('storage/'.$item->photo_path) }}" height='100'></div> @endif
</div>
<div class='mb-3'><label class='form-label'>Status</label><select class='form-select' name='status' required><option value='Akan Datang' {{ $item->status == 'Akan Datang' ? 'selected' : '' }}>Akan Datang</option><option value='Berlangsung' {{ $item->status == 'Berlangsung' ? 'selected' : '' }}>Berlangsung</option><option value='Selesai' {{ $item->status == 'Selesai' ? 'selected' : '' }}>Selesai</option></select></div>

<a href="{{ route('admin.kegiatan.index') }}" class='btn btn-secondary'>Kembali</a> <button type='submit' class='btn btn-primary'>Simpan</button>
</form>
</div></div>
@endsection