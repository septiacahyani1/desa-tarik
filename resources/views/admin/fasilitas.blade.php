@extends('layouts.admin')

@section('title', 'Manajemen Galeri & Fasilitas - Admin Desa Tarik')
@section('header-title', 'Manajemen Konten')

@section('admin-content')
    <div x-data="{
        openAddModal: false,
        photoName: ''
    }">

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

        <!-- Navigasi Tab / Kategori Konten -->
        <div class="border-b border-slate-200 mb-6">
            <div class="flex space-x-8 text-sm font-semibold">
                <a href="{{ url('/admin/berita') }}"
                   class="pb-3 border-b-2 {{ request()->is('admin/berita*') ? 'border-slate-900 text-slate-900' : 'border-transparent text-slate-400 hover:text-slate-700' }} transition">
                    Berita & Pengumuman
                </a>
                <a href="{{ url('/admin/fasilitas') }}"
                   class="pb-3 border-b-2 {{ request()->is('admin/fasilitas*') ? 'border-slate-900 text-slate-900' : 'border-transparent text-slate-400 hover:text-slate-700' }} transition">
                    Galeri & Fasilitas
                </a>
            </div>
        </div>

        <!-- Konten Tab 2: Galeri & Fasilitas -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-sm font-bold text-slate-900">Galeri Dokumentasi & Fasilitas Desa</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Foto yang ditambahkan akan tampil pada halaman Fasilitas & Galeri publik.</p>
                </div>
                <button type="button"
                        @click="photoName = ''; openAddModal = true"
                        class="bg-slate-950 hover:bg-slate-900 text-white text-xs font-semibold px-4 py-2.5 rounded-xl transition shadow-2xs flex items-center justify-center space-x-2 cursor-pointer">
                    <span>+ Tambah Galeri/Fasilitas</span>
                </button>
            </div>

            <!-- Grid Kartu Fasilitas -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($fasilitas as $item)
                    <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-2xs flex flex-col justify-between">
                        <div>
                            <div class="relative h-44 bg-slate-100 overflow-hidden flex items-center justify-center">
                                @if($item->foto)
                                    <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-xs text-slate-400 font-medium">Tidak ada foto</span>
                                @endif
                                <span class="absolute top-3 left-3 bg-slate-900/80 backdrop-blur-md text-white font-bold text-[10px] tracking-wider uppercase px-2.5 py-1 rounded-md">
                                    {{ $item->kategori }}
                                </span>
                            </div>
                            <div class="p-5">
                                <h3 class="font-bold text-slate-900 text-sm">{{ $item->nama }}</h3>
                                <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">{{ $item->deskripsi }}</p>
                            </div>
                        </div>
                        <div class="p-5 pt-0">
                            <form action="{{ url('/admin/fasilitas/' . $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus item ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="w-full py-2.5 rounded-xl border border-slate-200 text-slate-700 hover:bg-rose-50 hover:text-rose-600 hover:border-rose-200 text-xs font-semibold transition cursor-pointer">
                                    Hapus Item
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center text-xs text-slate-400 font-medium">
                        Belum ada data galeri atau fasilitas. Klik <strong>+ Tambah Galeri/Fasilitas</strong> untuk menambahkan.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Modal Tambah Galeri / Fasilitas -->
        <div x-show="openAddModal"
             style="display: none;"
             class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/40 backdrop-blur-xs p-4 overflow-y-auto"
             x-transition.opacity>
            <div @click.away="openAddModal = false"
                 class="bg-white rounded-3xl border border-slate-200 shadow-xl max-w-lg w-full p-6 md:p-7 relative max-h-[92vh] overflow-y-auto">

                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-bold text-slate-900">Tambah Galeri / Fasilitas</h3>
                    <button type="button" @click="openAddModal = false" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition cursor-pointer">
                        ✕
                    </button>
                </div>

                <form action="{{ url('/admin/fasilitas') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Fasilitas / Dokumentasi</label>
                        <input type="text" name="nama" required placeholder="Contoh: Lapangan Desa Tarik" class="w-full bg-slate-50/70 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:border-slate-900 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Kategori</label>
                        <select name="kategori" required class="w-full bg-slate-50/70 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-slate-900 transition cursor-pointer">
                            <option value="FASILITAS SOSIAL">FASILITAS SOSIAL</option>
                            <option value="FASILITAS UMUM">FASILITAS UMUM</option>
                            <option value="DOKUMENTASI KEGIATAN">DOKUMENTASI KEGIATAN</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Upload Foto</label>
                        <div class="relative border-2 border-dashed border-slate-200 rounded-2xl p-4 text-center hover:bg-slate-50 transition cursor-pointer">
                            <input type="file" name="foto" accept="image/jpeg,image/png,image/jpg,image/webp" @change="photoName = $event.target.files[0] ? $event.target.files[0].name : ''" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="text-slate-400 text-lg mb-1">⭱</div>
                            <p class="text-xs text-slate-500 font-medium" x-text="photoName ? 'File terpilih: ' + photoName : 'Klik untuk pilih foto (JPG/PNG)'"></p>
                            <p class="text-[10px] mt-0.5" :class="photoName ? 'text-emerald-600 font-bold' : 'text-slate-400'" x-text="photoName ? '✓ Foto siap diunggah' : 'Opsional • Maks. 5MB'"></p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Deskripsi Singkat</label>
                        <textarea name="deskripsi" rows="3" required placeholder="Tuliskan keterangan singkat fasilitas atau dokumentasi..." class="w-full bg-slate-50/70 border border-slate-200 rounded-xl p-4 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:border-slate-900 transition leading-relaxed"></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100">
                        <button type="button" @click="openAddModal = false" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-semibold transition cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-slate-950 hover:bg-slate-800 text-white text-xs font-semibold transition cursor-pointer">
                            Simpan Item
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>
@endsection