@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center" data-aos="fade-up">
        <div class="col-md-10">
            <h2 class="fw-bold mb-4 text-center border-bottom pb-3"><i class="bi bi-journal-text text-primary me-2"></i>Daily Report Lingkungan</h2>
            
            <div class="mt-5 timeline-container position-relative">
                <div class="position-absolute h-100 bg-primary" style="width: 3px; left: 20px; top: 0; opacity: 0.2;"></div>
                
                @forelse($reports as $report)
                <div class="position-relative mb-5" style="padding-left: 50px;">
                    <div class="position-absolute bg-primary rounded-circle" style="width: 15px; height: 15px; left: 14px; top: 20px;"></div>
                    
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h4 class="card-title fw-bold text-primary mb-0">{{ $report->title }}</h4>
                                <span class="badge bg-light text-secondary border"><i class="bi bi-calendar3 me-1"></i>{{ \Carbon\Carbon::parse($report->date)->format('d M Y') }}</span>
                            </div>
                            
                            <div class="mb-3">
                                <span class="badge bg-info text-white me-2"><i class="bi bi-tag-fill me-1"></i> {{ $report->category }}</span>
                                <span class="small text-muted"><i class="bi bi-person me-1"></i> Dilaporkan oleh: {{ $report->writer_name ?? 'Admin' }}</span>
                            </div>

                            @if($report->photo_path)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $report->photo_path) }}" class="img-fluid rounded" alt="Foto Laporan" style="max-height: 300px; object-fit: cover;">
                            </div>
                            @endif
                            
                            <p class="card-text">{{ $report->description }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="alert alert-light text-center border p-5">
                    <i class="bi bi-folder2-open fs-1 text-muted mb-3 d-block"></i>
                    Belum ada daily report yang dicatat.
                </div>
                @endforelse
                
                <div class="d-flex justify-content-center mt-4">
                    {{ $reports->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
