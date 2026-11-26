<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pengesahan - SISTA</title>
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
            <span class="font-medium text-slate-700">Riwayat Pengesahan</span>
        </x-topbar-kaprodi>

        <div class="p-4 md:p-6">
            <header class="mb-5">
                <p class="text-[10px] font-bold uppercase tracking-widest text-sky-700">
                    Ketua Program Studi
                </p>
                <h1 class="mt-1 text-2xl font-bold text-sky-900">Riwayat Pengesahan</h1>
                <p class="mt-1 text-xs text-slate-500">
                    Daftar pengajuan judul skripsi yang telah disahkan oleh Kaprodi beserta pembimbing dan nomor SK.
                </p>
            </header>

            <section class="overflow-hidden rounded-xl border border-slate-200 bg-white">
                <div class="flex flex-wrap items-center justify-between gap-3 px-4 py-4">
                    <div>
                        <h2 class="text-sm font-bold text-slate-900">Arsip Pengesahan</h2>
                        <p class="mt-1 text-xs text-slate-500">
                            {{ $riwayat->total() }} judul disahkan tercatat
                        </p>
                    </div>

                    <form action="{{ route('kaprodi.riwayat') }}" method="GET"
                          class="flex w-full flex-col gap-2 sm:w-auto sm:flex-row">
                        <label class="relative min-w-0 flex-1 sm:w-72">
                            <span class="sr-only">Cari nama, NPM, judul, atau nomor SK</span>
                            <i data-lucide="search" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>
                            <input type="search"
                                   name="q"
                                   value="{{ request('q') }}"
                                   placeholder="Cari nama, NPM, judul, atau no. SK"
                                   class="w-full rounded-lg border-slate-200 py-2 pl-9 pr-3 text-xs focus:border-sky-400 focus:ring-sky-400">
                        </label>

                        <button type="submit"
                                class="inline-flex items-center justify-center gap-2 rounded-lg bg-sky-600 px-4 py-2 text-xs font-semibold text-white transition hover:bg-sky-700">
                            Cari
                        </button>

                        @if (request()->filled('q'))
                            <a href="{{ route('kaprodi.riwayat') }}"
                               class="inline-flex items-center justify-center rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 transition hover:bg-slate-50">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>

                <div class="border-t border-slate-100">
                    @if ($riwayat->isEmpty())
                        <div class="px-5 py-10 text-center">
                            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-100">
                                <i data-lucide="archive" class="h-6 w-6 text-slate-400"></i>
                            </div>
                            <h3 class="mt-3 text-sm font-semibold text-slate-700">
                                {{ request()->filled('q') ? 'Tidak Ada Hasil' : 'Belum Ada Riwayat Pengesahan' }}
                            </h3>
                            <p class="mt-1 text-xs text-slate-500">
                                {{ request()->filled('q') ? 'Coba ubah kata kunci pencarian.' : 'Judul yang sudah disahkan Kaprodi akan ditampilkan di sini.' }}
                            </p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full min-w-[920px] text-left text-xs">
                                <thead class="bg-slate-50 text-slate-500">
                                    <tr>
                                        <th class="px-4 py-3 font-semibold">Mahasiswa</th>
                                        <th class="px-4 py-3 font-semibold">Judul Skripsi</th>
                                        <th class="px-4 py-3 font-semibold">Pembimbing 1 & 2</th>
                                        <th class="px-4 py-3 font-semibold">Status</th>
                                        <th class="px-4 py-3 font-semibold">Tanggal Disahkan</th>
                                        <th class="px-4 py-3 font-semibold">Nomor SK</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach ($riwayat as $item)
                                        <tr class="align-top hover:bg-slate-50/70">
                                            <td class="px-4 py-3">
                                                <p class="font-semibold text-slate-800">{{ $item->nama_mahasiswa }}</p>
                                                <p class="mt-1 text-[10px] text-slate-400">{{ $item->npm }}</p>
                                            </td>
                                            <td class="max-w-sm px-4 py-3 leading-5 text-slate-700">
                                                {{ $item->judul }}
                                            </td>
                                            <td class="px-4 py-3 text-slate-600">
                                                <p>1. {{ $item->nama_dospem_1 }}</p>
                                                <p class="mt-1">2. {{ $item->nama_dospem_2 }}</p>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-[10px] font-semibold text-emerald-700">
                                                    <i data-lucide="circle-check" class="h-3.5 w-3.5"></i>
                                                    {{ $item->status }}
                                                </span>
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-3 text-slate-500">
                                                {{ \Illuminate\Support\Carbon::parse($item->tanggal_disetujui ?? $item->updated_at)->format('d/m/Y') }}
                                            </td>
                                            <td class="px-4 py-3 font-medium text-slate-700">
                                                {{ $item->nomor_sk ?? '—' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if ($riwayat->hasPages())
                            <div class="border-t border-slate-100 px-4 py-3">
                                {{ $riwayat->links() }}
                            </div>
                        @endif
                    @endif
                </div>
            </section>
        </div>
    </main>
</div>

<script>lucide.createIcons();</script>
</body>
</html>