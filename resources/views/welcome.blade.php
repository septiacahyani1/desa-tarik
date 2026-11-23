@extends('layouts.app')

@section('title', 'Beranda - Desa Tarik, Sidoarjo')

@section('content')
    @php
        $resolveMedia = function (?string $path, string $fallback = 'img/Balai Desa.png') {
            if (!$path) {
                return asset($fallback);
            }
            if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
                return $path;
            }
            $clean = ltrim($path, '/');
            if (str_starts_with($clean, 'storage/')) {
                return asset($clean);
            }
            if (str_starts_with($clean, 'img/')) {
                return asset($clean);
            }
            return asset('storage/' . $clean);
        };
    @endphp

    <!-- 1. Hero Section -->
    <section class="relative bg-slate-950 text-white py-24 px-4 overflow-hidden">
        <div class="absolute inset-0 opacity-25 mix-blend-overlay">
            <img src="{{ asset('img/Balai Desa.png') }}" alt="Kantor Desa Tarik" class="w-full h-full object-cover">
        </div>
        <div class="max-w-7xl mx-auto text-center relative z-10">
            <span class="inline-block bg-slate-800/80 text-emerald-400 border border-slate-700 text-xs font-semibold px-3.5 py-1.5 rounded-full mb-5">
                &bull; TRANSPARANSI & PARTISIPASI WARGA DESA TARIK
            </span>
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-extrabold mb-6 tracking-tight leading-tight">
                Portal Informasi & Layanan<br>Publik Desa Tarik
            </h1>
            <p class="text-sm md:text-base text-slate-300 max-w-2xl mx-auto leading-relaxed">
                Wujudkan tata kelola desa yang transparan dan responsif melalui akses berita terkini, profil desa, informasi fasilitas publik, serta layanan pengaduan warga Desa Tarik.
            </p>
        </div>
    </section>

    <!-- 2. Tentang Kami -->
    <section class="py-16 md:py-24 max-w-7xl mx-auto px-4">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div>
                <span class="text-emerald-600 font-bold text-xs tracking-wider uppercase">Tentang Kami</span>
                <h2 class="text-2xl md:text-3xl font-bold text-slate-900 mt-2 mb-4">Mengenal Lebih Dekat Desa Tarik & Layanan Digitalnya</h2>
                <p class="text-slate-600 leading-relaxed mb-4 text-sm md:text-base">
                    Portal Informasi Publik Desa Tarik hadir sebagai wadah komunikasi dan keterbukaan informasi antara pemerintah desa dan masyarakat.
                </p>
                <p class="text-slate-600 leading-relaxed mb-6 text-sm md:text-base">
                    Melalui platform ini, warga dapat mengakses berita terkini, mengenal profil serta fasilitas umum desa, hingga menyampaikan laporan dan aspirasi publik secara transparan, cepat, dan terukur.
                </p>
                <a href="{{ url('/profil') }}" class="inline-block bg-slate-900 hover:bg-slate-800 text-white font-semibold px-5 py-2.5 rounded-lg text-sm transition">
                    Selengkapnya Tentang Desa &rarr;
                </a>
            </div>
            <div>
                <img src="{{ asset('img/Atas Tarik.png') }}" alt="Pemandangan Desa Tarik" class="w-full h-72 md:h-80 object-cover rounded-2xl shadow-md border border-slate-200">
            </div>
        </div>
    </section>

    <!-- 3. Kabar Desa (Berita & Pengumuman) -->
    <section class="bg-slate-100 py-16 md:py-24 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end mb-12 gap-4">
                <div>
                    <span class="text-emerald-600 font-bold text-xs tracking-wider uppercase">Kabar Desa</span>
                    <h2 class="text-2xl md:text-3xl font-bold text-slate-900 mt-1">Berita & Pengumuman Terbaru</h2>
                </div>
                <a href="{{ url('/berita') }}" class="text-slate-900 font-semibold text-sm hover:underline">Lihat Semua Berita &rarr;</a>
            </div>

            @php
                $daftarBerita = $beritasTerbaru ?? collect();
            @endphp

            @if($daftarBerita->count() > 0)
                <div class="grid md:grid-cols-3 gap-8">
                    @foreach($daftarBerita as $berita)
                        @php
                            $fotoBerita = $berita->foto ?? $berita->gambar ?? $berita->thumbnail ?? null;
                            $teksBerita = $berita->ringkasan ?? $berita->isi ?? $berita->konten ?? $berita->deskripsi ?? '';
                            $tglBerita = $berita->tanggal ?? $berita->created_at;
                        @endphp
                        <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-200 flex flex-col justify-between">
                            <div>
                                <img src="{{ $resolveMedia($fotoBerita, 'img/Balai Desa.png') }}"
                                     alt="{{ $berita->judul }}"
                                     class="w-full h-48 object-cover bg-slate-100">
                                <div class="p-6">
                                    @if($tglBerita)
                                        <span class="text-xs font-semibold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded">
                                            {{ \Carbon\Carbon::parse($tglBerita)->translatedFormat('d M Y') }}
                                        </span>
                                    @endif
                                    <h3 class="font-bold text-lg text-slate-900 mt-3 mb-2">{{ $berita->judul }}</h3>
                                    <p class="text-slate-600 text-sm leading-relaxed">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($teksBerita), 140) }}
                                    </p>
                                </div>
                            </div>
                            <div class="px-6 pb-6">
                                <a href="{{ url('/berita') }}" class="text-emerald-600 font-semibold text-sm hover:underline">
                                    Baca Selengkapnya &rarr;
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-2xl border border-slate-200 p-8 text-center text-sm text-slate-500">
                    Belum ada berita atau pengumuman yang diterbitkan.
                </div>
            @endif
        </div>
    </section>

    <!-- 4. Layanan Pengaduan Preview -->
    <section class="py-16 md:py-24 max-w-7xl mx-auto px-4">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end mb-12 gap-4">
            <div>
                <span class="text-emerald-600 font-bold text-xs tracking-wider uppercase">Pelayanan</span>
                <h2 class="text-2xl md:text-3xl font-bold text-slate-900 mt-1">Layanan Pengaduan</h2>
            </div>
            <a href="{{ url('/pengaduan') }}" class="inline-block bg-slate-900 hover:bg-slate-800 text-white font-semibold px-4 py-2.5 rounded-lg text-xs md:text-sm transition">
                Buat Pengaduan Warga &rarr;
            </a>
        </div>

        @php
            $daftarPengaduan = $pengaduanTerbaru ?? collect();
        @endphp

        @if($daftarPengaduan->count() > 0)
            <div class="grid md:grid-cols-2 gap-8">
                @foreach($daftarPengaduan as $aduan)
                    @php
                        $judulAduan = $aduan->judul ?? $aduan->subjek ?? $aduan->kategori ?? 'Laporan Warga';
                        $kategoriAduan = $aduan->kategori ?? 'PENGADUAN WARGA';
                        $isiAduan = $aduan->deskripsi ?? $aduan->isi ?? $aduan->keterangan ?? '';
                        $fotoAduan = $aduan->foto ?? $aduan->gambar ?? $aduan->bukti ?? null;
                    @endphp
                    <div class="bg-white rounded-2xl overflow-hidden border border-slate-200 shadow-sm p-6 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-[10px] font-bold text-blue-700 bg-blue-50 px-2.5 py-1 rounded uppercase">
                                    {{ $kategoriAduan }}
                                </span>
                                @if(!empty($aduan->status))
                                    <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded">
                                        {{ $aduan->status }}
                                    </span>
                                @endif
                            </div>
                            <h3 class="font-bold text-xl text-slate-900 mt-3 mb-2">{{ $judulAduan }}</h3>
                            <p class="text-slate-600 text-sm mb-4 leading-relaxed">
                                {{ \Illuminate\Support\Str::limit(strip_tags($isiAduan), 150) }}
                            </p>
                        </div>
                        <div class="space-y-4">
                            <img src="{{ $resolveMedia($fotoAduan, 'img/Jalan Berlubang.png') }}"
                                 alt="{{ $judulAduan }}"
                                 class="w-full h-44 object-cover rounded-xl bg-slate-100">
                            <a href="{{ url('/pengaduan') }}" class="inline-block text-emerald-600 font-semibold text-sm hover:underline">
                                Ajukan Pengaduan Serupa &rarr;
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="grid md:grid-cols-2 gap-8">
                <div class="bg-white rounded-2xl overflow-hidden border border-slate-200 shadow-sm p-6 flex flex-col justify-between">
                    <div>
                        <span class="text-[10px] font-bold text-blue-700 bg-blue-50 px-2.5 py-1 rounded">INFRASTRUKTUR JALAN</span>
                        <h3 class="font-bold text-xl text-slate-900 mt-3 mb-2">Jalan Berlubang</h3>
                        <p class="text-slate-600 text-sm mb-4">Laporan kerusakan aspal berlubang di akses jalan Dusun Tempuran RW 01 menuju arah Stasiun Tarik telah selesai diperbaiki.</p>
                    </div>
                    <div class="space-y-4">
                        <img src="{{ asset('img/Jalan Berlubang.png') }}" alt="Jalan Berlubang" class="w-full h-44 object-cover rounded-xl">
                        <a href="{{ url('/pengaduan') }}" class="inline-block text-emerald-600 font-semibold text-sm hover:underline">
                            Lapor Keluhan Jalan / Infrastruktur &rarr;
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-2xl overflow-hidden border border-slate-200 shadow-sm p-6 flex flex-col justify-between">
                    <div>
                        <span class="text-[10px] font-bold text-amber-700 bg-amber-50 px-2.5 py-1 rounded">LINGKUNGAN</span>
                        <h3 class="font-bold text-xl text-slate-900 mt-3 mb-2">Pembersihan Saluran Air Tersumbat</h3>
                        <p class="text-slate-600 text-sm mb-4">Aduan warga terkait tumpukan sampah di saluran air Dusun Clangap RW 03 telah didata dan masuk dalam jadwal penanganan lapangan.</p>
                    </div>
                    <div class="space-y-4">
                        <img src="{{ asset('img/Pembersihan Saluran.png') }}" alt="Saluran Air" class="w-full h-44 object-cover rounded-xl">
                        <a href="{{ url('/pengaduan') }}" class="inline-block text-emerald-600 font-semibold text-sm hover:underline">
                            Lapor Keluhan Lingkungan &rarr;
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </section>

    <!-- 5. Fasilitas Umum Memadai -->
    <section class="bg-slate-950 text-white py-20 px-4">
        <div class="max-w-7xl mx-auto text-center">
            <span class="text-emerald-400 font-bold text-xs tracking-wider uppercase">Layanan & Infrastruktur</span>
            <h2 class="text-3xl font-bold mt-1 mb-4">Fasilitas Umum Memadai</h2>
            <p class="text-slate-400 text-sm max-w-2xl mx-auto mb-8">
                Kami memastikan seluruh warga memiliki akses yang mudah menuju berbagai fasilitas penunjang kehidupan yang dikelola langsung oleh desa.
            </p>
            <div class="mb-12">
                <a href="{{ url('/fasilitas') }}" class="inline-block bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold px-5 py-2.5 rounded-lg text-xs md:text-sm transition">
                    Lihat Semua Fasilitas & Galeri &rarr;
                </a>
            </div>

            @php
                $daftarFasilitas = $fasilitasBeranda ?? collect();
            @endphp

            @if($daftarFasilitas->count() > 0)
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 text-left">
                    @foreach($daftarFasilitas as $fas)
                        <a href="{{ url('/fasilitas') }}" class="block bg-slate-900 hover:bg-slate-800/90 p-6 rounded-2xl border border-slate-800 transition">
                            <h4 class="font-bold text-base mb-2 text-white">{{ $fas->nama }}</h4>
                            <p class="text-slate-400 text-xs leading-relaxed">{{ $fas->deskripsi }}</p>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 text-left">
                    <a href="{{ url('/fasilitas') }}" class="block bg-slate-900 hover:bg-slate-800/90 p-6 rounded-2xl border border-slate-800 transition">
                        <h4 class="font-bold text-base mb-2 text-white">Balai Desa Tarik</h4>
                        <p class="text-slate-400 text-xs leading-relaxed">Pusat pelayanan administrasi kependudukan serta Pendopo Balai Desa untuk kegiatan musyawarah warga.</p>
                    </a>
                    <a href="{{ url('/fasilitas') }}" class="block bg-slate-900 hover:bg-slate-800/90 p-6 rounded-2xl border border-slate-800 transition">
                        <h4 class="font-bold text-base mb-2 text-white">Masjid Thoriqul Jannah</h4>
                        <p class="text-slate-400 text-xs leading-relaxed">Sarana ibadah utama warga Desa Tarik yang bersih, nyaman, dan aktif untuk kegiatan keagamaan.</p>
                    </a>
                    <a href="{{ url('/fasilitas') }}" class="block bg-slate-900 hover:bg-slate-800/90 p-6 rounded-2xl border border-slate-800 transition">
                        <h4 class="font-bold text-base mb-2 text-white">Puskesmas Tarik</h4>
                        <p class="text-slate-400 text-xs leading-relaxed">Layanan kesehatan tingkat pertama bagi warga Desa Tarik, meliputi pemeriksaan umum, KIA, dan posyandu.</p>
                    </a>
                    <a href="{{ url('/fasilitas') }}" class="block bg-slate-900 hover:bg-slate-800/90 p-6 rounded-2xl border border-slate-800 transition">
                        <h4 class="font-bold text-base mb-2 text-white">SDN Tarik 1 & SDN Tarik 2</h4>
                        <p class="text-slate-400 text-xs leading-relaxed">Lembaga pendidikan dasar negeri di wilayah Desa Tarik untuk menunjang wajib belajar anak-anak.</p>
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- 6. Kontak Kami dengan Google Maps -->
    <section id="kontak" class="py-20 max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-slate-900 mb-2">Kontak Kami</h2>
            <p class="text-slate-600 text-sm">Masukan, saran, atau pertanyaan? Kirimkan pesan langsung ke admin desa.</p>
        </div>

        <div class="grid md:grid-cols-2 gap-12 items-start bg-white p-8 md:p-12 rounded-3xl border border-slate-200 shadow-sm">
            <div>
                <h3 class="text-xl font-bold text-slate-900 mb-6">Tinggalkan Pesan</h3>

                @if(session('kontak_success'))
                    <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-xs font-semibold">
                        {{ session('kontak_success') }}
                    </div>
                @endif

                <form action="{{ url('/kontak') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama Anda" required
                               class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm">
                        @error('nama')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Email / No. HP</label>
                        <input type="text" name="kontak" value="{{ old('kontak') }}" placeholder="Kontak yang bisa dihubungi" required
                               class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm">
                        @error('kontak')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Isi Pesan</label>
                        <textarea name="pesan" rows="4" placeholder="Tuliskan pesan Anda di sini..." required
                                  class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm">{{ old('pesan') }}</textarea>
                        @error('pesan')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-3.5 rounded-xl text-sm transition shadow-sm cursor-pointer">
                        Kirim Pesan Sekarang
                    </button>
                </form>
            </div>

            <div class="space-y-6">
                <h3 class="text-xl font-bold text-slate-900 mb-2">Hubungi Kami</h3>
                <div class="bg-slate-100 p-3 rounded-2xl border border-slate-200 overflow-hidden">
                    <p class="text-xs font-semibold text-slate-500 mb-2 px-1">Peta Lokasi Kantor Desa</p>
                    <!-- GANTI LINK src DI BAWAH INI DENGAN LINK "EMBED A MAP" DARI GOOGLE MAPS KANTOR DESA TARIK -->
                    <div class="w-full h-48 rounded-xl overflow-hidden border border-slate-200">
                        <iframe
                            src="https://www.google.com/maps?q=Kantor+Desa+Tarik+Sidoarjo&output=embed"
                            width="100%"
                            height="100%"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 text-sm mb-1">Alamat Kantor Desa</h4>
                    <p class="text-slate-600 text-xs leading-relaxed">Jl. Raya Tarik No.20-4, Tarik Lor, Tarik, Kec. Tarik, Kabupaten Sidoarjo, Jawa Timur 61265.</p>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 text-sm mb-1">Nomor Telepon</h4>
                    <p class="text-slate-600 text-xs">(031)8970345</p>
                </div>
            </div>
        </div>
    </section>
@endsection