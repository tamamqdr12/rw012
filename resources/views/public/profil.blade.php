@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10" data-aos="fade-up">
            <div class="text-center mb-4"><div class="section-kicker mb-2">Identitas lingkungan</div><h1 class="section-title mb-0">Profil {{ $profile->name ?? 'RW 012' }}</h1></div>
            
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-body p-5 text-center">
                    <img src="{{ asset('assets/images/rw012.jpeg') }}" alt="Logo RW 012" class="mb-3" style="width:82px;height:82px;object-fit:cover;border:1px solid var(--rw-line);border-radius:50%;padding:4px;">
                    <h3 class="mt-3 fw-bold">{{ $profile->name ?? 'RW 012' }}</h3>
                    <p class="lead text-muted">{{ $profile->village ?? 'Kelurahan Bugel' }}, {{ $profile->district ?? 'Kecamatan Karawaci' }}, {{ $profile->city ?? 'Kota Tangerang' }}</p>
                    
                    <hr class="my-4">
                    
                    <div class="text-start">
                        <h5 class="fw-bold text-primary mb-3">Visi</h5>
                        <p class="fst-italic">"Mewujudkan lingkungan yang aman, tertib, bersih, dan sejahtera." (Placeholder visi - silakan diubah oleh admin)</p>
                        
                        <h5 class="fw-bold text-primary mt-4 mb-3">Misi</h5>
                        <ul class="list-group list-group-flush mb-0">
                            <li class="list-group-item bg-transparent px-0 border-0"><i class="bi bi-check-circle-fill text-success me-2"></i>Meningkatkan kerukunan antar warga.</li>
                            <li class="list-group-item bg-transparent px-0 border-0"><i class="bi bi-check-circle-fill text-success me-2"></i>Mengoptimalkan sistem keamanan lingkungan (Siskamling).</li>
                            <li class="list-group-item bg-transparent px-0 border-0"><i class="bi bi-check-circle-fill text-success me-2"></i>Mendorong kegiatan sosial dan gotong royong.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
