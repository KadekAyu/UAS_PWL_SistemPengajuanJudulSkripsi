<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Masuk - SISTA</title>
    <script src="https://unpkg.com/lucide@0.468.0/dist/umd/lucide.min.js"></script>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>

<body class="min-h-screen bg-[#E8F5FF] text-slate-800">
<div class="min-h-screen md:flex">

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
               class="flex items-center gap-3 whitespace-nowrap rounded-lg px-4 py-2.5 text-sm text-slate-500 transition hover:bg-sky-50 hover:text-sky-700">
                <i data-lucide="layout-grid" class="h-5 w-5"></i>
                Dashboard
            </a>

            <a href="{{ route('kaprodi.pengajuan.index') }}"
               class="flex items-center gap-3 whitespace-nowrap rounded-lg bg-sky-50 px-4 py-2.5 text-sm font-semibold text-sky-700">
                <i data-lucide="file-check-2" class="h-5 w-5"></i>
                Pengajuan Masuk
            </a>

            <a href="{{ route('kaprodi.riwayat') }}"
               class="flex items-center gap-3 whitespace-nowrap rounded-lg px-4 py-2.5 text-sm text-slate-500 transition hover:bg-sky-50 hover:text-sky-700">
                <i data-lucide="clock-3" class="h-5 w-5"></i>
                Riwayat Keputusan
            </a>
        </nav>

        <div class="border-t border-slate-100 p-3">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="flex w-full items-center gap-3 rounded-lg px-4 py-2.5 text-left text-sm text-rose-600 transition hover:bg-rose-50 hover:text-rose-700">
                    <i data-lucide="log-out" class="h-5 w-5"></i>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <main class="min-w-0 flex-1">
        <div class="flex min-h-[52px] flex-wrap items-center justify-between gap-3 border-b border-sky-100 bg-white px-5 py-2.5 md:px-7">
            <div class="flex items-center gap-2 text-xs text-slate-500">
                <span>Ketua Program Studi</span>
                <span class="text-slate-300">›</span>
                <span class="font-medium text-slate-700">Pengajuan Masuk</span>
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

        <div class="p-4 md:p-6">
            @if (session('success'))
                <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-2.5 text-xs text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-2.5 text-xs text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <header class="mb-5">
                <p class="text-[10px] font-bold uppercase tracking-widest text-sky-700">
                    Ketua Program Studi
                </p>
                <h1 class="mt-1 text-2xl font-bold text-sky-900">Pengajuan Masuk</h1>
                <p class="mt-1 text-xs text-slate-500">
                    Tinjau pengajuan yang telah disetujui dosen pembimbing dan tentukan dosen pembimbing final.
                </p>
            </header>

            <section class="overflow-hidden rounded-xl border border-slate-200 bg-white">
                <div class="flex items-center justify-between gap-3 px-4 py-4">
                    <div>
                        <h2 class="text-sm font-bold text-slate-900">Daftar Pengajuan</h2>
                        <p class="mt-1 text-xs text-slate-500">Pengajuan yang menunggu pengesahan Kaprodi.</p>
                    </div>
                    <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700">
                        {{ $pengajuanMasuk->count() }} Pengajuan
                    </span>
                </div>

                <div class="border-t border-slate-100">
                    @if ($pengajuanMasuk->isEmpty())
                        <div class="py-10 text-center">
                            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-100">
                                <i data-lucide="inbox" class="h-6 w-6 text-slate-400"></i>
                            </div>
                            <h3 class="mt-3 text-sm font-semibold text-slate-700">Belum Ada Pengajuan</h3>
                            <p class="mt-1 text-xs text-slate-500">
                                Pengajuan siap disahkan akan ditampilkan di sini.
                            </p>
                        </div>
                    @else
                        <div class="divide-y divide-slate-100">
                            @foreach ($pengajuanMasuk as $pengajuan)
                                <details class="group">
                                    <summary class="grid cursor-pointer list-none gap-3 px-4 py-4 hover:bg-sky-50/50 md:grid-cols-[minmax(150px,1fr)_minmax(280px,2fr)_150px_90px] md:items-center [&::-webkit-details-marker]:hidden">
                                        <div>
                                            <p class="text-sm font-semibold text-slate-800">{{ $pengajuan->nama_mahasiswa }}</p>
                                            <p class="mt-1 text-[11px] text-slate-400">{{ $pengajuan->npm }}</p>
                                        </div>

                                        <p class="text-sm leading-5 text-slate-700" title="{{ $pengajuan->judul }}">
                                            {{ $pengajuan->judul }}
                                        </p>

                                        <span class="w-fit rounded-full bg-amber-50 px-3 py-1 text-[10px] font-semibold text-amber-700">
                                            {{ $pengajuan->status }}
                                        </span>

                                        <span class="inline-flex w-fit items-center gap-1.5 rounded-lg bg-sky-100 px-3 py-2 text-xs font-semibold text-sky-700 group-open:bg-slate-600 group-open:text-white">
                                            <i data-lucide="eye" class="h-4 w-4"></i>
                                            <span class="group-open:hidden">Tinjau</span>
                                            <span class="hidden group-open:inline">Tutup</span>
                                        </span>
                                    </summary>

                                    <div class="border-t border-slate-100 bg-slate-50/70 p-4">
                                        <div class="grid gap-4 lg:grid-cols-[minmax(0,1fr)_280px]">
                                            <div class="rounded-lg border border-slate-200 bg-white p-4">
                                                <div class="flex flex-wrap items-center justify-between gap-2">
                                                    <p class="text-[10px] font-bold uppercase tracking-widest text-sky-600">
                                                        Detail Pengajuan
                                                    </p>
                                                    <p class="text-[11px] text-slate-400">
                                                        Diajukan {{ \Illuminate\Support\Carbon::parse($pengajuan->created_at)->format('d M Y') }}
                                                    </p>
                                                </div>

                                                <h3 class="mt-2 text-sm font-bold leading-6 text-slate-900">{{ $pengajuan->judul }}</h3>
                                                <p class="mt-2 text-xs leading-6 text-slate-600">
                                                    {{ $pengajuan->abstrak ?: 'Abstrak belum tersedia.' }}
                                                </p>

                                                <div class="mt-4 grid gap-2 sm:grid-cols-2">
                                                    <div class="rounded-lg bg-slate-50 px-3 py-2.5">
                                                        <p class="text-[10px] text-slate-400">Pilihan Dosen 1</p>
                                                        <p class="mt-1 text-xs font-semibold text-slate-700">{{ $pengajuan->nama_dospem_1 }}</p>
                                                    </div>
                                                    <div class="rounded-lg bg-slate-50 px-3 py-2.5">
                                                        <p class="text-[10px] text-slate-400">Pilihan Dosen 2</p>
                                                        <p class="mt-1 text-xs font-semibold text-slate-700">{{ $pengajuan->nama_dospem_2 }}</p>
                                                    </div>
                                                </div>

                                                @if ($pengajuan->file_proposal)
                                                    <a href="{{ \Illuminate\Support\Facades\Storage::url($pengajuan->file_proposal) }}"
                                                       target="_blank"
                                                       rel="noopener"
                                                       class="mt-4 inline-flex items-center gap-2 rounded-lg border border-sky-200 px-3 py-2 text-xs font-semibold text-sky-700 transition hover:bg-sky-50">
                                                        <i data-lucide="file-text" class="h-4 w-4"></i>
                                                        Lihat Proposal PDF
                                                    </a>
                                                @endif
                                            </div>

                                            <form action="{{ route('kaprodi.pengajuan.sahkan', $pengajuan->id) }}"
                                                  method="POST"
                                                  class="h-fit rounded-lg border border-slate-200 bg-white p-4">
                                                @csrf

                                                <p class="flex items-center gap-2 text-sm font-bold text-slate-900">
                                                    <i data-lucide="badge-check" class="h-4 w-4 text-sky-600"></i>
                                                    Pengesahan Judul
                                                </p>

                                                <label class="mt-4 block text-xs font-semibold text-slate-600">
                                                    Dosen Pembimbing Final
                                                    <select name="dospem_final_id"
                                                            required
                                                            class="mt-2 w-full rounded-lg border-slate-200 text-xs text-slate-700 focus:border-sky-400 focus:ring-sky-400">
                                                        <option value="">Pilih dosen pembimbing</option>
                                                        <option value="{{ $pengajuan->dospem_1_id }}">
                                                            {{ $pengajuan->nama_dospem_1 }}
                                                        </option>
                                                        <option value="{{ $pengajuan->dospem_2_id }}">
                                                            {{ $pengajuan->nama_dospem_2 }}
                                                        </option>
                                                    </select>
                                                </label>

                                                <button type="submit"
                                                        onclick="return confirm('Sahkan judul ini dan terbitkan nomor SK?')"
                                                        class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-lg bg-sky-600 px-4 py-2.5 text-xs font-semibold text-white transition hover:bg-sky-700">
                                                    <i data-lucide="check" class="h-4 w-4"></i>
                                                    Sahkan Judul
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </details>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>
        </div>
    </main>
</div>

<script>lucide.createIcons();</script>
</body>
</html>
