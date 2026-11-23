<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Berita;

class AdminBeritaController extends Controller
{
    public function index()
    {
        $beritas = Berita::orderBy('tanggal', 'desc')->latest()->get();
        return view('admin.berita', compact('beritas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'status' => 'required|in:Diterbitkan,Draft',
            'tanggal' => 'required|date',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5048',
            'isi' => 'required|string',
        ]);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('berita-thumbnail', 'public');
        }

        $slugBase = Str::slug($request->judul);
        $slug = ($slugBase ?: 'berita') . '-' . time();

        Berita::create([
            'judul' => $request->judul,
            'slug' => $slug,
            'kategori' => $request->kategori,
            'status' => $request->status,
            'thumbnail' => $thumbnailPath,
            'isi' => $request->isi,
            'tanggal' => $request->tanggal,
        ]);

        return back()->with('success', 'Berita / pengumuman berhasil disimpan ke database!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'status' => 'required|in:Diterbitkan,Draft',
            'tanggal' => 'required|date',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5048',
            'isi' => 'required|string',
        ]);

        $berita = Berita::findOrFail($id);
        $thumbnailPath = $berita->thumbnail;

        if ($request->hasFile('thumbnail')) {
            if ($berita->thumbnail && Storage::disk('public')->exists($berita->thumbnail)) {
                Storage::disk('public')->delete($berita->thumbnail);
            }
            $thumbnailPath = $request->file('thumbnail')->store('berita-thumbnail', 'public');
        }

        $berita->update([
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'status' => $request->status,
            'thumbnail' => $thumbnailPath,
            'isi' => $request->isi,
            'tanggal' => $request->tanggal,
        ]);

        return back()->with('success', 'Berita / pengumuman berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);

        if ($berita->thumbnail && Storage::disk('public')->exists($berita->thumbnail)) {
            Storage::disk('public')->delete($berita->thumbnail);
        }

        $berita->delete();

        return back()->with('success', 'Berita / pengumuman berhasil dihapus.');
    }
}