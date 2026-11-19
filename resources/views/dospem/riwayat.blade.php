<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Review - SISTA</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://unpkg.com/lucide@0.468.0/dist/umd/lucide.min.js"></script>
</head>

<body class="min-h-screen bg-[#E8F5FF] text-slate-800">

<div class="min-h-screen md:flex">

    <!-- SIDEBAR -->
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

            <a href="{{ route('dospem.dashboard') }}"
               class="flex items-center gap-3 whitespace-nowrap rounded-lg px-4 py-2.5 text-sm text-slate-500 transition hover:bg-sky-50 hover:text-sky-700">
                <i data-lucide="layout-grid" class="h-5 w-5"></i>
                Dashboard
            </a>

            <a href="{{ route('dospem.pengajuan.index') }}"
               class="flex items-center gap-3 whitespace-nowrap rounded-lg px-4 py-2.5 text-sm text-slate-500 transition hover:bg-sky-50 hover:text-sky-700">
                <i data-lucide="file-text" class="h-5 w-5"></i>
                Pengajuan Masuk
            </a>

            <a href="{{ route('dospem.riwayat') }}"
               class="flex items-center gap-3 whitespace-nowrap rounded-lg bg-sky-50 px-4 py-2.5 text-sm font-semibold text-sky-700">
                <i data-lucide="clock-3" class="h-5 w-5"></i>
                Riwayat Review
            </a>

            <a href="{{ route('dospem.profil') }}"
               class="flex items-center gap-3 whitespace-nowrap rounded-lg px-4 py-2.5 text-sm text-slate-500 transition hover:bg-sky-50 hover:text-sky-700">
                <i data-lucide="circle-user-round" class="h-5 w-5"></i>
                Profil
            </a>

        </nav>

        <!-- LOGOUT -->
        <div class="border-t border-slate-100 p-3">
            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button type="submit"
                        class="flex w-full items-center gap-3 rounded-lg px-4 py-2.5 text-left text-sm text-rose-600 transition hover:bg-rose-50">
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
                <span class="font-semibold text-slate-700">
                    Riwayat Review
                </span>
            </div>

            <div class="flex items-center gap-2.5">
                <div class="text-right">
                    <p class="max-w-[180px] truncate text-xs font-semibold text-slate-700">
                        {{ $user->name }}
                    </p>
                    <p class="text-[10px] text-slate-400">
                        Dosen Pembimbing
                    </p>
                </div>

                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-sky-100 text-xs font-bold text-sky-700">
                    {{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}
                </div>
            </div>

        </div>

        <!-- ISI -->
        <div class="p-4 md:p-6">

            <!-- HEADER -->
            <header class="mb-6">
                <p class="text-[10px] font-bold uppercase tracking-widest text-sky-700">
                    Dosen Pembimbing
                </p>

                <h1 class="mt-1 text-2xl font-bold text-sky-900">
                    Riwayat Review
                </h1>

                <p class="mt-1 text-xs text-slate-500">
                    Riwayat pemeriksaan dan keputusan review pengajuan judul skripsi mahasiswa.
                </p>
            </header>

            <!-- KARTU RINGKASAN -->
            <div class="mb-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">

                <!-- TOTAL -->
                <div class="rounded-xl border border-slate-200 bg-white p-5">
                    <div class="flex items-center justify-between">
                        <span class="rounded-lg bg-sky-50 p-2 text-sky-600">
                            <i data-lucide="clipboard-list" class="h-5 w-5"></i>
                        </span>
                        <span class="text-[10px] font-semibold text-slate-400">
                            Total Review
                        </span>
                    </div>

                    <p class="mt-4 text-3xl font-bold text-slate-900">
                        {{ $riwayat->count() }}
                    </p>
                    <p class="mt-1 text-xs text-slate-500">
                        Pengajuan yang sudah direview
                    </p>
                </div>

                <!-- ACC -->
                <div class="rounded-xl border border-slate-200 bg-white p-5">
                    <div class="flex items-center justify-between">
                        <span class="rounded-lg bg-emerald-50 p-2 text-emerald-600">
                            <i data-lucide="check-circle-2" class="h-5 w-5"></i>
                        </span>
                        <span class="text-[10px] font-semibold text-slate-400">
                            Disetujui
                        </span>
                    </div>

                    <p class="mt-4 text-3xl font-bold text-slate-900">
                        {{ $riwayat->filter(fn($item) => in_array(strtolower($item->keputusan ?? ''), ['acc', 'disetujui']))->count() }}
                    </p>
                    <p class="mt-1 text-xs text-slate-500">
                        Review dengan keputusan ACC
                    </p>
                </div>

                <!-- REVISI -->
                <div class="rounded-xl border border-slate-200 bg-white p-5">
                    <div class="flex items-center justify-between">
                        <span class="rounded-lg bg-amber-50 p-2 text-amber-600">
                            <i data-lucide="pencil-line" class="h-5 w-5"></i>
                        </span>
                        <span class="text-[10px] font-semibold text-slate-400">
                            Revisi
                        </span>
                    </div>

                    <p class="mt-4 text-3xl font-bold text-slate-900">
                        {{ $riwayat->filter(fn($item) => strtolower($item->keputusan ?? '') === 'revisi')->count() }}
                    </p>
                    <p class="mt-1 text-xs text-slate-500">
                        Review dengan permintaan revisi
                    </p>
                </div>

                <!-- DITOLAK -->
                <div class="rounded-xl border border-slate-200 bg-white p-5">
                    <div class="flex items-center justify-between">
                        <span class="rounded-lg bg-rose-50 p-2 text-rose-600">
                            <i data-lucide="x-circle" class="h-5 w-5"></i>
                        </span>
                        <span class="text-[10px] font-semibold text-slate-400">
                            Ditolak
                        </span>
                    </div>

                    <p class="mt-4 text-3xl font-bold text-slate-900">
                        {{ $riwayat->filter(fn($item) => strtolower($item->keputusan ?? '') === 'ditolak')->count() }}
                    </p>
                    <p class="mt-1 text-xs text-slate-500">
                        Review dengan keputusan ditolak
                    </p>
                </div>

            </div>

            <!-- DAFTAR RIWAYAT -->
            <section class="overflow-hidden rounded-xl border border-slate-200 bg-white">

                <div class="flex flex-wrap items-center justify-between gap-3 px-5 py-4">
                    <div>
                        <h2 class="flex items-center gap-2 text-sm font-bold text-slate-900">
                            <i data-lucide="history" class="h-4 w-4 text-sky-600"></i>
                            Daftar Riwayat Review
                        </h2>

                        <p class="mt-1 text-xs text-slate-500">
                            Daftar pengajuan yang sudah diperiksa oleh Anda.
                        </p>
                    </div>

                    <span class="rounded-full bg-sky-50 px-3 py-1.5 text-xs font-semibold text-sky-700">
                        {{ $riwayat->count() }} Review
                    </span>
                </div>

                <div class="border-t border-slate-100">

                    @if ($riwayat->isNotEmpty())

                        <div class="overflow-x-auto">
                            <table class="w-full min-w-[850px] text-left text-xs">

                                <thead class="bg-slate-50 text-slate-500">
                                    <tr>
                                        <th class="px-4 py-3 font-semibold">No</th>
                                        <th class="px-4 py-3 font-semibold">Mahasiswa</th>
                                        <th class="px-4 py-3 font-semibold">Judul Skripsi</th>
                                        <th class="px-4 py-3 font-semibold">Tanggal Review</th>
                                        <th class="px-4 py-3 font-semibold">Keputusan</th>
                                        <th class="px-4 py-3 font-semibold">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-slate-100">

                                    @foreach ($riwayat as $item)
                                        <tr>
                                            <td class="px-4 py-4 text-slate-500">
                                                {{ $loop->iteration }}
                                            </td>

                                            <td class="px-4 py-4">
                                                <p class="font-semibold text-slate-800">
                                                    {{ $item->nama_mahasiswa ?? '-' }}
                                                </p>
                                                <p class="mt-1 text-[10px] text-slate-400">
                                                    {{ $item->npm_mahasiswa ?? '-' }}
                                                </p>
                                            </td>

                                            <td class="px-4 py-4 text-slate-600">
                                                {{ $item->judul ?? '-' }}
                                            </td>

                                            <td class="px-4 py-4 text-slate-500">
                                                {{ !empty($item->tanggal_review) ? \Carbon\Carbon::parse($item->tanggal_review)->format('d/m/Y') : '-' }}
                                            </td>

                                            <td class="px-4 py-4">
                                                <span class="rounded-full bg-sky-50 px-3 py-1 text-[10px] font-semibold text-sky-700">
                                                    {{ ucfirst($item->keputusan ?? '-') }}
                                                </span>
                                            </td>

                                            <td class="px-4 py-4">
                                                <a href="{{ route('dospem.pengajuan.detail', $item->pengajuan_id) }}"
                                                   class="inline-flex items-center gap-2 rounded-lg bg-sky-100 px-3 py-2 font-semibold text-sky-700 hover:bg-sky-200">
                                                    <i data-lucide="eye" class="h-4 w-4"></i>
                                                    Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>

                    @else

                        <!-- EMPTY STATE -->
                        <div class="flex flex-col items-center px-5 py-14 text-center">

                            <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-sky-50 text-sky-500">
                                <i data-lucide="clipboard-check" class="h-8 w-8"></i>
                            </div>

                            <h3 class="mt-5 text-base font-bold text-slate-800">
                                Belum Ada Riwayat Review
                            </h3>

                            <p class="mt-2 max-w-sm text-xs leading-6 text-slate-500">
                                Anda belum memiliki riwayat keputusan review.
                                Pengajuan yang sudah diperiksa akan ditampilkan
                                di halaman ini setelah fitur review diaktifkan.
                            </p>

                            <a href="{{ route('dospem.pengajuan.index') }}"
                               class="mt-5 inline-flex items-center gap-2 rounded-lg bg-sky-600 px-4 py-3 text-xs font-semibold text-white transition hover:bg-sky-700">
                                <i data-lucide="file-text" class="h-4 w-4"></i>
                                Lihat Pengajuan Masuk
                            </a>

                        </div>

                    @endif

                </div>

            </section>

        </div>

    </main>

</div>

<script>
    if (window.lucide) {
        lucide.createIcons();
    }
</script>

</body>
</html>