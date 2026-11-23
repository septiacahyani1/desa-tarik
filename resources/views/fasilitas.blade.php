@extends('layouts.app')

@section('title', 'Fasilitas & Galeri - Desa Tarik, Sidoarjo')

@section('content')
    <!-- 1. Hero Section Fasilitas & Galeri -->
    <section class="relative bg-slate-950 text-white py-24 px-4 overflow-hidden">
        <div class="absolute inset-0 opacity-25 mix-blend-overlay">
            <img src="{{ asset('img/Balai Desa.png') }}" alt="Kantor Desa Tarik" class="w-full h-full object-cover">
        </div>
        <div class="max-w-7xl mx-auto text-center relative z-10">
            <span class="inline-block bg-slate-800/80 text-emerald-400 border border-slate-700 text-xs font-semibold px-3.5 py-1.5 rounded-full mb-4 tracking-widest uppercase">
                &bull; SARANA & PRASARANA
            </span>
            <h1 class="text-3xl md:text-5xl font-extrabold mb-4 tracking-tight">
                Fasilitas & Galeri
            </h1>
            <p class="text-xs md:text-sm text-slate-300 max-w-xl mx-auto leading-relaxed">
                Pemerintah Desa Tarik berkomitmen merawat dan menyediakan fasilitas terbaik untuk menunjang kebutuhan administrasi, kesehatan, hingga ruang sosial bagi seluruh warga.
            </p>
        </div>
    </section>

    <!-- 2. Grid Kartu Fasilitas (3 Kolom sesuai UI/UX) -->
    <div class="max-w-7xl mx-auto px-4 py-16">
        @if($fasilitas->count() > 0)
            <div class="grid md:grid-cols-3 gap-8">
                @foreach($fasilitas as $item)
                    <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-200 flex flex-col justify-between">
                        <div>
                            <div class="relative h-52 bg-slate-100 overflow-hidden flex items-center justify-center">
                                @if($item->foto)
                                    <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-xs text-slate-400 font-medium">Tidak ada foto</span>
                                @endif
                                <span class="absolute top-3.5 left-3.5 bg-slate-900/80 backdrop-blur-md text-white font-bold text-[10px] tracking-wider uppercase px-2.5 py-1 rounded-md">
                                    {{ $item->kategori }}
                                </span>
                            </div>
                            <div class="p-6 space-y-2">
                                <h3 class="font-bold text-lg text-slate-900">{{ $item->nama }}</h3>
                                <p class="text-slate-600 text-xs leading-relaxed">{{ $item->deskripsi }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white p-12 rounded-3xl border border-slate-200 shadow-sm text-center space-y-2">
                <p class="text-sm font-bold text-slate-800">Belum Ada Foto Fasilitas & Galeri</p>
                <p class="text-xs text-slate-500">Saat ini belum ada data fasilitas atau dokumentasi yang ditambahkan oleh admin.</p>
            </div>
        @endif
    </div>
@endsection