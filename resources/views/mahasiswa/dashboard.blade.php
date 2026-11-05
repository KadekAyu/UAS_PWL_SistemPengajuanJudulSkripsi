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

        <aside class="flex w-full flex-col border-b border-sky-100 bg-white md:h-screen md:w-60 md:shrink-0 md:border-b-0 md:border-r">

            <div class="px-5 py-5">
                <p class="text-2xl font-black tracking-tight text-sky-600">
                    SISTA
                </p>

                <p class="mt-1 text-[10px] font-semibold uppercase tracking-widest text-slate-400">
                    Portal Skripsi Mahasiswa
                </p>
            </div>

            <nav class="flex gap-2 overflow-x-auto px-3 pb-3 md:flex-1 md:flex-col">

                <p class="px-4 pb-1 pt-2 text-[10px] font-semibold uppercase tracking-widest text-slate-400">
                    Ruang Akademik
                </p>

                <a href="{{ route('mahasiswa.dashboard') }}"
                   class="whitespace-nowrap rounded-lg bg-sky-50 px-4 py-2.5 text-sm font-semibold text-sky-700">
                    Dashboard
                </a>

                <a href="#pengajuan"
                   class="whitespace-nowrap rounded-lg px-4 py-2.5 text-sm text-slate-500 transition hover:bg-sky-50 hover:text-sky-700">
                    Pengajuan Judul
                </a>

                <a href="#riwayat"
                   class="whitespace-nowrap rounded-lg px-4 py-2.5 text-sm text-slate-500 transition hover:bg-sky-50 hover:text-sky-700">
                    Riwayat Pengajuan
                </a>

                <a href="#profil"
                   class="whitespace-nowrap rounded-lg px-4 py-2.5 text-sm text-slate-500 transition hover:bg-sky-50 hover:text-sky-700">
                    Profil
                </a>

            </nav>

            <div class="border-t border-slate-100 p-3">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf

                    <button type="submit"
                        class="w-full rounded-lg px-3 py-2 text-left text-sm text-slate-500 transition hover:bg-slate-50 hover:text-slate-800">
                        Keluar
                    </button>
                </form>
            </div>

        </aside>

        <main class="min-w-0 flex-1">

            <div class="flex min-h-[52px] flex-wrap items-center justify-between gap-3 border-b border-sky-100 bg-white px-5 py-2.5 md:px-7">

                <div class="flex items-center gap-2 text-xs text-slate-500">
                    <span>Mahasiswa</span>
                    <span class="text-slate-300">›</span>
                    <span class="font-medium text-slate-700">Dashboard</span>
                </div>

                <div class="flex items-center gap-2.5">

                    <div class="text-right">
                        <p class="max-w-[180px] truncate text-xs font-semibold text-slate-700">
                            {{ auth()->user()->name }}
                        </p>

                        <p class="text-[10px] text-slate-400">
                            NPM {{ auth()->user()->npm }}
                        </p>
                    </div>

                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-sky-100 text-xs font-bold text-sky-700">
                        {{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}
                    </div>

                </div>

            </div>

            <div class="p-4 md:p-6">

                <header class="mb-5">

                    <p class="text-[10px] font-bold uppercase tracking-widest text-sky-700">
                        Dashboard Mahasiswa
                    </p>

                    <h1 class="mt-1 text-xl font-bold tracking-tight text-sky-900 md:text-2xl">
                        Selamat datang, {{ auth()->user()->name }} 👋
                    </h1>

                    <p class="mt-1 text-xs text-slate-500">
                        Pantau perkembangan judul dan tindak lanjut dari pembimbing Anda.
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

                <section class="mb-5 grid gap-3 sm:grid-cols-2 xl:grid-cols-4">

                    @foreach ([
                        ['label' => 'Total Pengajuan', 'value' => $statistics['total'], 'tone' => 'sky'],
                        ['label' => 'Menunggu Proses', 'value' => $statistics['pending'], 'tone' => 'amber'],
                        ['label' => 'Perlu Revisi', 'value' => $statistics['revisi'], 'tone' => 'orange'],
                        ['label' => 'Ditolak', 'value' => $statistics['ditolak'], 'tone' => 'rose'],
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
                                'orange' => 'bg-orange-400',
                                'rose' => 'bg-rose-400',
                            ][$card['tone']] }}"></div>

                        </article>

                    @endforeach

                </section>

                <section id="pengajuan" class="mb-5 overflow-hidden rounded-xl border border-slate-200 bg-white">

                    <div class="flex flex-wrap items-center justify-between gap-3 px-4 py-3.5">

                        <div>
                            <h2 class="text-sm font-bold text-slate-900">
                                Pengajuan Judul Skripsi
                            </h2>

                            <p class="mt-1 text-xs text-slate-500">
                                Ajukan judul dan proposal skripsi untuk mendapatkan persetujuan.
                            </p>
                        </div>

                        <a href="#"
                           class="rounded-lg bg-blue-500 px-3.5 py-2 text-xs font-semibold text-white transition hover:bg-blue-600">
                            Ajukan Judul Baru
                        </a>

                    </div>

                    <div class="border-t border-slate-100 px-4 py-3">

                        <div class="rounded-lg bg-sky-50/70 px-4 py-3">

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

                <section id="riwayat" class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-slate-200">

                    <div class="border-b border-slate-100 px-4 py-3.5">

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

                            <table class="w-full min-w-[640px] text-left text-sm">

                                <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">

                                    <tr>
                                        <th class="px-5 py-2.5 font-semibold">No</th>
                                        <th class="px-5 py-2.5 font-semibold">Judul Skripsi</th>
                                        <th class="px-5 py-2.5 font-semibold">Tanggal Pengajuan</th>
                                        <th class="px-5 py-2.5 font-semibold">Status</th>
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

                                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{
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

        <aside class="flex w-full flex-col border-b border-sky-100 bg-white md:h-screen md:w-60 md:shrink-0 md:border-b-0 md:border-r">

            <div class="px-5 py-5">
                <p class="text-2xl font-black tracking-tight text-sky-600">
                    SISTA
                </p>

                <p class="mt-1 text-[10px] font-semibold uppercase tracking-widest text-slate-400">
                    Portal Skripsi Mahasiswa
                </p>
            </div>

            <nav class="flex gap-2 overflow-x-auto px-3 pb-3 md:flex-1 md:flex-col">

                <p class="px-4 pb-1 pt-2 text-[10px] font-semibold uppercase tracking-widest text-slate-400">
                    Ruang Akademik
                </p>

                <a href="{{ route('mahasiswa.dashboard') }}"
                   class="whitespace-nowrap rounded-lg bg-sky-50 px-4 py-2.5 text-sm font-semibold text-sky-700">
                    Dashboard
                </a>

                <a href="#pengajuan"
                   class="whitespace-nowrap rounded-lg px-4 py-2.5 text-sm text-slate-500 transition hover:bg-sky-50 hover:text-sky-700">
                    Pengajuan Judul
                </a>

                <a href="#riwayat"
                   class="whitespace-nowrap rounded-lg px-4 py-2.5 text-sm text-slate-500 transition hover:bg-sky-50 hover:text-sky-700">
                    Riwayat Pengajuan
                </a>

                <a href="#profil"
                   class="whitespace-nowrap rounded-lg px-4 py-2.5 text-sm text-slate-500 transition hover:bg-sky-50 hover:text-sky-700">
                    Profil
                </a>

            </nav>

            <div class="border-t border-slate-100 p-3">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf

                    <button type="submit"
                        class="w-full rounded-lg px-3 py-2 text-left text-sm text-slate-500 transition hover:bg-slate-50 hover:text-slate-800">
                        Keluar
                    </button>
                </form>
            </div>

        </aside>

        <main class="min-w-0 flex-1">

            <div class="flex min-h-[52px] flex-wrap items-center justify-between gap-3 border-b border-sky-100 bg-white px-5 py-2.5 md:px-7">

                <div class="flex items-center gap-2 text-xs text-slate-500">
                    <span>Mahasiswa</span>
                    <span class="text-slate-300">›</span>
                    <span class="font-medium text-slate-700">Dashboard</span>
                </div>

                <div class="flex items-center gap-2.5">

                    <div class="text-right">
                        <p class="max-w-[180px] truncate text-xs font-semibold text-slate-700">
                            {{ auth()->user()->name }}
                        </p>

                        <p class="text-[10px] text-slate-400">
                            NPM {{ auth()->user()->npm }}
                        </p>
                    </div>

                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-sky-100 text-xs font-bold text-sky-700">
                        {{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}
                    </div>

                </div>

            </div>

            <div class="p-4 md:p-6">

                <header class="mb-5">

                    <p class="text-[10px] font-bold uppercase tracking-widest text-sky-900">
                        Dashboard Mahasiswa
                    </p>

                    <h1 class="mt-1 text-xl font-bold tracking-tight text-sky-900 md:text-2xl">
                        Selamat datang, {{ auth()->user()->name }} 👋
                    </h1>

                    <p class="mt-1 text-xs text-slate-500">
                        Pantau perkembangan judul dan tindak lanjut dari pembimbing Anda.
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

                <section class="mb-5 grid gap-3 sm:grid-cols-2 xl:grid-cols-4">

                    @foreach ([
                        ['label' => 'Total Pengajuan', 'value' => $statistics['total'], 'tone' => 'sky'],
                        ['label' => 'Menunggu Proses', 'value' => $statistics['pending'], 'tone' => 'amber'],
                        ['label' => 'Perlu Revisi', 'value' => $statistics['revisi'], 'tone' => 'orange'],
                        ['label' => 'Ditolak', 'value' => $statistics['ditolak'], 'tone' => 'rose'],
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
                                'orange' => 'bg-orange-400',
                                'rose' => 'bg-rose-400',
                            ][$card['tone']] }}"></div>

                        </article>

                    @endforeach

                </section>

                <section id="pengajuan" class="mb-5 overflow-hidden rounded-xl border border-slate-200 bg-white">

                    <div class="flex flex-wrap items-center justify-between gap-3 px-4 py-3.5">

                        <div>
                            <h2 class="text-sm font-bold text-slate-900">
                                Pengajuan Judul Skripsi
                            </h2>

                            <p class="mt-1 text-xs text-slate-500">
                                Ajukan judul dan proposal skripsi untuk mendapatkan persetujuan.
                            </p>
                        </div>

                        <a href="#"
                           class="rounded-lg bg-blue-500 px-3.5 py-2 text-xs font-semibold text-white transition hover:bg-blue-600">
                            Ajukan Judul Baru
                        </a>

                    </div>

                    <div class="border-t border-slate-100 px-4 py-3">

                        <div class="rounded-lg bg-sky-50/70 px-4 py-3">

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

                <section id="riwayat" class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-slate-200">

                    <div class="border-b border-slate-100 px-4 py-3.5">

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

                            <table class="w-full min-w-[640px] text-left text-sm">

                                <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">

                                    <tr>
                                        <th class="px-5 py-2.5 font-semibold">No</th>
                                        <th class="px-5 py-2.5 font-semibold">Judul Skripsi</th>
                                        <th class="px-5 py-2.5 font-semibold">Tanggal Pengajuan</th>
                                        <th class="px-5 py-2.5 font-semibold">Status</th>
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

                                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{
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
