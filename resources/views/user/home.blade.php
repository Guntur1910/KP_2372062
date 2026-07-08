@extends('layouts.user')

@section('title', 'Home - Kain Tenun Sumba')

@push('styles')
<style>
    .hero-bg {
        background-image: url('{{ asset("images/hero1.jpg") }}');
    }
</style>
@endpush

@section('content')

{{-- HERO --}}
<section class="hero">
    <div class="hero-bg"></div>
    <div class="hero-content">
        <h1>Kain Tenun Sumba</h1>
        <p>Menggabungkan tradisi & teknologi melalui digitalisasi</p>
    </div>
</section>

{{-- SECTION 1 --}}
<section class="section-split" id="tentang">
    <div class="split-image" id="slideshow-1">
        @foreach($kains as $kain)
            @if($kain->motifs->first() && $kain->motifs->first()->gambar)
                <img src="{{ asset('storage/' . $kain->motifs->first()->gambar) }}" alt="Kain Tenun" class="slide-img">
            @endif
        @endforeach
    </div>
    <div class="split-text">
        <h2 class="section-title">Warisan Budaya Sumba</h2>
        <p class="section-text">Kain tenun Sumba merupakan salah satu warisan budaya Indonesia yang memiliki nilai seni dan makna filosofis yang sangat tinggi. Setiap motif yang tercipta memiliki cerita dan simbol tersendiri yang mencerminkan kehidupan masyarakat Sumba. Melalui platform ini, kami menghadirkan dokumentasi digital yang lengkap untuk setiap kain dan motifnya.</p>
    </div>
</section>

{{-- SECTION 2 --}}
<section class="section-full">
    <h2 class="section-title">Tentang Digitalisasi Motif</h2>
    <p class="section-text">Platform ini dikembangkan sebagai upaya pelestarian dan inovasi motif kain tenun Sumba. Setiap motif didokumentasikan secara detail meliputi simbol, penempatan, asal daerah, pewarna, bentuk geometri, dan berbagai atribut lainnya. Data ini diharapkan dapat menjadi referensi bagi para desainer dalam mengembangkan inovasi aksesoris interior yang terinspirasi dari kekayaan budaya Sumba.</p>
</section>

{{-- SECTION 3 --}}
<section class="section-split-alt" id="galeri">
    <div class="split-text">
        <h2 class="section-title">Keanekaragaman Motif</h2>
        <p class="section-text">Setiap kain tenun Sumba memiliki keunikannya masing-masing. Motif flora menggambarkan keindahan alam Sumba dengan berbagai tumbuhan dan dedaunan, sementara motif fauna mengabadikan berbagai hewan yang memiliki makna simbolis bagi masyarakat setempat. Eksplorasi koleksi lengkap kami untuk mengenal lebih jauh kekayaan motif kain tenun Sumba.</p>
    </div>
    <div class="split-image" id="slideshow-2">
        @foreach($kains->reverse() as $kain)
            @if($kain->motifs->first() && $kain->motifs->first()->gambar)
                <img src="{{ asset('storage/' . $kain->motifs->first()->gambar) }}" alt="Kain Tenun" class="slide-img">
            @endif
        @endforeach
    </div>
</section>

