@extends('layouts.admin')
@section('content')
<div class="mb-4"><h1 class='h3 fw-bold mb-1'>Tambah pengurus</h1><p class="text-secondary mb-0">Lengkapi nama dan jabatan. Foto dapat diunggah bila tersedia.</p></div>
<div class='card border-0 shadow-sm'><div class='card-body'>
<form action="{{ route('admin.pengurus.store') }}" method='POST' enctype='multipart/form-data'>
@csrf

<div class='mb-3'><label class='form-label'>Nama anggota <span class="text-danger">*</span></label><input type='text' class='form-control' name='name' value="{{ old('name') }}" required></div>
<div class='mb-3'><label class='form-label'>Jabatan <span class="text-danger">*</span></label><input type='text' class='form-control' name='role' value="{{ old('role') }}" placeholder="Contoh: Ketua RW, Sekretaris, Bendahara" required></div>
<div class='mb-3'><label class='form-label'>Periode kepengurusan</label><input type='text' class='form-control' name='period' value="{{ old('period') }}" placeholder="Contoh: 2026–2031"></div>
<div class='mb-3'><label class='form-label'>Kontak (opsional)</label><input type='text' class='form-control' name='contact_info' value="{{ old('contact_info') }}" ></div>
<div class='mb-3'><label class='form-label'>Pilih RT (Opsional/Kosongkan untuk RW)</label><select class='form-select' name='rt_id'><option value=''>-- Untuk Seluruh RW / Tidak Spesifik RT --</option>@foreach($rts as $rt)<option value='{{ $rt->id }}' >{{ $rt->name }}</option>@endforeach</select></div>
<div class='mb-3'><label class='form-label'>Foto anggota <span class="text-secondary fw-normal">(opsional)</span></label><input type='file' class='form-control' name='photo_path' accept="image/*"><div class="form-text">Format gambar, maksimal 2 MB. Jika dikosongkan, sistem memakai ikon profil.</div>
</div>
<div class='mb-3 form-check'><input type='checkbox' class='form-check-input' name='is_karang_taruna' value='1' id='is_karang_taruna'><label class='form-check-label' for='is_karang_taruna'>Pengurus Karang Taruna</label></div>
<div class='mb-3 form-check'><input type='checkbox' class='form-check-input' name='is_active' value='1' checked id='is_active'><label class='form-check-label' for='is_active'>Aktif/Publish</label></div>

<a href="{{ route('admin.pengurus.index') }}" class='btn btn-secondary'>Kembali</a> <button type='submit' class='btn btn-primary'>Simpan</button>
</form>
</div></div>
@endsection
