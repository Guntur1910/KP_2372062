@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Dashboard Admin</h1>
        <p class="page-subtitle">Kelola data kain tenun Sumba</p>
    </div>
    <div style="display:flex; gap:10px;">
        <a href="{{ route('admin.kain.create') }}" class="btn-sage">+ Tambah Kain</a>
    </div>
</div>

<p class="section-label">Data Kain</p>
{{-- CATEGORY CARDS --}}
@php
    $icons = [
        'fauna'     => 'ikon_fauna.png', 
        'flora'     => 'ikon_flora.png',
        'manusia'   => 'ikon_manusia.png',
        'geometrik' => 'ikon_geo.png',
    ];
@endphp

<div class="category-grid">
    @foreach($jenisMotifs as $jenis)
    @php $count = $kains->where('jenis_motif_id', $jenis->id)->count(); @endphp
    <a href="{{ route('admin.dashboard') }}?jenis={{ $jenis->id }}" class="category-card {{ request('jenis') == $jenis->id ? 'active' : '' }}">
        <div class="category-card-top">
            <div class="category-count">{{ $count }}</div>
            @if(isset($icons[$jenis->nama]))
                <img src="{{ asset('images/' . $icons[$jenis->nama]) }}" alt="{{ $jenis->nama }}" class="category-icon">
            @else
                <div class="category-icon-placeholder">{{ strtoupper(substr($jenis->nama, 0, 1)) }}</div>
            @endif
        </div>
        <div class="category-label">{{ ucfirst($jenis->nama) }}</div>
        <div class="category-footer">
            Tampilkan <span>→</span>
        </div>
    </a>
    @endforeach
</div>

{{-- CHARTS --}}
<div class="charts-grid">
    <div class="chart-card">
        <h5 class="chart-title" id="barChartTitle" style="margin-top: 24px;">Jumlah Kain per Jenis Motif</h5>
        <canvas id="barChart2"></canvas>
        <h5 class="chart-title" id="barChartTitle" >Jumlah Motif per Kain (Top 10)</h5>
        <canvas id="barChart"></canvas>
    </div>
    <div class="chart-card">
        <h5 class="chart-title" id="barChartTitle" >Distribusi Kain per Jenis Motif</h5>
        <canvas id="pieChart"></canvas>
    </div>
</div>

{{-- TABLE --}}
@php
    $filtered = request('jenis') ? $kains->where('jenis_motif_id', request('jenis')) : $kains;
    $activeJenis = request('jenis') ? $jenisMotifs->firstWhere('id', request('jenis')) : null;
@endphp

