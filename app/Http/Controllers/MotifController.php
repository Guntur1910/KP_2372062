<?php

namespace App\Http\Controllers;

use App\Models\Motif;
use App\Models\Kain;
use App\Models\TarikanVisual;
use App\Models\Simetris;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MotifController extends Controller
{
    public function index()
    {
        return redirect()->route('admin.dashboard');
    }

    public function show($id)
    {
        $motif = Motif::with('kain')->findOrFail($id);
        return view('user.motif-detail', compact('motif'));
    }

    public function create()
    {
        $kains = Kain::all();
        $tarikanVisuals = TarikanVisual::all();
        $simetrisList = Simetris::all();
        return view('admin.motif.create', compact('kains', 'tarikanVisuals', 'simetrisList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kain' => 'required|exists:kain,id_kain',
            'nama_motif' => 'required|string|max:255',
            'gambar' => 'nullable|image|max:2048',
            'link_drive_utuh' => 'nullable|url',
            'link_drive_vektor' => 'nullable|url',
            'peruntukan' => 'nullable|in:raja,ratu,umum',
            'tarikan_visual_id' => 'nullable|exists:tarikan_visual,id',
            'simetris_id' => 'nullable|exists:simetris,id',
            'pewarna' => 'nullable|in:buatan,alami',
        ]);

        $data = $request->except('gambar');

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('motif', 'public');
        }

        Motif::create($data);
        return redirect()->route('admin.dashboard')->with('success', 'Motif berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $motif = Motif::findOrFail($id);
        $kains = Kain::all();
        $tarikanVisuals = TarikanVisual::all();
        $simetrisList = Simetris::all();
        return view('admin.motif.edit', compact('motif', 'kains', 'tarikanVisuals', 'simetrisList'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_kain' => 'required|exists:kain,id_kain',
            'nama_motif' => 'required|string|max:255',
            'gambar' => 'nullable|image|max:2048',
            'link_drive_utuh' => 'nullable|url',
            'link_drive_vektor' => 'nullable|url',
            'peruntukan' => 'nullable|in:raja,ratu,umum',
            'tarikan_visual' => 'nullable|in:garis,garis dan lengkung',
            'simetris' => 'nullable|in:bilateral,tidak simetris',
            'pewarna' => 'nullable|in:buatan,alami',
        ]);

        $motif = Motif::findOrFail($id);
        $data = $request->except('gambar');

        if ($request->hasFile('gambar')) {
            if ($motif->gambar) {
                Storage::disk('public')->delete($motif->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('motif', 'public');
        }

        $motif->update($data);
        return redirect()->route('admin.dashboard')->with('success', 'Motif berhasil diupdate!');
    }

    public function destroy($id)
    {
        $motif = Motif::findOrFail($id);
        if ($motif->gambar) {
            Storage::disk('public')->delete($motif->gambar);
        }
        $motif->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Motif berhasil dihapus!');
    }
}