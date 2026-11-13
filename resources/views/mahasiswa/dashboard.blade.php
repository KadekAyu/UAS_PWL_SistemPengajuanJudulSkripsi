@php
    $user = auth()->user();
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa - SISTA</title>

    <!-- Menggunakan CDN Tailwind agar langsung rapi tanpa build npm -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-[#E8F5FF] text-slate-800">

    <div class="min-h-screen md:flex">

        <x-sidebar-mahasiswa />

        <!-- MAIN CONTENT -->
        <main class="min-w-0 flex-1">

            <x-topbar-mahasiswa>
                <span class="font-semibold text-slate-800">Dashboard Mahasiswa</span>
            </x-topbar-mahasiswa>

            <!-- PAGE CONTENT -->
            <div class="p-6">

                <!-- HEADER -->
                <header class="mb-6">

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

                        <article class="rounded-xl border border-sky-100 bg-white px-4 py-3 shadow-sm">

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
                <section class="mb-4 overflow-hidden rounded-xl border border-sky-100 bg-white shadow-sm">

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
                           class="px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white font-semibold rounded-xl text-xs transition shadow-sm">
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
                <section id="riwayat" class="overflow-hidden rounded-xl border border-sky-100 bg-white shadow-sm">

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