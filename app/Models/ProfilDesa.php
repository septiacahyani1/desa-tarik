<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilDesa extends Model
{
    use HasFactory;

    protected $table = 'profil_desa';

    protected $fillable = [
        'nama_kades',
        'periode_kades',
        'foto_kades',
        'sambutan_kades',
        'sejarah',
        'visi_misi',
        'misi_1_judul',
        'misi_1_deskripsi',
        'misi_2_judul',
        'misi_2_deskripsi',
        'misi_3_judul',
        'misi_3_deskripsi',
        'jumlah_rt',
        'jumlah_rw',
        'total_penduduk',
        'luas_wilayah',
        'jam_senin_kamis',
        'jam_jumat',
        'jam_sabtu_minggu',
    ];
}