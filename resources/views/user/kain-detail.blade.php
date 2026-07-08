@extends('layouts.user')

@section('title', $kain->nama_kain . ' - Kain Tenun Sumba')

@section('content')

{{-- HERO KAIN --}}
<section class="kain-hero">
    <div class="kain-hero-inner">
        <a href="{{ route('user.home') }}" class="back-link">← Kembali ke Beranda</a>
        <div class="kain-hero-content">
            <div class="kain-hero-image">
                @if($kain->motifs->first() && $kain->motifs->first()->gambar)
                    <img src="{{ asset('storage/' . $kain->motifs->first()->gambar) }}" alt="{{ $kain->nama_kain }}">
                @else
                    <div class="no-img-large">Tidak ada gambar</div>
                @endif
            </div>
            <div class="kain-hero-info">
                <div class="kain-badge-wrap">
                    <span class="kain-badge">{{ ucfirst($kain->jenisMotif->nama ?? '-') }}</span>
                    <span class="kain-motif-count">{{ $kain->motifs->count() }} motif tersedia</span>
                </div>
                <h1 class="kain-title">{{ $kain->nama_kain }}</h1>
                <div class="kain-divider"></div>
                <p class="kain-desc">Kain tenun Sumba dengan motif <strong>{{ ucfirst($kain->jenisMotif->nama ?? '') }}</strong> yang memiliki nilai seni dan makna filosofis tinggi. Setiap motif mencerminkan kehidupan dan budaya masyarakat Sumba.</p>

                {{-- Quick stats --}}
                <div class="kain-stats">
                    <div class="stat-item">
                        <span class="stat-number">{{ $kain->motifs->count() }}</span>
                        <span class="stat-label">Total Motif</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $kain->motifs->whereNotNull('gambar')->count() }}</span>
                        <span class="stat-label">Dengan Gambar</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $kain->motifs->unique('asal_daerah')->count() }}</span>
                        <span class="stat-label">Asal Daerah</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- MOTIF LIST --}}
