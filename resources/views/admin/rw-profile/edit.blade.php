@extends('layouts.admin')
@section('content')
<h2 class='fw-bold mb-4'>Edit Profil RW</h2>
<div class='card border-0 shadow-sm'><div class='card-body'>
<form action="{{ route('admin.rw-profile.update', $item->id) }}" method='POST'>
@csrf
@method('PUT')
<div class='mb-3'><label class='form-label'>Name</label><input type='text' class='form-control' name='name' value="{{ old('name', $item->name) }}" required></div>
<div class='mb-3'><label class='form-label'>Village</label><input type='text' class='form-control' name='village' value="{{ old('village', $item->village) }}" required></div>
<div class='mb-3'><label class='form-label'>District</label><input type='text' class='form-control' name='district' value="{{ old('district', $item->district) }}" required></div>
<div class='mb-3'><label class='form-label'>City</label><input type='text' class='form-control' name='city' value="{{ old('city', $item->city) }}" required></div>

<a href="{{ route('admin.rw-profile.index') }}" class='btn btn-secondary'>Kembali</a> <button type='submit' class='btn btn-primary'>Simpan</button>
</form>
</div></div>
@endsection