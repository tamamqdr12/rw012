@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<style>
    #map {
        height: 600px;
        width: 100%;
        border-radius: 6px;
        z-index: 1; /* prevent overlapping with navbar */
    }
    .map-search { background:#fff; border:1px solid var(--rw-line); border-radius:6px; padding:1rem; }
    .map-search-results { display:none; margin-top:.75rem; border-top:1px solid var(--rw-line); }
    .map-search-results.show { display:block; }
    .map-search-result { width:100%; padding:.7rem 0; text-align:left; background:transparent; border:0; border-bottom:1px solid #edf1f3; color:var(--rw-ink); }
    .map-search-result:hover { color:var(--rw-blue); }
    @media (max-width: 768px) {
        #map {
            height: 400px;
        }
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center" data-aos="fade-up">
        <div class="col-md-12">
            <h2 class="fw-bold mb-4 text-center border-bottom pb-3"><i class="bi bi-map text-primary me-2"></i>Peta Wilayah RW 012</h2>
            <p class="text-center text-muted mb-4">Peta kawasan Kelurahan Bugel, Kecamatan Karawaci, Kota Tangerang</p>

            <div class="map-search mb-3">
                <form id="placeSearchForm" class="row g-2 align-items-center">
                    <div class="col-md"><label for="placeSearch" class="visually-hidden">Cari tempat di kawasan Bugel</label><input id="placeSearch" class="form-control" type="search" placeholder="Cari masjid, sekolah, fasilitas umum, atau nama tempat di Bugel" autocomplete="off"></div>
                    <div class="col-md-auto"><button class="btn btn-primary w-100" type="submit">Cari lokasi</button></div>
                </form>
                <div id="searchStatus" class="form-text mt-2">Pencarian dibatasi pada batas Kelurahan Bugel. Lokasi RW 012 yang dikelola admin ditampilkan sebagai marker.</div>
                <div id="searchResults" class="map-search-results" aria-live="polite"></div>
            </div>
            
            <div class="card border-0 shadow-sm p-2">
                <div id="map"></div>
            </div>

            <div class="row mt-5 g-4">
                <div class="col-12">
                    <h4 class="fw-bold text-secondary mb-3"><i class="bi bi-geo-alt-fill text-danger me-2"></i>Daftar Lokasi Penting</h4>
                </div>
                @forelse($locations as $loc)
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 border-start border-4 border-primary">
                        <div class="card-body">
                            <h5 class="fw-bold">{{ $loc->name }}</h5>
                            <span class="badge bg-primary mb-2">{{ $loc->type }}</span>
                            <p class="card-text text-muted small">{{ $loc->description }}</p>
                            @if(!$loc->latitude || !$loc->longitude)
                            <span class="badge bg-warning text-dark"><i class="bi bi-exclamation-triangle"></i> Koordinat Belum Diset</span>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center text-muted">Belum ada data lokasi.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Batas tampilan kawasan Kelurahan Bugel, Karawaci, Kota Tangerang.
        // Pengguna tetap dapat memperbesar peta, tetapi tidak dapat bergeser keluar kawasan.
        var bugelBounds = L.latLngBounds(
            [-6.1838, 106.6013],
            [-6.1708, 106.6105]
        );
        // Batas navigasi sedikit lebih luas agar peta nyaman digeser
        // ke kanan, kiri, atas, dan bawah saat pengguna melihat detail area.
        var navigationBounds = bugelBounds.pad(0.12);
        var map = L.map('map', {
            maxBounds: navigationBounds,
            maxBoundsViscosity: 1.0,
            minZoom: 13
        });
        map.fitBounds(bugelBounds, { padding: [8, 8] });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        var locations = @json($locations);
        var searchMarker = null;

        locations.forEach(function(loc) {
            if (loc.latitude && loc.longitude) {
                var lat = parseFloat(loc.latitude);
                var lng = parseFloat(loc.longitude);
                
                if (!isNaN(lat) && !isNaN(lng)) {
                    // Marker di luar kawasan Bugel tidak ditampilkan pada peta publik.
                    if (!bugelBounds.contains([lat, lng])) {
                        return;
                    }

                    var marker = L.marker([lat, lng]).addTo(map);
                    
                    var popupContent = `
                        <div style="min-width: 150px;">
                            <h6 style="margin: 0; font-weight: bold; color: #0d6efd;">${loc.name}</h6>
                            <span style="font-size: 0.8em; background: #0d6efd; color: white; padding: 2px 5px; border-radius: 3px; display: inline-block; margin: 5px 0;">${loc.type}</span>
                            <p style="margin: 5px 0 0 0; font-size: 0.9em; color: #666;">${loc.description}</p>
                        </div>
                    `;
                    marker.bindPopup(popupContent);
                    
                }
            }
        });

        var searchForm = document.getElementById('placeSearchForm');
        var searchInput = document.getElementById('placeSearch');
        var searchStatus = document.getElementById('searchStatus');
        var searchResults = document.getElementById('searchResults');

        function showSearchResults(items) {
            searchResults.replaceChildren();
            searchResults.classList.add('show');

            if (!items.length) {
                searchResults.textContent = 'Tempat tidak ditemukan di kawasan Bugel.';
                return;
            }

            items.forEach(function(item) {
                var button = document.createElement('button');
                button.type = 'button';
                button.className = 'map-search-result';
                button.textContent = item.display_name;
                button.addEventListener('click', function() {
                    var point = [parseFloat(item.lat), parseFloat(item.lon)];
                    if (searchMarker) map.removeLayer(searchMarker);
                    searchMarker = L.marker(point).addTo(map);
                    var popup = document.createElement('div');
                    popup.textContent = item.display_name;
                    searchMarker.bindPopup(popup).openPopup();
                    map.setView(point, 17);
                    searchResults.classList.remove('show');
                    searchStatus.textContent = 'Lokasi ditampilkan pada peta.';
                });
                searchResults.appendChild(button);
            });
        }

        function escapeOverpassRegex(value) {
            return value.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        }

        function buildOverpassQuery(query) {
            var keyword = query.toLowerCase();
            var south = '-6.1838';
            var west = '106.6013';
            var north = '-6.1708';
            var east = '106.6105';
            var area = '(' + south + ',' + west + ',' + north + ',' + east + ')';
            var categoryQuery = '';

            if (/masjid|musala|mushola|surau/.test(keyword)) {
                categoryQuery = 'nwr["amenity"="place_of_worship"]' + area + ';';
            } else if (/makam|kuburan|pemakaman/.test(keyword)) {
                categoryQuery = 'nwr["landuse"="cemetery"]' + area + ';nwr["amenity"="grave_yard"]' + area + ';';
            } else if (/coffee|kopi|cafe|kafe/.test(keyword)) {
                categoryQuery = 'nwr["amenity"="cafe"]' + area + ';nwr["cuisine"~"coffee|kopi",i]' + area + ';';
            }

            var nameQuery = 'nwr["name"~"' + escapeOverpassRegex(query) + '",i]' + area + ';';
            return '[out:json][timeout:20];(' + categoryQuery + nameQuery + ');out center tags 20;';
        }

        function normalizeOverpassResults(elements) {
            var seen = new Set();
            return elements.map(function(item) {
                var lat = item.lat ?? item.center?.lat;
                var lon = item.lon ?? item.center?.lon;
                var tags = item.tags || {};
                var category = tags.amenity || tags.landuse || tags.shop || tags.tourism || 'Lokasi';
                return {
                    lat: lat,
                    lon: lon,
                    display_name: (tags.name || category) + ' — ' + category
                };
            }).filter(function(item) {
                var key = item.lat + ',' + item.lon;
                if (!item.lat || !item.lon || seen.has(key)) return false;
                seen.add(key);
                return bugelBounds.contains([parseFloat(item.lat), parseFloat(item.lon)]);
            });
        }

        searchForm.addEventListener('submit', async function(event) {
            event.preventDefault();
            var query = searchInput.value.trim();
            if (query.length < 2) {
                searchStatus.textContent = 'Masukkan minimal dua karakter untuk mencari lokasi.';
                return;
            }

            searchStatus.textContent = 'Mencari lokasi di kawasan Bugel...';
            searchResults.classList.remove('show');

            try {
                var overpassQuery = buildOverpassQuery(query);
                var url = 'https://overpass-api.de/api/interpreter?data=' + encodeURIComponent(overpassQuery);
                var response = await fetch(url, { headers: { 'Accept': 'application/json' } });
                if (!response.ok) throw new Error('Search request failed');
                var results = await response.json();
                var withinBugel = normalizeOverpassResults(results.elements || []);
                searchStatus.textContent = withinBugel.length ? 'Pilih lokasi untuk melihatnya di peta.' : 'Tempat tidak ditemukan di kawasan Bugel.';
                showSearchResults(withinBugel);
            } catch (error) {
                searchStatus.textContent = 'Pencarian tidak dapat dilakukan. Periksa koneksi internet lalu coba lagi.';
            }
        });
    });
</script>
@endsection
