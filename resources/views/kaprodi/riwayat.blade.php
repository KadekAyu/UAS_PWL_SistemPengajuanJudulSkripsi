<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Keputusan - SISTA</title>
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
               class="flex items-center gap-3 whitespace-nowrap rounded-lg px-4 py-2.5 text-sm text-slate-500 transition hover:bg-sky-50 hover:text-sky-700">
                <i data-lucide="file-check-2" class="h-5 w-5"></i>
                Pengajuan Masuk
            </a>

            <a href="{{ route('kaprodi.riwayat') }}"
               class="flex items-center gap-3 whitespace-nowrap rounded-lg bg-sky-50 px-4 py-2.5 text-sm font-semibold text-sky-700">
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
                <span class="font-medium text-slate-700">Riwayat Keputusan</span>
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
            <header class="mb-5">
                <p class="text-[10px] font-bold uppercase tracking-widest text-sky-700">
                    Ketua Program Studi
                </p>
                <h1 class="mt-1 text-2xl font-bold text-sky-900">Riwayat Keputusan</h1>
                <p class="mt-1 text-xs text-slate-500">
                    Arsip pengajuan judul skripsi yang telah disahkan atau ditolak.
                </p>
            </header>

            <section class="mb-5 grid gap-3 sm:grid-cols-3">
                @foreach ([
                    ['label' => 'Total Keputusan', 'value' => $statistics['total'], 'tone' => 'sky'],
                    ['label' => 'Judul Disahkan', 'value' => $statistics['disahkan'], 'tone' => 'emerald'],
                    ['label' => 'Pengajuan Ditolak', 'value' => $statistics['ditolak'], 'tone' => 'rose'],
                ] as $card)
                    <article class="rounded-xl border border-slate-200 bg-white px-4 py-3">
                        <p class="text-xs text-slate-500">{{ $card['label'] }}</p>
                        <p class="mt-1 text-xl font-bold text-slate-900">{{ $card['value'] }}</p>
                        <div class="mt-2 h-1 w-9 rounded-full {{ [
                            'sky' => 'bg-sky-400',
                            'emerald' => 'bg-emerald-500',
                            'rose' => 'bg-rose-400',
                        ][$card['tone']] }}"></div>
                    </article>
                @endforeach
            </section>

            <section class="overflow-hidden rounded-xl border border-slate-200 bg-white">
                <div class="flex flex-wrap items-center justify-between gap-3 px-4 py-4">
                    <div>
                        <h2 class="text-sm font-bold text-slate-900">Arsip Keputusan</h2>
                        <p class="mt-1 text-xs text-slate-500">
                            {{ $riwayat->total() }} keputusan tercatat
                        </p>
                    </div>

                    <form action="{{ route('kaprodi.riwayat') }}" method="GET"
                          class="flex w-full flex-col gap-2 sm:w-auto sm:flex-row">
                        <label class="relative min-w-0 flex-1 sm:w-64">
                            <span class="sr-only">Cari nama, NPM, atau judul</span>
                            <i data-lucide="search" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>
                            <input type="search"
                                   name="q"
                                   value="{{ request('q') }}"
                                   placeholder="Cari nama, NPM, atau judul"
                                   class="w-full rounded-lg border-slate-200 py-2 pl-9 pr-3 text-xs focus:border-sky-400 focus:ring-sky-400">
                        </label>

                        <label>
                            <span class="sr-only">Filter status</span>
                            <select name="status"
                                    class="w-full rounded-lg border-slate-200 py-2 text-xs text-slate-600 focus:border-sky-400 focus:ring-sky-400">
                                <option value="">Semua status</option>
                                <option value="ACC Final" @selected(request('status') === 'ACC Final')>Disahkan</option>
                                <option value="Ditolak" @selected(request('status') === 'Ditolak')>Ditolak</option>
                            </select>
                        </label>

                        <button type="submit"
                                class="inline-flex items-center justify-center gap-2 rounded-lg bg-sky-600 px-4 py-2 text-xs font-semibold text-white transition hover:bg-sky-700">
                            Terapkan
                        </button>

                        @if (request()->filled('q') || request()->filled('status'))
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
                                {{ request()->filled('q') || request()->filled('status') ? 'Tidak Ada Hasil' : 'Belum Ada Riwayat Keputusan' }}
                            </h3>
                            <p class="mt-1 text-xs text-slate-500">
                                {{ request()->filled('q') || request()->filled('status') ? 'Coba ubah kata kunci atau filter status.' : 'Keputusan pengajuan akan ditampilkan di sini.' }}
                            </p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full min-w-[900px] text-left text-xs">
                                <thead class="bg-slate-50 text-slate-500">
                                    <tr>
                                        <th class="px-4 py-3 font-semibold">Mahasiswa</th>
                                        <th class="px-4 py-3 font-semibold">Judul Skripsi</th>
                                        <th class="px-4 py-3 font-semibold">Keputusan</th>
                                        <th class="px-4 py-3 font-semibold">Pembimbing Final</th>
                                        <th class="px-4 py-3 font-semibold">Tanggal</th>
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
                                            <td class="px-4 py-3">
                                                <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-[10px] font-semibold {{ $item->status === 'ACC Final' ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' }}">
                                                    <i data-lucide="{{ $item->status === 'ACC Final' ? 'circle-check' : 'circle-x' }}" class="h-3.5 w-3.5"></i>
                                                    {{ $item->status === 'ACC Final' ? 'Disahkan' : 'Ditolak' }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-slate-600">
                                                {{ $item->nama_dospem_final ?? '—' }}
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-3 text-slate-500">
                                                {{ \Illuminate\Support\Carbon::parse($item->tanggal_disetujui ?? $item->updated_at)->format('d/m/Y') }}
                                            </td>
                                            <td class="px-4 py-3 font-medium text-slate-600">
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
