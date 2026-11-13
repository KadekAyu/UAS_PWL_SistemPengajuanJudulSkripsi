<!-- resources/views/components/topbar-mahasiswa.blade.php -->
<div class="flex items-center justify-between px-6 py-4 bg-white border-b border-sky-100">
    <!-- Bagian Kiri (Breadcrumb / Judul halaman yang dinamis) -->
    <div class="flex items-center gap-2 text-xs text-slate-500">
        {{ $slot }}
    </div>

    <!-- Bagian Kanan (Profil yang bisa diklik) -->
    <a href="{{ route('mahasiswa.profil') }}" class="flex items-center gap-2.5 group hover:opacity-85 transition-opacity cursor-pointer">
        <div class="text-right">
            <p class="text-xs font-bold text-slate-800 group-hover:text-sky-600 transition-colors">{{ auth()->user()->name }}</p>
            <p class="text-[10px] text-slate-400">NPM {{ auth()->user()->npm }}</p>
        </div>
        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-sky-100 font-bold text-sky-600 text-xs shadow-sm">
            {{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}
        </div>
    </a>
</div>