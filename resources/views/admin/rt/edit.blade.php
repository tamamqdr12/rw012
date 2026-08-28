@extends('layouts.admin')
@section('content')
<h2 class='fw-bold mb-4'>Edit Data RT</h2>
<div class='card border-0 shadow-sm'><div class='card-body'>
<form action="{{ route('admin.rt.update', $item->id) }}" method='POST'>
@csrf
@method('PUT')
<div class='mb-3'><label class='form-label'>Name</label><input type='text' class='form-control' name='name' value="{{ old('name', $item->name) }}" required></div>

<a href="{{ route('admin.rt.index') }}" class='btn btn-secondary'>Kembali</a> <button type='submit' class='btn btn-primary'>Simpan</button>
</form>
</div></div>
@endsection