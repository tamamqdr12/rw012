@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center" data-aos="fade-up">
        <div class="col-md-10">
            <h2 class="fw-bold mb-4 text-center border-bottom pb-3">Profil {{ $rt->name }}</h2>
            
            <div class="row mt-4">
                <div class="col-md-5 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4 text-center d-flex flex-column justify-content-center">
                            <i class="bi bi-house-door-fill text-success" style="font-size: 4rem;"></i>
                            <h3 class="fw-bold mt-3">{{ $rt->name }}</h3>
                            <p class="text-muted">RW 012, Kelurahan Bugel</p>
                            
                            @if($contact)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contact->phone_number) }}" class="btn btn-outline-success mt-3 rounded-pill">
                                <i class="bi bi-whatsapp me-2"></i> Hubungi Pengurus
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="col-md-7 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white fw-bold py-3">Statistik Warga</div>
                        <div class="card-body p-4">
                            @if($rt->residentsStatistic)
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    Laki-laki
                                    <span class="badge bg-primary rounded-pill px-3">{{ $rt->residentsStatistic->male_count ?: 0 }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    Perempuan
                                    <span class="badge bg-danger rounded-pill px-3">{{ $rt->residentsStatistic->female_count ?: 0 }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0 fw-bold">
                                    Total Warga
                                    <span class="badge bg-success rounded-pill px-3 fs-6">{{ $rt->residentsStatistic->total_count ?: 0 }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0 fw-bold">
                                    Total KK
                                    <span class="badge bg-primary rounded-pill px-3 fs-6">{{ $rt->residentsStatistic->total_kk ?: 0 }}</span>
                                </li>
                            </ul>
                            @else
                            <div class="alert alert-light border text-center">Data statistik belum diisi.</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-5">
                <h4 class="fw-bold mb-4">Susunan Pengurus {{ $rt->name }}</h4>
                <div class="row g-4">
                    @forelse($rt->organizationalMembers as $member)
                    <div class="col-md-4 text-center">
                        <div class="card border-0 shadow-sm py-4 h-100">
                            @if($member->photo_path)
                            <img src="{{ asset('storage/' . $member->photo_path) }}" class="rounded-circle mx-auto mb-3 object-fit-cover shadow-sm border border-3 border-success" style="width: 80px; height: 80px;" alt="{{ $member->name }}">
                            @else
                            <div class="bg-success text-white rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 80px; height: 80px;">
                                <i class="bi bi-person fs-1"></i>
                            </div>
                            @endif
                            <h6 class="fw-bold mb-1">{{ $member->name ?: 'Belum Diisi' }}</h6>
                            <p class="small text-success fw-bold mb-0">{{ $member->role ?: 'Pengurus' }}</p>
                            @if($member->period)
                            <span class="badge bg-light text-secondary border mt-2" style="font-size: 0.7rem;">Periode {{ $member->period }}</span>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="alert alert-light border text-center">Susunan pengurus belum ditambahkan.</div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
