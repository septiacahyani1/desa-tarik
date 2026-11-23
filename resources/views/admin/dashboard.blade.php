@extends('layouts.admin')

@section('title', 'Tinjauan Dasbor - Admin Desa Tarik')
@section('header-title', 'Tinjauan Dasbor')

@section('admin-content')
    <div x-data="{ 
        openModal: false, 
        selectedLaporan: {} 
    }">

        @if(session('success'))
            <div class="mb-6 bg-emerald-100 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-2xl text-xs font-bold shadow-2xs">
                {{ session('success') }}
            </div>
        @endif

        <!-- 4 Kartu Ringkasan -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
            <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-2xs">
                <p class="text-xs font-medium text-slate-500">Total Laporan Masuk</p>
                <p class="text-2xl font-extrabold text-slate-900 mt-2">{{ $totalLaporan ?? 0 }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-200/80 border-l-4 border-l-slate-400 p-5 shadow-2xs">
                <p class="text-xs font-medium text-slate-500">Menunggu Tinjauan</p>
                <p class="text-2xl font-extrabold text-slate-900 mt-2">{{ $menunggu ?? 0 }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-200/80 border-l-4 border-l-amber-400 p-5 shadow-2xs">
                <p class="text-xs font-medium text-slate-500">Sedang Diproses</p>
                <p class="text-2xl font-extrabold text-slate-900 mt-2">{{ $diproses ?? 0 }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-200/80 border-l-4 border-l-emerald-400 p-5 shadow-2xs">
                <p class="text-xs font-medium text-slate-500">Selesai Ditangani</p>
                <p class="text-2xl font-extrabold text-slate-900 mt-2">{{ $selesai ?? 0 }}</p>
            </div>
        </div>

        <!-- Tabel Manajemen Pengaduan -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden">
            <div class="px-6 py-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <h2 class="text-sm font-bold text-slate-900">Manajemen Layanan Pengaduan</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 border-y border-slate-100 text-[11px] font-semibold text-slate-500">
                            <th class="py-3.5 px-6">Pelapor</th>
                            <th class="py-3.5 px-6">Judul Laporan</th>
                            <th class="py-3.5 px-6">Kategori</th>
                            <th class="py-3.5 px-6 text-right pr-10">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        @forelse($pengaduans as $item)
                            <tr @click="openModal = true; selectedLaporan = { 
                                id: '{{ $item->id }}', 
                                pelapor: '{{ addslashes($item->nama) }}', 
                                judul: `{{ addslashes($item->judul) }}`, 
                                kategori: '{{ $item->kategori }}', 
                                waktu: '{{ $item->created_at->diffForHumans() }}', 
                                desc: `{{ addslashes($item->deskripsi) }}`, 
                                status: '{{ $item->status }}', 
                                tanggapan: `{{ addslashes($item->tanggapan) }}`, 
                                foto: '{{ $item->foto }}',
                                foto_tanggapan: '{{ $item->foto_tanggapan }}' 
                            }" 
                                class="hover:bg-slate-50/80 transition cursor-pointer">
                                <td class="py-4 px-6 font-bold text-slate-800">{{ $item->nama }}</td>
                                <td class="py-4 px-6 text-slate-600">{{ $item->judul }}</td>
                                <td class="py-4 px-6 text-slate-500">{{ $item->kategori }}</td>
                                <td class="py-4 px-6 text-right pr-8">
                                    <span class="inline-block px-3 py-1 rounded-full font-bold text-[10px] tracking-wider uppercase
                                        {{ $item->status == 'Selesai' ? 'bg-emerald-100 text-emerald-700' : ($item->status == 'Diproses' ? 'bg-amber-100 text-amber-700' : 'bg-slate-100 text-slate-600') }}">
                                        {{ strtoupper($item->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-slate-400 font-medium">
                                    Belum ada data pengaduan yang masuk dari warga.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-slate-100 flex items-center justify-between text-xs">
                <p class="text-slate-500">Total laporan: {{ $pengaduans->count() }}</p>
            </div>
        </div>

        <!-- MODAL TINDAK LANJUT ADMIN -->
        <div x-show="openModal" 
             style="display: none;"
             class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/40 backdrop-blur-xs p-4 overflow-y-auto"
             x-transition.opacity>
            
            <div @click.away="openModal = false" 
                 class="bg-white rounded-3xl border border-slate-200 shadow-xl max-w-lg w-full p-6 md:p-8 space-y-6 relative max-h-[90vh] overflow-y-auto">
                
                <form :action="'/admin/pengaduan/' + selectedLaporan.id + '/update'" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <button type="button" @click="openModal = false" class="absolute top-6 right-6 w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition">
                        ✕
                    </button>

                    <h3 class="text-base font-bold text-slate-900">Tindak Lanjut Laporan</h3>

                    <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-4 space-y-2">
                        <div class="flex justify-between items-center text-[11px]">
                            <span class="font-bold text-slate-500 uppercase tracking-wider" x-text="selectedLaporan.kategori"></span>
                            <span class="text-slate-400" x-text="selectedLaporan.waktu"></span>
                        </div>
                        <h4 class="font-bold text-slate-900 text-sm" x-text="selectedLaporan.judul"></h4>
                        <p class="text-xs text-slate-600 leading-relaxed" x-text="selectedLaporan.desc"></p>
                        <p class="text-xs font-medium text-slate-500 pt-1">Pelapor: <span class="font-bold text-slate-800" x-text="selectedLaporan.pelapor"></span></p>

                        <!-- Pratinjau Foto Warga -->
                        <template x-if="selectedLaporan.foto && selectedLaporan.foto !== ''">
                            <div class="pt-3 border-t border-slate-200/60 mt-3">
                                <span class="block text-[11px] font-bold text-slate-700 uppercase mb-1.5">Bukti Foto dari Warga:</span>
                                <div class="bg-white p-1.5 rounded-xl border border-slate-200 text-center">
                                    <img :src="'/storage/' + selectedLaporan.foto" alt="Bukti Foto Warga" class="w-full max-h-48 object-contain rounded-lg mx-auto">
                                </div>
                            </div>
                        </template>
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Ubah Status Laporan</label>
                        <select name="status" x-model="selectedLaporan.status" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs text-slate-800 font-medium focus:outline-none focus:border-slate-900 transition cursor-pointer">
                            <option value="Menunggu">Menunggu Tinjauan</option>
                            <option value="Diproses">Sedang Diproses (Tindakan Berjalan)</option>
                            <option value="Selesai">Selesai Ditangani</option>
                        </select>
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Pesan Tanggapan Desa</label>
                        <textarea name="tanggapan" x-model="selectedLaporan.tanggapan" rows="3" placeholder="Ketik tindakan yang sedang/sudah dilakukan..." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-4 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:border-slate-900 transition leading-relaxed"></textarea>
                    </div>

                    <!-- Input Upload Foto Bukti Penanganan oleh Admin dengan Alpine.js (Ada Petanda Nama File) -->
                    <div class="space-y-1.5" x-data="{ adminFileName: '' }">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Foto Bukti Penanganan (Opsional)</label>
                        <div class="relative border-2 border-dashed border-slate-200 rounded-2xl p-4 text-center hover:bg-slate-50 transition cursor-pointer">
                            <input type="file" name="foto_tanggapan" @change="adminFileName = $event.target.files[0] ? $event.target.files[0].name : ''" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            
                            <div class="space-y-1">
                                <div class="text-slate-400 text-sm mb-0.5">📷</div>
                                <p class="text-xs text-slate-600 font-semibold" x-text="adminFileName ? 'File terpilih: ' + adminFileName : 'Klik atau seret foto bukti penanganan'"></p>
                                <p class="text-[10px]" :class="adminFileName ? 'text-emerald-600 font-bold' : 'text-slate-400'" x-text="adminFileName ? '✓ Foto penanganan siap dipublikasikan' : 'Format: JPG, PNG, GIF (Maks. 5MB)'"></p>
                            </div>
                        </div>

                        <!-- Pratinjau Foto Tanggapan Saat Ini dari Database -->
                        <template x-if="selectedLaporan.foto_tanggapan && selectedLaporan.foto_tanggapan !== ''">
                            <div class="mt-2 p-2 bg-slate-50 rounded-xl border border-slate-200 text-center">
                                <p class="text-[10px] font-bold text-slate-500 mb-1">Foto Penanganan Saat Ini:</p>
                                <img :src="'/storage/' + selectedLaporan.foto_tanggapan" alt="Foto Tanggapan" class="w-full max-h-36 object-contain rounded-lg mx-auto">
                            </div>
                        </template>
                    </div>

                    <div class="flex items-center justify-end space-x-3 pt-2 border-t border-slate-100">
                        <button type="button" @click="openModal = false" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-semibold transition">
                            Tutup
                        </button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-slate-950 hover:bg-slate-900 text-white text-xs font-semibold transition shadow-xs">
                            Simpan & Publikasikan
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>
@endsection