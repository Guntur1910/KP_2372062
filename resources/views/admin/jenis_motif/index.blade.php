@extends('layouts.admin')

@section('title', 'Jenis Motif')

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Jenis Motif</h1>
        <p class="page-subtitle">Kelola jenis motif kain tenun Sumba</p>
    </div>
    <a href="{{ route('admin.jenis-motif.create') }}" class="btn-sage">+ Tambah Jenis Motif</a>
</div>

<div class="table-wrapper">
    <table class="admin-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Jenis Motif</th>
                <th>Jumlah Kain</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jenisMotifs as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ ucfirst($item->nama) }}</td>
                <td>{{ $item->kains_count }}</td>
                <td>
                    <div class="action-buttons">
                        <a href="{{ route('admin.jenis-motif.edit', $item->id) }}" class="btn-warning-custom">Edit</a>
                        <form action="{{ route('admin.jenis-motif.destroy', $item->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-danger-custom" onclick="return confirm('Yakin hapus jenis motif ini?')">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align:center; padding:40px; color:var(--text-muted);">Belum ada jenis motif</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<style>
    .table-wrapper {
        background: var(--white);
        padding: 24px;
        border-radius: 4px;
    }
    .alert-error-custom {
        background: #FDEDEC;
        border-left: 4px solid var(--danger);
        color: var(--danger);
        padding: 12px 20px;
        font-size: 14px;
        margin-bottom: 24px;
        border-radius: 2px;
    }
</style>

@endsection
