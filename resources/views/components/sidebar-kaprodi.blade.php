@php
    $isDashboard = request()->routeIs('kaprodi.dashboard');
    $isPengajuan = request()->routeIs('kaprodi.pengajuan.*');
    $isRiwayat = request()->routeIs('kaprodi.riwayat');
@endphp

<aside class="flex w-full flex-col border-b border-sky-100 bg-white md:sticky md:top-0 md:h-screen md:w-60 md:shrink-0 md:border-b-0 md:border-r">
    <div class="px-5 py-5">
        <p class="text-2xl font-black tracking-tight text-sky-600">SISTA</p>
        <p class="mt-1 text-[8px] font-semibold uppercase tracking-widest text-slate-400">
            Portal Skripsi Ketua Program Studi
        </p>
    </div>

    <nav class="flex gap-2 overflow-x-auto px-3 pb-3 md:flex-1 md:flex-col">
        <p class="px-4 pb-1 pt-2 text-[10px] font-semibold uppercase tracking-widest text-slate-400">
            Ruang Akademik
        </p>

        <a href="{{ route('kaprodi.dashboard') }}"
           class="flex items-center gap-3 whitespace-nowrap rounded-lg px-4 py-2.5 text-sm transition {{ $isDashboard ? 'bg-sky-50 font-semibold text-sky-700' : 'text-slate-500 hover:bg-sky-50 hover:text-sky-700' }}">
            <i data-lucide="layout-grid" class="h-5 w-5 shrink-0"></i>
            Dashboard
        </a>

        <a href="{{ route('kaprodi.pengajuan.index') }}"
           class="flex items-center gap-3 whitespace-nowrap rounded-lg px-4 py-2.5 text-sm transition {{ $isPengajuan ? 'bg-sky-50 font-semibold text-sky-700' : 'text-slate-500 hover:bg-sky-50 hover:text-sky-700' }}">
            <i data-lucide="file-check-2" class="h-5 w-5 shrink-0"></i>
            Pengajuan Masuk
        </a>

        <a href="{{ route('kaprodi.riwayat') }}"
           class="flex items-center gap-3 whitespace-nowrap rounded-lg px-4 py-2.5 text-sm transition {{ $isRiwayat ? 'bg-sky-50 font-semibold text-sky-700' : 'text-slate-500 hover:bg-sky-50 hover:text-sky-700' }}">
            <i data-lucide="clock-3" class="h-5 w-5 shrink-0"></i>
            Riwayat Keputusan
        </a>
    </nav>

    <div class="border-t border-slate-100 p-3">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                    class="flex w-full items-center gap-3 rounded-lg px-4 py-2.5 text-left text-sm text-rose-600 transition hover:bg-rose-50 hover:text-rose-700">
                <i data-lucide="log-out" class="h-5 w-5 shrink-0"></i>
                Logout
            </button>
        </form>
    </div>
</aside>

<script src="https://unpkg.com/lucide@0.468.0/dist/umd/lucide.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (window.lucide) {
            window.lucide.createIcons();
        }
    });
    if (window.lucide) {
        window.lucide.createIcons();
    }
</script>