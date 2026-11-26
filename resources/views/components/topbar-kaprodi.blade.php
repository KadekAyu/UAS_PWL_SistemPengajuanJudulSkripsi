<!-- TOPBAR KAPRODI -->
<div class="flex min-h-[52px] flex-wrap items-center justify-between gap-3 border-b border-sky-100 bg-white px-5 py-2.5 md:px-7">
    <div class="flex items-center gap-2 text-xs text-slate-500">
        {{ $slot }}
    </div>

    <div class="flex items-center gap-2.5">
        <div class="text-right">
            <p class="max-w-[180px] truncate text-xs font-semibold text-slate-700">
                {{ auth()->user()->name }}
            </p>
            <p class="text-[10px] text-slate-400">Ketua Program Studi</p>
        </div>
        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-sky-100 text-xs font-bold text-sky-700">
            {{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}
        </div>
    </div>
</div>