@extends('layouts.admin')
@section('content')
<h2 class='fw-bold mb-4'>Tambah Peta Lokasi</h2>
<div class='card border-0 shadow-sm'><div class='card-body'>
<form action="{{ route('admin.map-location.store') }}" method='POST'>
@csrf

<div class='mb-3'><label class='form-label'>Name</label><input type='text' class='form-control' name='name' value="{{ old('name') }}" required></div>
<div class='mb-3'><label class='form-label'>Kategori Lokasi</label><select class='form-select' name='type' required><option value=''>Pilih Kategori</option><option value='Sekretariat RW' >Sekretariat RW</option><option value='RT 001' >RT 001</option><option value='RT 002' >RT 002</option><option value='RT 003' >RT 003</option><option value='Posyandu' >Posyandu</option><option value='Masjid/Musala' >Masjid/Musala</option><option value='Sekolah' >Sekolah</option><option value='Fasilitas umum' >Fasilitas umum</option><option value='Pos keamanan' >Pos keamanan</option><option value='UMKM' >UMKM</option><option value='Lokasi penting lainnya' >Lokasi penting lainnya</option></select></div>
<div class='mb-3'><label class='form-label'>Latitude</label><input type='text' class='form-control' name='latitude' value="{{ old('latitude') }}" placeholder="Boleh dikosongkan jika belum tahu, misal: -6.1852"><div class="form-text">Gunakan koordinat di kawasan Kelurahan Bugel.</div></div>
<div class='mb-3'><label class='form-label'>Longitude</label><input type='text' class='form-control' name='longitude' value="{{ old('longitude') }}" placeholder="Boleh dikosongkan jika belum tahu, misal: 106.6111"></div>
<div class='mb-3'><label class='form-label'>Description</label><textarea class='form-control' name='description' rows='4' required>{{ old('description') }}</textarea></div>

<a href="{{ route('admin.map-location.index') }}" class='btn btn-secondary'>Kembali</a> <button type='submit' class='btn btn-primary'>Simpan</button>
</form>
</div></div>
@endsection
