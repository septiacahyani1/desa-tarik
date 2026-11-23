@extends('layouts.admin')

@section('title', 'Manajemen Konten - Admin Desa Tarik')
@section('header-title', 'Manajemen Konten')

@section('admin-content')
    <div x-data="{
        openCreateModal: false,
        openEditModal: false,
        thumbNameCreate: '',
        thumbNameEdit: '',
        editData: {
            id: '',
            judul: '',
            kategori: 'Berita Desa',
            status: 'Diterbitkan',
            tanggal: '',
            isi: '',
            thumbnail: ''
        },
        openEdit(item) {
            this.editData = { ...item };
            this.thumbNameEdit = '';
            this.openEditModal = true;
        }
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

        <!-- Navigasi Tab -->
        <div class="flex items-center space-x-6 border-b border-slate-200 mb-6 text-xs font-semibold">
            <a href="{{ url('/admin/berita') }}"
               class="pb-3 border-b-2 {{ request()->is('admin/berita*') ? 'border-slate-900 text-slate-900' : 'border-transparent text-slate-500 hover:text-slate-800' }} transition">
                Berita & Pengumuman
            </a>
            <a href="{{ url('/admin/fasilitas') }}"
               class="pb-3 border-b-2 {{ request()->is('admin/fasilitas*') ? 'border-slate-900 text-slate-900' : 'border-transparent text-slate-500 hover:text-slate-800' }} transition">
                Galeri & Fasilitas
            </a>
        </div>

        <!-- Card Daftar Berita & Pengumuman -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden">
            <div class="p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-100">
                <div>
                    <h2 class="text-base font-bold text-slate-900">Daftar Berita & Pengumuman</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Kelola publikasi pengumuman dan kegiatan warga Desa Tarik.</p>
                </div>

                <button type="button"
                        @click="thumbNameCreate = ''; openCreateModal = true"
                        class="inline-flex items-center justify-center bg-slate-950 hover:bg-slate-800 text-white text-xs font-semibold px-4 py-2.5 rounded-xl transition cursor-pointer shrink-0">
                    + Tulis Berita Baru
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-100 text-[11px] font-semibold text-slate-500">
                            <th class="py-3.5 px-6">Artikel</th>
                            <th class="py-3.5 px-6">Kategori</th>
                            <th class="py-3.5 px-6">Tanggal</th>
                            <th class="py-3.5 px-6">Status</th>
                            <th class="py-3.5 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        @forelse($beritas as $item)
                            @php
                                $tglRaw = $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('Y-m-d') : $item->created_at->format('Y-m-d');
                                $tglTampil = $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d M Y') : $item->created_at->format('d M Y');
                            @endphp
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="py-4 px-6 max-w-md">
                                    <div class="flex items-center gap-3.5">
                                        @if($item->thumbnail)
                                            <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->judul }}" class="w-12 h-9 rounded-lg object-cover border border-slate-200 shrink-0">
                                        @else
                                            <div class="w-12 h-9 rounded-lg bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400 text-[10px] shrink-0">
                                                IMG
                                            </div>
                                        @endif
                                        <div class="min-w-0">
                                            <p class="font-bold text-slate-900 truncate">{{ $item->judul }}</p>
                                            <p class="text-slate-500 text-[11px] truncate">{{ \Illuminate\Support\Str::limit(strip_tags($item->isi), 65) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-slate-600 whitespace-nowrap">{{ $item->kategori }}</td>
                                <td class="py-4 px-6 text-slate-500 whitespace-nowrap">{{ $tglTampil }}</td>
                                <td class="py-4 px-6 whitespace-nowrap">
                                    <span class="inline-block px-2.5 py-1 rounded-md text-[10px] font-bold uppercase
                                        {{ strtolower($item->status) == 'diterbitkan' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-600 border border-slate-200' }}">
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-2">
                                        <button type="button"
                                                @click="openEdit({
                                                    id: '{{ $item->id }}',
                                                    judul: @js($item->judul),
                                                    kategori: @js($item->kategori),
                                                    status: @js($item->status),
                                                    tanggal: '{{ $tglRaw }}',
                                                    isi: @js($item->isi),
                                                    thumbnail: @js($item->thumbnail)
                                                })"
                                                class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-100 font-semibold text-[11px] transition cursor-pointer">
                                            Edit
                                        </button>

                                        <form action="{{ url('/admin/berita/' . $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus berita ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 rounded-lg border border-rose-200 text-rose-600 hover:bg-rose-50 font-semibold text-[11px] transition cursor-pointer">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-slate-400 font-medium">
                                    Belum ada berita atau pengumuman. Klik <strong>+ Tulis Berita Baru</strong> untuk menambahkan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- MODAL TULIS BERITA BARU -->
        <div x-show="openCreateModal"
             style="display: none;"
             class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/40 backdrop-blur-xs p-4 overflow-y-auto"
             x-transition.opacity>
            <div @click.away="openCreateModal = false"
                 class="bg-white rounded-3xl border border-slate-200 shadow-xl max-w-lg w-full p-6 md:p-7 relative max-h-[92vh] overflow-y-auto">

                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-bold text-slate-900">Tulis Berita Baru</h3>
                    <button type="button" @click="openCreateModal = false" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition cursor-pointer">
                        ✕
                    </button>
                </div>

                <form action="{{ url('/admin/berita') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Judul Berita / Pengumuman</label>
                        <input type="text" name="judul" required placeholder="Contoh: Bupati Sidoarjo Tinjau Kebakaran KB/TK ..." class="w-full bg-slate-50/70 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:border-slate-900 transition">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Kategori</label>
                            <select name="kategori" required class="w-full bg-slate-50/70 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-slate-900 transition cursor-pointer">
                                <option value="Berita Desa">Berita Desa</option>
                                <option value="Pengumuman">Pengumuman</option>
                                <option value="Kegiatan Warga">Kegiatan Warga</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Status Publikasi</label>
                            <select name="status" required class="w-full bg-slate-50/70 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-slate-900 transition cursor-pointer">
                                <option value="Diterbitkan">Diterbitkan</option>
                                <option value="Draft">Draft</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Tanggal Publikasi</label>
                            <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required class="w-full bg-slate-50/70 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-slate-900 transition cursor-pointer">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Upload Thumbnail</label>
                        <div class="relative border-2 border-dashed border-slate-200 rounded-2xl p-5 text-center hover:bg-slate-50 transition cursor-pointer">
                            <input type="file" name="thumbnail" accept="image/jpeg,image/png,image/jpg,image/webp" @change="thumbNameCreate = $event.target.files[0] ? $event.target.files[0].name : ''" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="text-slate-400 text-lg mb-1">⭱</div>
                            <p class="text-xs text-slate-500 font-medium" x-text="thumbNameCreate ? 'File terpilih: ' + thumbNameCreate : 'Klik untuk pilih gambar sampul (JPG/PNG)'"></p>
                            <p class="text-[10px] mt-0.5" :class="thumbNameCreate ? 'text-emerald-600 font-bold' : 'text-slate-400'" x-text="thumbNameCreate ? '✓ Gambar siap diunggah' : 'Opsional • Maks. 5MB'"></p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Isi Berita</label>
                        <textarea name="isi" rows="4" required placeholder="Tuliskan detail informasi berita desa atau pengumuman desa..." class="w-full bg-slate-50/70 border border-slate-200 rounded-xl p-4 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:border-slate-900 transition leading-relaxed"></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100">
                        <button type="button" @click="openCreateModal = false" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-semibold transition cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-slate-950 hover:bg-slate-800 text-white text-xs font-semibold transition cursor-pointer">
                            Simpan Berita
                        </button>
                    </div>
                </form>

            </div>
        </div>

        <!-- MODAL EDIT BERITA -->
        <div x-show="openEditModal"
             style="display: none;"
             class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/40 backdrop-blur-xs p-4 overflow-y-auto"
             x-transition.opacity>
            <div @click.away="openEditModal = false"
                 class="bg-white rounded-3xl border border-slate-200 shadow-xl max-w-lg w-full p-6 md:p-7 relative max-h-[92vh] overflow-y-auto">

                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-bold text-slate-900">Edit Berita / Pengumuman</h3>
                    <button type="button" @click="openEditModal = false" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition cursor-pointer">
                        ✕
                    </button>
                </div>

                <form :action="'/admin/berita/' + editData.id + '/update'" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Judul Berita / Pengumuman</label>
                        <input type="text" name="judul" x-model="editData.judul" required class="w-full bg-slate-50/70 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-slate-900 transition">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Kategori</label>
                            <select name="kategori" x-model="editData.kategori" required class="w-full bg-slate-50/70 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-slate-900 transition cursor-pointer">
                                <option value="Berita Desa">Berita Desa</option>
                                <option value="Pengumuman">Pengumuman</option>
                                <option value="Kegiatan Warga">Kegiatan Warga</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Status Publikasi</label>
                            <select name="status" x-model="editData.status" required class="w-full bg-slate-50/70 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-slate-900 transition cursor-pointer">
                                <option value="Diterbitkan">Diterbitkan</option>
                                <option value="Draft">Draft</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Tanggal Publikasi</label>
                            <input type="date" name="tanggal" x-model="editData.tanggal" required class="w-full bg-slate-50/70 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-slate-900 transition cursor-pointer">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Ganti Thumbnail (Opsional)</label>
                        <div class="relative border-2 border-dashed border-slate-200 rounded-2xl p-4 text-center hover:bg-slate-50 transition cursor-pointer">
                            <input type="file" name="thumbnail" accept="image/jpeg,image/png,image/jpg,image/webp" @change="thumbNameEdit = $event.target.files[0] ? $event.target.files[0].name : ''" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <p class="text-xs text-slate-500 font-medium" x-text="thumbNameEdit ? 'File terpilih: ' + thumbNameEdit : 'Klik untuk ganti gambar sampul (JPG/PNG)'"></p>
                        </div>
                        <template x-if="editData.thumbnail">
                            <div class="mt-2">
                                <p class="text-[10px] text-slate-500 mb-1">Thumbnail saat ini:</p>
                                <img :src="'/storage/' + editData.thumbnail" alt="Thumbnail" class="h-24 rounded-xl object-cover border border-slate-200">
                            </div>
                        </template>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Isi Berita</label>
                        <textarea name="isi" x-model="editData.isi" rows="4" required class="w-full bg-slate-50/70 border border-slate-200 rounded-xl p-4 text-xs text-slate-800 focus:outline-none focus:border-slate-900 transition leading-relaxed"></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100">
                        <button type="button" @click="openEditModal = false" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-semibold transition cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-slate-950 hover:bg-slate-800 text-white text-xs font-semibold transition cursor-pointer">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>
@endsection