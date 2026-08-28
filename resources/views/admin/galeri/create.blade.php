@extends('layouts.admin')
@section('content')
<h2 class="fw-bold mb-4">Upload Foto Galeri</h2>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
            @endif

            <div class="mb-3">
                <label class="form-label fw-bold">Judul Foto <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="title" value="{{ old('title') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Kategori <span class="text-danger">*</span></label>
                <select class="form-select" name="category" required>
                    <option value="">Pilih Kategori</option>
                    @foreach(['Kegiatan RW','Kegiatan RT','Kerja Bakti','Sosial','Keagamaan','Kepemudaan','Lainnya'] as $cat)
                    <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Tanggal</label>
                <input type="date" class="form-control" name="date" value="{{ old('date') }}">
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Deskripsi</label>
                <textarea class="form-control" name="description" rows="3">{{ old('description') }}</textarea>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">File Gambar <span class="text-danger">*</span></label>
                <input type="file" class="form-control" name="image_path" accept="image/*" required>
                <div class="form-text">Format: JPG, PNG, WEBP. Maksimal 5MB.</div>
            </div>

            <a href="{{ route('admin.galeri.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
    </div>
</div>
@endsection