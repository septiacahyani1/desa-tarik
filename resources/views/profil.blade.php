@extends('layouts.app')

@section('title', 'Profil Desa - Desa Tarik, Sidoarjo')

@section('content')
    @php
        $namaKades = $profil->nama_kades ?? 'Ifanul Ahmad Irfandi, S.pd.';
        $periodeKades = $profil->periode_kades ?? 'Kepala Desa Tarik, Periode 2022-2028';
        $sambutanKades = $profil->sambutan_kades ?? 'Selamat datang di portal resmi Desa Tarik. Melalui platform digital ini, kami berdedikasi untuk menghadirkan transparansi informasi publik, mempermudah akses layanan kependudukan secara transparan dari Kantor Desa kami, serta mendukung kemajuan ekonomi dan kesejahteraan seluruh warga.';
        $sejarahDesa = $profil->sejarah ?? 'Pada awalnya Desa Tarik merupakan bagian dari wilayah Kerajaan Majapahit yang dipimpin oleh Raden Wijaya. Sekitar delapan abad yang lalu, dari sebuah hutan yang bernama hutan Tarik itu, akhirnya Raden Wijaya membabat hutan yang sangat lebat itu yang kemudian berkembang menjadi kerajaan yang adiluhung, Kerajaan Majapahit.';
        $visiMisi = $profil->visi_misi ?? 'Mewujudkan Desa Tarik yang Mandiri, Sejahtera, Transparan, dan Berdaya Saing Tinggi Melalui Optimalisasi Pelayanan Publik Berbasis Digital di Wilayah Sidoarjo.';
        $misi1Judul = $profil->misi_1_judul ?? 'Pelayanan Digital & Administrasi Publik';
        $misi1Deskripsi = $profil->misi_1_deskripsi ?? 'Meningkatkan kualitas pelayanan administrasi kependudukan yang cepat, transparan, dan terpadu bagi seluruh warga di Kantor Desa Tarik.';
        $misi2Judul = $profil->misi_2_judul ?? 'Pemerataan Infrastruktur & Fasilitas Dusun';
        $misi2Deskripsi = $profil->misi_2_deskripsi ?? 'Mengembangkan infrastruktur desa yang merata dan berkualitas di keempat dusun (Tempuran, Munggon, Clangap, dan Tarik).';
        $misi3Judul = $profil->misi_3_judul ?? 'Optimalisasi Potensi Ekonomi & Fasilitas Umum';
        $misi3Deskripsi = $profil->misi_3_deskripsi ?? 'Mengoptimalkan pemanfaatan fasilitas strategis desa—seperti Stasiun Tarik, Puskesmas, dan sektor pertanian—untuk ekonomi lokal.';
        $jumlahRt = $profil->jumlah_rt ?? 17;
        $jumlahRw = $profil->jumlah_rw ?? 4;
        $totalPenduduk = $profil->total_penduduk ?? '4.636';
        $luasWilayah = $profil->luas_wilayah ?? '158,66';
        $jamSeninKamis = $profil->jam_senin_kamis ?? '07:00 - 16:00 WIB';
        $jamJumat = $profil->jam_jumat ?? '07:00 - 16:00 WIB';
        $jamSabtuMinggu = $profil->jam_sabtu_minggu ?? 'Tutup';
    @endphp

    <!-- 1. Hero Section Profil Desa -->
    <section class="relative bg-[#060a14] text-white py-20 px-4 overflow-hidden">
        <div class="max-w-5xl mx-auto text-center relative z-10">
            <span class="inline-block bg-slate-800/80 text-emerald-400 border border-slate-700 text-[11px] font-semibold px-3.5 py-1 rounded-full mb-4 tracking-widest uppercase">
                MENGENAL LEBIH DEKAT
            </span>
            <h1 class="text-3xl md:text-5xl font-extrabold mb-3 tracking-tight">
                Profil Desa Tarik
            </h1>
            <p class="text-xs md:text-sm text-slate-300 max-w-xl mx-auto leading-relaxed">
                Pusat informasi resmi mengenai sejarah, struktur pemerintahan, wilayah dusun, serta transparansi data pelayanan warga Desa Tarik.
            </p>
        </div>
    </section>

    <!-- 2. Sambutan Kepala Desa -->
    <section class="max-w-6xl mx-auto px-4 py-12">
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-6 md:p-10 flex flex-col md:flex-row items-center gap-8">
            <div class="w-44 h-56 rounded-2xl bg-slate-100 border border-slate-200 overflow-hidden shrink-0 flex items-center justify-center">
                @if(!empty($profil?->foto_kades))
                    <img src="{{ asset('storage/' . $profil->foto_kades) }}" alt="{{ $namaKades }}" class="w-full h-full object-cover">
                @else
                    <img src="{{ asset('img/Kepala Desa.png') }}" alt="{{ $namaKades }}" class="w-full h-full object-cover" onerror="this.style.display='none'">
                @endif
            </div>

            <div class="space-y-3 flex-1">
                <span class="text-[11px] font-bold text-blue-600 uppercase tracking-widest">— SAMBUTAN KEPALA DESA</span>
                <h2 class="text-2xl font-extrabold text-slate-900">Sambutan Kepala Desa</h2>
                <p class="text-xs md:text-sm text-slate-600 leading-relaxed whitespace-pre-line">{{ $sambutanKades }}</p>
                <div class="pt-2">
                    <p class="text-sm font-bold text-slate-900">{{ $namaKades }}</p>
                    <p class="text-xs text-blue-600 font-medium">{{ $periodeKades }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. Sejarah Singkat Desa -->
    <section class="max-w-6xl mx-auto px-4 pb-14">
        <div class="grid md:grid-cols-2 gap-8 items-center">
            <div class="space-y-3">
                <span class="text-[11px] font-bold text-blue-600 uppercase tracking-widest">JEJAK LANGKAH</span>
                <h2 class="text-2xl font-extrabold text-slate-900">Sejarah Singkat Desa</h2>
                <p class="text-xs md:text-sm text-slate-600 leading-relaxed whitespace-pre-line">{{ $sejarahDesa }}</p>
            </div>
            <div class="rounded-3xl overflow-hidden border border-slate-200 shadow-xs h-64 bg-slate-100">
                <img src="{{ asset('img/Balai Desa.png') }}" alt="Kantor Desa Tarik" class="w-full h-full object-cover">
            </div>
        </div>
    </section>

    <!-- 4. Visi & Misi -->
    <section class="bg-[#060a14] text-white py-16 px-4">
        <div class="max-w-6xl mx-auto space-y-10">
            <div class="text-center max-w-2xl mx-auto space-y-2">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">ARAH PEMBANGUNAN</span>
                <h2 class="text-3xl font-extrabold">Visi & Misi</h2>
                <p class="text-xs md:text-sm text-slate-300 italic leading-relaxed">
                    "{{ $visiMisi }}"
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <div class="bg-slate-900/80 border border-slate-800 rounded-2xl p-6 space-y-3">
                    <span class="w-7 h-7 rounded-lg bg-blue-600 text-white text-xs font-bold inline-flex items-center justify-center">1</span>
                    <h3 class="font-bold text-sm text-white">{{ $misi1Judul }}</h3>
                    <p class="text-xs text-slate-400 leading-relaxed whitespace-pre-line">{{ $misi1Deskripsi }}</p>
                </div>
                <div class="bg-slate-900/80 border border-slate-800 rounded-2xl p-6 space-y-3">
                    <span class="w-7 h-7 rounded-lg bg-emerald-600 text-white text-xs font-bold inline-flex items-center justify-center">2</span>
                    <h3 class="font-bold text-sm text-white">{{ $misi2Judul }}</h3>
                    <p class="text-xs text-slate-400 leading-relaxed whitespace-pre-line">{{ $misi2Deskripsi }}</p>
                </div>
                <div class="bg-slate-900/80 border border-slate-800 rounded-2xl p-6 space-y-3">
                    <span class="w-7 h-7 rounded-lg bg-rose-600 text-white text-xs font-bold inline-flex items-center justify-center">3</span>
                    <h3 class="font-bold text-sm text-white">{{ $misi3Judul }}</h3>
                    <p class="text-xs text-slate-400 leading-relaxed whitespace-pre-line">{{ $misi3Deskripsi }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. Statistik Desa & Jam Pelayanan -->
    <section class="max-w-6xl mx-auto px-4 py-16">
        <div class="grid lg:grid-cols-3 gap-8 items-start">
            <div class="lg:col-span-2 space-y-5">
                <div>
                    <span class="text-[11px] font-bold text-blue-600 uppercase tracking-widest">DATA TERBUKA</span>
                    <h2 class="text-2xl font-extrabold text-slate-900">Statistik Desa Tarik</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Gambaran umum demografi wilayah, administrasi, dan tata guna lahan desa.</p>
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-2xs">
                        <p class="text-2xl font-extrabold text-slate-900">{{ $jumlahRw }}</p>
                        <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mt-1">Rukun Warga (RW)</p>
                    </div>
                    <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-2xs">
                        <p class="text-2xl font-extrabold text-slate-900">{{ $jumlahRt }}</p>
                        <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mt-1">Rukun Tetangga (RT)</p>
                    </div>
                    <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-2xs">
                        <p class="text-2xl font-extrabold text-slate-900">{{ $totalPenduduk }}</p>
                        <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mt-1">Total Penduduk</p>
                    </div>
                    <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-2xs">
                        <p class="text-2xl font-extrabold text-slate-900">{{ $luasWilayah }}</p>
                        <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mt-1">Luas Wilayah (Ha)</p>
                    </div>
                </div>
            </div>

            <div class="bg-[#060a14] text-white rounded-3xl p-6 space-y-5">
                <div>
                    <h3 class="font-bold text-base">Jam Pelayanan</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Jadwal operasional pelayanan Balai Desa Tarik.</p>
                </div>

                <div class="divide-y divide-slate-800 text-xs">
                    <div class="py-3 flex items-center justify-between gap-2">
                        <span class="text-slate-300">Senin - Kamis</span>
                        <span class="bg-slate-800 text-emerald-400 font-semibold px-3 py-1 rounded-lg">{{ $jamSeninKamis }}</span>
                    </div>
                    <div class="py-3 flex items-center justify-between gap-2">
                        <span class="text-slate-300">Jumat</span>
                        <span class="bg-slate-800 text-emerald-400 font-semibold px-3 py-1 rounded-lg">{{ $jamJumat }}</span>
                    </div>
                    <div class="py-3 flex items-center justify-between gap-2">
                        <span class="text-slate-300">Sabtu - Minggu & Libur</span>
                        <span class="bg-rose-500/20 text-rose-400 font-semibold px-3 py-1 rounded-lg">{{ $jamSabtuMinggu }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection