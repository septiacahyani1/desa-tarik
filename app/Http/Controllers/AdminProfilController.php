<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\ProfilDesa;

class AdminProfilController extends Controller
{
    private function defaultData(): array
    {
        return [
            'nama_kades' => 'Ifanul Ahmad Irfandi, S.pd.',
            'periode_kades' => 'Kepala Desa Tarik, Periode 2022-2028',
            'foto_kades' => null,
            'sambutan_kades' => 'Selamat datang di portal resmi Desa Tarik. Melalui platform digital ini, kami berdedikasi untuk menghadirkan transparansi informasi publik, mempermudah akses layanan kependudukan secara transparan dari Kantor Desa kami, serta mendukung kemajuan ekonomi dan kesejahteraan seluruh warga.',
            'sejarah' => 'Pada awalnya Desa Tarik merupakan bagian dari wilayah Kerajaan Majapahit yang dipimpin oleh Raden Wijaya. Sekitar delapan abad yang lalu, dari sebuah hutan yang bernama hutan Tarik itu, akhirnya Raden Wijaya membabat hutan yang sangat lebat itu yang kemudian berkembang menjadi kerajaan yang adiluhung, Kerajaan Majapahit.',
            'visi_misi' => 'Mewujudkan Desa Tarik yang Mandiri, Sejahtera, Transparan, dan Berdaya Saing Tinggi Melalui Optimalisasi Pelayanan Publik Berbasis Digital di Wilayah Sidoarjo.',
            'misi_1_judul' => 'Pelayanan Digital & Administrasi Publik',
            'misi_1_deskripsi' => 'Meningkatkan kualitas pelayanan administrasi kependudukan yang cepat, transparan, dan terpadu bagi seluruh warga di Kantor Desa Tarik.',
            'misi_2_judul' => 'Pemerataan Infrastruktur & Fasilitas Dusun',
            'misi_2_deskripsi' => 'Mengembangkan infrastruktur desa yang merata dan berkualitas di keempat dusun (Tempuran, Munggon, Clangap, dan Tarik).',
            'misi_3_judul' => 'Optimalisasi Potensi Ekonomi & Fasilitas Umum',
            'misi_3_deskripsi' => 'Mengoptimalkan pemanfaatan fasilitas strategis desa—seperti Stasiun Tarik, Puskesmas, dan sektor pertanian—untuk ekonomi lokal.',
            'jumlah_rt' => 17,
            'jumlah_rw' => 4,
            'total_penduduk' => '4.636',
            'luas_wilayah' => '158,66',
            'jam_senin_kamis' => '07:00 - 16:00 WIB',
            'jam_jumat' => '07:00 - 16:00 WIB',
            'jam_sabtu_minggu' => 'Tutup',
        ];
    }

    private function getOrCreateProfil(): ProfilDesa
    {
        $profil = ProfilDesa::first();

        if (!$profil) {
            $profil = ProfilDesa::create($this->defaultData());
        }

        return $profil;
    }

    public function index()
    {
        $profil = $this->getOrCreateProfil();
        return view('admin.profil', compact('profil'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'nama_kades' => 'required|string|max:255',
            'periode_kades' => 'required|string|max:255',
            'foto_kades' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5048',
            'sambutan_kades' => 'required|string',
            'sejarah' => 'required|string',
            'visi_misi' => 'required|string',
            'misi_1_judul' => 'required|string|max:255',
            'misi_1_deskripsi' => 'required|string',
            'misi_2_judul' => 'required|string|max:255',
            'misi_2_deskripsi' => 'required|string',
            'misi_3_judul' => 'required|string|max:255',
            'misi_3_deskripsi' => 'required|string',
            'jumlah_rt' => 'required|integer|min:0',
            'jumlah_rw' => 'required|integer|min:0',
            'total_penduduk' => 'required|string|max:50',
            'luas_wilayah' => 'required|string|max:50',
            'jam_senin_kamis' => 'required|string|max:100',
            'jam_jumat' => 'required|string|max:100',
            'jam_sabtu_minggu' => 'required|string|max:100',
        ]);

        $profil = $this->getOrCreateProfil();

        if ($request->hasFile('foto_kades')) {
            if ($profil->foto_kades && Storage::disk('public')->exists($profil->foto_kades)) {
                Storage::disk('public')->delete($profil->foto_kades);
            }
            $validated['foto_kades'] = $request->file('foto_kades')->store('profil-desa', 'public');
        } else {
            unset($validated['foto_kades']);
        }

        $profil->update($validated);

        return back()->with('success', 'Informasi profil desa, visi, misi, dan foto kepala desa berhasil disimpan!');
    }
}