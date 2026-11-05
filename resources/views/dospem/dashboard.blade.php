<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Dosen Pembimbing - SISTA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-[#E8F5FF] text-slate-800">

<div class="min-h-screen md:flex">

    <!-- SIDEBAR -->
    <aside class="flex w-full flex-col bg-white md:min-h-screen md:w-72">

        <div class="px-6 py-6">
            <h1 class="text-4xl font-black text-sky-600">SISTA</h1>
            <p class="mt-1 text-xs text-slate-500">
                Panel Dosen Pembimbing
            </p>
        </div>

        <nav class="flex gap-2 px-3 md:flex-1 md:flex-col">

            <a href="#dashboard"
               class="flex items-center gap-3 rounded-xl bg-sky-50 px-4 py-3 text-sm font-semibold text-sky-700">
                <span>▦</span> Dashboard
            </a>

            <a href="#pengajuan"
               class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm text-slate-500 hover:bg-sky-50">
                <span>▤</span> Pengajuan Masuk
            </a>

            <a href="#riwayat"
               class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm text-slate-500 hover:bg-sky-50">
                <span>◷</span> Riwayat Review
            </a>

            <a href="#profil"
               class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm text-slate-500 hover:bg-sky-50">
                <span style="color: gray;">👤︎</span> Profil
            </a>

        </nav>

        <div class="border-t p-4">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="px-3 py-2 text-sm text-slate-500">
                    Keluar
                </button>
            </form>
        </div>

    </aside>

    <!-- KONTEN UTAMA -->
    <main id="dashboard" class="min-w-0 flex-1 p-5 md:p-8">

        <!-- HEADER + PROFIL -->
        <div class="mb-8 flex flex-wrap items-start justify-between gap-4">

            <div>
                <p class="text-xs text-slate-500">
                    Dashboard Dosen Pembimbing
                </p>
                <h2 class="mt-1 text-3xl font-bold text-slate-900">
                    Selamat datang, {{ auth()->user()->name }}
                </h2>
                <p class="mt-2 text-sm text-slate-500">
                    Pantau dan review pengajuan judul skripsi mahasiswa.
                </p>
            </div>

            <div id="profil"
                 class="flex items-center gap-3 rounded-xl border bg-white px-5 py-3 shadow-sm">

                <div class="text-right">
                    <p class="text-sm font-semibold">
                        {{ auth()->user()->name }}
                    </p>
                    <p class="text-xs text-slate-500">
                        Dosen Pembimbing
                    </p>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-full bg-sky-100 text-sky-600 text-xl">
                    👤
                </div>

                <span class="text-slate-400">⌄</span>
            </div>

        </div>

        <!-- STATISTIK -->
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">

            @foreach ([
                ['Total Pengajuan', 'bg-sky-400'],
                ['Menunggu Review', 'bg-amber-400'],
                ['Sudah ACC', 'bg-emerald-500'],
                ['Revisi / Ditolak', 'bg-rose-400']
            ] as $item)

                <div class="rounded-xl border border-slate-200 bg-white p-5">
                    <p class="text-xs text-slate-500">
                        {{ $item[0] }}
                    </p>
                    <p class="mt-2 text-2xl font-bold">0</p>
                    <div class="mt-3 h-1 w-10 rounded-full {{ $item[1] }}"></div>
                </div>

            @endforeach

        </div>

        <!-- PENGAJUAN MASUK -->
        <section id="pengajuan" class="mt-8 rounded-xl bg-white p-6">
            <h3 class="font-bold">Pengajuan Masuk</h3>
            <p class="mt-6 text-center text-sm text-slate-500">
                Belum ada pengajuan untuk direview.
            </p>
        </section>

        <!-- RIWAYAT REVIEW -->
        <section id="riwayat" class="mt-6 rounded-xl bg-white p-6">
            <h3 class="font-bold">Riwayat Review</h3>
            <p class="mt-6 text-center text-sm text-slate-500">
                Belum ada riwayat review.
            </p>
        </section>

    </main>
</div>

</body>
</html>