<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;

class AdminPengaduanController extends Controller
{
    // Mengupdate status, tanggapan, dan foto bukti penanganan dari modal dashboard admin
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
            'tanggapan' => 'nullable|string',
            'foto_tanggapan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5048',
        ]);

        $pengaduan = Pengaduan::findOrFail($id);

        // Ambil path foto lama jika sudah ada
        $fotoTanggapanPath = $pengaduan->foto_tanggapan;

        // Cek apakah admin mengunggah foto bukti penanganan baru
        if ($request->hasFile('foto_tanggapan')) {
            $fotoTanggapanPath = $request->file('foto_tanggapan')->store('tanggapan-foto', 'public');
        }

        // Perbarui data ke dalam database
        $pengaduan->update([
            'status' => $request->status,
            'tanggapan' => $request->tanggapan ?? '',
            'foto_tanggapan' => $fotoTanggapanPath,
        ]);

        return back()->with('success', 'Tindak lanjut laporan berhasil disimpan dan dipublikasikan!');
    }
}