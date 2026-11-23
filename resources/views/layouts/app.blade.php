<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Desa Tarik - Sidoarjo')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased flex flex-col min-h-screen">

    <!-- Navbar Warga -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="{{ url('/') }}" class="flex items-center space-x-3">
                <span class="bg-slate-900 text-white font-bold px-3 py-1.5 rounded-lg text-sm">DT</span>
                <span class="text-lg font-bold text-slate-900 tracking-wide">Desa Tarik</span>
            </a>
            
            <nav class="hidden md:flex space-x-8 text-sm font-medium text-slate-600">
                <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'text-slate-950 font-bold border-b-2 border-slate-950 pb-1' : 'hover:text-slate-900' }} transition">Beranda</a>
                <a href="{{ url('/profil') }}" class="{{ request()->is('profil') ? 'text-slate-950 font-bold border-b-2 border-slate-950 pb-1' : 'hover:text-slate-900' }} transition">Profil Desa</a>
                <a href="{{ url('/berita') }}" class="{{ request()->is('berita') ? 'text-slate-950 font-bold border-b-2 border-slate-950 pb-1' : 'hover:text-slate-900' }} transition">Berita</a>
                <a href="{{ url('/pengaduan') }}" class="{{ request()->is('pengaduan') ? 'text-slate-950 font-bold border-b-2 border-slate-950 pb-1' : 'hover:text-slate-900' }} transition">Pengaduan</a>
                <a href="{{ url('/fasilitas') }}" class="{{ request()->is('fasilitas') ? 'text-slate-950 font-bold border-b-2 border-slate-950 pb-1' : 'hover:text-slate-900' }} transition">Fasilitas</a>
            </nav>

            <div class="flex items-center space-x-4">
                <!-- Tombol Lapor Warga diarahkan langsung ke Login Admin -->
                <a href="{{ url('/admin/login') }}" class="bg-slate-900 hover:bg-slate-800 text-white px-5 py-2.5 rounded-full text-sm font-semibold transition shadow-sm">
                    Login Admin
                </a>
            </div>
        </div>
    </header>

    <main class="flex-grow">
        @yield('content')
    </main>

    <footer class="bg-slate-950 text-white py-12 border-t border-slate-800 mt-auto">
        <div class="max-w-7xl mx-auto px-4 grid md:grid-cols-2 gap-8 items-center">
            <div>
                <div class="flex items-center space-x-2 mb-3">
                    <span class="bg-slate-800 text-white font-bold px-2.5 py-1 rounded text-xs">DT</span>
                    <span class="font-bold text-base">Pemerintah Desa Tarik</span>
                </div>
                <p class="text-slate-400 text-sm leading-relaxed">
                    Jl. Raya Tarik No.20-4, Tarik Lor, Tarik, Kec. Tarik, Kabupaten Sidoarjo, Jawa Timur 61265.
                </p>
            </div>
            <div class="md:text-right">
                <p class="text-slate-300 text-sm font-medium">info@desatarik.id | 085784457716</p>
                <div class="mt-3 space-x-4 text-xs text-slate-500">
                    <a href="{{ url('/admin/login') }}" class="hover:text-slate-300 transition">Portal Perangkat Desa</a>
                    <span>&bull;</span>
                    <span>&copy; 2026 Desa Tarik, Sidoarjo.</span>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>