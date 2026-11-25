<aside class="flex w-full flex-col border-b border-sky-100 bg-white md:sticky md:top-0 md:h-screen md:w-60 md:shrink-0 md:border-b-0 md:border-r">

    <!-- LOGO -->
    <div class="px-5 py-5">
        <p class="text-2xl font-black tracking-tight text-sky-600">
            SISTA
        </p>

        <p class="mt-1 text-[8px] font-semibold uppercase tracking-widest text-slate-400">
            Portal Skripsi Dosen Pembimbing
        </p>
    </div>

    <!-- NAVIGASI -->
    <nav class="flex gap-2 overflow-x-auto px-3 pb-3 md:flex-1 md:flex-col">

        <p class="px-4 pb-1 pt-2 text-[10px] font-semibold uppercase tracking-widest text-slate-400">
            Ruang Akademik
        </p>

        <!-- DASHBOARD -->
        <a href="{{ route('dospem.dashboard') }}"
           class="flex items-center gap-3 rounded-xl px-4 py-2.5 text-xs font-semibold transition {{ request()->routeIs('dospem.dashboard') ? 'bg-sky-50 text-sky-600' : 'text-slate-600 hover:bg-slate-50' }}">

            <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <rect x="3.5" y="3.5" width="7" height="7" rx="1"/>
                <rect x="13.5" y="3.5" width="7" height="7" rx="1"/>
                <rect x="3.5" y="13.5" width="7" height="7" rx="1"/>
                <rect x="13.5" y="13.5" width="7" height="7" rx="1"/>
            </svg>

            <span>Dashboard</span>
        </a>

        <!-- PENGAJUAN MASUK -->
        <a href="{{ route('dospem.pengajuan.index') }}"
           class="flex items-center gap-3 rounded-xl px-4 py-2.5 text-xs font-semibold transition {{ request()->routeIs('dospem.pengajuan.*') ? 'bg-sky-50 text-sky-600' : 'text-slate-600 hover:bg-slate-50' }}">

            <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7 3.75h7l5 5V20a1 1 0 0 1-1 1H7a2 2 0 0 1-2-2V5.75a2 2 0 0 1 2-2Z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M14 3.75v5h5M9 13h6M9 16.5h6"/>
            </svg>

            <span>Pengajuan Masuk</span>
        </a>

        <!-- MAHASISWA BIMBINGAN -->
        <a href="{{ route('dospem.mahasiswa-bimbingan') }}"
           class="flex items-center gap-3 rounded-xl px-4 py-2.5 text-xs font-semibold transition {{ request()->routeIs('dospem.mahasiswa-bimbingan') ? 'bg-sky-50 text-sky-600' : 'text-slate-600 hover:bg-slate-50' }}">

            <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                <circle cx="10" cy="7" r="4"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M20 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>

            <span>Mahasiswa Bimbingan</span>
        </a>

        <!-- RIWAYAT REVIEW -->
        <a href="{{ route('dospem.riwayat') }}"
           class="flex items-center gap-3 rounded-xl px-4 py-2.5 text-xs font-semibold transition {{ request()->routeIs('dospem.riwayat') ? 'bg-sky-50 text-sky-600' : 'text-slate-600 hover:bg-slate-50' }}">

            <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 2m6-2a9 9 0 1 1-2.64-6.36"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 3v6h-6"/>
            </svg>

            <span>Riwayat Review</span>
        </a>

        <!-- PROFIL -->
        <a href="{{ route('dospem.profil') }}"
           class="flex items-center gap-3 rounded-xl px-4 py-2.5 text-xs font-semibold transition {{ request()->routeIs('dospem.profil') ? 'bg-sky-50 text-sky-600' : 'text-slate-600 hover:bg-slate-50' }}">

            <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <circle cx="12" cy="8" r="4"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 20a8 8 0 0 1 16 0"/>
            </svg>

            <span>Profil</span>
        </a>

    </nav>

    <!-- LOGOUT -->
    <div class="border-t border-slate-100 p-3">
        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button type="submit"
                    class="flex w-full items-center gap-3 rounded-xl px-4 py-2.5 text-left text-xs font-semibold text-rose-600 transition hover:bg-rose-50">

                <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 17l5-5-5-5m5 5H3"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3h7a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-7"/>
                </svg>

                <span>Logout</span>
            </button>
        </form>
    </div>

</aside>
