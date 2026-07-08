<?php

namespace App\Http\Controllers;

use App\Models\JenisMotif;
use Illuminate\Http\Request;

class JenisMotifController extends Controller
{
    public function index()
    {
        $jenisMotifs = JenisMotif::withCount('kains')->get();
        return view('admin.jenis_motif.index', compact('jenisMotifs'));
    }

    public function create()
    {
        return view('admin.jenis_motif.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:jenis_motif,nama',
        ]);

        JenisMotif::create(['nama' => strtolower($request->nama)]);
        return redirect()->route('admin.jenis-motif.index')->with('success', 'Jenis motif berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $jenisMotif = JenisMotif::findOrFail($id);
        return view('admin.jenis_motif.edit', compact('jenisMotif'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:jenis_motif,nama,' . $id,
        ]);

        $jenisMotif = JenisMotif::findOrFail($id);
        $jenisMotif->update(['nama' => strtolower($request->nama)]);
        return redirect()->route('admin.jenis-motif.index')->with('success', 'Jenis motif berhasil diupdate!');
    }

    public function destroy($id)
    {
        $jenisMotif = JenisMotif::findOrFail($id);
        if ($jenisMotif->kains()->count() > 0) {
            return redirect()->route('admin.jenis-motif.index')->with('error', 'Jenis motif tidak bisa dihapus karena masih digunakan!');
        }
        $jenisMotif->delete();
        return redirect()->route('admin.jenis-motif.index')->with('success', 'Jenis motif berhasil dihapus!');
    }
}