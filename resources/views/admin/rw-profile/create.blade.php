@extends('layouts.admin')
@section('content')
<h2 class='fw-bold mb-4'>Tambah Profil RW</h2>
<div class='card border-0 shadow-sm'><div class='card-body'>
<form action="{{ route('admin.rw-profile.store') }}" method='POST'>
@csrf

<div class='mb-3'><label class='form-label'>Name</label><input type='text' class='form-control' name='name' value="{{ old('name') }}" required></div>
<div class='mb-3'><label class='form-label'>Village</label><input type='text' class='form-control' name='village' value="{{ old('village') }}" required></div>
<div class='mb-3'><label class='form-label'>District</label><input type='text' class='form-control' name='district' value="{{ old('district') }}" required></div>
<div class='mb-3'><label class='form-label'>City</label><input type='text' class='form-control' name='city' value="{{ old('city') }}" required></div>

<a href="{{ route('admin.rw-profile.index') }}" class='btn btn-secondary'>Kembali</a> <button type='submit' class='btn btn-primary'>Simpan</button>
</form>
</div></div>
@endsection