{{-- CARDS SECTION --}}
<section class="section-cards" id="koleksi">
    <h2 class="section-title">Koleksi Motif Tenun Sumba</h2>

    <div class="search-filter-wrap">
        <form method="GET" action="{{ route('user.home') }}#koleksi" class="search-filter-form" id="searchFilterForm">

            <div class="search-box">
                <button type="submit" class="search-btn" title="Cari">
                    <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                </button>
                <input
                    type="text"
                    name="search"
                    id="searchInput"
                    class="search-input"
                    placeholder="Cari nama motif..."
                    value="{{ $searchQuery }}"
                    autocomplete="off"
                >
                @if($searchQuery)
                <a href="{{ route('user.home') }}?{{ http_build_query(array_filter(['jenis' => $activeJenis, 'tarikan_visual' => $activeTarikan, 'simetris' => $activeSimetris])) }}#koleksi" class="search-clear" title="Hapus pencarian">&#x2715;</a>
                @endif
            </div>

            <div class="filter-dropdowns">
                <div class="filter-dropdown-wrap">
                    <label class="filter-label">Jenis Motif</label>
                    <select name="jenis" class="filter-select">
                        <option value="">Semua</option>
                        @foreach($jenisMotifs as $jenis)
                            <option value="{{ $jenis->id }}" {{ $activeJenis == $jenis->id ? 'selected' : '' }}>
                                {{ ucfirst($jenis->nama) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-dropdown-wrap">
                    <label class="filter-label">Tarikan Visual</label>
                    <select name="tarikan_visual" class="filter-select">
                        <option value="">Semua</option>
                        @foreach($tarikanVisuals as $tarikan)
                            <option value="{{ $tarikan->id }}" {{ $activeTarikan == $tarikan->id ? 'selected' : '' }}>
                                {{ ucfirst($tarikan->nama) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-dropdown-wrap">
                    <label class="filter-label">Simetris</label>
                    <select name="simetris" class="filter-select">
                        <option value="">Semua</option>
                        @foreach($simetrisOptions as $sim)
                            <option value="{{ $sim->id }}" {{ $activeSimetris == $sim->id ? 'selected' : '' }}>
                                {{ ucfirst($sim->nama) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                @if($activeJenis || $activeTarikan || $activeSimetris || $searchQuery)
                <a href="{{ route('user.home') }}#koleksi" class="filter-reset">&#x2715; Reset</a>
                @endif

            </div>
            <button type="submit" class="btn-terapkan">Terapkan Filter</button>

        </form>

        <div class="result-info">
            <span>{{ $motifs->count() }} motif ditemukan</span>
        </div>
    </div>

    <div class="cards-grid" id="cardsGrid">
        @forelse($motifs as $motif)
        <a href="{{ route('kain.show', $motif->id_kain) }}#motif-{{ $motif->id }}" class="kain-card">
            <div class="card-img">
                @if($motif->gambar)
                    <img src="{{ asset('storage/' . $motif->gambar) }}" alt="{{ $motif->nama_motif }}">
                @else
                    <span class="no-img">Tidak ada gambar</span>
                @endif
            </div>
            <div class="card-body-custom">
                <div class="card-kain-name">{{ $motif->nama_motif }}</div>
                <div class="card-meta">
                    <span class="badge-motif">{{ $motif->kain && $motif->kain->jenisMotif ? ucfirst($motif->kain->jenisMotif->nama) : '-' }}</span>
                    <span style="font-size: 11px; opacity: 0.85;">Kain: {{ $motif->kain ? $motif->kain->nama_kain : '-' }}</span>
                </div>
            </div>
        </a>
        @empty
        <div class="empty-search-state">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <p>Tidak ada motif yang cocok dengan pencarian.</p>
            <a href="{{ route('user.home') }}#koleksi" class="filter-btn active" style="margin-top:12px; display:inline-block;">
                Tampilkan Semua
            </a>
        </div>
        @endforelse
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const grid = document.getElementById('cardsGrid');

    document.addEventListener('submit', function(e) {
        const form = e.target.closest('#searchFilterForm');
        if (form) {
            e.preventDefault();
            const actionUrl = new URL(form.action);
            const formData = new FormData(form);
            for (const [key, value] of formData.entries()) {
                if (value) {
                    actionUrl.searchParams.set(key, value);
                } else {
                    actionUrl.searchParams.delete(key);
                }
            }
            actionUrl.hash = '';
            fetchResults(actionUrl.toString(), true);
        }
    });

    document.addEventListener('click', function(e) {
        const actionBtn = e.target.closest('.filter-btn, .search-clear, .filter-reset');
        if (actionBtn && actionBtn.tagName === 'A') {
            e.preventDefault();
            const href = actionBtn.getAttribute('href');
            fetchResults(href, true);
        }
    });

    function fetchResults(url, updateHistory) {
        grid.style.opacity = '0.4';
        grid.style.transition = 'opacity 0.2s ease';

        fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');

            const newGrid = doc.getElementById('cardsGrid');
            if (newGrid && grid) grid.innerHTML = newGrid.innerHTML;

            const newResultInfo = doc.querySelector('.result-info');
            const currentResultInfo = document.querySelector('.result-info');
            if (newResultInfo && currentResultInfo) currentResultInfo.innerHTML = newResultInfo.innerHTML;

            const newSearchInput = doc.getElementById('searchInput');
            const currentSearchInput = document.getElementById('searchInput');
            if (newSearchInput && currentSearchInput) currentSearchInput.value = newSearchInput.value;

            const newClear = doc.querySelector('.search-clear');
            const currentClear = document.querySelector('.search-clear');
            const searchBox = document.querySelector('.search-box');
            if (newClear) {
                if (currentClear) {
                    currentClear.setAttribute('href', newClear.getAttribute('href'));
                } else if (searchBox) {
                    searchBox.insertAdjacentHTML('beforeend', newClear.outerHTML);
                }
            } else if (currentClear) {
                currentClear.remove();
            }

            ['jenis', 'tarikan_visual', 'simetris'].forEach(function(name) {
                const newSelect = doc.querySelector('select[name="' + name + '"]');
                const currentSelect = document.querySelector('select[name="' + name + '"]');
                if (newSelect && currentSelect) currentSelect.value = newSelect.value;
            });

            const newReset = doc.querySelector('.filter-reset');
            const currentReset = document.querySelector('.filter-reset');
            const filterDropdowns = document.querySelector('.filter-dropdowns');
            if (newReset) {
                if (currentReset) {
                    currentReset.setAttribute('href', newReset.getAttribute('href'));
                } else if (filterDropdowns) {
                    filterDropdowns.insertAdjacentHTML('beforeend', newReset.outerHTML);
                }
            } else if (currentReset) {
                currentReset.remove();
            }

            if (updateHistory) {
                const targetUrl = new URL(url);
                targetUrl.hash = 'koleksi';
                history.pushState({ url: targetUrl.toString() }, '', targetUrl.toString());
            }
        })
        .catch(err => console.error('Error fetching search results:', err))
        .finally(() => { grid.style.opacity = '1'; });
    }

    if (!history.state) {
        history.replaceState({ url: window.location.href }, '');
    }

    window.addEventListener('popstate', function(e) {
        if (e.state && e.state.url) fetchResults(e.state.url, false);
    });
});
</script>
@endpush
@endsection