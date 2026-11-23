@extends('layouts.app')

@section('title', 'Layanan Pengaduan Publik - Desa Tarik, Sidoarjo')

@section('content')
    <!-- 1. Hero Section Pengaduan -->
    <section class="relative bg-slate-950 text-white py-20 px-4 overflow-hidden">
        <div class="absolute inset-0 opacity-25 mix-blend-overlay">
            <img src="{{ asset('img/Balai Desa.png') }}" alt="Kantor Desa Tarik" class="w-full h-full object-cover">
        </div>
        <div class="max-w-7xl mx-auto text-center relative z-10">
            <span class="inline-block bg-slate-800/80 text-emerald-400 border border-slate-700 text-xs font-semibold px-3.5 py-1.5 rounded-full mb-4 tracking-widest uppercase">
                &bull; PARTISIPASI WARGA
            </span>
            <h1 class="text-3xl md:text-5xl font-extrabold mb-3 tracking-tight">
                Layanan Pengaduan Publik
            </h1>
            <p class="text-xs md:text-sm text-slate-300 max-w-xl mx-auto leading-relaxed">
                Sampaikan aspirasi, laporan infrastruktur, atau keluhan pelayanan publik. Kami menjamin transparansi dalam setiap penanganan masalah desa.
            </p>
        </div>
    </section>

    <!-- Notifikasi Sukses -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 mt-8">
            <div class="bg-emerald-100 border border-emerald-200 text-emerald-800 px-6 py-4 rounded-2xl text-xs font-bold shadow-2xs">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <!-- 2. Konten Dua Kolom -->
    <div class="max-w-7xl mx-auto px-4 py-16">
        <div class="grid lg:grid-cols-12 gap-10 items-start">

            <!-- KIRI: Form Buat Laporan Baru -->
            <div class="lg:col-span-5 bg-white p-6 md:p-8 rounded-3xl border border-slate-200 shadow-sm sticky top-24">
                <div class="mb-6">
                    <h2 class="text-xl font-bold text-slate-900 mb-1">Buat Laporan Baru</h2>
                    <p class="text-slate-500 text-xs">Sampaikan aduan Anda secara langsung kepada perangkat desa.</p>
                </div>

                <form action="{{ url('/pengaduan') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Nama Lengkap Pelapor</label>
                        <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Contoh: Budi Santoso" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs text-slate-800 focus:outline-none focus:border-emerald-500 transition">
                        @error('nama')
                            <p class="text-[11px] text-rose-600 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Judul Laporan</label>
                        <input type="text" name="judul" value="{{ old('judul') }}" required placeholder="Contoh: Jalan berlubang di RT 02" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs text-slate-800 focus:outline-none focus:border-emerald-500 transition">
                        @error('judul')
                            <p class="text-[11px] text-rose-600 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Kategori Masalah</label>
                        <select name="kategori" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs text-slate-800 focus:outline-none focus:border-emerald-500 transition">
                            <option value="Infrastruktur Jalan" {{ old('kategori') == 'Infrastruktur Jalan' ? 'selected' : '' }}>Infrastruktur Jalan</option>
                            <option value="Saluran Air & Drainase" {{ old('kategori') == 'Saluran Air & Drainase' ? 'selected' : '' }}>Saluran Air & Drainase</option>
                            <option value="Kebersihan & Lingkungan" {{ old('kategori') == 'Kebersihan & Lingkungan' ? 'selected' : '' }}>Kebersihan & Lingkungan</option>
                            <option value="Fasilitas Umum" {{ old('kategori') == 'Fasilitas Umum' ? 'selected' : '' }}>Fasilitas Umum</option>
                            <option value="Administrasi Kependudukan" {{ old('kategori') == 'Administrasi Kependudukan' ? 'selected' : '' }}>Administrasi Kependudukan</option>
                        </select>
                        @error('kategori')
                            <p class="text-[11px] text-rose-600 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Deskripsi Rinci</label>
                        <textarea name="deskripsi" rows="4" required placeholder="Jelaskan detail lokasi, waktu, dan masalah yang dihadapi..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs text-slate-800 focus:outline-none focus:border-emerald-500 transition">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <p class="text-[11px] text-rose-600 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kotak Upload Foto Interaktif (Ada Petunjuk "Unggah di sini" & Indikator Nama File) -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Bukti Foto (Opsional)</label>
                        <div id="dropzone-foto-pengaduan"
                             class="relative border-2 border-dashed border-slate-200 hover:border-emerald-500 rounded-2xl p-5 text-center bg-slate-50/50 hover:bg-slate-50 transition cursor-pointer">
                            <input
                                id="input-foto-pengaduan"
                                type="file"
                                name="foto"
                                accept="image/jpeg,image/png,image/gif,image/webp"
                                onchange="updatePreviewFotoPengaduan(this)"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                            >

                            <div id="prompt-foto-pengaduan" class="space-y-1">
                                <div class="text-slate-400 text-base mb-1">📷</div>
                                <p class="text-xs text-slate-800 font-bold">Unggah di sini</p>
                                <p class="text-[11px] text-slate-500">Klik atau seret foto bukti kondisi lapangan ke area ini</p>
                                <p class="text-[10px] text-slate-400">Format: JPG, PNG, GIF (Maks. 5MB)</p>
                            </div>

                            <div id="info-foto-pengaduan" class="hidden space-y-1.5 relative z-20">
                                <p class="text-xs font-bold text-emerald-700">
                                    ✓ Foto berhasil diunggah / dipilih: <span id="nama-foto-pengaduan" class="underline"></span>
                                </p>
                                <p id="ukuran-foto-pengaduan" class="text-[10px] text-slate-500"></p>
                                <button type="button"
                                        onclick="resetFotoPengaduan()"
                                        class="inline-block mt-1 text-[11px] font-semibold text-rose-600 hover:text-rose-700 underline cursor-pointer">
                                    Hapus / Ganti Foto
                                </button>
                            </div>
                        </div>

                        @error('foto')
                            <p class="text-[11px] text-rose-600 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full bg-slate-950 hover:bg-slate-900 text-white font-semibold py-3.5 rounded-xl text-xs transition shadow-sm">
                        Kirim Laporan Pengaduan
                    </button>
                </form>
                <p class="text-[11px] text-slate-400 text-center mt-4">Identitas pelapor dijamin kerahasiaannya oleh pemerintah desa.</p>
            </div>

            <!-- KANAN: Pantauan Laporan Warga -->
            <div class="lg:col-span-7 space-y-6">
                <div class="flex justify-between items-center bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">Pantauan Laporan Warga</h2>
                        <p class="text-slate-500 text-xs">Transparansi penanganan keluhan oleh pihak desa.</p>
                    </div>
                    <span class="bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold px-3 py-1.5 rounded-xl">
                        Total {{ $pengaduans->count() }} Laporan Masuk
                    </span>
                </div>

                <!-- Perulangan Data Pengaduan -->
                @forelse($pengaduans as $item)
                    <div class="bg-white p-6 md:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-5">
                        <div class="flex justify-between items-center">
                            <span class="text-[11px] font-bold px-3 py-1 rounded-lg uppercase
                                {{ strtolower($item->status) == 'selesai' ? 'text-emerald-700 bg-emerald-50 border border-emerald-200' : (strtolower($item->status) == 'diproses' ? 'text-amber-700 bg-amber-50 border border-amber-200' : 'text-blue-700 bg-blue-50 border border-blue-200') }}">
                                {{ $item->status }}
                            </span>
                            <span class="text-xs text-slate-400">{{ $item->created_at->diffForHumans() }}</span>
                        </div>

                        <div>
                            <div class="flex items-center space-x-2 mb-1">
                                <span class="text-[10px] font-bold text-slate-600 bg-slate-100 px-2.5 py-0.5 rounded-full">Oleh: {{ $item->nama ?? 'Warga' }}</span>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">&bull; {{ $item->kategori }}</span>
                            </div>
                            <h3 class="font-bold text-base text-slate-900 mb-1">{{ $item->judul }}</h3>
                            <p class="text-slate-600 text-xs leading-relaxed">{{ $item->deskripsi }}</p>
                        </div>

                        <!-- BAGIAN FOTO BERJAJAR SEBELAHAN -->
                        @if($item->foto || $item->foto_tanggapan)
                            <div class="grid grid-cols-1 {{ ($item->foto && $item->foto_tanggapan) ? 'md:grid-cols-2' : '' }} gap-4 pt-1">
                                
                                <!-- Kolom Kiri: Bukti Foto Pelapor -->
                                @if($item->foto)
                                    <div class="bg-slate-50/60 p-3 rounded-2xl border border-slate-200/80 space-y-1.5 flex flex-col justify-between">
                                        <span class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Bukti Foto Pelapor:</span>
                                        <div class="flex-1 flex items-center justify-center">
                                            <img src="{{ asset('storage/' . $item->foto) }}" alt="Bukti Foto" class="w-full max-h-52 object-contain rounded-xl bg-white p-1 border border-slate-200">
                                        </div>
                                    </div>
                                @endif

                                <!-- Kolom Kanan: Dokumentasi Penanganan Desa -->
                                @if($item->foto_tanggapan)
                                    <div class="bg-slate-50/60 p-3 rounded-2xl border border-slate-200/80 space-y-1.5 flex flex-col justify-between">
                                        <span class="block text-[10px] font-bold text-slate-700 uppercase tracking-wider">Dokumentasi Penanganan Desa:</span>
                                        <div class="flex-1 flex items-center justify-center">
                                            <img src="{{ asset('storage/' . $item->foto_tanggapan) }}" alt="Foto Bukti Penanganan" class="w-full max-h-52 object-contain rounded-xl bg-white p-1 border border-slate-200">
                                        </div>
                                    </div>
                                @endif

                            </div>
                        @endif

                        <!-- Tanggapan Resmi Desa (Teks) -->
                        @if($item->tanggapan)
                            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 space-y-1.5">
                                <div class="flex items-center space-x-1.5 text-xs font-bold text-blue-600">
                                    <span>💬</span>
                                    <span>Tanggapan Resmi Desa:</span>
                                </div>
                                <p class="text-xs text-slate-600 leading-relaxed">{{ $item->tanggapan }}</p>
                            </div>
                        @endif

                    </div>
                @empty
                    <div class="bg-white p-8 rounded-3xl border border-slate-200 text-center text-slate-400 text-xs font-medium">
                        Belum ada laporan pengaduan yang masuk.
                    </div>
                @endforelse

            </div>

        </div>
    </div>

    <script>
        function updatePreviewFotoPengaduan(input) {
            const promptBox = document.getElementById('prompt-foto-pengaduan');
            const infoBox = document.getElementById('info-foto-pengaduan');
            const namaEl = document.getElementById('nama-foto-pengaduan');
            const ukuranEl = document.getElementById('ukuran-foto-pengaduan');
            const dropzone = document.getElementById('dropzone-foto-pengaduan');

            if (input.files && input.files.length > 0) {
                const file = input.files[0];
                const sizeKB = (file.size / 1024).toFixed(1);
                const sizeText = file.size >= 1024 * 1024
                    ? (file.size / (1024 * 1024)).toFixed(2) + ' MB'
                    : sizeKB + ' KB';

                namaEl.textContent = file.name;
                ukuranEl.textContent = 'Ukuran file: ' + sizeText + ' — Siap dikirim bersama laporan';

                promptBox.classList.add('hidden');
                infoBox.classList.remove('hidden');
                dropzone.classList.remove('border-slate-200', 'bg-slate-50/50');
                dropzone.classList.add('border-emerald-400', 'bg-emerald-50/40');
            } else {
                resetFotoPengaduan();
            }
        }

        function resetFotoPengaduan() {
            const input = document.getElementById('input-foto-pengaduan');
            const promptBox = document.getElementById('prompt-foto-pengaduan');
            const infoBox = document.getElementById('info-foto-pengaduan');
            const namaEl = document.getElementById('nama-foto-pengaduan');
            const ukuranEl = document.getElementById('ukuran-foto-pengaduan');
            const dropzone = document.getElementById('dropzone-foto-pengaduan');

            if (input) input.value = '';
            if (namaEl) namaEl.textContent = '';
            if (ukuranEl) ukuranEl.textContent = '';

            infoBox.classList.add('hidden');
            promptBox.classList.remove('hidden');
            dropzone.classList.remove('border-emerald-400', 'bg-emerald-50/40');
            dropzone.classList.add('border-slate-200', 'bg-slate-50/50');
        }
    </script>
@endsection