<section class="motif-section">
    <div class="motif-section-inner">
        <div class="motif-section-header">
            <h2 class="motif-section-title">Koleksi Motif</h2>
            <span class="motif-section-count">{{ $kain->motifs->count() }} motif</span>
        </div>

        @forelse($kain->motifs as $index => $motif)
        <div class="motif-product-card" id="motif-{{ $motif->id }}">

            {{-- Left: Image --}}
            <div class="motif-product-image">
                @if($motif->gambar)
                    <img src="{{ asset('storage/' . $motif->gambar) }}" alt="{{ $motif->nama_motif }}">
                @else
                    <div class="no-img-motif">Tidak ada gambar</div>
                @endif

                {{-- Drive links --}}
                @if($motif->link_drive_utuh || $motif->link_drive_vektor)
                <div class="motif-drive-links">
                    @if($motif->link_drive_utuh)
                        <a href="{{ $motif->link_drive_utuh }}" target="_blank" class="drive-btn">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                            Gambar Utuh
                        </a>
                    @endif
                    @if($motif->link_drive_vektor)
                        <a href="{{ $motif->link_drive_vektor }}" target="_blank" class="drive-btn drive-btn-outline">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                            Gambar Vektor
                        </a>
                    @endif
                </div>
                @endif
            </div>

            <div class="motif-product-info">
                <div class="motif-product-header">
                    <span class="motif-number">Motif {{ $index + 1 }}</span>
                    <h3 class="motif-product-name">{{ $motif->nama_motif }}</h3>
                    @if($motif->deskripsi)
                        <p class="motif-product-desc">{{ $motif->deskripsi }}</p>
                    @endif
                </div>

                <div class="motif-attrs">
                    @if($motif->simbol)
                    <div class="motif-attr">
                        <div>
                            <span class="attr-label">Simbol</span>
                            <span class="attr-value">{{ $motif->simbol }}</span>
                        </div>
                    </div>
                    @endif

                    @if($motif->penempatan)
                    <div class="motif-attr">
                        <div>
                            <span class="attr-label">Penempatan</span>
                            <span class="attr-value">{{ $motif->penempatan }}</span>
                        </div>
                    </div>
                    @endif

                    @if($motif->peruntukan)
                    <div class="motif-attr">
                        <div>
                            <span class="attr-label">Peruntukan</span>
                            <span class="attr-value">{{ ucfirst($motif->peruntukan) }}</span>
                        </div>
                    </div>
                    @endif

                    @if($motif->asal_daerah)
                    <div class="motif-attr">
                        <div>
                            <span class="attr-label">Asal Daerah</span>
                            <span class="attr-value">{{ $motif->asal_daerah }}</span>
                        </div>
                    </div>
                    @endif

                    @if($motif->sumber)
                    <div class="motif-attr">
                        <div>
                            <span class="attr-label">Sumber</span>
                            <span class="attr-value">{{ $motif->sumber }}</span>
                        </div>
                    </div>
                    @endif

                    @if($motif->arah_penggunaan)
                    <div class="motif-attr">
                        <div>
                            <span class="attr-label">Arah Penggunaan</span>
                            <span class="attr-value">{{ $motif->arah_penggunaan }}</span>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="motif-tags">
                    @if($motif->bentuk_geometri)
                        <div class="motif-tag-group">
                            <span class="tag-label">Bentuk Geometri</span>
                            <span class="motif-tag">{{ $motif->bentuk_geometri }}</span>
                        </div>
                    @endif
                    @if($motif->tarikanVisual)
                        <div class="motif-tag-group">
                            <span class="tag-label">Tarikan Visual</span>
                            <span class="motif-tag">{{ ucfirst($motif->tarikanVisual->nama) }}</span>
                        </div>
                    @endif
                    @if($motif->simetris)
                        <div class="motif-tag-group">
                            <span class="tag-label">Simetris</span>
                            <span class="motif-tag">{{ ucfirst($motif->simetris->nama) }}</span>
                        </div>
                    @endif
                    @if($motif->pewarna)
                        <div class="motif-tag-group">
                            <span class="tag-label">Pewarna</span>
                            <span class="motif-tag motif-tag-{{ $motif->pewarna }}">{{ ucfirst($motif->pewarna) }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="empty-state">Belum ada motif untuk kain ini.</div>
        @endforelse
    </div>
</section>

@push('styles')
<style>
    /* HERO */
    .kain-hero {
        background: var(--cream);
        padding: 0;
        border-bottom: 1px solid var(--cream-dark);
    }

    .kain-hero-inner {
        max-width: 1100px;
        margin: 0 auto;
        padding: 32px 40px 48px;
    }

    .kain-hero-content {
        display: flex;
        gap: 56px;
        align-items: flex-start;
        margin-top: 20px;
    }

    .kain-hero-image {
        width: 380px;
        height: 380px;
        flex-shrink: 0;
        overflow: hidden;
        border-radius: 8px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.12);
    }

    .kain-hero-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .no-img-large {
        width: 100%;
        height: 100%;
        background: var(--cream-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--sage-light);
        font-size: 13px;
    }

    .kain-hero-info {
        flex: 1;
        padding-top: 8px;
    }

    .kain-badge-wrap {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 16px;
    }

    .kain-badge {
        background: var(--sage);
        color: var(--white);
        padding: 4px 16px;
        font-size: 12px;
        font-weight: 400;
        letter-spacing: 0.5px;
        border-radius: 2px;
    }

    .kain-motif-count {
        font-size: 13px;
        color: var(--text-muted);
    }

    .kain-title {
        font-family: 'Playfair Display', serif;
        font-size: 48px;
        font-weight: 600;
        color: var(--text-dark);
        line-height: 1.1;
        margin-bottom: 16px;
    }

    .kain-divider {
        width: 48px;
        height: 3px;
        background: var(--sage);
        margin-bottom: 20px;
        border-radius: 2px;
    }

    .kain-desc {
        font-size: 14px;
        color: var(--text-muted);
        line-height: 1.8;
        font-weight: 300;
        margin-bottom: 32px;
        max-width: 480px;
    }

    .kain-stats {
        display: flex;
        gap: 32px;
        padding: 24px 0;
        border-top: 1px solid var(--cream-dark);
    }

    .stat-item {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .stat-number {
        font-family: 'Playfair Display', serif;
        font-size: 32px;
        font-weight: 600;
        color: var(--sage-dark);
        line-height: 1;
    }

    .stat-label {
        font-size: 11px;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* MOTIF SECTION */
    .motif-section {
        background: var(--white);
        padding: 60px 0;
    }

    .motif-section-inner {
        max-width: 1100px;
        margin: 0 auto;
        padding: 0 40px;
    }

    .motif-section-header {
        display: flex;
        align-items: baseline;
        gap: 16px;
        margin-bottom: 40px;
        padding-bottom: 20px;
        /* border-bottom: 2px solid var(--cream-dark); */
    }

    .motif-section-title {
        font-family: 'Playfair Display', serif;
        font-size: 28px;
        font-weight: 600;
        color: var(--text-dark);
    }

    .motif-section-count {
        font-size: 13px;
        color: var(--text-muted);
    }

    /* MOTIF PRODUCT CARD */
    .motif-product-card {
        display: flex;
        gap: 0;
        margin-bottom: 40px;
        background: var(--cream);
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 16px rgba(0,0,0,0.06);
        transition: box-shadow 0.3s;
    }

    .motif-product-card:hover {
        box-shadow: 0 8px 32px rgba(0,0,0,0.12);
    }

    .motif-product-image {
        width: 300px;
        flex-shrink: 0;
        display: flex;
        flex-direction: column;
        background: var(--cream);
    }

    .motif-product-image img {
        width: 100%;
        height: 280px;
        object-fit: cover;
    }

    .no-img-motif {
        width: 100%;
        height: 280px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--sage-light);
        font-size: 12px;
    }

    .motif-drive-links {
        padding: 12px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        background: var(--cream);
        border-top: 1px solid var(--cream-dark);
    }

    .drive-btn {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 8px 12px;
        background: var(--sage);
        color: var(--white);
        text-decoration: none;
        font-size: 12px;
        border-radius: 4px;
        transition: background 0.2s;
        justify-content: center;
    }

    .drive-btn:hover { background: var(--sage-dark); color: var(--white); }

    .drive-btn-outline {
        background: transparent;
        border: 1px solid var(--sage);
        color: var(--sage-dark);
    }

    .drive-btn-outline:hover { background: var(--sage); color: var(--white); }

    /* MOTIF INFO */
    .motif-product-info {
        flex: 1;
        padding: 32px 36px;
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .motif-number {
        font-size: 11px;
        color: var(--sage);
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 700;
        display: block;
        margin-bottom: 6px;
    }

    .motif-product-name {
        font-family: 'Playfair Display', serif;
        font-size: 24px;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 10px;
    }

    .motif-product-desc {
        font-size: 13px;
        color: var(--text-muted);
        line-height: 1.7;
        font-weight: 300;
    }

    /* ATTRIBUTES */
    .motif-attrs {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .motif-attr {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 10px 14px;
        background: var(--white);
        border-radius: 4px;
    }

    .attr-label {
        display: block;
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--text-muted);
        margin-bottom: 2px;
    }

    .attr-value {
        display: block;
        font-size: 13px;
        color: var(--text-dark);
        font-weight: 400;
    }

    /* TAGS */
    .motif-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        padding-top: 16px;
        border-top: 1px solid var(--cream-dark);
    }

    .motif-tag-group {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .tag-label {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--text-muted);
    }

    .motif-tag {
        display: inline-block;
        padding: 4px 12px;
        background: var(--cream-dark);
        color: var(--text-dark);
        font-size: 12px;
        border-radius: 20px;
        border: 1px solid rgba(0,0,0,0.06);
    }

    .motif-tag-alami {
        background: #E8F5E9;
        color: #2E7D32;
        border-color: #C8E6C9;
    }

    .motif-tag-buatan {
        background: #FFF3E0;
        color: #E65100;
        border-color: #FFE0B2;
    }

    .empty-state {
        text-align: center;
        padding: 80px 0;
        color: var(--text-muted);
        font-size: 14px;
    }

    @media (max-width: 768px) {
        .kain-hero-inner { padding: 24px 20px 36px; }
        .kain-hero-content { flex-direction: column; gap: 24px; }
        .kain-hero-image { width: 100%; height: 260px; }
        .kain-title { font-size: 32px; }
        .kain-stats { gap: 20px; }
        .motif-section-inner { padding: 0 20px; }
        .motif-product-card { flex-direction: column; }
        .motif-product-image { width: 100%; }
        .motif-product-info { padding: 20px; }
        .motif-attrs { grid-template-columns: 1fr; }
    }
</style>
@endpush

@endsection