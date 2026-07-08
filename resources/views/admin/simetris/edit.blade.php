@extends('layouts.admin')

@section('title', 'Edit Simetris')

@section('content')

<a href="{{ route('admin.simetris.index') }}" class="back-link-admin">← Kembali</a>

<div class="page-header">
    <div>
        <h1 class="page-title">Edit Simetris</h1>
        <p class="page-subtitle">Ubah nama simetris</p>
    </div>
</div>

<div class="form-card">
    @if($errors->any())
        <div class="alert-error-custom">{{ $errors->first() }}</div>
    @endif

    <form action="{{ route('admin.simetris.update', $item->id) }}" method="POST">
        @csrf @method('PUT')
        <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 20px;">
            <span style="color: var(--danger);">*</span> Wajib diisi
        </p>
        <div class="form-group">
            <label>Nama Simetris <span style="color: var(--danger);">*</span></label></label>
            <input type="text" name="nama" value="{{ old('nama', $item->nama) }}" required>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn-sage">Update</button>
            <a href="{{ route('admin.simetris.index') }}" class="btn-outline-sage">Batal</a>
        </div>
    </form>
</div>

@endsection
