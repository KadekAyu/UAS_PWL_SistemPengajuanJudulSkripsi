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

    <!-- SIDEBAR -->
    <aside class="flex w-full flex-col border-b border-sky-100 bg-white md:h-screen md:w-60 md:shrink-0 md:border-b-0 md:border-r">

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
        <nav class="flex gap-2 px-3 pb-3 md:flex-1 md:flex-col">

            <p class="px-4 pb-1 pt-2 text-[10px] font-semibold uppercase tracking-widest text-slate-400">
                Ruang Akademik
            </p>

            <a href="{{ route('dospem.dashboard') }}"
               class="flex items-center gap-3 rounded-lg px-4 py-2.5 text-sm text-slate-500 hover:bg-sky-50 hover:text-sky-700">
                <i data-lucide="layout-grid" class="h-5 w-5"></i>
                Dashboard
            </a>

            <a href="{{ route('dospem.pengajuan.index') }}"
               class="flex items-center gap-3 rounded-lg bg-sky-50 px-4 py-2.5 text-sm font-semibold text-sky-700">
                <i data-lucide="file-text" class="h-5 w-5"></i>
                Pengajuan Masuk
            </a>

            <a href="{{ route('dospem.dashboard') }}#riwayat"
               class="flex items-center gap-3 rounded-lg px-4 py-2.5 text-sm text-slate-500 hover:bg-sky-50 hover:text-sky-700">
                <i data-lucide="clock-3" class="h-5 w-5"></i>
                Riwayat Review
            </a>

            <a href="{{ route('dospem.dashboard') }}#profil"
               class="flex items-center gap-3 rounded-lg px-4 py-2.5 text-sm text-slate-500 hover:bg-sky-50 hover:text-sky-700">
                <i data-lucide="circle-user-round" class="h-5 w-5"></i>
                Profil
            </a>

        </nav>

        <!-- LOGOUT -->
        <div class="border-t border-slate-100 p-3">
            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button type="submit"
                    class="flex w-full items-center gap-3 rounded-lg px-4 py-2.5 text-left text-sm text-slate-500 hover:bg-slate-50 hover:text-slate-800">
                    <i data-lucide="log-out" class="h-5 w-5"></i>
                    Logout
                </button>
            </form>
        </div>

    </aside>

    <!-- KONTEN UTAMA -->
    <main class="min-w-0 flex-1">

        <!-- HEADER -->
        <div class="flex min-h-[52px] items-center justify-between gap-3 border-b border-sky-100 bg-white px-5 py-2.5 md:px-7">

            <div class="flex items-center gap-2 text-xs text-slate-500">
                <span>Dosen Pembimbing</span>
                <span>›</span>
                <span class="font-medium text-slate-700">
                    Pengajuan Masuk
                </span>
            </div>

            <div class="flex items-center gap-2.5">
                <div class="text-right">
                    <p class="text-xs font-semibold text-slate-700">
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

        <!-- ISI HALAMAN -->
        <div class="p-4 md:p-6">

            <header class="mb-5">
                <p class="text-[10px] font-bold uppercase tracking-widest text-sky-700">
                    Dosen Pembimbing
                </p>

                <h1 class="mt-1 text-2xl font-bold text-sky-900">
                    Pengajuan Masuk
                </h1>

                <p class="mt-1 text-xs text-slate-500">
                    Daftar pengajuan judul skripsi mahasiswa yang memilih Anda sebagai dosen pembimbing.
                </p>
            </header>

            <!-- TABEL PENGAJUAN -->
            <section class="overflow-hidden rounded-xl border border-slate-200 bg-white">

                <div class="flex items-center justify-between px-4 py-4">
                    <div>
                        <h2 class="text-sm font-bold text-slate-900">
                            Daftar Pengajuan
                        </h2>

                        <p class="mt-1 text-xs text-slate-500">
                            Pengajuan yang sedang menunggu review.
                        </p>
                    </div>

                    <span class="rounded-full bg-sky-50 px-3 py-1 text-xs font-semibold text-sky-700">
                        {{ $pengajuanMasuk->count() }} Pengajuan
                    </span>
                </div>

                <div class="border-t border-slate-100 px-4 py-3">

                    @if ($pengajuanMasuk->isNotEmpty())

                        <div class="overflow-x-auto">
                            <table class="w-full min-w-[850px] text-left text-xs">

                                <thead class="bg-slate-50 text-slate-500">
                                    <tr>
                                        <th class="px-4 py-3 font-semibold">No</th>
                                        <th class="px-4 py-3 font-semibold">Mahasiswa</th>
                                        <th class="px-4 py-3 font-semibold">Judul Skripsi</th>
                                        <th class="px-4 py-3 font-semibold">Tanggal Pengajuan</th>
                                        <th class="px-4 py-3 font-semibold">Status</th>
                                        <th class="px-4 py-3 font-semibold">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-slate-100">

                                    @foreach ($pengajuanMasuk as $item)
                                        <tr>
                                            <!-- NOMOR -->
                                            <td class="px-4 py-3 text-slate-600">
                                                {{ $loop->iteration }}
                                            </td>

                                            <!-- NAMA DAN NPM MAHASISWA -->
                                            <td class="px-4 py-3">
                                                <p class="font-semibold text-slate-700">
                                                    {{ $item->nama_mahasiswa }}
                                                </p>
                                                <p class="mt-1 text-[10px] text-slate-400">
                                                    {{ $item->npm_mahasiswa ?? '-' }}
                                                </p>
                                            </td>

                                            <!-- JUDUL SKRIPSI -->
                                            <td class="px-4 py-3 text-slate-600">
                                                {{ $item->judul }}
                                            </td>

                                            <!-- TANGGAL PENGAJUAN -->
                                            <td class="px-4 py-3 text-slate-500">
                                                {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}
                                            </td>

                                            <!-- STATUS -->
                                            <td class="px-4 py-3">
                                                <span class="rounded-full bg-amber-50 px-3 py-1 text-[10px] font-semibold text-amber-700">
                                                    {{ ucfirst($item->status) }}
                                                </span>
                                            </td>

                                            <!-- TOMBOL DETAIL: TAMPIL SAJA, FITUR BELUM AKTIF -->
                                            <td class="px-4 py-3">
                                                <button type="button"
                                                        disabled
                                                        title="Fitur Detail Pengajuan akan tersedia pada tahap berikutnya"
                                                        class="inline-flex cursor-not-allowed items-center gap-2 rounded-lg bg-sky-100 px-3 py-2 text-xs font-semibold text-sky-700 opacity-70">
                                                    <i data-lucide="eye" class="h-4 w-4"></i>
                                                    Detail
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>

                    @else

                        <div class="py-10 text-center">
                            <h3 class="text-sm font-semibold text-slate-700">
                                Belum Ada Pengajuan
                            </h3>

                            <p class="mt-1 text-xs text-slate-500">
                                Belum ada pengajuan mahasiswa yang menunggu review.
                            </p>
                        </div>

                    @endif

                </div>

            </section>

        </div>

    </main>

</div>

<script>
    lucide.createIcons();
</script>

</body>
</html>
