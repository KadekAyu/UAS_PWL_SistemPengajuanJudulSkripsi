<!-- SIDEBAR MAHASISWA -->
<aside class="flex w-full flex-col md:sticky md:top-0 md:h-screen md:w-60 md:shrink-0 bg-white border-r border-sky-100">

    <!-- LOGO -->
    <div class="px-5 py-5">
        <p class="text-2xl font-black tracking-tight text-sky-600">
            SISTA
        </p>

        <p class="mt-1 text-[8px] font-semibold uppercase tracking-widest text-slate-400">
            Portal Skripsi Mahasiswa
        </p>
    </div>

    <!-- NAVIGASI -->
    <nav class="flex gap-2 overflow-x-auto px-3 pb-3 md:flex-1 md:flex-col">

        <p class="px-4 pb-1 pt-2 text-[10px] font-semibold uppercase tracking-widest text-slate-400">
            Ruang Akademik
        </p>

        <!-- Menu Dashboard -->
        <a href="{{ route('mahasiswa.dashboard') }}" 
           class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('mahasiswa.dashboard') ? 'text-sky-600 bg-sky-50' : 'text-slate-600 hover:bg-slate-50' }} transition">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <rect x="4" y="4" width="6" height="6" rx="1"/>
                <rect x="14" y="4" width="6" height="6" rx="1"/>
                <rect x="4" y="14" width="6" height="6" rx="1"/>
                <rect x="14" y="14" width="6" height="6" rx="1"/>
            </svg>
            <span>Dashboard</span>
        </a>

        <!-- Menu Pengajuan Judul -->
        <a href="{{ route('mahasiswa.pengajuan.create') }}" 
           class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('mahasiswa.pengajuan.*') ? 'text-sky-600 bg-sky-50' : 'text-slate-600 hover:bg-slate-50' }} transition">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M13 3H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V10z"/>
                <path d="M13 3v7h7M8 15h8M8 18h5"/>
            </svg>
            <span>Pengajuan Judul</span>
        </a>

        <!-- Menu Riwayat Pengajuan -->
        <a href="{{ route('mahasiswa.riwayat') }}" 
           class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('mahasiswa.riwayat') ? 'text-sky-600 bg-sky-50' : 'text-slate-600 hover:bg-slate-50' }} transition">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <circle cx="12" cy="12" r="9"/>
                <path d="M12 7v5l3 2"/>
            </svg>
            <span>Riwayat Pengajuan</span>
        </a>

    </nav>

    <!-- LOGOUT -->
    <div class="border-t border-slate-100 p-3">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="flex w-full items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-semibold text-rose-600 hover:bg-rose-50 transition">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M10 17l5-5-5-5M15 12H3"/>
                    <path d="M12 3h6a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-6"/>
                </svg>
                <span>Logout</span>
            </button>
        </form>
    </div>

</aside>