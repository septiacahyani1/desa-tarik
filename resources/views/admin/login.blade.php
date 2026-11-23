@extends('layouts.app')

@section('title', 'Portal Perangkat Desa - Desa Tarik, Sidoarjo')

@section('content')
    <div class="min-h-[85vh] flex items-center justify-center py-12 px-4 bg-slate-50">
        <div class="max-w-md w-full bg-white p-8 md:p-10 rounded-3xl border border-slate-200 shadow-sm space-y-6">
            
            <!-- Logo & Header -->
            <div class="text-center space-y-3">
                <div class="inline-flex items-center justify-center w-12 h-12 bg-slate-950 text-white font-bold rounded-2xl shadow-sm text-sm">
                    DT
                </div>
                <div>
                    <h1 class="text-xl font-bold text-slate-900 tracking-tight">Portal Perangkat Desa</h1>
                    <p class="text-slate-500 text-xs mt-1.5 leading-relaxed max-w-xs mx-auto">
                        Silakan masuk untuk mengelola Sistem Informasi Desa Tarik.
                    </p>
                </div>
            </div>
<!-- Tambahkan ini di atas <form> -->
@if ($errors->any())
    <div class="bg-rose-50 border border-rose-200 text-rose-600 text-xs rounded-xl p-3.5 font-medium">
        {{ $errors->first() }}
    </div>
@endif

<form action="{{ url('/admin/login') }}" method="POST" class="space-y-4">
            
            <!-- Form Login -->
            <form action="{{ url('/admin/login') }}" method="POST" class="space-y-4">
                @csrf
                
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Username</label>
                    <input type="text" name="username" required placeholder="Masukkan username admin" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:border-slate-900 transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Password</label>
                    <input type="password" name="password" required placeholder="••••••••" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:border-slate-900 transition">
                </div>

                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-slate-900 focus:ring-slate-900 w-4 h-4">
                        <span class="text-slate-600 font-medium">Ingat saya</span>
                    </label>
                </div>

                <button type="submit" class="w-full bg-slate-950 hover:bg-slate-900 text-white font-semibold py-3.5 rounded-xl text-xs transition shadow-sm flex items-center justify-center space-x-2 mt-2">
                    <span>Masuk ke Dashboard</span>
                    <span>&rarr;</span>
                </button>
            </form>

            <!-- Kembali ke Beranda Warga -->
            <div class="text-center pt-3 border-t border-slate-100">
                <a href="{{ url('/') }}" class="inline-flex items-center space-x-1.5 text-xs text-slate-500 hover:text-slate-950 transition font-medium">
                    <span>&larr;</span>
                    <span>Kembali ke Beranda Warga</span>
                </a>
            </div>

        </div>
    </div>
@endsection