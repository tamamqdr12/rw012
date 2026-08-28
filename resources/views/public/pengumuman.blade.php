@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center" data-aos="fade-up">
        <div class="col-md-10">
            <h2 class="fw-bold mb-4 text-center border-bottom pb-3"><i class="bi bi-megaphone-fill text-accent me-2"></i>Pengumuman Warga</h2>
            
            <div class="mt-4">
                @forelse($announcements as $item)
                <div class="card mb-4 border-0 shadow-sm border-start border-4 {{ $item->is_pinned ? 'border-warning bg-light' : 'border-primary' }}">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between">
                            <small class="text-muted d-block mb-2"><i class="bi bi-clock me-1"></i> Dipublikasikan: {{ $item->publish_date ? \Carbon\Carbon::parse($item->publish_date)->format('d M Y, H:i') : $item->created_at->format('d M Y, H:i') }}</small>
                            @if($item->is_pinned)
                                <span class="badge bg-warning text-dark"><i class="bi bi-pin-angle-fill me-1"></i> Pinned</span>
                            @endif
                        </div>
                        
                        <h4 class="card-title fw-bold mb-3">{{ $item->title }}</h4>
                        
                        @if($item->photo_path)
                        <div class="mb-4">
                            <img src="{{ asset('storage/' . $item->photo_path) }}" class="img-fluid rounded" alt="Gambar Pengumuman" style="max-height: 400px; object-fit: contain;">
                        </div>
                        @endif

                        <div class="card-text text-secondary lh-lg">
                            {!! nl2br(e($item->content)) !!}
                        </div>
                    </div>
                </div>
                @empty
                <div class="alert alert-light text-center border p-5">
                    <i class="bi bi-info-circle fs-1 text-muted mb-3 d-block"></i>
                    Saat ini tidak ada pengumuman.
                </div>
                @endforelse
                
                <div class="d-flex justify-content-center mt-4">
                    {{ $announcements->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
