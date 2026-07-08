<?php

namespace App\Http\Controllers;

use App\Models\Simetris;
use Illuminate\Http\Request;

class SimetrisController extends Controller
{
    public function index()
    {
        $items = Simetris::withCount('motifs')->get();
        return view('admin.simetris.index', compact('items'));
    }

    public function create()
    {
        return view('admin.simetris.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:simetris,nama',
        ]);

        Simetris::create(['nama' => strtolower($request->nama)]);
        return redirect()->route('admin.simetris.index')->with('success', 'Simetris berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $item = Simetris::findOrFail($id);
        return view('admin.simetris.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:simetris,nama,' . $id,
        ]);

        Simetris::findOrFail($id)->update(['nama' => strtolower($request->nama)]);
        return redirect()->route('admin.simetris.index')->with('success', 'Simetris berhasil diupdate!');
    }

    public function destroy($id)
    {
        $item = Simetris::findOrFail($id);
        if ($item->motifs()->count() > 0) {
            return redirect()->route('admin.simetris.index')->with('error', 'Simetris tidak bisa dihapus karena masih digunakan!');
        }
        $item->delete();
        return redirect()->route('admin.simetris.index')->with('success', 'Simetris berhasil dihapus!');
    }
}