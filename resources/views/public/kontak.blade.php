@extends('layouts.app')

@section('content')
<style>
    .contact-intro{border-left:4px solid var(--rw-green);padding-left:1.15rem}.contact-card{background:#fff;border:1px solid var(--rw-line);border-radius:.45rem;height:100%;padding:1.25rem;transition:border-color .2s ease,transform .2s ease,box-shadow .2s ease}.contact-card:hover{border-color:#a9c7d8;transform:translateY(-2px);box-shadow:0 8px 18px rgba(29,52,67,.06)}.contact-number{font-size:1.05rem;font-weight:700;color:var(--rw-ink);text-decoration:none}.contact-number:hover{color:var(--rw-blue)}.copy-feedback{min-height:1.2rem;font-size:.78rem;color:var(--rw-green)}
</style>
<div class="container section-space">
    <div class="row align-items-end g-4 mb-5" data-aos="fade-up"><div class="col-lg-7"><div class="section-kicker mb-2">Layanan warga</div><h1 class="section-title mb-3">Kontak lingkungan</h1><div class="contact-intro"><p class="text-secondary mb-0">Pilih kontak pengurus yang sesuai untuk informasi dan kebutuhan warga. Untuk hal yang tidak mendesak, Anda juga dapat menyampaikan aspirasi melalui formulir online.</p></div></div><div class="col-lg-5 text-lg-end"><a href="{{ route('aspirasi') }}" class="btn btn-outline-primary">Sampaikan aspirasi</a></div></div>

    <div class="row g-3" data-aos="fade-up" data-aos-delay="60">@forelse($contacts as $contact)@php $phone = preg_replace('/[^0-9]/', '', $contact->phone_number); @endphp<div class="col-md-6 col-lg-4"><article class="contact-card"><div class="d-flex justify-content-end"><button type="button" class="btn btn-sm btn-light border copy-contact" data-phone="{{ $contact->phone_number }}" aria-label="Salin nomor {{ $contact->name }}"><i class="bi bi-copy"></i></button></div><div class="mt-2"><div class="small text-secondary mb-1">Kontak pengurus</div><h2 class="h5 fw-bold mb-2">{{ $contact->name }}</h2><a class="contact-number" href="tel:{{ $phone }}">{{ $contact->phone_number }}</a><div class="copy-feedback" aria-live="polite"></div></div><div class="mt-3"><a href="https://wa.me/{{ $phone }}" class="btn btn-success btn-sm w-100" target="_blank" rel="noopener"><i class="bi bi-whatsapp me-1"></i>WhatsApp</a></div></article></div>@empty<div class="col-12"><div class="content-panel text-center p-5"><h2 class="h5 fw-bold">Kontak belum tersedia</h2><p class="text-secondary mb-0">Silakan periksa kembali dalam beberapa waktu atau gunakan formulir aspirasi.</p></div></div>@endforelse</div>

    <div class="content-panel mt-5 p-4 p-md-5" data-aos="fade-up"><div class="row align-items-center g-3"><div class="col-md"><h2 class="h5 fw-bold mb-1">Sebelum menghubungi pengurus</h2><p class="text-secondary small mb-0">Sampaikan keperluan secara singkat dan sertakan lokasi bila berkaitan dengan fasilitas atau lingkungan.</p></div><div class="col-md-auto"><a href="{{ route('aspirasi') }}" class="small fw-semibold text-decoration-none">Kirim aspirasi tertulis</a></div></div></div>
</div>
<script>
document.querySelectorAll('.copy-contact').forEach((button) => {
    button.addEventListener('click', async () => {
        const feedback = button.closest('.contact-card').querySelector('.copy-feedback');
        try { await navigator.clipboard.writeText(button.dataset.phone); feedback.textContent = 'Nomor berhasil disalin.'; }
        catch (error) { feedback.textContent = 'Silakan salin nomor secara manual.'; }
        setTimeout(() => { feedback.textContent = ''; }, 2500);
    });
});
</script>
@endsection
