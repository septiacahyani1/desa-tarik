<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminBeritaController;
use App\Http\Controllers\AdminFasilitasController;
use App\Http\Controllers\AdminPengaduanController;
use App\Http\Controllers\AdminProfilController;
use App\Http\Controllers\PengaduanPublikController;
use App\Models\Berita;
use App\Models\Fasilitas;
use App\Models\ProfilDesa;
use App\Models\PesanKontak;

// Halaman Publik & Warga
Route::get('/pengaduan', [PengaduanPublikController::class, 'create']);
Route::post('/pengaduan', [PengaduanPublikController::class, 'store']);

Route::get('/', function () {
    $beritasTerbaru = Berita::where('status', 'Diterbitkan')->latest()->take(3)->get();
    $fasilitasBeranda = Fasilitas::latest()->take(4)->get();

    $pengaduanTerbaru = collect();
    if (class_exists(\App\Models\Pengaduan::class)) {
        $pengaduanTerbaru = \App\Models\Pengaduan::latest()->take(2)->get();
    }

    return view('welcome', compact('beritasTerbaru', 'fasilitasBeranda', 'pengaduanTerbaru'));
});

Route::post('/kontak', function (Request $request) {
    $validated = $request->validate([
        'nama' => 'required|string|max:255',
        'kontak' => 'required|string|max:255',
        'pesan' => 'required|string',
    ]);

    PesanKontak::create($validated);

    return redirect(url('/#kontak'))->with('kontak_success', 'Terima kasih! Pesan Anda sudah terkirim dan tercatat ke sistem Desa Tarik.');
})->name('kontak.store');

Route::get('/profil', function () {
    $profil = ProfilDesa::first();
    return view('profil', compact('profil'));
});

Route::get('/berita', function () {
    $beritas = Berita::where('status', 'Diterbitkan')->latest()->get();
    return view('berita', compact('beritas'));
});

Route::get('/fasilitas', function () {
    $fasilitas = Fasilitas::latest()->get();
    return view('fasilitas', compact('fasilitas'));
});

// Area Admin / Perangkat Desa
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login']);

    Route::middleware(['auth'])->group(function () {
        Route::post('/logout', function (Request $request) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/admin/login');
        })->name('admin.logout');

        Route::get('/dashboard', [AdminAuthController::class, 'dashboard'])->name('admin.dashboard');
        Route::post('/pengaduan/{id}/update', [AdminPengaduanController::class, 'update']);

        // Manajemen Konten Berita & Pengumuman
        Route::get('/berita', [AdminBeritaController::class, 'index'])->name('admin.berita.index');
        Route::post('/berita', [AdminBeritaController::class, 'store'])->name('admin.berita.store');
        Route::post('/berita/{id}/update', [AdminBeritaController::class, 'update'])->name('admin.berita.update');
        Route::delete('/berita/{id}', [AdminBeritaController::class, 'destroy'])->name('admin.berita.destroy');

        // Galeri & Fasilitas Admin
        Route::get('/fasilitas', [AdminFasilitasController::class, 'index'])->name('admin.fasilitas.index');
        Route::post('/fasilitas', [AdminFasilitasController::class, 'store'])->name('admin.fasilitas.store');
        Route::delete('/fasilitas/{id}', [AdminFasilitasController::class, 'destroy'])->name('admin.fasilitas.destroy');

        // Pengaturan Profil Desa Admin
        Route::get('/profil', [AdminProfilController::class, 'index'])->name('admin.profil.index');
        Route::post('/profil', [AdminProfilController::class, 'update'])->name('admin.profil.update');
    });
});