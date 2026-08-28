@extends('layouts.admin')
@section('content')
<h2 class='fw-bold mb-4'>Tambah Aspirasi</h2>
<div class='card border-0 shadow-sm'><div class='card-body'>
<form action="{{ route('admin.aspirasi.store') }}" method='POST'>
@csrf

<div class='mb-3'><label class='form-label'>Sender name</label><input type='text' class='form-control' name='sender_name' value="{{ old('sender_name') }}" required></div>
<div class='mb-3'><label class='form-label'>Status</label><select class='form-select' name='status' required><option value='pending' >Pending</option><option value='resolved' >Resolved</option></select></div>
<div class='mb-3'><label class='form-label'>Message</label><textarea class='form-control' name='message' rows='4' required>{{ old('message') }}</textarea></div>

<a href="{{ route('admin.aspirasi.index') }}" class='btn btn-secondary'>Kembali</a> <button type='submit' class='btn btn-primary'>Simpan</button>
</form>
</div></div>
@endsection