@extends('layouts.admin')
@section('content')
<h2 class='fw-bold mb-4'>Tambah Kontak</h2>
<div class='card border-0 shadow-sm'><div class='card-body'>
<form action="{{ route('admin.kontak.store') }}" method='POST'>
@csrf

<div class='mb-3'><label class='form-label'>Name</label><input type='text' class='form-control' name='name' value="{{ old('name') }}" required></div>
<div class='mb-3'><label class='form-label'>Phone number</label><input type='text' class='form-control' name='phone_number' value="{{ old('phone_number') }}" required></div>

<a href="{{ route('admin.kontak.index') }}" class='btn btn-secondary'>Kembali</a> <button type='submit' class='btn btn-primary'>Simpan</button>
</form>
</div></div>
@endsection