<div class="table-wrapper">
    <div class="section-header" style="margin-bottom: 16px;">
        <h5>
            @if($activeJenis)
                Kain {{ ucfirst($activeJenis->nama) }}
            @else
                Semua Kain
            @endif
        </h5>
        @if($activeJenis)
            <a href="{{ route('admin.dashboard') }}" class="btn-outline-sage">Lihat Semua</a>
        @endif
    </div>

    <table class="admin-table" id="kainTable">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kain</th>
                <th>Jenis Motif</th>
                <th>Jumlah Motif</th>
                <th>Aksi</th>
                <th style="display:none;">jenis_id</th>
            </tr>
        </thead>
        <tbody>
            @forelse($filtered as $item)
            <tr style="cursor:pointer" onclick="window.location='{{ route('admin.kain.detail', $item->id_kain) }}'">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->nama_kain }}</td>
                <td><span class="badge-motif">{{ ucfirst($item->jenisMotif->nama ?? '-') }}</span></td>
                <td>{{ $item->motifs->count() }}</td>
                <td onclick="event.stopPropagation()">
                    <div class="action-buttons">
                        <a href="{{ route('admin.motif.create', ['id_kain' => $item->id_kain]) }}" class="btn-outline-sage">+ Motif</a>
                        <a href="{{ route('admin.kain.edit', $item->id_kain) }}" class="btn-warning-custom">Edit</a>
                        <form action="{{ route('admin.kain.destroy', $item->id_kain) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-danger-custom" onclick="return confirm('Yakin hapus?')">Hapus</button>
                        </form>
                    </div>
                </td>
                <td style="display:none;">{{ $item->jenis_motif_id }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center; padding:40px; color:var(--text-muted);">Belum ada data kain</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    // Data semua kain
    const allKainData = [
        @foreach($kains->sortByDesc(fn($k) => $k->motifs->count()) as $kain)
        { name: '{{ addslashes($kain->nama_kain) }}', count: {{ $kain->motifs->count() }}, jenisId: {{ $kain->jenis_motif_id ?? 'null' }} },
        @endforeach
    ];

    const jenisIds = [@foreach($jenisMotifs as $jenis){{ $jenis->id }},@endforeach];
    const defaultColors = ['#7A8C6E', '#5C6E52', '#A4B494', '#EDE6D6'];
    const getTop10 = (data) => data.slice(0, 10);

    // Pie Chart
    const pieCtx = document.getElementById('pieChart');
    const pieChart = new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: [@foreach($jenisMotifs as $jenis)'{{ ucfirst($jenis->nama) }}',@endforeach],
            datasets: [{
                data: [@foreach($jenisMotifs as $jenis){{ $kains->where('jenis_motif_id', $jenis->id)->count() }},@endforeach],
                backgroundColor: ['#7A8C6E', '#5C6E52', '#A4B494', '#EDE6D6']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom', labels: { font: { family: 'Lato' } } }
            }
        }
    });

    // Bar Chart 2 - Jumlah Kain per Jenis Motif
    const barCtx2 = document.getElementById('barChart2');
    const barChart2 = new Chart(barCtx2, {
        type: 'bar',
        data: {
            labels: [@foreach($jenisMotifs as $jenis)'{{ ucfirst($jenis->nama) }}',@endforeach],
            datasets: [{
                label: 'Jumlah Kain',
                data: [@foreach($jenisMotifs as $jenis){{ $kains->where('jenis_motif_id', $jenis->id)->count() }},@endforeach],
                backgroundColor: '#5C6E52'
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });

    // Bar Chart - Jumlah Motif per Kain (Top 10)
    const barCtx = document.getElementById('barChart');
    const barChart = new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: getTop10(allKainData).map(k => k.name),
            datasets: [{
                label: 'Jumlah Motif',
                data: getTop10(allKainData).map(k => k.count),
                backgroundColor: '#7A8C6E'
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });

    // DataTable
    const table = new DataTable('#kainTable', {
        pageLength: 10,
        columnDefs: [
            { orderable: false, targets: 4 },
            { visible: false, targets: 5 }
        ],
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Tidak ada data",
            zeroRecords: "Data tidak ditemukan",
            emptyTable: "Belum ada data kain",
            paginate: { first: "Pertama", last: "Terakhir", next: "›", previous: "‹" }
        }
    });

    document.querySelectorAll('.category-card').forEach(card => {
        card.addEventListener('click', function(e) {
            e.preventDefault();

            const url = new URL(this.href);
            const jenisId = url.searchParams.get('jenis');
            const jenisLabel = this.querySelector('.category-label').textContent.trim();
            const isActive = this.classList.contains('active');

            document.querySelectorAll('.category-card').forEach(c => c.classList.remove('active'));

            let activeJenisId = null;
            let activeLabel = null;

            if (!isActive) {
                this.classList.add('active');
                activeJenisId = jenisId;
                activeLabel = jenisLabel;
            }

            let filtered = activeJenisId
                ? allKainData.filter(k => k.jenisId == activeJenisId)
                : allKainData;
            filtered = filtered.sort((a, b) => b.count - a.count);

            barChart.data.labels = getTop10(filtered).map(k => k.name);
            barChart.data.datasets[0].data = getTop10(filtered).map(k => k.count);
            barChart.update();

            document.getElementById('barChartTitle').textContent = activeJenisId
                ? `Jumlah Motif per Kain - ${activeLabel} (Top 10)`
                : 'Jumlah Motif per Kain (Top 10)';

            barChart2.data.datasets[0].backgroundColor = jenisIds.map(id =>
                activeJenisId ? (id == activeJenisId ? '#5C6E52' : '#C8D5C0') : '#5C6E52'
            );
            barChart2.update();

            pieChart.data.datasets[0].backgroundColor = jenisIds.map((id, index) =>
                activeJenisId ? (id == activeJenisId ? '#5C6E52' : '#D8E4D0') : defaultColors[index]
            );
            pieChart.update();

            if (activeJenisId) {
                table.column(5).search(activeJenisId).draw();
            } else {
                table.column(5).search('').draw();
            }
        });
    });

});
</script>
@endpush

