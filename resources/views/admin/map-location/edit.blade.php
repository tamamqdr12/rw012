@extends('layouts.admin')
@section('content')
<h2 class='fw-bold mb-4'>Edit Peta Lokasi</h2>
<div class='card border-0 shadow-sm'><div class='card-body'>
<form action="{{ route('admin.map-location.update', $item->id) }}" method='POST'>
@csrf
@method('PUT')
<div class='mb-3'><label class='form-label'>Name</label><input type='text' class='form-control' name='name' value="{{ old('name', $item->name) }}" required></div>
<div class='mb-3'><label class='form-label'>Kategori Lokasi</label><select class='form-select' name='type' required><option value=''>Pilih Kategori</option><option value='Sekretariat RW' {{ $item->type == 'Sekretariat RW' ? 'selected' : '' }}>Sekretariat RW</option><option value='RT 001' {{ $item->type == 'RT 001' ? 'selected' : '' }}>RT 001</option><option value='RT 002' {{ $item->type == 'RT 002' ? 'selected' : '' }}>RT 002</option><option value='RT 003' {{ $item->type == 'RT 003' ? 'selected' : '' }}>RT 003</option><option value='Posyandu' {{ $item->type == 'Posyandu' ? 'selected' : '' }}>Posyandu</option><option value='Masjid/Musala' {{ $item->type == 'Masjid/Musala' ? 'selected' : '' }}>Masjid/Musala</option><option value='Sekolah' {{ $item->type == 'Sekolah' ? 'selected' : '' }}>Sekolah</option><option value='Fasilitas umum' {{ $item->type == 'Fasilitas umum' ? 'selected' : '' }}>Fasilitas umum</option><option value='Pos keamanan' {{ $item->type == 'Pos keamanan' ? 'selected' : '' }}>Pos keamanan</option><option value='UMKM' {{ $item->type == 'UMKM' ? 'selected' : '' }}>UMKM</option><option value='Lokasi penting lainnya' {{ $item->type == 'Lokasi penting lainnya' ? 'selected' : '' }}>Lokasi penting lainnya</option></select></div>
<div class='mb-3'><label class='form-label'>Latitude</label><input type='text' class='form-control' name='latitude' value="{{ old('latitude', $item->latitude) }}" placeholder="Boleh dikosongkan jika belum tahu, misal: -6.1852"><div class="form-text">Marker publik hanya ditampilkan di kawasan Kelurahan Bugel.</div></div>
<div class='mb-3'><label class='form-label'>Longitude</label><input type='text' class='form-control' name='longitude' value="{{ old('longitude', $item->longitude) }}" placeholder="Boleh dikosongkan jika belum tahu, misal: 106.6111"></div>
<div class='mb-3'><label class='form-label'>Description</label><textarea class='form-control' name='description' rows='4' required>{{ old('description', $item->description) }}</textarea></div>

<a href="{{ route('admin.map-location.index') }}" class='btn btn-secondary'>Kembali</a> <button type='submit' class='btn btn-primary'>Simpan</button>
</form>
</div></div>
@endsection
