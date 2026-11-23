<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Fasilitas;

class AdminFasilitasController extends Controller
{
    public function index()
    {
        $fasilitas = Fasilitas::latest()->get();
        return view('admin.fasilitas', compact('fasilitas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5048',
            'deskripsi' => 'required|string',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('fasilitas-foto', 'public');
        }

        Fasilitas::create([
            'nama' => $request->nama,
            'kategori' => $request->kategori,
            'foto' => $fotoPath,
            'deskripsi' => $request->deskripsi,
        ]);

        return back()->with('success', 'Data galeri / fasilitas berhasil disimpan ke database!');
    }

    public function destroy($id)
    {
        $item = Fasilitas::findOrFail($id);

        if ($item->foto && Storage::disk('public')->exists($item->foto)) {
            Storage::disk('public')->delete($item->foto);
        }

        $item->delete();

        return back()->with('success', 'Data galeri / fasilitas berhasil dihapus.');
    }
}