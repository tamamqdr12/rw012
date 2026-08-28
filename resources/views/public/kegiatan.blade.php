@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center" data-aos="fade-up">
        <div class="col-md-10">
            <h2 class="fw-bold mb-4 text-center border-bottom pb-3"><i class="bi bi-calendar-event text-primary me-2"></i>Kegiatan Warga</h2>
            
            <div class="row g-4 mt-3">
                @forelse($events as $event)
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100 overflow-hidden">
                        @if($event->photo_path)
                            <img src="{{ asset('storage/' . $event->photo_path) }}" class="card-img-top" alt="{{ $event->title }}" style="height: 250px; object-fit: cover;">
                        @endif
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between mb-3">
                                <div class="badge bg-primary"><i class="bi bi-calendar me-1"></i> {{ \Carbon\Carbon::parse($event->event_date)->format('d F Y') }} {{ $event->event_time ? '- ' . \Carbon\Carbon::parse($event->event_time)->format('H:i') : '' }}</div>
                                @php
                                    $statusColor = 'bg-secondary';
                                    if($event->status == 'Akan Datang') $statusColor = 'bg-info';
                                    else if($event->status == 'Berlangsung') $statusColor = 'bg-warning text-dark';
                                    else if($event->status == 'Selesai') $statusColor = 'bg-success';
                                @endphp
                                <span class="badge {{ $statusColor }}">{{ $event->status }}</span>
                            </div>
                            
                            <h4 class="fw-bold card-title">{{ $event->title }}</h4>
                            
                            @if($event->organizer)
                            <p class="text-muted small mb-1"><i class="bi bi-people-fill text-primary me-1"></i> Penyelenggara: {{ $event->organizer }}</p>
                            @endif

                            @if($event->location)
                            <p class="text-muted small mb-3"><i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $event->location }}</p>
                            @endif
                            
                            <p class="card-text text-secondary">{{ $event->description }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-light border text-center p-5">
                        <i class="bi bi-calendar-x fs-1 text-muted mb-3 d-block"></i>
                        Belum ada kegiatan yang dijadwalkan.
                    </div>
                </div>
                @endforelse
            </div>
            
            <div class="d-flex justify-content-center mt-5">
                {{ $events->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