<style>
    .section-label {
        font-size: 13px;
        font-weight: 700;
        color: var(--text-muted);
        letter-spacing: 0.5px;
        text-transform: uppercase;
        margin-bottom: 16px;
    }

    .chart-card-full {
    margin-bottom: 28px;
    }

    .category-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 36px;
    }

    .category-card {
        background: var(--sage);
        border-radius: 12px;
        overflow: hidden;
        text-decoration: none;
        display: flex;
        flex-direction: column;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .category-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(0,0,0,0.15);
    }

    .category-card.active {
        background: var(--sage-dark);
        box-shadow: 0 0 0 3px var(--sage-dark);
    }

    .category-card-top {
        padding: 24px 24px 12px;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .category-count {
        font-family: 'Playfair Display', serif;
        font-size: 42px;
        font-weight: 600;
        color: var(--white);
        line-height: 1;
    }

    .category-icon {
        width: 64px;
        height: 64px;
        object-fit: contain;
        opacity: 0.4;
        filter: brightness(10);
    }

    .category-icon-placeholder {
        width: 64px;
        height: 64px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        font-weight: 700;
        color: rgba(255,255,255,0.4);
        font-family: 'Playfair Display', serif;
    }

    .category-label {
        padding: 0 24px 16px;
        font-size: 18px;
        font-weight: 400;
        color: var(--white);
        font-family: 'Playfair Display', serif;
    }

    .category-footer {
        background: var(--sage-dark);
        padding: 10px 24px;
        font-size: 12px;
        color: rgba(255,255,255,0.8);
        letter-spacing: 0.3px;
        margin-top: auto;
    }

    .category-card.active .category-footer {
        background: rgba(0,0,0,0.2);
    }

    .table-wrapper {
        background: var(--white);
        padding: 24px;
        border-radius: 4px;
    }

    @media (max-width: 768px) {
        .category-grid { grid-template-columns: repeat(2, 1fr); }
    }

    .summary-cards {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-bottom: 28px;
    }

    .summary-card {
        background: var(--white);
        border-radius: 8px;
        padding: 20px 24px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        border-left: 4px solid var(--sage);
    }

    .summary-card-warning {
        border-left-color: var(--danger);
    }

    .summary-icon img {
        width: 40px;
        height: 40px;
        object-fit: contain;
        opacity: 0.75;
        filter: brightness(0) saturate(100%) invert(34%) sepia(11%) saturate(930%) hue-rotate(63deg) brightness(97%) contrast(88%);
    }

    .summary-info {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .summary-number {
        font-family: 'Playfair Display', serif;
        font-size: 32px;
        font-weight: 600;
        color: var(--text-dark);
        line-height: 1;
    }

    .summary-label {
        font-size: 12px;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .charts-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 28px;
    }

    .chart-card {
        background: var(--white);
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }

    .chart-title {
        font-family: 'Playfair Display', serif;
        font-size: 15px;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 16px;
    }

    @media (max-width: 768px) {
        .charts-grid { grid-template-columns: 1fr; }
    }
</style>

@endsection