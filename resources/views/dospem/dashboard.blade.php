<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Dosen Pembimbing - SISTA</title>
    <script src="https://unpkg.com/lucide@0.468.0/dist/umd/lucide.min.js"></script>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>

<body class="min-h-screen bg-[#E8F5FF] text-slate-800">

    <div class="min-h-screen md:flex">

        <!-- SIDEBAR DOSEN PEMBIMBING -->
        <aside class="flex w-full flex-col border-b border-sky-100 bg-white md:h-screen md:w-60 md:shrink-0 md:border-b-0 md:border-r">

            <!-- LOGO APLIKASI -->
            <div class="px-5 py-5">
                <p class="text-2xl font-black tracking-tight text-sky-600">
                    SISTA
                </p>

                <p class="mt-1 text-[8px] font-semibold uppercase tracking-widest text-slate-400">
                    Portal Skripsi Dosen Pembimbing
                </p>
            </div>

            <!-- NAVIGASI SIDEBAR -->
            <nav class="flex gap-2 overflow-x-auto px-3 pb-3 md:flex-1 md:flex-col">

                <p class="px-4 pb-1 pt-2 text-[10px] font-semibold uppercase tracking-widest text-slate-400">
                    Ruang Akademik
                </p>

                <a href="#dashboard"
                   class="flex items-center gap-3 whitespace-nowrap rounded-lg bg-sky-50 px-4 py-2.5 text-sm font-semibold text-sky-700">
                    <i data-lucide="layout-grid" class="h-5 w-5"></i>
                    Dashboard
                </a>

                <a href="#pengajuan"
                   class="flex items-center gap-3 whitespace-nowrap rounded-lg px-4 py-2.5 text-sm text-slate-500 hover:bg-sky-50 hover:text-sky-700">
                    <i data-lucide="file-text" class="h-5 w-5"></i>
                    Pengajuan Masuk
                </a>

                <a href="#riwayat"
                   class="flex items-center gap-3 whitespace-nowrap rounded-lg px-4 py-2.5 text-sm text-slate-500 hover:bg-sky-50 hover:text-sky-700">
                    <i data-lucide="clock-3" class="h-5 w-5"></i>
                    Riwayat Review
                </a>

                <a href="#profil"
                   class="flex items-center gap-3 whitespace-nowrap rounded-lg px-4 py-2.5 text-sm text-slate-500 hover:bg-sky-50 hover:text-sky-700">
                    <i data-lucide="circle-user-round" class="h-5 w-5"></i>
                    Profil
                </a>

            </nav>

            <!-- TOMBOL LOGOUT -->
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
        <main id="dashboard" class="min-w-0 flex-1">

            <!-- HEADER -->
            <div class="flex min-h-[52px] flex-wrap items-center justify-between gap-3 border-b border-sky-100 bg-white px-5 py-2.5 md:px-7">

                <div class="flex items-center gap-2 text-xs text-slate-500">
                    <span>Dosen Pembimbing</span>
                    <span class="text-slate-300">›</span>
                    <span class="font-medium text-slate-700">Dashboard</span>
                </div>

                <!-- PROFIL DOSEN YANG LOGIN -->
                <div id="profil" class="flex items-center gap-2.5">

                    <div class="text-right">
                        <p class="max-w-[180px] truncate text-xs font-semibold text-slate-700">
                            {{ auth()->user()->name }}
                        </p>

                        <p class="text-[10px] text-slate-400">
                            Dosen Pembimbing
                        </p>
                    </div>

                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-sky-100 text-xs font-bold text-sky-700">
                        {{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}
                    </div>

                </div>

            </div>

            <div class="p-4 md:p-6">

                <!-- JUDUL DASHBOARD -->
                <header class="mb-5">

                    <p class="text-[10px] font-bold uppercase tracking-widest text-sky-700">
                        Dashboard Dosen Pembimbing
                    </p>

                    <h1 class="mt-1 text-xl font-bold tracking-tight text-sky-900 md:text-2xl">
                        Selamat datang, {{ auth()->user()->name }}
                    </h1>

                    <p class="mt-1 text-xs text-slate-500">
                        Pantau dan review pengajuan judul skripsi mahasiswa.
                    </p>

                </header>

                <!-- NOTIFIKASI BERHASIL DAN ERROR -->
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

                <!-- STATISTIK -->
                <section class="mb-5 grid gap-3 sm:grid-cols-2 xl:grid-cols-4">

                    @foreach ([
                        ['label' => 'Total Pengajuan', 'value' => $statistics['total'] ?? 0, 'tone' => 'sky'],
                        ['label' => 'Menunggu Review', 'value' => $statistics['pending'] ?? 0, 'tone' => 'amber'],
                        ['label' => 'Sudah ACC', 'value' => $statistics['disetujui'] ?? 0, 'tone' => 'emerald'],
                        ['label' => 'Revisi / Ditolak', 'value' => $statistics['revisi'] ?? 0, 'tone' => 'rose'],
                    ] as $card)

                        <article class="rounded-xl border border-slate-200 bg-white px-4 py-3">

                            <p class="text-xs text-slate-500">
                                {{ $card['label'] }}
                            </p>

                            <p class="mt-1 text-xl font-bold text-slate-900">
                                {{ $card['value'] }}
                            </p>

                            <div class="mt-2 h-1 w-9 rounded-full {{ [
                                'sky' => 'bg-sky-400',
                                'amber' => 'bg-amber-400',
                                'emerald' => 'bg-emerald-500',
                                'rose' => 'bg-rose-400',
                            ][$card['tone']] }}"></div>

                        </article>

                    @endforeach

                </section>

                <!-- PENGAJUAN MASUK -->
                <section id="pengajuan" class="mb-5 overflow-hidden rounded-xl border border-slate-200 bg-white">

                    <div class="px-4 py-3.5">
                        <h2 class="text-sm font-bold text-slate-900">
                            Pengajuan Masuk
                        </h2>

                        <p class="mt-1 text-xs text-slate-500">
                            Daftar pengajuan judul skripsi mahasiswa yang perlu direview.
                        </p>
                    </div>

                    <div class="border-t border-slate-100 px-4 py-3">

                        @if (isset($pengajuan) && $pengajuan->isNotEmpty())

                            <div class="overflow-x-auto">
                                <table class="w-full min-w-[640px] text-left text-xs">

                                    <thead class="bg-slate-50 text-slate-500">
                                        <tr>
                                            <th class="px-4 py-3 font-semibold">No</th>
                                            <th class="px-4 py-3 font-semibold">Mahasiswa</th>
                                            <th class="px-4 py-3 font-semibold">Judul Skripsi</th>
                                            <th class="px-4 py-3 font-semibold">Status</th>
                                        </tr>
                                    </thead>

                                    <tbody class="divide-y divide-slate-100">

                                        @foreach ($pengajuan as $item)
                                            <tr>
                                                <td class="px-4 py-3 text-slate-600">
                                                    {{ $loop->iteration }}
                                                </td>

                                                <td class="px-4 py-3 font-medium text-slate-700">
                                                    {{ $item->mahasiswa->name ?? '-' }}
                                                </td>

                                                <td class="px-4 py-3 text-slate-600">
                                                    {{ $item->judul }}
                                                </td>

                                                <td class="px-4 py-3">
                                                    <span class="rounded-full bg-amber-50 px-3 py-1 text-[10px] font-semibold text-amber-700">
                                                        {{ $item->status }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>

                                </table>
                            </div>

                        @else

                            <div class="py-7 text-center">
                                <h3 class="text-xs font-semibold text-slate-700">
                                    Belum Ada Pengajuan
                                </h3>

                                <p class="mt-1 text-xs text-slate-500">
                                    Pengajuan judul dari mahasiswa akan ditampilkan di sini.
                                </p>
                            </div>

                        @endif

                    </div>

                </section>

                <!-- RIWAYAT REVIEW -->
                <section id="riwayat" class="overflow-hidden rounded-xl border border-slate-200 bg-white">

                    <div class="px-4 py-3.5">
                        <h2 class="text-sm font-bold text-slate-900">
                            Riwayat Review
                        </h2>

                        <p class="mt-1 text-xs text-slate-500">
                            Daftar pengajuan yang sudah pernah direview.
                        </p>
                    </div>

                    <div class="border-t border-slate-100 px-4 py-3">

                        @if (isset($riwayat) && $riwayat->isNotEmpty())

                            <div class="overflow-x-auto">
                                <table class="w-full min-w-[640px] text-left text-xs">

                                    <thead class="bg-slate-50 text-slate-500">
                                        <tr>
                                            <th class="px-4 py-3 font-semibold">No</th>
                                            <th class="px-4 py-3 font-semibold">Mahasiswa</th>
                                            <th class="px-4 py-3 font-semibold">Judul Skripsi</th>
                                            <th class="px-4 py-3 font-semibold">Status</th>
                                        </tr>
                                    </thead>

                                    <tbody class="divide-y divide-slate-100">

                                        @foreach ($riwayat as $item)
                                            <tr>
                                                <td class="px-4 py-3 text-slate-600">
                                                    {{ $loop->iteration }}
                                                </td>

                                                <td class="px-4 py-3 font-medium text-slate-700">
                                                    {{ $item->mahasiswa->name ?? '-' }}
                                                </td>

                                                <td class="px-4 py-3 text-slate-600">
                                                    {{ $item->judul }}
                                                </td>

                                                <td class="px-4 py-3">
                                                    <span class="rounded-full bg-emerald-50 px-3 py-1 text-[10px] font-semibold text-emerald-700">
                                                        {{ $item->status }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>

                                </table>
                            </div>

                        @else

                            <div class="py-7 text-center">
                                <h3 class="text-xs font-semibold text-slate-700">
                                    Belum Ada Riwayat Review
                                </h3>

                                <p class="mt-1 text-xs text-slate-500">
                                    Pengajuan yang sudah direview akan ditampilkan di sini.
                                </p>
                            </div>

                        @endif

                    </div>

                </section>

            </div>

        </main>

    </div>

    <!-- AKTIFKAN IKON LUCIDE -->
    <script>
        lucide.createIcons();
    </script>

</body>
</html>
