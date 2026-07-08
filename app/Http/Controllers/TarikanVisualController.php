<?php

namespace App\Http\Controllers;

use App\Models\TarikanVisual;
use Illuminate\Http\Request;

class TarikanVisualController extends Controller
{
    public function index()
    {
        $items = TarikanVisual::withCount('motifs')->get();
        return view('admin.tarikan_visual.index', compact('items'));
    }

    public function create()
    {
        return view('admin.tarikan_visual.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:tarikan_visual,nama',
        ]);

        TarikanVisual::create(['nama' => strtolower($request->nama)]);
        return redirect()->route('admin.tarikan-visual.index')->with('success', 'Tarikan visual berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $item = TarikanVisual::findOrFail($id);
        return view('admin.tarikan_visual.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:tarikan_visual,nama,' . $id,
        ]);

        TarikanVisual::findOrFail($id)->update(['nama' => strtolower($request->nama)]);
        return redirect()->route('admin.tarikan-visual.index')->with('success', 'Tarikan visual berhasil diupdate!');
    }

    public function destroy($id)
    {
        $item = TarikanVisual::findOrFail($id);
        if ($item->motifs()->count() > 0) {
            return redirect()->route('admin.tarikan-visual.index')->with('error', 'Tarikan visual tidak bisa dihapus karena masih digunakan!');
        }
        $item->delete();
        return redirect()->route('admin.tarikan-visual.index')->with('success', 'Tarikan visual berhasil dihapus!');
    }
}