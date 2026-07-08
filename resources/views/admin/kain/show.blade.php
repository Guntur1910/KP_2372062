@extends('layouts.admin')

@section('hide_navbar', true)

@section('title', $kain->nama_kain . ' - Detail Kain (Admin)')

@section('content')

{{-- ADMIN HERO KAIN --}}
<section class="kain-hero">
    <div class="kain-hero-inner">
        <a href="{{ route('admin.dashboard') }}" class="back-link">← Kembali ke Dashboard</a>
        
        <div class="kain-hero-content">
            <div class="kain-hero-info">
                <div class="kain-badge-wrap">
                    <span class="kain-badge">{{ ucfirst($kain->jenisMotif->nama ?? '-') }}</span>
                    <span class="kain-motif-count">{{ $kain->motifs->count() }} motif terdaftar</span>
                </div>
                <h1 class="kain-title">{{ $kain->nama_kain }}</h1>
                <div class="kain-divider"></div>
            </div>
            
            <div class="admin-actions">
                <a href="{{ route('admin.motif.create', ['id_kain' => $kain->id_kain]) }}" class="drive-btn">+ Tambah Motif</a>
                <a href="{{ route('admin.kain.edit', $kain->id_kain) }}" class="drive-btn drive-btn-outline">Edit Kain</a>
            </div>
        </div>
    </div>
</section>

