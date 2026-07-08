@extends('layouts.admin')

@section('title', 'Tambah Kain')

@section('content')

<a href="{{ route('admin.dashboard') }}" class="back-link-admin">← Kembali ke Dashboard</a>

<div class="page-header">
    <div>
        <h1 class="page-title">Tambah Kain</h1>
        <p class="page-subtitle">Tambahkan data kain tenun baru</p>
    </div>
</div>

<div class="form-card">
    @if($errors->any())
        <div class="alert-error-custom">{{ $errors->first() }}</div>
    @endif

    <form action="{{ route('admin.kain.store') }}" method="POST">
        @csrf
        <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 20px;">
            <span style="color: var(--danger);">*</span> Wajib diisi
        </p>
        <div class="form-group">
            <label>Nama Kain<span style="color: var(--danger);">*</span></label>
            <input type="text" name="nama_kain" value="{{ old('nama_kain') }}" placeholder="Contoh: Kain Ayam" required>
        </div>
        <div class="form-group">
            <label>Jenis Motif<span style="color: var(--danger);">*</span></label>
            <select name="jenis_motif_id" required>
                <option value="">-- Pilih Jenis Motif --</option>
                @foreach($jenisMotifs as $jenis)
                    <option value="{{ $jenis->id }}" {{ old('jenis_motif_id') == $jenis->id ? 'selected' : '' }}>
                        {{ ucfirst($jenis->nama) }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn-sage">Simpan</button>
            <a href="{{ route('admin.dashboard') }}" class="btn-outline-sage">Batal</a>
        </div>
    </form>
</div>

@endsection