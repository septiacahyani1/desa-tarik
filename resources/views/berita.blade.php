@extends('layouts.app')

@section('title', 'Berita & Pengumuman - Desa Tarik, Sidoarjo')

@section('content')
    <!-- 1. Hero Section Berita -->
    <section class="relative bg-slate-950 text-white py-20 px-4 overflow-hidden">
        <div class="absolute inset-0 opacity-25 mix-blend-overlay">
            <img src="{{ asset('img/Balai Desa.png') }}" alt="Kantor Desa Tarik" class="w-full h-full object-cover">
        </div>
        <div class="max-w-7xl mx-auto text-center relative z-10">
            <span class="inline-block bg-slate-800/80 text-emerald-400 border border-slate-700 text-xs font-semibold px-3.5 py-1.5 rounded-full mb-4 tracking-widest uppercase">
                &bull; KABAR DESA
            </span>
            <h1 class="text-3xl md:text-5xl font-extrabold mb-3 tracking-tight">
                Berita & Pengumuman Terbaru
            </h1>
            <p class="text-xs md:text-sm text-slate-300 max-w-xl mx-auto leading-relaxed">
                Ikuti perkembangan terkini, informasi kegiatan warga, dan pengumuman resmi dari Pemerintah Desa Tarik.
            </p>
        </div>
    </section>

    <!-- 2. Konten Berita Utama & Grid -->
    <div class="max-w-7xl mx-auto px-4 py-16 space-y-12">

        @if($beritas->count() > 0)
            @php
                $utama = $beritas->first();
                $lainnya = $beritas->skip(1);
            @endphp

            <!-- Berita Utama (Featured Horizontal Card) -->
            <div class="bg-white p-6 md:p-8 rounded-3xl border border-slate-200 shadow-sm grid md:grid-cols-12 gap-8 items-center">
                <div class="md:col-span-7">
                    @if($utama->thumbnail)
                        <img src="{{ asset('storage/' . $utama->thumbnail) }}" alt="{{ $utama->judul }}" class="w-full h-72 md:h-80 object-cover rounded-2xl shadow-sm border border-slate-200">
                    @else
                        <div class="w-full h-72 md:h-80 bg-slate-100 rounded-2xl border border-slate-200 flex items-center justify-center text-slate-400 text-xs font-medium">
                            Tidak ada gambar sampul
                        </div>
                    @endif
                </div>
                <div class="md:col-span-5 space-y-3">
                    <div class="flex items-center space-x-2">
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-md uppercase
                            {{ strtolower($utama->kategori) == 'pengumuman' ? 'text-amber-700 bg-amber-50 border border-amber-200' : 'text-emerald-700 bg-emerald-50 border border-emerald-200' }}">
                            {{ $utama->kategori }}
                        </span>
                        <span class="text-xs text-slate-400">{{ $utama->tanggal ? \Carbon\Carbon::parse($utama->tanggal)->format('d M Y') : $utama->created_at->format('d M Y') }}</span>
                    </div>
                    <h2 class="text-xl md:text-2xl font-bold text-slate-900 leading-snug">
                        {{ $utama->judul }}
                    </h2>
                    <p class="text-slate-600 text-xs md:text-sm leading-relaxed">
                        {{ \Illuminate\Support\Str::limit(strip_tags($utama->isi), 220) }}
                    </p>
                    <div class="pt-2">
                        <button type="button"
                                onclick="bukaModalBerita(this)"
                                data-judul="{{ $utama->judul }}"
                                data-kategori="{{ $utama->kategori }}"
                                data-tanggal="{{ $utama->tanggal ? \Carbon\Carbon::parse($utama->tanggal)->format('d M Y') : $utama->created_at->format('d M Y') }}"
                                data-thumbnail="{{ $utama->thumbnail ? asset('storage/' . $utama->thumbnail) : '' }}"
                                data-isi="{{ $utama->isi }}"
                                class="inline-flex items-center text-emerald-600 hover:text-emerald-700 font-bold text-xs transition cursor-pointer">
                            Baca Selengkapnya &rarr;
                        </button>
                    </div>
                </div>
            </div>

            <!-- Grid Berita Lainnya -->
            @if($lainnya->count() > 0)
                <div class="grid md:grid-cols-3 gap-8">
                    @foreach($lainnya as $item)
                        <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-200 flex flex-col justify-between">
                            <div>
                                @if($item->thumbnail)
                                    <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->judul }}" class="w-full h-48 object-cover">
                                @else
                                    <div class="w-full h-48 bg-slate-100 flex items-center justify-center text-slate-400 text-xs">
                                        Tidak ada gambar sampul
                                    </div>
                                @endif
                                <div class="p-6">
                                    <div class="flex items-center space-x-2 mb-2">
                                        <span class="text-[11px] font-semibold px-2.5 py-0.5 rounded uppercase
                                            {{ strtolower($item->kategori) == 'pengumuman' ? 'text-amber-700 bg-amber-50' : 'text-emerald-700 bg-emerald-50' }}">
                                            {{ $item->kategori }}
                                        </span>
                                        <span class="text-[11px] text-slate-400">{{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d M Y') : $item->created_at->format('d M Y') }}</span>
                                    </div>
                                    <h3 class="font-bold text-base text-slate-900 mb-2">{{ $item->judul }}</h3>
                                    <p class="text-slate-600 text-xs leading-relaxed">{{ \Illuminate\Support\Str::limit(strip_tags($item->isi), 140) }}</p>
                                </div>
                            </div>
                            <div class="px-6 pb-6">
                                <button type="button"
                                        onclick="bukaModalBerita(this)"
                                        data-judul="{{ $item->judul }}"
                                        data-kategori="{{ $item->kategori }}"
                                        data-tanggal="{{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d M Y') : $item->created_at->format('d M Y') }}"
                                        data-thumbnail="{{ $item->thumbnail ? asset('storage/' . $item->thumbnail) : '' }}"
                                        data-isi="{{ $item->isi }}"
                                        class="text-emerald-600 hover:text-emerald-700 font-bold text-xs cursor-pointer">
                                    Baca Selengkapnya &rarr;
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        @else
            <!-- Tampilan Saat Berita Masih Kosong -->
            <div class="bg-white p-12 rounded-3xl border border-slate-200 shadow-sm text-center space-y-2">
                <p class="text-sm font-bold text-slate-800">Belum Ada Berita & Pengumuman</p>
                <p class="text-xs text-slate-500">Saat ini belum ada berita atau pengumuman resmi yang diterbitkan oleh Pemerintah Desa Tarik.</p>
            </div>
        @endif

    </div>

    <!-- Modal Isi Berita Lengkap -->
    <div id="modalDetailBerita"
         onclick="if(event.target === this) tutupModalBerita()"
         style="display: none;"
         class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/60 p-4 overflow-y-auto">
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xl max-w-2xl w-full p-6 md:p-8 relative max-h-[90vh] overflow-y-auto space-y-5">

            <button type="button" onclick="tutupModalBerita()" class="absolute top-5 right-5 w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-600 flex items-center justify-center transition cursor-pointer">
                ✕
            </button>

            <div class="space-y-2 pr-8">
                <div class="flex items-center space-x-2">
                    <span id="modalBeritaKategori" class="text-[11px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2.5 py-0.5 rounded uppercase"></span>
                    <span id="modalBeritaTanggal" class="text-xs text-slate-400"></span>
                </div>
                <h3 id="modalBeritaJudul" class="text-xl md:text-2xl font-bold text-slate-900 leading-snug"></h3>
            </div>

            <img id="modalBeritaThumbnail" src="" alt="" style="display: none;" class="w-full max-h-80 object-cover rounded-2xl border border-slate-200">

            <div id="modalBeritaIsi" class="text-xs md:text-sm text-slate-700 leading-relaxed whitespace-pre-line"></div>

            <div class="pt-4 border-t border-slate-100 text-right">
                <button type="button" onclick="tutupModalBerita()" class="px-5 py-2.5 rounded-xl bg-slate-950 hover:bg-slate-800 text-white text-xs font-semibold transition cursor-pointer">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <script>
        function bukaModalBerita(el) {
            const modal = document.getElementById('modalDetailBerita');
            const img = document.getElementById('modalBeritaThumbnail');

            document.getElementById('modalBeritaKategori').textContent = el.dataset.kategori;
            document.getElementById('modalBeritaTanggal').textContent = el.dataset.tanggal;
            document.getElementById('modalBeritaJudul').textContent = el.dataset.judul;
            document.getElementById('modalBeritaIsi').textContent = el.dataset.isi;

            if (el.dataset.thumbnail) {
                img.src = el.dataset.thumbnail;
                img.alt = el.dataset.judul;
                img.style.display = 'block';
            } else {
                img.src = '';
                img.style.display = 'none';
            }

            modal.style.display = 'flex';
        }

        function tutupModalBerita() {
            document.getElementById('modalDetailBerita').style.display = 'none';
        }
    </script>
@endsection