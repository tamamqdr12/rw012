@extends('layouts.app')

@section('content')
<style>
    .gallery-item {
        overflow: hidden;
        border-radius: 10px;
        position: relative;
        cursor: pointer;
    }
    .gallery-item img {
        transition: transform 0.4s ease;
    }
    .gallery-item:hover img {
        transform: scale(1.08);
    }
    .gallery-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(transparent, rgba(0,0,0,0.85));
        padding: 20px 15px 15px;
        color: #fff;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .gallery-item:hover .gallery-overlay {
        opacity: 1;
    }
    .filter-btn {
        border: 1px solid #dee2e6;
        background: #fff;
        padding: 6px 16px;
        border-radius: 50px;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.2s;
    }
    .filter-btn:hover, .filter-btn.active {
        background: #0d6efd;
        color: #fff;
        border-color: #0d6efd;
    }

    /* Lightbox */
    .lightbox-overlay {
        display: none;
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.92);
        z-index: 9999;
        justify-content: center;
        align-items: center;
        cursor: pointer;
    }
    .lightbox-overlay.show { display: flex; }
    .lightbox-overlay img {
        max-width: 90vw;
        max-height: 85vh;
        border-radius: 10px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.5);
    }
    .lightbox-caption {
        position: fixed;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        color: #fff;
        text-align: center;
        max-width: 600px;
    }
    .lightbox-close {
        position: fixed;
        top: 20px;
        right: 30px;
        color: #fff;
        font-size: 2.5rem;
        cursor: pointer;
        z-index: 10000;
        line-height: 1;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center" data-aos="fade-up">
        <div class="col-12">
            <h2 class="fw-bold mb-2 text-center"><i class="bi bi-images text-primary me-2"></i>Galeri Lingkungan</h2>
            <p class="text-center text-muted mb-4">Dokumentasi kegiatan dan kehidupan warga RW 012</p>

            {{-- Category Filter Buttons --}}
            <div class="text-center mb-4 d-flex flex-wrap justify-content-center gap-2" id="filterBar">
                <button class="filter-btn active" data-filter="all">Semua</button>
                @foreach(['Kegiatan RW','Kegiatan RT','Kerja Bakti','Sosial','Keagamaan','Kepemudaan','Lainnya'] as $cat)
                <button class="filter-btn" data-filter="{{ $cat }}">{{ $cat }}</button>
                @endforeach
            </div>

            {{-- Gallery Grid --}}
            <div class="row g-3" id="galleryGrid">
                @forelse($galleries as $gallery)
                <div class="col-6 col-md-4 col-lg-3 gallery-col" data-category="{{ $gallery->category }}">
                    <div class="gallery-item shadow-sm" onclick="openLightbox('{{ asset('storage/' . $gallery->image_path) }}', '{{ addslashes($gallery->title) }}', '{{ addslashes($gallery->description ?? '') }}')">
                        <img src="{{ asset('storage/' . $gallery->image_path) }}" class="w-100" alt="{{ $gallery->title }}" style="height: 220px; object-fit: cover;" onerror="this.src='https://placehold.co/300x220/e9ecef/6c757d?text=No+Image'">
                        <div class="gallery-overlay">
                            <span class="badge bg-primary mb-1" style="font-size: 0.7rem;">{{ $gallery->category }}</span>
                            <h6 class="fw-bold mb-0">{{ $gallery->title }}</h6>
                            @if($gallery->date)
                            <small><i class="bi bi-calendar3 me-1"></i>{{ $gallery->date->format('d M Y') }}</small>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12" id="emptyGallery">
                    <div class="alert alert-light border text-center p-5">
                        <i class="bi bi-image fs-1 text-muted mb-3 d-block"></i>
                        Belum ada foto yang diunggah ke galeri.
                    </div>
                </div>
                @endforelse
            </div>

            <div class="d-flex justify-content-center mt-5">
                {{ $galleries->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

{{-- Lightbox --}}
<div class="lightbox-overlay" id="lightbox" onclick="closeLightbox(event)">
    <span class="lightbox-close" onclick="closeLightbox(event)">&times;</span>
    <img id="lightboxImg" src="" alt="">
    <div class="lightbox-caption">
        <h5 class="fw-bold mb-1" id="lightboxTitle"></h5>
        <p class="small mb-0" id="lightboxDesc"></p>
    </div>
</div>

<script>
    // Category Filter
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            const filter = this.dataset.filter;
            document.querySelectorAll('.gallery-col').forEach(col => {
                if (filter === 'all' || col.dataset.category === filter) {
                    col.style.display = '';
                } else {
                    col.style.display = 'none';
                }
            });
        });
    });

    // Lightbox
    function openLightbox(src, title, desc) {
        document.getElementById('lightboxImg').src = src;
        document.getElementById('lightboxTitle').textContent = title;
        document.getElementById('lightboxDesc').textContent = desc;
        document.getElementById('lightbox').classList.add('show');
        document.body.style.overflow = 'hidden';
    }
    function closeLightbox(e) {
        if (e.target.id === 'lightbox' || e.target.classList.contains('lightbox-close')) {
            document.getElementById('lightbox').classList.remove('show');
            document.body.style.overflow = '';
        }
    }
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.getElementById('lightbox').classList.remove('show');
            document.body.style.overflow = '';
        }
    });
</script>
@endsection
