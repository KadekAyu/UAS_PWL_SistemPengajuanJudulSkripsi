@php
    $user = auth()->user();
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Dosen Pembimbing - SISTA</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
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

                    <!-- ICON HOME -->
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
                        Dashboard
                    </span>

                </div>
            </x-topbar-dospem>

            <!-- PAGE CONTENT -->
            <div class="p-4 md:p-6">

                <!-- HEADER -->
                <header class="mb-5">

                    <div class="mb-2 flex items-center gap-2">
                        <span class="text-[10px] font-bold tracking-wider text-sky-600">
                            DASHBOARD DOSEN PEMBIMBING
                        </span>
                    </div>

                    <h1 class="text-xl font-bold tracking-tight text-slate-800">
                        Selamat datang, {{ $user->name }}
                    </h1>

                    <p class="mt-1 text-xs text-slate-500">
                        Pantau dan review pengajuan judul skripsi mahasiswa.
                    </p>

                </header>

                <!-- PESAN BERHASIL -->
                @if (session('success'))
                    <div class="mb-3 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-xs text-emerald-800">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- PESAN ERROR -->
                @if ($errors->any())
                    <div class="mb-3 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-xs text-red-700">
                        {{ $errors->first() }}
                    </div>
                @endif

                <!-- STATISTIK -->
                <section class="mb-4 grid gap-3 sm:grid-cols-2 xl:grid-cols-4">

                    @foreach ([
                        ['label' => 'Total Pengajuan', 'value' => $statistics['total'] ?? 0, 'tone' => 'sky', 'icon' => 'document'],
                        ['label' => 'Menunggu Review', 'value' => $statistics['pending'] ?? 0, 'tone' => 'amber', 'icon' => 'clock'],
                        ['label' => 'Sudah ACC', 'value' => $statistics['disetujui'] ?? 0, 'tone' => 'emerald', 'icon' => 'check'],
                        ['label' => 'Revisi / Ditolak', 'value' => ($statistics['revisi'] ?? 0) + ($statistics['ditolak'] ?? 0), 'tone' => 'rose', 'icon' => 'x'],
                    ] as $card)

                        <article class="rounded-xl border border-sky-100 bg-white px-4 py-3 shadow-sm transition hover:shadow-md">

                            <div class="flex items-center justify-between">

                                <p class="text-xs text-slate-500">
                                    {{ $card['label'] }}
                                </p>

                                @if ($card['icon'] === 'document')
                                    <svg class="h-4 w-4 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 3.75h7l5 5V20a1 1 0 0 1-1 1H7a2 2 0 0 1-2-2V5.75a2 2 0 0 1 2-2Z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 3.75v5h5M9 13h6M9 16.5h6"/>
                                    </svg>
                                @elseif ($card['icon'] === 'clock')
                                    <svg class="h-4 w-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <circle cx="12" cy="12" r="9"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2"/>
                                    </svg>
                                @elseif ($card['icon'] === 'check')
                                    <svg class="h-4 w-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4 4L19 6"/>
                                    </svg>
                                @else
                                    <svg class="h-4 w-4 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <circle cx="12" cy="12" r="9"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m9 9 6 6m0-6-6 6"/>
                                    </svg>
                                @endif

                            </div>

                            <p class="mt-1 text-xl font-bold text-slate-900">
                                {{ $card['value'] }}
                            </p>

                            <div class="mt-2 h-1 w-9 rounded-full {{
                                [
                                    'sky' => 'bg-sky-400',
                                    'amber' => 'bg-amber-400',
                                    'emerald' => 'bg-emerald-500',
                                    'rose' => 'bg-rose-400',
                                ][$card['tone']]
                            }}"></div>

                        </article>

                    @endforeach

                </section>

                <!-- PENGAJUAN MASUK -->
                <section class="mb-4 overflow-hidden rounded-xl border border-sky-100 bg-white shadow-sm">

                    <div class="flex items-center gap-3 border-b border-slate-100 px-4 py-3">

                        <div class="rounded-lg bg-sky-50 p-2">
                            <svg class="h-5 w-5 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 3.75h7l5 5V20a1 1 0 0 1-1 1H7a2 2 0 0 1-2-2V5.75a2 2 0 0 1 2-2Z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 3.75v5h5M9 13h6M9 16.5h6"/>
                            </svg>
                        </div>

                        <div>
                            <h2 class="text-sm font-bold text-slate-900">
                                Pengajuan Masuk
                            </h2>

                            <p class="mt-1 text-xs text-slate-500">
                                Daftar pengajuan judul skripsi mahasiswa yang perlu direview.
                            </p>
                        </div>

                    </div>

                    @if ($pengajuanMasuk->isNotEmpty())

                        <div class="overflow-x-auto">
                            <table class="w-full min-w-[640px] text-left text-xs">

                                <thead class="bg-slate-50 text-[10px] uppercase tracking-wide text-slate-500">
                                    <tr>
                                        <th class="px-5 py-3 font-semibold">No</th>
                                        <th class="px-5 py-3 font-semibold">Mahasiswa</th>
                                        <th class="px-5 py-3 font-semibold">Judul Skripsi</th>
                                        <th class="px-5 py-3 font-semibold">Status</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-slate-100">
                                    @foreach ($pengajuanMasuk as $item)
                                        <tr class="transition hover:bg-sky-50/50">

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
                                                {{ $item->judul }}
                                            </td>

                                            <td class="px-5 py-3">
                                                <span class="rounded-full px-3 py-1 text-[10px] font-semibold {{
                                                    match($item->status) {
                                                        'ACC Dospem', 'ACC Dosen' => 'bg-emerald-50 text-emerald-700',
                                                        'Revisi' => 'bg-orange-50 text-orange-700',
                                                        'Ditolak' => 'bg-rose-50 text-rose-700',
                                                        default => 'bg-amber-50 text-amber-700',
                                                    }
                                                }}">
                                                    {{ $item->status }}
                                                </span>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>

                    @else

                        <div class="px-5 py-7 text-center">
                            <h3 class="text-xs font-semibold text-slate-700">
                                Belum Ada Pengajuan
                            </h3>

                            <p class="mt-1 text-xs text-slate-500">
                                Pengajuan dari mahasiswa yang memilih Anda sebagai dosen pembimbing akan ditampilkan di sini.
                            </p>
                        </div>

                    @endif

                </section>

                <!-- RIWAYAT REVIEW -->
                <section class="overflow-hidden rounded-xl border border-sky-100 bg-white shadow-sm">

                    <div class="flex items-center gap-3 border-b border-slate-100 px-4 py-3">

                        <div class="rounded-lg bg-sky-50 p-2">
                            <svg class="h-5 w-5 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 2m6-2a9 9 0 1 1-2.64-6.36"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 3v6h-6"/>
                            </svg>
                        </div>

                        <div>
                            <h2 class="text-sm font-bold text-slate-900">
                                Riwayat Review
                            </h2>

                        </div>

                    </div>

                    @if (isset($riwayat) && $riwayat->isNotEmpty())

                        <div class="overflow-x-auto">
                            <table class="w-full min-w-[640px] text-left text-xs">

                                <thead class="bg-slate-50 text-[10px] uppercase tracking-wide text-slate-500">
                                    <tr>
                                        <th class="px-5 py-3 font-semibold">No</th>
                                        <th class="px-5 py-3 font-semibold">Mahasiswa</th>
                                        <th class="px-5 py-3 font-semibold">Judul Skripsi</th>
                                        <th class="px-5 py-3 font-semibold">Status</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-slate-100">
                                    @foreach ($riwayat as $item)
                                        <tr class="transition hover:bg-sky-50/50">

                                            <td class="px-5 py-3 text-slate-600">
                                                {{ $loop->iteration }}
                                            </td>

                                            <td class="px-5 py-3 font-medium text-slate-700">
                                                {{ $item->nama_mahasiswa ?? '-' }}
                                            </td>

                                            <td class="max-w-md px-5 py-3 text-slate-600">
                                                {{ $item->judul }}
                                            </td>

                                            <td class="px-5 py-3">
                                                <span class="rounded-full px-3 py-1 text-[10px] font-semibold {{
                                                    match($item->status) {
                                                        'ACC Final', 'ACC Dospem', 'ACC Dosen' => 'bg-emerald-50 text-emerald-700',
                                                        'Revisi' => 'bg-orange-50 text-orange-700',
                                                        'Ditolak' => 'bg-rose-50 text-rose-700',
                                                        default => 'bg-amber-50 text-amber-700',
                                                    }
                                                }}">
                                                    {{ $item->status }}
                                                </span>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>

                    @else

                        <div class="px-5 py-7 text-center">
                            <h3 class="text-xs font-semibold text-slate-700">
                                Belum Ada Riwayat Review
                            </h3>

                            <p class="mt-1 text-xs text-slate-500">
                                Pengajuan yang sudah direview akan ditampilkan di sini.
                            </p>
                        </div>

                    @endif

                </section>

            </div>

        </main>

    </div>

</body>
</html>
