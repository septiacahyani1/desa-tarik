<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;

class PengaduanPublikController extends Controller
{
    public function create()
    {
        $pengaduans = Pengaduan::latest()->get();
        return view('pengaduan', compact('pengaduans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('pengaduan-foto', 'public');
        }

        Pengaduan::create([
            'nama' => $request->nama,
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'foto' => $fotoPath,
            'status' => 'Menunggu',
            'tanggapan' => '',
            'foto_tanggapan' => null,
        ]);

        return redirect('/pengaduan')->with('success', 'Laporan berhasil dikirim! Perangkat desa akan segera meninjau laporan Anda.');
    }
}