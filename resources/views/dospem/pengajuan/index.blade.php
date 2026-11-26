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

    <x-sidebar-dospem />

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
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="m3 10 9-7 9 7"/>
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M5 9v11h14V9"/>
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9 20v-6h6v6"/>
                </svg>

                <span class="text-slate-400">Dosen Pembimbing</span>

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-3 w-3 text-slate-400"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="m9 18 6-6-6-6"/>
                </svg>

                <span class="font-semibold text-slate-800">
                    Pengajuan Masuk
                </span>

            </div>
        </x-topbar-dospem>

        <!-- ISI HALAMAN -->
        <div class="p-4 md:p-6">

            <!-- JUDUL HALAMAN -->
            <header class="mb-6">

                <h1 class="text-xl font-bold tracking-tight text-slate-800">
                    Pengajuan Masuk
                </h1>

                <p class="mt-1 text-xs text-slate-500">
                    Daftar pengajuan judul skripsi mahasiswa yang ditugaskan oleh Kaprodi untuk Anda review.
                </p>
            </header>

            <!-- TABEL PENGAJUAN -->
            <section class="overflow-hidden rounded-xl border border-sky-100 bg-white shadow-sm">

                <div class="flex items-center justify-between gap-3 px-4 py-4">
                    <div>
                        <h2 class="text-sm font-bold text-slate-800">
                            Daftar Pengajuan
                        </h2>

                        <p class="mt-1 text-xs text-slate-500">
                            Pengajuan yang sedang menunggu review.
                        </p>
                    </div>

                    <span class="shrink-0 rounded-full bg-sky-50 px-3 py-1 text-xs font-semibold text-sky-700">
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
                                        <tr class="transition hover:bg-sky-50/50">

                                            <td class="px-4 py-3 text-slate-600">
                                                {{ $loop->iteration }}
                                            </td>

                                            <td class="px-4 py-3">
                                                <p class="font-semibold text-slate-700">
                                                    {{ $item->nama_mahasiswa }}
                                                </p>

                                                <p class="mt-1 text-[10px] text-slate-400">
                                                    {{ $item->npm ?? '-' }}
                                                </p>
                                            </td>

                                            <td class="max-w-xs px-4 py-3 text-slate-600">
                                                {{ $item->judul }}
                                            </td>

                                            <td class="px-4 py-3 text-slate-500">
                                                {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}
                                            </td>

                                            <td class="px-4 py-3">
                                                <span class="inline-flex rounded-full bg-amber-50 px-3 py-1 text-[10px] font-semibold text-amber-700">
                                                    {{ ucfirst($item->status) }}
                                                </span>
                                            </td>

                                            <td class="px-4 py-3">
                                                <a href="{{ route('dospem.pengajuan.detail', $item->id) }}"
                                                   class="inline-flex items-center gap-2 rounded-lg bg-sky-100 px-3 py-2 text-xs font-semibold text-sky-700 transition hover:bg-sky-200 hover:text-sky-900">

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

                        <div class="py-10 text-center">

                            <div class="mx-auto mb-3 flex h-11 w-11 items-center justify-center rounded-full bg-sky-50 text-sky-500">
                                <i data-lucide="file-text" class="h-5 w-5"></i>
                            </div>

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
