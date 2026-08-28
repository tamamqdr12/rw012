@extends('layouts.admin')
@section('content')
<h2 class='fw-bold mb-4'>Tambah Data Warga</h2>
<div class='card border-0 shadow-sm'><div class='card-body'>
<form action="{{ route('admin.data-warga.store') }}" method='POST' enctype='multipart/form-data'>
@csrf

<div class='mb-3'><label class='form-label'>Pilih RT (Opsional/Kosongkan untuk RW)</label><select class='form-select' name='rt_id'><option value=''>-- Untuk Seluruh RW / Tidak Spesifik RT --</option>@foreach($rts as $rt)<option value='{{ $rt->id }}' >{{ $rt->name }}</option>@endforeach</select></div>
<div class='mb-3'><label class='form-label'>Total kk</label><input type='number' class='form-control' name='total_kk' value="{{ old('total_kk') }}" required></div>
<div class='mb-3'><label class='form-label'>Male count</label><input type='number' class='form-control' name='male_count' value="{{ old('male_count') }}" required></div>
<div class='mb-3'><label class='form-label'>Female count</label><input type='number' class='form-control' name='female_count' value="{{ old('female_count') }}" required></div>
<div class='mb-3'><label class='form-label'>Total count</label><input type='number' class='form-control' name='total_count' value="{{ old('total_count') }}" required></div>

<a href="{{ route('admin.data-warga.index') }}" class='btn btn-secondary'>Kembali</a> <button type='submit' class='btn btn-primary'>Simpan</button>
</form>
</div></div>
@endsection