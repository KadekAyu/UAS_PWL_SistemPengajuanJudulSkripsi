<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detail Pengajuan - SISTA</title>

    <script src="https://unpkg.com/lucide@0.468.0/dist/umd/lucide.min.js"></script>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>

<body class="min-h-screen bg-[#E8F5FF] text-slate-800">

<div class="min-h-screen md:flex">

    <!-- SIDEBAR DOSPEM -->
    <aside class="flex w-full flex-col border-b border-sky-100 bg-white md:sticky md:top-0 md:h-screen md:w-60 md:shrink-0 md:border-b-0 md:border-r">

        <div class="px-5 py-5">
            <p class="text-2xl font-black tracking-tight text-sky-600">
                SISTA
            </p>
            <p class="mt-1 text-[8px] font-semibold uppercase tracking-widest text-slate-400">
                Portal Skripsi Dosen Pembimbing
            </p>
        </div>

        <nav class="flex gap-2 overflow-x-auto px-3 pb-3 md:flex-1 md:flex-col">

            <p class="px-4 pb-1 pt-2 text-[10px] font-semibold uppercase tracking-widest text-slate-400">
                Ruang Akademik
            </p>

            <a href="{{ route('dospem.dashboard') }}"
               class="flex items-center gap-3 whitespace-nowrap rounded-lg px-4 py-2.5 text-sm text-slate-500 transition hover:bg-sky-50 hover:text-sky-700">
                <i data-lucide="layout-grid" class="h-5 w-5"></i>
                Dashboard
            </a>

            <a href="{{ route('dospem.pengajuan.index') }}"
               class="flex items-center gap-3 whitespace-nowrap rounded-lg bg-sky-50 px-4 py-2.5 text-sm font-semibold text-sky-700">
                <i data-lucide="file-text" class="h-5 w-5"></i>
                Pengajuan Masuk
            </a>

            <a href="{{ route('dospem.riwayat') }}"
               class="flex items-center gap-3 whitespace-nowrap rounded-lg px-4 py-2.5 text-sm text-slate-500 transition hover:bg-sky-50 hover:text-sky-700">
                <i data-lucide="clock-3" class="h-5 w-5"></i>
                Riwayat Review
            </a>

            <a href="{{ route('dospem.profil') }}"
               class="flex items-center gap-3 whitespace-nowrap rounded-lg px-4 py-2.5 text-sm text-slate-500 transition hover:bg-sky-50 hover:text-sky-700">
                <i data-lucide="circle-user-round" class="h-5 w-5"></i>
                Profil
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

    <!-- KONTEN UTAMA -->
    <main class="min-w-0 flex-1">

        <!-- TOPBAR -->
        <div class="flex min-h-[52px] flex-wrap items-center justify-between gap-3 border-b border-sky-100 bg-white px-5 py-2.5 md:px-7">

            <div class="flex items-center gap-2 text-xs text-slate-500">
                <span>Dosen Pembimbing</span>
                <span>›</span>
                <a href="{{ route('dospem.pengajuan.index') }}"
                   class="hover:text-sky-700">
                    Pengajuan Masuk
                </a>
                <span>›</span>
                <span class="font-medium text-slate-700">
                    Detail
                </span>
            </div>

            <div class="flex items-center gap-2.5">
                <div class="text-right">
                    <p class="max-w-[180px] truncate text-xs font-semibold text-slate-700">
                        {{ auth()->user()->name }}
                    </p>
                    <p class="text-[10px] text-slate-400">
                        Dosen Pembimbing
                    </p>
                </div>

                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-sky-100 text-xs font-bold text-sky-700">
                    {{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}
                </div>
            </div>

        </div>

        <div class="p-4 md:p-6">

            <!-- JUDUL HALAMAN -->
            <header class="mb-5">

                <a href="{{ route('dospem.pengajuan.index') }}"
                   class="mb-4 inline-flex items-center gap-2 text-xs font-semibold text-sky-700 hover:text-sky-900">
                    <i data-lucide="arrow-left" class="h-4 w-4"></i>
                    Kembali ke Pengajuan Masuk
                </a>

                <p class="text-[10px] font-bold uppercase tracking-widest text-sky-700">
                    Dosen Pembimbing
                </p>

                <h1 class="mt-1 text-2xl font-bold text-sky-900">
                    Detail Pengajuan
                </h1>

                <p class="mt-1 text-xs text-slate-500">
                    Informasi lengkap pengajuan judul skripsi mahasiswa.
                </p>
            </header>

            <!-- RINGKASAN PENGAJUAN -->
            <section class="mb-5 rounded-xl border border-slate-200 bg-white p-5">

                <div class="flex flex-wrap items-start justify-between gap-3">

                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-sky-600">
                            Pengajuan Judul Skripsi
                        </p>

                        <h2 class="mt-2 text-lg font-bold leading-relaxed text-slate-900">
                            {{ $pengajuan->judul }}
                        </h2>
                    </div>

                    <span class="rounded-full bg-amber-50 px-3 py-1.5 text-xs font-semibold text-amber-700">
                        {{ ucfirst($pengajuan->status) }}
                    </span>

                </div>

                <div class="mt-4 border-t border-slate-100 pt-4 text-xs text-slate-500">
                    Diajukan pada
                    <span class="font-semibold text-slate-700">
                        {{ \Carbon\Carbon::parse($pengajuan->created_at)->format('d/m/Y') }}
                    </span>
                </div>

            </section>

            <div class="grid gap-5 xl:grid-cols-3">

                <!-- KOLOM INFORMASI -->
                <div class="space-y-5 xl:col-span-2">

                    <!-- IDENTITAS MAHASISWA -->
                    <section class="overflow-hidden rounded-xl border border-slate-200 bg-white">

                        <div class="border-b border-slate-100 px-5 py-4">
                            <h2 class="flex items-center gap-2 text-sm font-bold text-slate-900">
                                <i data-lucide="user-round" class="h-4 w-4 text-sky-600"></i>
                                Identitas Mahasiswa
                            </h2>
                        </div>

                        <div class="grid gap-4 p-5 sm:grid-cols-2">

                            <div>
                                <p class="text-xs text-slate-400">Nama Mahasiswa</p>
                                <p class="mt-1 text-sm font-semibold text-slate-800">
                                    {{ $pengajuan->nama_mahasiswa ?? '-' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-slate-400">NPM</p>
                                <p class="mt-1 text-sm font-semibold text-slate-800">
                                    {{ $pengajuan->npm_mahasiswa ?? '-' }}
                                </p>
                            </div>

                            <div class="sm:col-span-2">
                                <p class="text-xs text-slate-400">Email</p>
                                <p class="mt-1 break-all text-sm font-semibold text-slate-800">
                                    {{ $pengajuan->email_mahasiswa ?? '-' }}
                                </p>
                            </div>

                        </div>

                    </section>

                    <!-- INFORMASI SKRIPSI -->
                    <section class="overflow-hidden rounded-xl border border-slate-200 bg-white">

                        <div class="border-b border-slate-100 px-5 py-4">
                            <h2 class="flex items-center gap-2 text-sm font-bold text-slate-900">
                                <i data-lucide="book-open" class="h-4 w-4 text-sky-600"></i>
                                Informasi Skripsi
                            </h2>
                        </div>

                        <div class="p-5">

                            <p class="text-xs text-slate-400">Judul Skripsi</p>
                            <p class="mt-1 text-sm font-semibold leading-relaxed text-slate-800">
                                {{ $pengajuan->judul }}
                            </p>

                            <div class="mt-5 border-t border-slate-100 pt-5">
                                <p class="text-xs text-slate-400">
                                    Abstrak / Latar Belakang
                                </p>

                                <p class="mt-2 whitespace-pre-line text-sm leading-7 text-slate-700">{{ $pengajuan->abstrak }}</p>
                            </div>

                        </div>

                    </section>

                    <!-- PILIHAN DOSEN -->
                    <section class="overflow-hidden rounded-xl border border-slate-200 bg-white">

                        <div class="border-b border-slate-100 px-5 py-4">
                            <h2 class="flex items-center gap-2 text-sm font-bold text-slate-900">
                                <i data-lucide="users" class="h-4 w-4 text-sky-600"></i>
                                Pilihan Dosen Pembimbing
                            </h2>
                        </div>

                        <div class="grid gap-4 p-5 sm:grid-cols-2">

                            <div class="rounded-lg bg-slate-50 p-4">
                                <p class="text-xs text-slate-500">
                                    Dosen Pembimbing 1
                                </p>
                                <p class="mt-1 text-sm font-semibold text-slate-800">
                                    {{ $pengajuan->nama_dospem_1 ?? '-' }}
                                </p>
                            </div>

                            <div class="rounded-lg bg-slate-50 p-4">
                                <p class="text-xs text-slate-500">
                                    Dosen Pembimbing 2
                                </p>
                                <p class="mt-1 text-sm font-semibold text-slate-800">
                                    {{ $pengajuan->nama_dospem_2 ?? '-' }}
                                </p>
                            </div>

                        </div>

                    </section>

                </div>

                <!-- KOLOM KANAN -->
                <div class="space-y-5">

                    <!-- FILE PROPOSAL -->
                    <section class="overflow-hidden rounded-xl border border-slate-200 bg-white">

                        <div class="border-b border-slate-100 px-5 py-4">
                            <h2 class="flex items-center gap-2 text-sm font-bold text-slate-900">
                                <i data-lucide="file-text" class="h-4 w-4 text-sky-600"></i>
                                Proposal Skripsi
                            </h2>
                        </div>

                        <div class="p-5">

                            <div class="flex items-center gap-3 rounded-lg bg-sky-50 p-4">
                                <i data-lucide="file-type" class="h-8 w-8 text-sky-600"></i>

                                <div>
                                    <p class="text-sm font-semibold text-slate-800">
                                        File Proposal
                                    </p>
                                    <p class="text-xs text-slate-500">
                                        Dokumen PDF
                                    </p>
                                </div>
                            </div>

                            @if ($proposalTersedia)

                                <a href="{{ route('dospem.pengajuan.proposal', $pengajuan->id) }}"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-lg bg-sky-600 px-4 py-3 text-xs font-semibold text-white transition hover:bg-sky-700">
                                    <i data-lucide="eye" class="h-4 w-4"></i>
                                    Lihat Proposal PDF
                                </a>

                            @else

                                <div class="mt-4 rounded-lg border border-amber-200 bg-amber-50 p-3 text-xs leading-5 text-amber-800">
                                    File PDF belum tersedia pada penyimpanan project ini.
                                </div>

                            @endif

                        </div>

                    </section>

                    <!-- FORM REVIEW (UI SAJA) -->
                    <section class="overflow-hidden rounded-xl border border-slate-200 bg-white">

                        <div class="border-b border-slate-100 px-5 py-4">
                            <h2 class="flex items-center gap-2 text-sm font-bold text-slate-900">
                                <i data-lucide="clipboard-check" class="h-4 w-4 text-sky-600"></i>
                                Review Pengajuan
                            </h2>
                        </div>

                        <div class="p-5">

                            <p class="text-xs leading-5 text-slate-500">
                                Tinjau pengajuan mahasiswa dan berikan keputusan review.
                            </p>

                            <label for="catatan"
                                   class="mt-4 block text-xs font-semibold text-slate-700">
                                Catatan Review
                            </label>

                            <textarea id="catatan"
                                      rows="4"
                                      disabled
                                      placeholder="Masukkan catatan untuk mahasiswa..."
                                      class="mt-2 w-full resize-none rounded-lg border border-slate-200 bg-slate-50 p-3 text-xs text-slate-500"></textarea>

                            <div class="mt-4 grid grid-cols-3 gap-2">

                                <button type="button" disabled
                                    class="cursor-not-allowed rounded-lg bg-emerald-100 px-2 py-2.5 text-xs font-semibold text-emerald-700 opacity-70">
                                    ACC
                                </button>

                                <button type="button" disabled
                                    class="cursor-not-allowed rounded-lg bg-amber-100 px-2 py-2.5 text-xs font-semibold text-amber-700 opacity-70">
                                    Revisi
                                </button>

                                <button type="button" disabled
                                    class="cursor-not-allowed rounded-lg bg-rose-100 px-2 py-2.5 text-xs font-semibold text-rose-700 opacity-70">
                                    Tolak
                                </button>

                            </div>

                            <p class="mt-3 text-[11px] leading-5 text-slate-400">
                                Form review masih berupa tampilan dan belum dapat mengirim keputusan.
                            </p>

                        </div>

                    </section>

                </div>

            </div>

        </div>

    </main>

</div>

<script>
    lucide.createIcons();
</script>

</body>
</html>