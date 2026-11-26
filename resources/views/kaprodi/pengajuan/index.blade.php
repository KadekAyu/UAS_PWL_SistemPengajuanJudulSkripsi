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

    <x-sidebar-kaprodi />

    <main class="min-w-0 flex-1">
        <x-topbar-kaprodi>
            <span>Ketua Program Studi</span>
            <span class="text-slate-300">›</span>
            <span class="font-medium text-slate-700">Pengajuan Masuk</span>
        </x-topbar-kaprodi>

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
                    Tinjau pengajuan yang telah disetujui kedua dosen pembimbing dan buka detailnya untuk mengesahkan.
                </p>
            </header>

            <section class="overflow-hidden rounded-xl border border-slate-200 bg-white">
                <div class="flex flex-wrap items-center justify-between gap-3 px-4 py-3.5">
                    <div>
                        <h2 class="text-sm font-bold text-slate-900">
                            Pengajuan Masuk
                        </h2>
                        <p class="mt-1 text-xs text-slate-500">
                            Judul yang telah disetujui kedua dosen pembimbing dan siap disahkan.
                        </p>
                    </div>

                    <span class="rounded-full bg-amber-50 px-3 py-1 text-[10px] font-semibold text-amber-700">
                        {{ $pengajuanMasuk->count() }} menunggu
                    </span>
                </div>

                @if ($pengajuanMasuk->isEmpty())
                    <div class="border-t border-slate-100 px-5 py-10 text-center">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-100">
                            <i data-lucide="inbox" class="h-6 w-6 text-slate-400"></i>
                        </div>
                        <h3 class="mt-3 text-sm font-semibold text-slate-700">
                            Belum Ada Pengajuan untuk Disahkan
                        </h3>
                        <p class="mt-1 text-xs text-slate-500">
                            Pengajuan akan tampil setelah mendapat persetujuan kedua dosen pembimbing.
                        </p>
                    </div>
                @else
                    <div class="overflow-x-auto border-t border-slate-100">
                        <div class="min-w-[760px]">
                            <div class="grid grid-cols-[1.1fr_0.9fr_2fr_1fr_0.65fr] gap-4 bg-slate-50 px-5 py-3 text-[11px] font-semibold text-slate-500">
                                <span>Mahasiswa</span>
                                <span>NPM</span>
                                <span>Judul</span>
                                <span>Status</span>
                                <span>Aksi</span>
                            </div>

                            <div class="divide-y divide-slate-100">
                                @foreach ($pengajuanMasuk as $pengajuan)
                                    <div class="grid grid-cols-[1.1fr_0.9fr_2fr_1fr_0.65fr] items-center gap-4 px-5 py-3 text-xs transition hover:bg-sky-50/40">
                                        <span class="font-semibold text-slate-800">
                                            {{ $pengajuan->nama_mahasiswa }}
                                        </span>

                                        <span class="text-slate-600">
                                            {{ $pengajuan->npm }}
                                        </span>

                                        <span class="truncate text-slate-700" title="{{ $pengajuan->judul }}">
                                            {{ $pengajuan->judul }}
                                        </span>

                                        <span>
                                            <span class="rounded-full bg-amber-50 px-2.5 py-1 text-[10px] font-medium text-amber-700">
                                                {{ $pengajuan->status }}
                                            </span>
                                        </span>

                                        <a href="{{ route('kaprodi.pengajuan.show', $pengajuan->id) }}"
                                           class="inline-flex w-fit items-center justify-center rounded-md bg-blue-500 px-3 py-1.5 text-[10px] font-semibold text-white transition hover:bg-blue-600">
                                            Review
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </section>
        </div>
    </main>
</div>

<script>lucide.createIcons();</script>
</body>
</html>