@extends('layouts.admin')
@section('content')
<div class="mb-4"><h1 class='h3 fw-bold mb-1'>Edit pengurus</h1><p class="text-secondary mb-0">Perbarui data anggota dan jabatannya sesuai struktur kepengurusan.</p></div>
<div class='card border-0 shadow-sm'><div class='card-body'>
<form action="{{ route('admin.pengurus.update', $item->id) }}" method='POST' enctype='multipart/form-data'>
@csrf
@method('PUT')
<div class='mb-3'><label class='form-label'>Nama anggota <span class="text-danger">*</span></label><input type='text' class='form-control' name='name' value="{{ old('name', $item->name) }}" required></div>
<div class='mb-3'><label class='form-label'>Jabatan <span class="text-danger">*</span></label><input type='text' class='form-control' name='role' value="{{ old('role', $item->role) }}" required></div>
<div class='mb-3'><label class='form-label'>Periode kepengurusan</label><input type='text' class='form-control' name='period' value="{{ old('period', $item->period) }}" ></div>
<div class='mb-3'><label class='form-label'>Kontak (opsional)</label><input type='text' class='form-control' name='contact_info' value="{{ old('contact_info', $item->contact_info) }}" ></div>
<div class='mb-3'><label class='form-label'>Pilih RT (Opsional/Kosongkan untuk RW)</label><select class='form-select' name='rt_id'><option value=''>-- Untuk Seluruh RW / Tidak Spesifik RT --</option>@foreach($rts as $rt)<option value='{{ $rt->id }}' {{ $item->rt_id == $rt->id ? 'selected' : '' }}>{{ $rt->name }}</option>@endforeach</select></div>
<div class='mb-3'><label class='form-label'>Ganti foto <span class="text-secondary fw-normal">(opsional)</span></label><input type='file' class='form-control' name='photo_path' accept="image/*"><div class="form-text">Kosongkan untuk mempertahankan foto saat ini.</div>
@if($item->photo_path) <div class='mt-2'><img src="{{ asset('storage/'.$item->photo_path) }}" height='100'></div> @endif
</div>
<div class='mb-3 form-check'><input type='checkbox' class='form-check-input' name='is_karang_taruna' value='1' {{ $item->is_karang_taruna ? 'checked' : '' }} id='is_karang_taruna'><label class='form-check-label' for='is_karang_taruna'>Pengurus Karang Taruna</label></div>
<div class='mb-3 form-check'><input type='checkbox' class='form-check-input' name='is_active' value='1' {{ $item->is_active ? 'checked' : '' }} id='is_active'><label class='form-check-label' for='is_active'>Aktif/Publish</label></div>

<a href="{{ route('admin.pengurus.index') }}" class='btn btn-secondary'>Kembali</a> <button type='submit' class='btn btn-primary'>Simpan</button>
</form>
</div></div>
@endsection
