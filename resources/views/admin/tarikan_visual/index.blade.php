@extends('layouts.admin')

@section('title', 'Tarikan Visual')

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Tarikan Visual</h1>
        <p class="page-subtitle">Kelola data tarikan visual motif</p>
    </div>
    <a href="{{ route('admin.tarikan-visual.create') }}" class="btn-sage">+ Tambah Tarikan Visual</a>
</div>

<div class="table-wrapper">
    <table class="admin-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Tarikan Visual</th>
                <th>Jumlah Motif</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ ucfirst($item->nama) }}</td>
                <td>{{ $item->motifs_count }}</td>
                <td>
                    <div class="action-buttons">
                        <a href="{{ route('admin.tarikan-visual.edit', $item->id) }}" class="btn-warning-custom">Edit</a>
                        <form action="{{ route('admin.tarikan-visual.destroy', $item->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-danger-custom" onclick="return confirm('Yakin hapus?')">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align:center; padding:40px; color:var(--text-muted);">Belum ada data tarikan visual</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<style>
    .table-wrapper { background: var(--white); padding: 24px; border-radius: 4px; }
</style>

@endsection
