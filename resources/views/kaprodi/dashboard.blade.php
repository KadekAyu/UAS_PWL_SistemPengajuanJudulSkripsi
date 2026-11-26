<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kaprodi - SISTA</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>

<body class="min-h-screen bg-[#E8F5FF] text-slate-800">

    <div class="min-h-screen md:flex">

        <x-sidebar-kaprodi />

        <!-- KONTEN UTAMA -->
        <main class="min-w-0 flex-1">

            <x-topbar-kaprodi>
                <span>Ketua Program Studi</span>
                <span class="text-slate-300">›</span>
                <span class="font-medium text-slate-700">Dashboard</span>
            </x-topbar-kaprodi>

            <div class="p-4 md:p-6">

                <!-- JUDUL DASHBOARD -->
                <header class="mb-5">

                    <p class="text-[10px] font-bold uppercase tracking-widest text-sky-700">
                        Dashboard Ketua Program Studi
                    </p>

                    <h1 class="mt-1 text-xl font-bold tracking-tight text-sky-900 md:text-2xl">
                        Selamat datang, {{ auth()->user()->name }}
                    </h1>

                    <p class="mt-1 text-xs text-slate-500">
                        Pantau pengajuan judul skripsi, lakukan penunjukan dosen pembimbing, dan sahkan judul setelah mendapatkan persetujuan dosen.
                    </p>

                </header>

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
                <section class="mb-5 grid gap-3 sm:grid-cols-3">

                    @foreach ([
                        ['label' => 'Menunggu Pengesahan', 'value' => $statistics['menunggu'], 'tone' => 'amber'],
                        ['label' => 'Sudah Disahkan', 'value' => $statistics['disahkan'], 'tone' => 'emerald'],
                        ['label' => 'Total Diproses Kaprodi', 'value' => $statistics['total_diproses'], 'tone' => 'sky'],
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
                            ][$card['tone']] }}"></div>

                        </article>

                    @endforeach

                </section>

                <!-- PENGAJUAN MASUK -->
                <section id="antrean" class="mb-5 overflow-hidden rounded-xl border border-slate-200 bg-white">

                    <div class="flex flex-wrap items-center justify-between gap-3 px-4 py-3.5">

                        <div>
                            <h2 class="text-sm font-bold text-slate-900">
                                Pengajuan Masuk
                            </h2>

                            <p class="mt-1 text-xs text-slate-500">
                                Daftar pengajuan mahasiswa yang menunggu penunjukan dosen atau pengesahan akhir.
                            </p>
                        </div>

                        <span class="rounded-full bg-amber-50 px-3 py-1 text-[10px] font-semibold text-amber-700">
                            {{ $menungguPengesahan->count() }} menunggu
                        </span>

                    </div>

                    @if ($menungguPengesahan->isEmpty())

                        <div class="border-t border-slate-100 px-5 py-7 text-center">

                            <h3 class="text-xs font-semibold text-slate-700">
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

                                    @foreach ($menungguPengesahan as $pengajuan)

                                        <div class="grid grid-cols-[1.1fr_0.9fr_2fr_1fr_0.65fr] items-center gap-4 px-5 py-3 text-xs transition hover:bg-sky-50/50">

                                            <span class="font-medium text-slate-700">
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

                <!-- RIWAYAT PENGESAHAN -->
                <section id="riwayat" class="overflow-hidden rounded-xl border border-slate-200 bg-white">

                    <div class="px-4 py-3.5">

                        <div class="flex flex-wrap items-center justify-between gap-2">
                            <div>
                                <h2 class="text-sm font-bold text-slate-900">
                                    Riwayat Pengesahan
                                </h2>

                                <p class="mt-1 text-xs text-slate-500">
                                    Judul skripsi terbaru yang telah disahkan oleh Kaprodi.
                                </p>
                            </div>

                            <a href="{{ route('kaprodi.riwayat') }}"
                               class="inline-flex items-center gap-1.5 rounded-lg border border-sky-200 px-3 py-2 text-xs font-semibold text-sky-700 transition hover:bg-sky-50">
                                Lihat semua
                                <span aria-hidden="true">→</span>
                            </a>
                        </div>

                    </div>

                    <div class="border-t border-slate-100">

                        @if ($riwayat->isEmpty())

                            <div class="px-5 py-7 text-center">

                                <h3 class="text-xs font-semibold text-slate-700">
                                    Belum Ada Riwayat Pengesahan
                                </h3>

                                <p class="mt-1 text-xs text-slate-500">
                                    Pengajuan yang sudah disahkan Kaprodi akan ditampilkan di sini.
                                </p>

                            </div>

                        @else

                            <div class="overflow-x-auto">

                                <table class="w-full min-w-[760px] text-left text-xs">

                                    <thead class="bg-slate-50 text-slate-500">

                                        <tr>
                                            <th class="px-5 py-3 font-semibold">Mahasiswa</th>
                                            <th class="px-5 py-3 font-semibold">Judul</th>
                                            <th class="px-5 py-3 font-semibold">Pembimbing 1 & 2</th>
                                            <th class="px-5 py-3 font-semibold">Status</th>
                                            <th class="px-5 py-3 font-semibold">Nomor SK</th>
                                        </tr>

                                    </thead>

                                    <tbody class="divide-y divide-slate-100">

                                        @foreach ($riwayat as $item)

                                            <tr>

                                                <td class="px-5 py-3">
                                                    <p class="font-semibold text-slate-800">
                                                        {{ $item->nama_mahasiswa }}
                                                    </p>

                                                    <p class="text-[10px] text-slate-500">
                                                        {{ $item->npm }}
                                                    </p>
                                                </td>

                                                <td class="max-w-md px-5 py-3 text-slate-600">
                                                    {{ $item->judul }}
                                                </td>

                                                <td class="px-5 py-3 text-slate-600">
                                                    <p>{{ $item->nama_dospem_1 }}</p>
                                                    <p class="text-[11px] text-slate-500">{{ $item->nama_dospem_2 }}</p>
                                                </td>

                                                <td class="px-5 py-3">

                                                    <span class="rounded-full bg-emerald-50 px-3 py-1 text-[10px] font-semibold text-emerald-700">
                                                        {{ $item->status }}
                                                    </span>

                                                </td>

                                                <td class="px-5 py-3 font-medium text-slate-600">
                                                    {{ $item->nomor_sk ?? '—' }}
                                                </td>

                                            </tr>

                                        @endforeach

                                    </tbody>

                                </table>

                            </div>

                        @endif

                    </div>

                </section>

            </div>

        </main>

    </div>

</body>
</html>