<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tinjauan Dasbor - Admin Desa Tarik')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js untuk Modal Interaktif -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-[#f8fafc] text-slate-800 font-sans antialiased">

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar Admin -->
        <aside class="w-64 bg-[#0f172a] text-white flex flex-col justify-between shrink-0">
            <div>
                <!-- Brand Logo -->
                <div class="px-6 py-7 flex items-center space-x-3.5">
                    <div class="w-9 h-9 bg-white text-[#0f172a] font-extrabold rounded-xl flex items-center justify-center text-xs tracking-tight shadow-xs">
                        DT
                    </div>
                    <span class="font-bold text-base tracking-tight text-white">Admin Desa</span>
                </div>

                <!-- Menu Navigasi -->
                <nav class="px-4 mt-2 space-y-1.5 text-sm">
                    <a href="{{ url('/admin/dashboard') }}"
                       class="flex items-center space-x-3.5 px-4 py-3 rounded-xl transition {{ request()->is('admin/dashboard') ? 'bg-slate-800/90 text-white font-semibold' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white font-medium' }}">
                        <!-- Icon Home -->
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ url('/admin/berita') }}"
                       class="flex items-center space-x-3.5 px-4 py-3 rounded-xl transition {{ request()->is('admin/berita*') || request()->is('admin/fasilitas*') ? 'bg-slate-800/90 text-white font-semibold' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white font-medium' }}">
                        <!-- Icon Layers / Konten -->
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <span>Manajemen Konten</span>
                    </a>

                    <a href="{{ url('/admin/profil') }}"
                       class="flex items-center space-x-3.5 px-4 py-3 rounded-xl transition {{ request()->is('admin/profil*') ? 'bg-slate-800/90 text-white font-semibold' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white font-medium' }}">
                        <!-- Icon Gear / Pengaturan -->
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>Pengaturan Profil</span>
                    </a>
                </nav>
            </div>

            <!-- Tombol Keluar di Bawah -->
            <div class="p-4">
                <form action="{{ url('/admin/logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                       class="flex items-center justify-center space-x-2 w-full py-2.5 px-4 rounded-xl bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 text-xs font-semibold transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-y-auto">
            <!-- Top Header -->
            <header class="bg-white border-b border-slate-200/80 px-8 py-4 flex justify-between items-center">
                <h1 class="text-base font-bold text-slate-900 tracking-tight">@yield('header-title', 'Tinjauan Dasbor')</h1>
                
                <div class="flex items-center space-x-3">
                    <div class="text-right">
                        <p class="text-xs font-bold text-slate-900 leading-tight">{{ Auth::user()->name ?? 'Admin Desa' }}</p>
                        <p class="text-[11px] text-slate-400 font-medium">Administrator</p>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-slate-200 border border-slate-300 overflow-hidden flex items-center justify-center text-slate-600 font-bold text-xs">
                        <svg class="w-5 h-5 text-slate-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                        </svg>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-8 space-y-6">
                @yield('admin-content')
            </main>
        </div>
    </div>

</body>
</html>