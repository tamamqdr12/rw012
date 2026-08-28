@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center" data-aos="fade-up">
        <div class="col-md-10">
            <h2 class="fw-bold mb-4 text-center border-bottom pb-3"><i class="bi bi-bar-chart-fill text-success me-2"></i>Data Statistik Warga</h2>
            
            <div class="row g-4 mt-3">
                @php 
                    $totalSemua = 0; 
                    $totalKK = 0;
                @endphp
                @forelse($statistics as $stat)
                @php 
                    $totalSemua += $stat->total_count; 
                    $totalKK += $stat->total_kk;
                @endphp
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-primary text-white text-center py-3 fw-bold">
                            {{ $stat->rt->name }}
                        </div>
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted"><i class="bi bi-gender-male text-primary me-1"></i> Laki-laki</span>
                                <span class="fw-bold">{{ $stat->male_count ?: 0 }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted"><i class="bi bi-gender-female text-danger me-1"></i> Perempuan</span>
                                <span class="fw-bold">{{ $stat->female_count ?: 0 }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="fw-bold text-dark">Total Warga</span>
                                <span class="fw-bold text-success fs-5">{{ $stat->total_count ?: 0 }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="fw-bold text-dark">Total KK</span>
                                <span class="fw-bold text-primary fs-5">{{ $stat->total_kk ?: 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-light text-center border p-5">Data statistik warga belum tersedia.</div>
                </div>
                @endforelse
            </div>

            @if($statistics->count() > 0)
            <div class="row mt-5">
                <div class="col-md-6 mb-3">
                    <div class="card border-0 shadow-sm bg-light">
                        <div class="card-body text-center p-4">
                            <h4 class="text-secondary mb-1">Total Warga RW 012</h4>
                            <h1 class="display-4 fw-bold text-primary">{{ $totalSemua }} <span class="fs-4 text-muted fw-normal">Jiwa</span></h1>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card border-0 shadow-sm bg-light">
                        <div class="card-body text-center p-4">
                            <h4 class="text-secondary mb-1">Total Kepala Keluarga</h4>
                            <h1 class="display-4 fw-bold text-success">{{ $totalKK }} <span class="fs-4 text-muted fw-normal">KK</span></h1>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
