<?php

namespace App\Http\Controllers;

use App\Models\Kain;
use App\Models\Motif;
use App\Models\JenisMotif;
use App\Models\TarikanVisual;
use App\Models\Simetris;
use Illuminate\Http\Request;

class KainController extends Controller
{
    public function index(Request $request)
    {
        $kains = Kain::with('motifs')->get();

        $query = Motif::with(['kain.jenisMotif']);

        if ($request->filled('jenis')) {
            $query->whereHas('kain', function($q) use ($request) {
                $q->where('jenis_motif_id', $request->jenis); 
            });
        }

        if ($request->filled('tarikan_visual')) {
            $query->where('tarikan_visual_id', $request->tarikan_visual);
        }

        if ($request->filled('simetris')) {
            $query->where('simetris_id', $request->simetris);
        }

        if ($request->filled('search')) {
            $query->where('nama_motif', 'like', '%' . $request->search . '%');
        }

        $motifs          = $query->get();
        $jenisMotifs     = JenisMotif::all();
        $tarikanVisuals  = TarikanVisual::all();
        $simetrisOptions = Simetris::all();
        $searchQuery     = $request->search ?? '';
        $activeJenis     = $request->jenis ?? '';
        $activeTarikan   = $request->tarikan_visual ?? '';
        $activeSimetris  = $request->simetris ?? '';

        return view('user.home', compact(
            'kains', 'motifs', 'jenisMotifs',
            'tarikanVisuals', 'simetrisOptions',
            'searchQuery', 'activeJenis', 'activeTarikan', 'activeSimetris'
        ));
    }

    public function show($id)
    {
        $kain = Kain::with(['motifs.tarikanVisual', 'motifs.simetris'])->findOrFail($id);
        return view('user.kain-detail', compact('kain'));
    }

    public function adminIndex()
    {
        $kains = Kain::with(['motifs', 'jenisMotif'])->get();
        $jenisMotifs = JenisMotif::all();
        return view('admin.dashboard', compact('kains', 'jenisMotifs'));
    }

    public function create()
    {
        $jenisMotifs = JenisMotif::all();
        return view('admin.kain.create', compact('jenisMotifs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kain' => 'required|string|max:255',
            'jenis_motif_id' => 'required|exists:jenis_motif,id',
        ]);

        Kain::create($request->only('nama_kain', 'jenis_motif_id'));
        return redirect()->route('admin.dashboard')->with('success', 'Kain berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $kain = Kain::findOrFail($id);
        $jenisMotifs = JenisMotif::all();
        return view('admin.kain.edit', compact('kain', 'jenisMotifs'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kain' => 'required|string|max:255',
            'jenis_motif_id' => 'required|exists:jenis_motif,id',
        ]);

        $kain = Kain::findOrFail($id);
        $kain->update($request->only('nama_kain', 'jenis_motif_id'));
        return redirect()->route('admin.dashboard')->with('success', 'Kain berhasil diupdate!');
    }

    public function destroy($id)
    {
        Kain::findOrFail($id)->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Kain berhasil dihapus!');
    }

    public function adminShow($id)
    {
        $kain = Kain::with(['motifs.tarikanVisual', 'motifs.simetris'])->findOrFail($id);
        return view('admin.kain.show', compact('kain'), ['hide_navbar' => true]);
    }
}