<div class="flex items-center justify-between border-b border-sky-100 bg-white px-6 py-4">

    <!-- BAGIAN KIRI: BREADCRUMB -->
    <div class="flex items-center gap-2 text-xs text-slate-500">
        {{ $slot }}
    </div>

    <!-- BAGIAN KANAN: PROFIL DOSEN -->
    <a href="{{ route('dospem.profil') }}"
       class="group flex cursor-pointer items-center gap-2.5 transition-opacity hover:opacity-85">

        <div class="text-right">
            <p class="text-xs font-bold text-slate-800 transition-colors group-hover:text-sky-600">
                {{ auth()->user()->name }}
            </p>

            <p class="text-[10px] text-slate-400">
                Dosen Pembimbing
            </p>
        </div>

        <!-- AVATAR DENGAN PINGGIRAN -->
        <div class="flex h-9 w-9 items-center justify-center rounded-full border-2 border-white bg-sky-100 text-xs font-bold text-sky-600 shadow-[0_0_0_2px_#BAE6FD]">
            {{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}
        </div>

    </a>

</div>
