@extends('layouts.app')

@section('content')
<div class="container py-5 text-center" style="min-height: 60vh; display: flex; flex-direction: column; justify-content: center;">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="display-1 fw-bold text-primary">404</h1>
            <h3 class="fw-bold mb-3">Halaman Tidak Ditemukan</h3>
            <p class="text-muted mb-4">Maaf, halaman yang Anda cari tidak tersedia, telah dipindahkan, atau Anda salah memasukkan URL.</p>
            <a href="{{ route('home') }}" class="btn btn-primary rounded-pill px-4"><i class="bi bi-house-door me-2"></i>Kembali ke Beranda</a>
        </div>
    </div>
</div>
@endsection
