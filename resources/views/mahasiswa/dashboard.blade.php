@php
    $user = auth()->user();
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa - SISTA</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>

<body class="min-h-screen bg-[#E8F5FF] text-slate-800">

    <div class="min-h-screen md:flex">

        <!-- SIDEBAR -->
        <aside class="sista-sidebar flex w-full flex-col md:sticky md:top-0 md:h-screen md:w-60 md:shrink-0">

            <!-- LOGO -->
            <div class="px-5 py-5">
                <p class="text-2xl font-black tracking-tight text-sky-600">
                    SISTA
                </p>

                <p class="mt-1 text-[8px] font-semibold uppercase tracking-widest text-slate-400">
                    Portal Skripsi Mahasiswa
                </p>
            </div>

            <!-- NAVIGASI -->
            <nav class="flex gap-2 overflow-x-auto px-3 pb-3 md:flex-1 md:flex-col">

                <p class="px-4 pb-1 pt-2 text-[10px] font-semibold uppercase tracking-widest text-slate-400">
                    Ruang Akademik
                </p>

                <a href="{{ route('mahasiswa.dashboard') }}" class="sista-nav active">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <rect x="4" y="4" width="6" height="6" rx="1"/>
                        <rect x="14" y="4" width="6" height="6" rx="1"/>
                        <rect x="4" y="14" width="6" height="6" rx="1"/>
                        <rect x="14" y="14" width="6" height="6" rx="1"/>
                    </svg>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('mahasiswa.pengajuan.create') }}" class="sista-nav">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M13 3H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V10z"/>
                        <path d="M13 3v7h7M8 15h8M8 18h5"/>
                    </svg>
                    <span>Pengajuan Judul</span>
                </a>

                <a href="#riwayat" class="sista-nav">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <circle cx="12" cy="12" r="9"/>
                        <path d="M12 7v5l3 2"/>
                    </svg>
                    <span>Riwayat Pengajuan</span>
                </a>

                <a href="#profil" class="sista-nav">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <circle cx="12" cy="8" r="4"/>
                        <path d="M5 21v-2a7 7 0 0 1 14 0v2"/>
                    </svg>
                    <span>Profil</span>
                </a>

            </nav>

            <!-- LOGOUT -->
            <div class="border-t border-slate-100 p-3">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf

                    <button type="submit" class="sista-logout">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M10 17l5-5-5-5M15 12H3"/>
                            <path d="M12 3h6a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-6"/>
                        </svg>
                        <span>Logout</span>
                    </button>
                </form>
            </div>

        </aside>

        <!-- MAIN CONTENT -->
        <main class="min-w-0 flex-1">

            <!-- TOPBAR -->
            <div class="sista-topbar">

                <div class="flex items-center gap-2 text-xs text-slate-500">
                    <svg class="h-4 w-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="m3 11 9-8 9 8"/>
                        <path d="M5 10v10h14V10"/>
                        <path d="M9 20v-6h6v6"/>
                    </svg>

                    <span>Mahasiswa</span>
                    <span class="text-slate-300">›</span>
                    <span class="font-semibold text-slate-800">Dashboard</span>
                </div>

                <!-- PROFIL -->
                <div class="flex items-center gap-2.5">

                    <div class="text-right">
                        <p class="sista-user-name">
                            {{ $user->name }}
                        </p>

                        <p class="text-[10px] text-slate-400">
                            NPM {{ $user->npm }}
                        </p>
                    </div>

                    <div class="sista-avatar">
                        {{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}
                    </div>

                </div>

            </div>

            <!-- PAGE CONTENT -->
            <div class="sista-dashboard-content">

                <!-- HEADER -->
                <header class="sista-dashboard-header">

                    <p class="text-[10px] font-bold uppercase tracking-widest text-slate-500">
                        Dashboard Mahasiswa
                    </p>

                    <h1 class="mt-1 text-xl font-bold tracking-tight text-sky-600">
                        Selamat datang, {{ $user->name }}
                    </h1>

                    <p class="mt-1 text-xs text-slate-500">
                        Pantau perkembangan judul dan tindak lanjut dari pembimbing Anda.
                    </p>

                </header>

                <!-- PESAN BERHASIL -->
                @if (session('success'))
                    <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-xs text-emerald-800">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- PESAN ERROR -->
                @if ($errors->any())
                    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-xs text-red-700">
                        {{ $errors->first() }}
                    </div>
                @endif

                <!-- STATISTIK -->
                <section class="mb-4 grid gap-3 sm:grid-cols-2 xl:grid-cols-4">

                    @foreach ([
                        ['label' => 'Total Pengajuan', 'value' => $statistics['total'], 'tone' => 'sky'],
                        ['label' => 'Menunggu Proses', 'value' => $statistics['pending'], 'tone' => 'amber'],
                        ['label' => 'Perlu Revisi', 'value' => $statistics['revisi'], 'tone' => 'orange'],
                        ['label' => 'Ditolak', 'value' => $statistics['ditolak'], 'tone' => 'rose'],
                    ] as $card)

                        <article class="rounded-xl border border-sky-100 bg-white px-4 py-3">

                            <p class="text-xs text-slate-500">
                                {{ $card['label'] }}
                            </p>

                            <p class="mt-1 text-xl font-bold text-slate-900">
                                {{ $card['value'] }}
                            </p>

                            <div class="mt-2 h-1 w-9 rounded-full {{
                                [
                                    'sky' => 'bg-sky-400',
                                    'amber' => 'bg-amber-400',
                                    'orange' => 'bg-orange-400',
                                    'rose' => 'bg-rose-400',
                                ][$card['tone']]
                            }}"></div>

                        </article>

                    @endforeach

                </section>

                <!-- PENGAJUAN JUDUL -->
                <section class="mb-4 overflow-hidden rounded-xl border border-sky-100 bg-white">

                    <div class="flex flex-wrap items-center justify-between gap-3 px-4 py-3">

                        <div>
                            <h2 class="text-sm font-bold text-slate-900">
                                Pengajuan Judul Skripsi
                            </h2>

                            <p class="mt-1 text-xs text-slate-500">
                                Ajukan judul dan proposal skripsi untuk mendapatkan persetujuan.
                            </p>
                        </div>

                        <a href="{{ route('mahasiswa.pengajuan.create') }}"
                           class="sista-button sista-button-submit">
                            <span>+ Ajukan Judul Baru</span>
                        </a>

                    </div>

                    <div class="border-t border-slate-100 px-4 py-3">

                        <div class="rounded-lg bg-sky-50 px-4 py-3">

                            <h3 class="text-xs font-semibold text-slate-800">
                                Informasi Pengajuan
                            </h3>

                            <p class="mt-1 text-xs leading-5 text-slate-600">
                                Silakan ajukan judul skripsi beserta abstrak dan proposal.
                                Perkembangan pengajuan dapat dipantau melalui dashboard ini.
                            </p>

                        </div>

                    </div>

                </section>

                <!-- RIWAYAT PENGAJUAN -->
                <section id="riwayat" class="overflow-hidden rounded-xl border border-sky-100 bg-white">

                    <div class="border-b border-slate-100 px-4 py-3">

                        <h2 class="text-sm font-bold text-slate-900">
                            Riwayat Pengajuan
                        </h2>

                        <p class="mt-1 text-xs text-slate-500">
                            Daftar pengajuan judul skripsi yang pernah Anda ajukan.
                        </p>

                    </div>

                    @if ($pengajuan->isEmpty())

                        <div class="px-5 py-7 text-center">

                            <h3 class="text-xs font-semibold text-slate-700">
                                Belum Ada Pengajuan
                            </h3>

                            <p class="mt-1 text-xs text-slate-500">
                                Pengajuan judul skripsi Anda akan ditampilkan di sini.
                            </p>

                        </div>

                    @else

                        <div class="overflow-x-auto">

                            <table class="w-full min-w-[640px] text-left text-xs">

                                <thead class="bg-slate-50 text-[10px] uppercase tracking-wide text-slate-500">

                                    <tr>
                                        <th class="px-5 py-3 font-semibold">No</th>
                                        <th class="px-5 py-3 font-semibold">Judul Skripsi</th>
                                        <th class="px-5 py-3 font-semibold">Tanggal Pengajuan</th>
                                        <th class="px-5 py-3 font-semibold">Status</th>
                                    </tr>

                                </thead>

                                <tbody class="divide-y divide-slate-100">

                                    @foreach ($pengajuan as $item)

                                        <tr>

                                            <td class="px-5 py-3 text-slate-600">
                                                {{ $loop->iteration }}
                                            </td>

                                            <td class="max-w-md px-5 py-3 font-medium text-slate-700">
                                                {{ $item->judul }}
                                            </td>

                                            <td class="px-5 py-3 text-slate-600">
                                                {{ \Illuminate\Support\Carbon::parse($item->created_at)->format('d M Y') }}
                                            </td>

                                            <td class="px-5 py-3">

                                                <span class="rounded-full px-3 py-1 text-[10px] font-semibold {{
                                                    match($item->status) {
                                                        'ACC Final', 'Disahkan' => 'bg-emerald-50 text-emerald-700',
                                                        'Revisi' => 'bg-orange-50 text-orange-700',
                                                        'Ditolak' => 'bg-rose-50 text-rose-700',
                                                        'ACC Dospem', 'ACC Dosen' => 'bg-sky-50 text-sky-700',
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

                    @endif

                </section>

            </div>

        </main>

    </div>

</body>
</html>
