@extends('layouts.admin')

@section('title', 'Simetris')

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Simetris</h1>
        <p class="page-subtitle">Kelola data simetris motif</p>
    </div>
    <a href="{{ route('admin.simetris.create') }}" class="btn-sage">+ Tambah Simetris</a>
</div>

<div class="table-wrapper">
    <table class="admin-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Simetris</th>
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
                        <a href="{{ route('admin.simetris.edit', $item->id) }}" class="btn-warning-custom">Edit</a>
                        <form action="{{ route('admin.simetris.destroy', $item->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-danger-custom" onclick="return confirm('Yakin hapus?')">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align:center; padding:40px; color:var(--text-muted);">Belum ada data simetris</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<style>
    .table-wrapper { background: var(--white); padding: 24px; border-radius: 4px; }
</style>

@endsection
