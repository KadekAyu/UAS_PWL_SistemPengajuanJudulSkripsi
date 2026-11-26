<!-- SIDEBAR MAHASISWA -->
<aside class="flex w-full flex-col border-r border-sky-100 bg-white md:h-full md:w-60 md:shrink-0 md:overflow-y-auto">

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
           class="flex shrink-0 items-center gap-3 rounded-xl px-4 py-2.5 text-xs font-semibold {{ request()->routeIs('mahasiswa.dashboard') ? 'bg-sky-50 text-sky-600' : 'text-slate-600 hover:bg-slate-50' }} transition">

            <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <rect x="4" y="4" width="6" height="6" rx="1"/>
                <rect x="14" y="4" width="6" height="6" rx="1"/>
                <rect x="4" y="14" width="6" height="6" rx="1"/>
                <rect x="14" y="14" width="6" height="6" rx="1"/>
            </svg>

            <span>Dashboard</span>
        </a>

        <!-- Menu Pengajuan Judul -->
        <a href="{{ route('mahasiswa.pengajuan.create') }}"
           class="flex shrink-0 items-center gap-3 rounded-xl px-4 py-2.5 text-xs font-semibold {{ request()->routeIs('mahasiswa.pengajuan.*') ? 'bg-sky-50 text-sky-600' : 'text-slate-600 hover:bg-slate-50' }} transition">

            <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M13 3H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V10z"/>
                <path d="M13 3v7h7M8 15h8M8 18h5"/>
            </svg>

            <span>Pengajuan Judul</span>
        </a>

        <!-- Menu Riwayat Pengajuan -->
        <a href="{{ route('mahasiswa.riwayat') }}"
           class="flex shrink-0 items-center gap-3 rounded-xl px-4 py-2.5 text-xs font-semibold {{ request()->routeIs('mahasiswa.riwayat') ? 'bg-sky-50 text-sky-600' : 'text-slate-600 hover:bg-slate-50' }} transition">

            <svg class="h-4 w-4 shrink-0"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="1.8">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M12 8v4l3 2m6-2a9 9 0 1 1-2.64-6.36"/>
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M21 3v6h-6"/>
            </svg>

            <span>Riwayat Pengajuan</span>
        </a>

    </nav>

    <!-- LOGOUT -->
    <div class="border-t border-slate-100 p-3 md:mt-auto">
        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button type="submit"
                    class="flex w-full items-center gap-3 rounded-xl px-4 py-2.5 text-xs font-semibold text-rose-600 transition hover:bg-rose-50">

                <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M10 17l5-5-5-5M15 12H3"/>
                    <path d="M12 3h6a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-6"/>
                </svg>

                <span>Logout</span>
            </button>
        </form>
    </div>

</aside>