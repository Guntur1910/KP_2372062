@extends('layouts.admin')

@section('title', 'Tambah Motif')

@section('content')

<a href="{{ route('admin.dashboard') }}" class="back-link-admin">← Kembali ke Dashboard</a>

<div class="page-header">
    <div>
        <h1 class="page-title">Tambah Motif</h1>
        <p class="page-subtitle">Tambahkan data motif kain tenun</p>
    </div>
</div>

<div class="form-card">
    @if($errors->any())
        <div class="alert-error-custom">{{ $errors->first() }}</div>
    @endif

    <form action="{{ route('admin.motif.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 20px;">
            <span style="color: var(--danger);">*</span> Wajib diisi
        </p>
        <div class="form-group">
            <label>Kain <span style="color: var(--danger);">*</span></label>
            <select name="id_kain" required>
                <option value="">-- Pilih Kain --</option>
                @foreach($kains as $kain)
                    <option value="{{ $kain->id_kain }}" {{ request('id_kain') == $kain->id_kain || old('id_kain') == $kain->id_kain ? 'selected' : '' }}>
                        {{ $kain->nama_kain }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Nama Motif <span style="color: var(--danger);">*</span></label>
            <input type="text" name="nama_motif" value="{{ old('nama_motif') }}" placeholder="Contoh: Motif Ayam Jantan" required>
        </div>

        <div class="form-group">
            <label>Gambar</label>
            <input type="file" name="gambar" accept="image/*">
            <small>Format JPG/PNG, maksimal 2MB</small>
        </div>

        <div class="form-group">
            <label>Link Drive (Gambar Utuh)</label>
            <input type="url" name="link_drive_utuh" value="{{ old('link_drive_utuh') }}" placeholder="https://drive.google.com/...">
        </div>

        <div class="form-group">
            <label>Link Drive (Gambar Vektor)</label>
            <input type="url" name="link_drive_vektor" value="{{ old('link_drive_vektor') }}" placeholder="https://drive.google.com/...">
        </div>

        <div class="form-group">
            <label>Simbol</label>
            <input type="text" name="simbol" value="{{ old('simbol') }}" placeholder="Simbol yang terkandung dalam motif">
        </div>

        <div class="form-group">
            <label>Penempatan</label>
            <input type="text" name="penempatan" value="{{ old('penempatan') }}" placeholder="Penempatan motif pada kain">
        </div>

        <div class="form-group">
            <label>Sumber</label>
            <input type="text" name="sumber" value="{{ old('sumber') }}" placeholder="Sumber referensi">
        </div>

        <div class="form-group">
            <label>Peruntukan</label>
            <select name="peruntukan">
                <option value="">-- Pilih Peruntukan --</option>
                <option value="raja" {{ old('peruntukan') == 'raja' ? 'selected' : '' }}>Raja</option>
                <option value="ratu" {{ old('peruntukan') == 'ratu' ? 'selected' : '' }}>Ratu</option>
                <option value="umum" {{ old('peruntukan') == 'umum' ? 'selected' : '' }}>Umum</option>
            </select>
        </div>

        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" placeholder="Deskripsi motif">{{ old('deskripsi') }}</textarea>
        </div>

        <div class="form-group">
            <label>Arah Penggunaan</label>
            <input type="text" name="arah_penggunaan" value="{{ old('arah_penggunaan') }}" placeholder="Arah penggunaan motif">
        </div>

        <div class="form-group">
            <label>Bentuk Geometri</label>
            <input type="text" name="bentuk_geometri" value="{{ old('bentuk_geometri') }}" placeholder="Bentuk geometri motif">
        </div>

        <div class="form-group">
            <label>Tarikan Visual</label>
            <select name="tarikan_visual_id">
                <option value="">-- Pilih Tarikan Visual --</option>
                @foreach($tarikanVisuals as $tv)
                    <option value="{{ $tv->id }}" {{ old('tarikan_visual_id') == $tv->id ? 'selected' : '' }}>
                        {{ ucfirst($tv->nama) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Simetris</label>
            <select name="simetris_id">
                <option value="">-- Pilih Simetris --</option>
                @foreach($simetrisList as $s)
                    <option value="{{ $s->id }}" {{ old('simetris_id') == $s->id ? 'selected' : '' }}>
                        {{ ucfirst($s->nama) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Asal Daerah</label>
            <input type="text" name="asal_daerah" value="{{ old('asal_daerah') }}" placeholder="Contoh: Sumba Barat">
        </div>

        <div class="form-group">
            <label>Pewarna</label>
            <select name="pewarna">
                <option value="">-- Pilih Pewarna --</option>
                <option value="buatan" {{ old('pewarna') == 'buatan' ? 'selected' : '' }}>Buatan</option>
                <option value="alami" {{ old('pewarna') == 'alami' ? 'selected' : '' }}>Alami</option>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-sage">Simpan</button>
            <a href="{{ route('admin.dashboard') }}" class="btn-outline-sage">Batal</a>
        </div>
    </form>
</div>

@endsection