<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengaduan; // <-- Jangan lupa panggil model Pengaduan

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/admin/dashboard');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    // Perbarui bagian dashboard ini
    public function dashboard()
    {
        $pengaduans = Pengaduan::latest()->get();
        
        // Hitung statistik dinamis dari database
        $totalLaporan = $pengaduans->count();
        $menunggu = $pengaduans->where('status', 'Menunggu')->count();
        $diproses = $pengaduans->where('status', 'Diproses')->count();
        $selesai = $pengaduans->where('status', 'Selesai')->count();

        return view('admin.dashboard', compact('pengaduans', 'totalLaporan', 'menunggu', 'diproses', 'selesai'));
    }
}