@php
    $user = auth()->user();

    $totalReview = $riwayat->count();
    $totalAcc = $riwayat->filter(fn($item) => in_array(strtolower($item->keputusan ?? ''), ['acc', 'disetujui']))->count();
    $totalRevisi = $riwayat->filter(fn($item) => strtolower($item->keputusan ?? '') === 'revisi')->count();
    $totalDitolak = $riwayat->filter(fn($item) => strtolower($item->keputusan ?? '') === 'ditolak')->count();
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Review - SISTA</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif

    <style>
        .filter-button {
            transition: all 0.2s ease;
        }

        .filter-button.active {
            background: #E8F5FF;
            color: #269BD8;
            border-color: #B9E4FA;
        }

        .filter-button:not(.active):hover {
            background: #F8FBFE;
        }
    </style>
</head>

<body class="min-h-screen bg-[#E8F5FF] text-slate-800">

    <div class="min-h-screen md:flex">

        <!-- SIDEBAR DOSPEM -->
        <x-sidebar-dospem />

        <!-- MAIN CONTENT -->
        <main class="min-w-0 flex-1">

            <!-- TOPBAR -->
            <x-topbar-dospem>
                <div class="flex items-center gap-2 text-xs font-medium text-slate-600">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4 text-slate-400"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m3 10 9-7 9 7"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 9v11h14V9"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 20v-6h6v6"/>
                    </svg>

                    <span class="text-slate-400">Dosen Pembimbing</span>

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-3 w-3 text-slate-400"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6"/>
                    </svg>

                    <span class="font-semibold text-slate-800">
                        Riwayat Review
                    </span>

                </div>
            </x-topbar-dospem>

            <!-- PAGE CONTENT -->
            <div class="p-4 md:p-6">

                <!-- HEADER -->
                <header class="mb-5">
                    <h1 class="text-xl font-bold tracking-tight text-slate-800">
                        Riwayat Review
                    </h1>

                    <p class="mt-1 text-xs text-slate-500">
                        Pantau riwayat pemeriksaan dan keputusan review pengajuan judul skripsi mahasiswa.
                    </p>
                </header>

                <!-- CARD DAFTAR RIWAYAT -->
                <section class="overflow-hidden rounded-xl border border-sky-100 bg-white shadow-sm">

                    <!-- CARD HEADER -->
                    <div class="border-b border-slate-100 px-4 py-4 md:px-5">

                        <div class="flex items-center gap-3">

                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-sky-50">
                                <svg class="h-5 w-5 text-sky-500"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 2m6-2a9 9 0 1 1-2.64-6.36"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 3v6h-6"/>
                                </svg>
                            </div>

                            <div class="min-w-0 flex-1">
                                <h2 class="text-sm font-bold text-slate-900">
                                    Daftar Riwayat Review
                                </h2>

                                <p class="mt-1 text-xs text-slate-500">
                                    Daftar pengajuan yang sudah diperiksa oleh Anda.
                                </p>
                            </div>

                            <span class="whitespace-nowrap rounded-full bg-sky-50 px-3 py-1.5 text-[10px] font-semibold text-sky-600">
                                {{ $totalReview }} Review
                            </span>

                        </div>

                        <!-- FILTER STATUS -->
                        <div class="mt-4 border-t border-slate-100 pt-3">

                            <div class="mb-2">
                                <p class="text-[11px] font-semibold text-slate-500">
                                    Filter berdasarkan keputusan
                                </p>
                            </div>

                            <div class="flex flex-wrap gap-2">

                                <!-- SEMUA -->
                                <button type="button"
                                    onclick="filterRiwayat('semua', this)"
                                    class="filter-button active inline-flex items-center gap-2 rounded-full border border-sky-200 bg-sky-50 px-3.5 py-2 text-[11px] font-semibold text-sky-600">

                                    Semua

                                    <span class="flex h-5 min-w-5 items-center justify-center rounded-full bg-white px-1.5 text-[10px] text-sky-600">
                                        {{ $totalReview }}
                                    </span>
                                </button>

                                <!-- DISETUJUI -->
                                <button type="button"
                                    onclick="filterRiwayat('disetujui', this)"
                                    class="filter-button inline-flex items-center gap-2 rounded-full border border-emerald-100 bg-white px-3.5 py-2 text-[11px] font-semibold text-emerald-700">

                                    <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                                    Disetujui

                                    <span class="flex h-5 min-w-5 items-center justify-center rounded-full bg-emerald-50 px-1.5 text-[10px]">
                                        {{ $totalAcc }}
                                    </span>
                                </button>

                                <!-- REVISI -->
                                <button type="button"
                                    onclick="filterRiwayat('revisi', this)"
                                    class="filter-button inline-flex items-center gap-2 rounded-full border border-amber-100 bg-white px-3.5 py-2 text-[11px] font-semibold text-amber-700">

                                    <span class="h-2 w-2 rounded-full bg-amber-400"></span>
                                    Revisi

                                    <span class="flex h-5 min-w-5 items-center justify-center rounded-full bg-amber-50 px-1.5 text-[10px]">
                                        {{ $totalRevisi }}
                                    </span>
                                </button>

                                <!-- DITOLAK -->
                                <button type="button"
                                    onclick="filterRiwayat('ditolak', this)"
                                    class="filter-button inline-flex items-center gap-2 rounded-full border border-rose-100 bg-white px-3.5 py-2 text-[11px] font-semibold text-rose-600">

                                    <span class="h-2 w-2 rounded-full bg-rose-400"></span>
                                    Ditolak

                                    <span class="flex h-5 min-w-5 items-center justify-center rounded-full bg-rose-50 px-1.5 text-[10px]">
                                        {{ $totalDitolak }}
                                    </span>
                                </button>

                            </div>
                        </div>

                    </div>

                    <!-- DAFTAR TABEL -->
                    @if ($riwayat->isNotEmpty())

                        <div class="overflow-x-auto">

                            <table class="w-full min-w-[640px] text-left text-xs">

                                <thead class="bg-slate-50 text-[10px] uppercase tracking-wide text-slate-500">
                                    <tr>
                                        <th class="px-5 py-3 font-semibold">No</th>
                                        <th class="px-5 py-3 font-semibold">Mahasiswa</th>
                                        <th class="px-5 py-3 font-semibold">Judul Skripsi</th>
                                        <th class="px-5 py-3 font-semibold">Tanggal Review</th>
                                        <th class="px-5 py-3 font-semibold">Keputusan</th>
                                        <th class="px-5 py-3 text-center font-semibold">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-slate-100">

                                    @foreach ($riwayat as $item)

                                        @php
                                            $statusFilter = in_array(strtolower($item->keputusan ?? ''), ['acc', 'disetujui'])
                                                ? 'disetujui'
                                                : strtolower($item->keputusan ?? '');
                                        @endphp

                                        <tr
                                            data-status="{{ $statusFilter }}"
                                            class="riwayat-row transition hover:bg-sky-50/50">

                                            <td class="px-5 py-3 text-slate-600">
                                                {{ $loop->iteration }}
                                            </td>

                                            <td class="px-5 py-3">
                                                <p class="font-semibold text-slate-700">
                                                    {{ $item->nama_mahasiswa ?? '-' }}
                                                </p>

                                                <p class="mt-1 text-[10px] text-slate-400">
                                                    {{ $item->npm_mahasiswa ?? '-' }}
                                                </p>
                                            </td>

                                            <td class="max-w-md px-5 py-3 text-slate-600">
                                                {{ $item->judul ?? '-' }}
                                            </td>

                                            <td class="whitespace-nowrap px-5 py-3 text-slate-500">
                                                {{ !empty($item->tanggal_review) ? \Carbon\Carbon::parse($item->tanggal_review)->format('d/m/Y') : '-' }}
                                            </td>

                                            <td class="px-5 py-3">
                                                <span class="rounded-full px-3 py-1 text-[10px] font-semibold {{
                                                    match(strtolower($item->keputusan ?? '')) {
                                                        'acc', 'disetujui' => 'bg-emerald-50 text-emerald-700',
                                                        'revisi' => 'bg-orange-50 text-orange-700',
                                                        'ditolak' => 'bg-rose-50 text-rose-700',
                                                        default => 'bg-sky-50 text-sky-700',
                                                    }
                                                }}">
                                                    {{ ucfirst($item->keputusan ?? '-') }}
                                                </span>
                                            </td>

                                            <td class="px-5 py-3 text-center">
                                                <a href="{{ route('dospem.pengajuan.detail', $item->pengajuan_id) }}"
                                                    class="inline-flex items-center gap-1.5 rounded-lg bg-sky-50 px-3 py-2 text-[11px] font-semibold text-sky-600 transition hover:bg-sky-100">

                                                    <svg class="h-3.5 w-3.5"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke="currentColor"
                                                        stroke-width="1.8">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.5 12s3.5-7 9.5-7 9.5 7 9.5 7-3.5 7-9.5 7-9.5-7-9.5-7Z"/>
                                                        <circle cx="12" cy="12" r="3"/>
                                                    </svg>

                                                    Detail
                                                </a>
                                            </td>

                                        </tr>

                                    @endforeach

                                    <!-- PESAN FILTER KOSONG -->
                                    <tr id="filter-empty" class="hidden">
                                        <td colspan="6" class="px-5 py-10 text-center">

                                            <div class="mx-auto mb-2 flex h-10 w-10 items-center justify-center rounded-full bg-sky-50">
                                                <svg class="h-5 w-5 text-sky-400"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                    stroke-width="1.8">
                                                    <circle cx="12" cy="12" r="9"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01"/>
                                                </svg>
                                            </div>

                                            <p class="text-xs font-semibold text-slate-700">
                                                Tidak Ada Riwayat
                                            </p>

                                            <p class="mt-1 text-xs text-slate-400">
                                                Tidak ada pengajuan dengan status yang dipilih.
                                            </p>

                                        </td>
                                    </tr>

                                </tbody>

                            </table>
                        </div>

                    @else

                        <div class="px-5 py-10 text-center">

                            <div class="mx-auto mb-3 flex h-11 w-11 items-center justify-center rounded-xl bg-sky-50 text-sky-500">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.5 11 14.5l4-4m5 2.5a8 8 0 1 1-16 0 8 8 0 0 1 16 0Z"/>
                                </svg>
                            </div>

                            <h3 class="text-xs font-semibold text-slate-700">
                                Belum Ada Riwayat Review
                            </h3>

                            <p class="mt-1 text-xs text-slate-500">
                                Pengajuan yang sudah direview akan ditampilkan di sini.
                            </p>

                            <a href="{{ route('dospem.pengajuan.index') }}"
                                class="mt-4 inline-flex items-center gap-2 rounded-lg bg-sky-400 px-4 py-2.5 text-xs font-semibold text-white transition hover:bg-sky-500">
                                Lihat Pengajuan Masuk
                            </a>

                        </div>

                    @endif

                </section>

            </div>

        </main>

    </div>

    <!-- FILTER JAVASCRIPT -->
    <script>
        function filterRiwayat(status, button) {
            const rows = document.querySelectorAll('.riwayat-row');
            const emptyMessage = document.getElementById('filter-empty');

            let jumlahTampil = 0;

            rows.forEach(row => {
                const rowStatus = row.dataset.status;
                const tampil = status === 'semua' || rowStatus === status;

                row.classList.toggle('hidden', !tampil);

                if (tampil) {
                    jumlahTampil++;
                }
            });

            if (emptyMessage) {
                emptyMessage.classList.toggle('hidden', jumlahTampil !== 0);
            }

            document.querySelectorAll('.filter-button').forEach(btn => {
                btn.classList.remove('active');
            });

            button.classList.add('active');
        }
    </script>

</body>
</html>