{{-- MOTIF MANAGEMENT LIST --}}
<section class="motif-section">
    <div class="motif-section-inner">
        <div class="motif-section-header">
            <h2 class="motif-section-title">Kelola Motif</h2>
            <span class="motif-section-count">{{ $kain->motifs->count() }} motif</span>
        </div>

        @forelse($kain->motifs as $index => $motif)
        <div class="motif-product-card" id="motif-{{ $motif->id }}">

            <div class="motif-product-image">
                @if($motif->gambar)
                    <img src="{{ asset('storage/' . $motif->gambar) }}" alt="{{ $motif->nama_motif }}">
                @else
                    <div class="no-img-motif">Tidak ada gambar</div>
                @endif

                @if($motif->link_drive_utuh || $motif->link_drive_vektor)
                <div class="motif-drive-links">
                    @if($motif->link_drive_utuh)
                        <a href="{{ $motif->link_drive_utuh }}" target="_blank" class="drive-btn">
                            🔗 Gambar Utuh
                        </a>
                    @endif
                    @if($motif->link_drive_vektor)
                        <a href="{{ $motif->link_drive_vektor }}" target="_blank" class="drive-btn drive-btn-outline">
                            🔗 Gambar Vektor
                        </a>
                    @endif
                </div>
                @endif
            </div>

            <div class="motif-product-info">
                <div class="admin-card-header">
                    <div>
                        <span class="motif-number">Motif {{ $index + 1 }}</span>
                        <h3 class="motif-product-name">{{ $motif->nama_motif }}</h3>
                    </div>
                    <div class="admin-action-trigger">
                        <a href="{{ route('admin.motif.edit', $motif->id) }}" class="drive-btn drive-btn-outline">Edit</a>
                        <form action="{{ route('admin.motif.destroy', $motif->id) }}" method="POST" class="d-inline">
                            @csrf 
                            @method('DELETE')
                            <button type="submit" class="drive-btn drive-btn-danger" onclick="return confirm('Yakin hapus motif ini?')">Hapus</button>
                        </form>
                    </div>
                </div>

                <div class="motif-attrs">
                    <div class="motif-attr">
                        <div>
                            <span class="attr-label">Simbol</span>
                            <span class="attr-value">{{ $motif->simbol ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="motif-attr">
                        <div>
                            <span class="attr-label">Penempatan</span>
                            <span class="attr-value">{{ $motif->penempatan ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="motif-attr">
                        <div>
                            <span class="attr-label">Peruntukan</span>
                            <span class="attr-value">{{ ucfirst($motif->peruntukan ?? '-') }}</span>
                        </div>
                    </div>

                    <div class="motif-attr">
                        <div>
                            <span class="attr-label">Asal Daerah</span>
                            <span class="attr-value">{{ $motif->asal_daerah ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="motif-attr">
                        <div>
                            <span class="attr-label">Sumber</span>
                            <span class="attr-value">{{ $motif->sumber ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="motif-attr">
                        <div>
                            <span class="attr-label">Arah Penggunaan</span>
                            <span class="attr-value">{{ $motif->arah_penggunaan ?? '-' }}</span>
                        </div>
                    </div>
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

                @if($motif->deskripsi)
                    <div class="admin-deskripsi-box">
                        <span class="tag-label">Deskripsi</span>
                        <p class="motif-product-desc">{{ $motif->deskripsi }}</p>
                    </div>
                @endif
            </div>
        </div>
        @empty
        <div class="empty-state">
            Belum ada motif untuk kain ini. <a href="{{ route('admin.motif.create', ['id_kain' => $kain->id_kain]) }}">Tambah sekarang</a>
        </div>
        @endforelse
    </div>
</section>

@push('styles')
<style>
    /* HERO ADMIN */
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

    .back-link {
        text-decoration: none;
        color: var(--text-muted);
        font-size: 13px;
        transition: color 0.2s;
    }
    .back-link:hover { color: var(--sage-dark); }

    .kain-hero-content {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-top: 20px;
        gap: 24px;
    }

    .kain-hero-info { flex: 1; }

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
        font-size: 40px;
        font-weight: 600;
        color: var(--text-dark);
        line-height: 1.1;
        margin-bottom: 16px;
    }

    .kain-divider {
        width: 48px;
        height: 3px;
        background: var(--sage);
        border-radius: 2px;
    }

    .admin-actions {
        display: flex;
        gap: 12px;
        margin-bottom: 4px;
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
        border-bottom: 2px solid var(--cream-dark);
    }

    .motif-section-title {
        font-family: 'Playfair Display', serif;
        font-size: 24px;
        font-weight: 600;
        color: var(--text-dark);
    }

    .motif-section-count {
        font-size: 13px;
        color: var(--text-muted);
    }

    /* CARD STRUCTURE */
    .motif-product-card {
        display: flex;
        gap: 0;
        margin-bottom: 40px;
        background: var(--cream);
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 16px rgba(0,0,0,0.06);
    }

    .motif-product-image {
        width: 260px;
        flex-shrink: 0;
        display: flex;
        flex-direction: column;
        background: var(--cream);
    }

    .motif-product-image img {
        width: 100%;
        height: 240px;
        object-fit: cover;
    }

    .no-img-motif {
        width: 100%;
        height: 240px;
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

    /* BUTTONS */
    .drive-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        background: var(--sage);
        color: var(--white);
        text-decoration: none;
        font-size: 12px;
        border-radius: 4px;
        transition: background 0.2s;
        justify-content: center;
        border: 1px solid transparent;
        cursor: pointer;
        font-weight: 500;
    }
    .drive-btn:hover { background: var(--sage-dark); color: var(--white); }

    .drive-btn-outline {
        background: transparent;
        border: 1px solid var(--sage);
        color: var(--sage-dark);
    }
    .drive-btn-outline:hover { background: var(--sage); color: var(--white); }

    .drive-btn-danger {
        background: #e53935;
    }
    .drive-btn-danger:hover { background: #b71c1c; }

    /* CARD INFO & DATA HEADER */
    .motif-product-info {
        flex: 1;
        padding: 32px 36px;
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .admin-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
    }

    .admin-action-trigger {
        display: flex;
        gap: 8px;
    }

    .motif-number {
        font-size: 11px;
        color: var(--sage);
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 700;
        display: block;
        margin-bottom: 4px;
    }

    .motif-product-name {
        font-family: 'Playfair Display', serif;
        font-size: 22px;
        font-weight: 600;
        color: var(--text-dark);
    }

    /* GRID ATTRIBUTES */
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
        border: 1px solid rgba(0,0,0,0.02);
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
    }

    /* TAGS */
    .motif-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        padding-top: 20px;
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

    .motif-tag-alami { background: #E8F5E9; color: #2E7D32; border-color: #C8E6C9; }
    .motif-tag-buatan { background: #FFF3E0; color: #E65100; border-color: #FFE0B2; }

    /* DESKRIPSI BOX */
    .admin-deskripsi-box {
        display: flex;
        flex-direction: column;
        gap: 6px;
        padding-top: 16px;
        border-top: 1px solid var(--cream-dark);
    }

    .motif-product-desc {
        font-size: 13px;
        color: var(--text-muted);
        line-height: 1.7;
    }

    .empty-state {
        text-align: center;
        padding: 80px 0;
        color: var(--text-muted);
        font-size: 14px;
    }
    .empty-state a { color: var(--sage-dark); text-decoration: none; font-weight: 500; }

    /* RESPONSIVE DESIGN */
    @media (max-width: 768px) {
        .kain-hero-inner { padding: 24px 20px 36px; }
        .kain-hero-content { flex-direction: column; align-items: flex-start; gap: 20px; }
        .kain-title { font-size: 30px; }
        .motif-section-inner { padding: 0 20px; }
        .motif-product-card { flex-direction: column; }
        .motif-product-image { width: 100%; }
        .motif-product-info { padding: 20px; }
        .admin-card-header { flex-direction: column; gap: 12px; }
        .motif-attrs { grid-template-columns: 1fr; }
    }
</style>
@endpush

@endsection