@extends('layouts.admin')

@section('title', 'Pengaturan Profil Desa - Admin Desa Tarik')
@section('header-title', 'Pengaturan Profil')

@section('admin-content')
    <div x-data="{ fotoKadesName: '' }">

        @if(session('success'))
            <div class="mb-6 bg-emerald-100 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-2xl text-xs font-bold shadow-2xs">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 bg-rose-100 border border-rose-200 text-rose-800 px-5 py-4 rounded-2xl text-xs font-semibold">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url('/admin/profil') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Header Card + Tombol Simpan Perubahan -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-base font-bold text-slate-900">Informasi Halaman Profil Desa</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Perbarui foto, nama & periode kepala desa, sambutan, sejarah, visi misi, dan data statistik kependudukan.</p>
                </div>
                <button type="submit"
                        class="bg-slate-950 hover:bg-slate-800 text-white text-xs font-semibold px-5 py-2.5 rounded-xl transition shadow-2xs shrink-0 cursor-pointer">
                    ✓ Simpan Perubahan
                </button>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                <!-- Kolom Kiri (2 Kolom) -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Foto & Identitas Kepala Desa -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs p-6 space-y-4">
                        <h3 class="text-sm font-bold text-slate-900">Identitas & Foto Kepala Desa</h3>

                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-5">
                            <div class="w-24 h-28 rounded-2xl bg-slate-100 border border-slate-200 overflow-hidden shrink-0 flex items-center justify-center">
                                @if(!empty($profil->foto_kades))
                                    <img src="{{ asset('storage/' . $profil->foto_kades) }}" alt="Foto Kepala Desa" class="w-full h-full object-cover">
                                @else
                                    <span class="text-[11px] text-slate-400 font-medium text-center px-2">Belum ada foto</span>
                                @endif
                            </div>

                            <div class="flex-1 w-full space-y-2">
                                <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider">Ganti Foto Kepala Desa</label>
                                <div class="relative border-2 border-dashed border-slate-200 rounded-xl p-3.5 text-center hover:bg-slate-50 transition cursor-pointer">
                                    <input type="file" name="foto_kades" accept="image/jpeg,image/png,image/jpg,image/webp"
                                           @change="fotoKadesName = $event.target.files[0] ? $event.target.files[0].name : ''"
                                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                    <p class="text-xs text-slate-600 font-medium" x-text="fotoKadesName ? 'File terpilih: ' + fotoKadesName : 'Klik untuk pilih foto kepala desa baru (JPG/PNG/WEBP)'"></p>
                                    <p class="text-[10px] text-slate-400 mt-0.5">Opsional • Maks. 5MB • Kosongkan jika tidak ingin mengganti</p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Kepala Desa</label>
                                <input type="text" name="nama_kades" value="{{ old('nama_kades', $profil->nama_kades ?? '') }}" required
                                       class="w-full bg-slate-50/70 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-slate-900 transition">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1.5">Jabatan & Periode</label>
                                <input type="text" name="periode_kades" value="{{ old('periode_kades', $profil->periode_kades ?? '') }}" required
                                       class="w-full bg-slate-50/70 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-slate-900 transition">
                            </div>
                        </div>
                    </div>

                    <!-- Sambutan, Sejarah & Visi -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs p-6 space-y-5">
                        <h3 class="text-sm font-bold text-slate-900">Sambutan Kepala Desa, Sejarah & Visi</h3>

                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1.5">Sambutan Kepala Desa</label>
                            <textarea name="sambutan_kades" rows="4" required
                                      class="w-full bg-slate-50/70 border border-slate-200 rounded-xl p-4 text-xs text-slate-800 leading-relaxed focus:outline-none focus:border-slate-900 transition">{{ old('sambutan_kades', $profil->sambutan_kades ?? '') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1.5">Sejarah Singkat Desa</label>
                            <textarea name="sejarah" rows="4" required
                                      class="w-full bg-slate-50/70 border border-slate-200 rounded-xl p-4 text-xs text-slate-800 leading-relaxed focus:outline-none focus:border-slate-900 transition">{{ old('sejarah', $profil->sejarah ?? '') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1.5">Visi Desa</label>
                            <textarea name="visi_misi" rows="3" required
                                      class="w-full bg-slate-50/70 border border-slate-200 rounded-xl p-4 text-xs text-slate-800 leading-relaxed focus:outline-none focus:border-slate-900 transition">{{ old('visi_misi', $profil->visi_misi ?? '') }}</textarea>
                        </div>
                    </div>

                    <!-- Daftar Misi Desa (3 Poin Utama) -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs p-6 space-y-5">
                        <div>
                            <h3 class="text-sm font-bold text-slate-900">Daftar Misi Desa (3 Poin Utama)</h3>
                            <p class="text-xs text-slate-500 mt-0.5">Akan tampil sebagai kartu nomor 1, 2, dan 3 pada bagian Visi & Misi di halaman warga.</p>
                        </div>

                        <!-- Misi 1 -->
                        <div class="p-4 rounded-2xl bg-slate-50/70 border border-slate-200/80 space-y-3">
                            <p class="text-xs font-bold text-slate-800">Misi 1</p>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Judul Misi 1</label>
                                <input type="text" name="misi_1_judul" value="{{ old('misi_1_judul', $profil->misi_1_judul ?? 'Pelayanan Digital & Administrasi Publik') }}" required
                                       class="w-full bg-white border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:outline-none focus:border-slate-900 transition">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Deskripsi Misi 1</label>
                                <textarea name="misi_1_deskripsi" rows="2" required
                                          class="w-full bg-white border border-slate-200 rounded-xl p-3 text-xs text-slate-800 leading-relaxed focus:outline-none focus:border-slate-900 transition">{{ old('misi_1_deskripsi', $profil->misi_1_deskripsi ?? '') }}</textarea>
                            </div>
                        </div>

                        <!-- Misi 2 -->
                        <div class="p-4 rounded-2xl bg-slate-50/70 border border-slate-200/80 space-y-3">
                            <p class="text-xs font-bold text-slate-800">Misi 2</p>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Judul Misi 2</label>
                                <input type="text" name="misi_2_judul" value="{{ old('misi_2_judul', $profil->misi_2_judul ?? 'Pemerataan Infrastruktur & Fasilitas Dusun') }}" required
                                       class="w-full bg-white border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:outline-none focus:border-slate-900 transition">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Deskripsi Misi 2</label>
                                <textarea name="misi_2_deskripsi" rows="2" required
                                          class="w-full bg-white border border-slate-200 rounded-xl p-3 text-xs text-slate-800 leading-relaxed focus:outline-none focus:border-slate-900 transition">{{ old('misi_2_deskripsi', $profil->misi_2_deskripsi ?? '') }}</textarea>
                            </div>
                        </div>

                        <!-- Misi 3 -->
                        <div class="p-4 rounded-2xl bg-slate-50/70 border border-slate-200/80 space-y-3">
                            <p class="text-xs font-bold text-slate-800">Misi 3</p>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Judul Misi 3</label>
                                <input type="text" name="misi_3_judul" value="{{ old('misi_3_judul', $profil->misi_3_judul ?? 'Optimalisasi Potensi Ekonomi & Fasilitas Umum') }}" required
                                       class="w-full bg-white border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:outline-none focus:border-slate-900 transition">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Deskripsi Misi 3</label>
                                <textarea name="misi_3_deskripsi" rows="2" required
                                          class="w-full bg-white border border-slate-200 rounded-xl p-3 text-xs text-slate-800 leading-relaxed focus:outline-none focus:border-slate-900 transition">{{ old('misi_3_deskripsi', $profil->misi_3_deskripsi ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Statistik Desa & Jam Pelayanan -->
                <div class="space-y-6">
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs p-6 space-y-4">
                        <h3 class="text-sm font-bold text-slate-900">Statistik Desa Tarik</h3>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1.5">Jumlah RT</label>
                                <input type="number" name="jumlah_rt" value="{{ old('jumlah_rt', $profil->jumlah_rt ?? 17) }}" required
                                       class="w-full bg-slate-50/70 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-slate-900 transition">
                            </div>

                            <div>
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1.5">Jumlah RW</label>
                                <input type="number" name="jumlah_rw" value="{{ old('jumlah_rw', $profil->jumlah_rw ?? 4) }}" required
                                       class="w-full bg-slate-50/70 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-slate-900 transition">
                            </div>

                            <div>
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1.5">Total Penduduk</label>
                                <input type="text" name="total_penduduk" value="{{ old('total_penduduk', $profil->total_penduduk ?? '4.636') }}" required
                                       class="w-full bg-slate-50/70 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-slate-900 transition">
                            </div>

                            <div>
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1.5">Luas Wilayah (Hektar)</label>
                                <input type="text" name="luas_wilayah" value="{{ old('luas_wilayah', $profil->luas_wilayah ?? '158,66') }}" required
                                       class="w-full bg-slate-50/70 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-slate-900 transition">
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs p-6 space-y-4">
                        <h3 class="text-sm font-bold text-slate-900">Jam Pelayanan Balai Desa</h3>

                        <div>
                            <label class="block text-[11px] font-semibold text-slate-600 mb-1.5">Senin - Kamis</label>
                            <input type="text" name="jam_senin_kamis" value="{{ old('jam_senin_kamis', $profil->jam_senin_kamis ?? '07:00 - 16:00 WIB') }}" required
                                   class="w-full bg-slate-50/70 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-slate-900 transition">
                        </div>

                        <div>
                            <label class="block text-[11px] font-semibold text-slate-600 mb-1.5">Jumat</label>
                            <input type="text" name="jam_jumat" value="{{ old('jam_jumat', $profil->jam_jumat ?? '07:00 - 16:00 WIB') }}" required
                                   class="w-full bg-slate-50/70 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-slate-900 transition">
                        </div>

                        <div>
                            <label class="block text-[11px] font-semibold text-slate-600 mb-1.5">Sabtu - Minggu & Libur</label>
                            <input type="text" name="jam_sabtu_minggu" value="{{ old('jam_sabtu_minggu', $profil->jam_sabtu_minggu ?? 'Tutup') }}" required
                                   class="w-full bg-slate-50/70 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-slate-900 transition">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection