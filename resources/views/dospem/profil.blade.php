<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Dosen Pembimbing - SISTA</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://unpkg.com/lucide@0.468.0/dist/umd/lucide.min.js"></script>
</head>

<body class="min-h-screen bg-[#E8F5FF] text-slate-800">

<div class="min-h-screen md:flex">

    <!-- SIDEBAR -->
    <aside class="flex w-full flex-col border-b border-sky-100 bg-white md:sticky md:top-0 md:h-screen md:w-60 md:shrink-0 md:border-b-0 md:border-r">

        <!-- LOGO -->
        <div class="px-5 py-5">
            <p class="text-2xl font-black tracking-tight text-sky-600">
                SISTA
            </p>
            <p class="mt-1 text-[8px] font-semibold uppercase tracking-widest text-slate-400">
                Portal Skripsi Dosen Pembimbing
            </p>
        </div>

        <!-- NAVIGASI -->
        <nav class="flex gap-2 overflow-x-auto px-3 pb-3 md:flex-1 md:flex-col">

            <p class="px-4 pb-1 pt-2 text-[10px] font-semibold uppercase tracking-widest text-slate-400">
                Ruang Akademik
            </p>

            <a href="{{ route('dospem.dashboard') }}"
               class="flex items-center gap-3 whitespace-nowrap rounded-lg px-4 py-2.5 text-sm text-slate-500 transition hover:bg-sky-50 hover:text-sky-700">
                <i data-lucide="layout-grid" class="h-5 w-5"></i>
                Dashboard
            </a>

            <a href="{{ route('dospem.pengajuan.index') }}"
               class="flex items-center gap-3 whitespace-nowrap rounded-lg px-4 py-2.5 text-sm text-slate-500 transition hover:bg-sky-50 hover:text-sky-700">
                <i data-lucide="file-text" class="h-5 w-5"></i>
                Pengajuan Masuk
            </a>

            <a href="{{ route('dospem.riwayat') }}"
               class="flex items-center gap-3 whitespace-nowrap rounded-lg px-4 py-2.5 text-sm text-slate-500 transition hover:bg-sky-50 hover:text-sky-700">
                <i data-lucide="clock-3" class="h-5 w-5"></i>
                Riwayat Review
            </a>

            <a href="{{ route('dospem.profil') }}"
               class="flex items-center gap-3 whitespace-nowrap rounded-lg bg-sky-50 px-4 py-2.5 text-sm font-semibold text-sky-700">
                <i data-lucide="circle-user-round" class="h-5 w-5"></i>
                Profil
            </a>

        </nav>

        <!-- LOGOUT -->
        <div class="border-t border-slate-100 p-3">
            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button type="submit"
                        class="flex w-full items-center gap-3 rounded-lg px-4 py-2.5 text-left text-sm text-rose-600 transition hover:bg-rose-50">
                    <i data-lucide="log-out" class="h-5 w-5"></i>
                    Logout
                </button>
            </form>
        </div>

    </aside>

    <!-- KONTEN UTAMA -->
    <main class="min-w-0 flex-1">

        <!-- TOPBAR -->
        <div class="flex min-h-[52px] flex-wrap items-center justify-between gap-3 border-b border-sky-100 bg-white px-5 py-2.5 md:px-7">

            <div class="flex items-center gap-2 text-xs text-slate-500">
                <span>Dosen Pembimbing</span>
                <span>›</span>
                <span class="font-semibold text-slate-700">
                    Profil
                </span>
            </div>

            <div class="flex items-center gap-2.5">

                <div class="text-right">
                    <p class="max-w-[180px] truncate text-xs font-semibold text-slate-700">
                        {{ $user->name }}
                    </p>
                    <p class="text-[10px] text-slate-400">
                        Dosen Pembimbing
                    </p>
                </div>

                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-sky-100 text-xs font-bold text-sky-700">
                    {{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}
                </div>

            </div>

        </div>

        <!-- ISI HALAMAN -->
        <div class="p-4 md:p-6">

            <header class="mb-6">

                <p class="text-[10px] font-bold uppercase tracking-widest text-sky-700">
                    Dosen Pembimbing
                </p>

                <h1 class="mt-1 text-2xl font-bold text-sky-900">
                    Profil Saya
                </h1>

                <p class="mt-1 text-xs text-slate-500">
                    Informasi identitas dan akun dosen pembimbing.
                </p>

            </header>

            <!-- KARTU PROFIL UTAMA -->
            <section class="mb-5 overflow-hidden rounded-xl border border-slate-200 bg-white">

                <div class="h-24 bg-gradient-to-r from-sky-600 to-cyan-400"></div>

                <div class="px-5 pb-6">

                    <div class="-mt-8 flex flex-wrap items-end justify-between gap-3">

                        <div class="flex h-16 w-16 items-center justify-center rounded-2xl border-4 border-white bg-sky-100 text-2xl font-bold text-sky-700 shadow-sm">
                            {{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}
                        </div>

                        <span class="rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700">
                            Akun Dosen Pembimbing
                        </span>

                    </div>

                    <h2 class="mt-4 text-xl font-bold text-slate-900">
                        {{ $user->name }}
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Dosen Pembimbing
                    </p>

                    <div class="mt-4 flex flex-wrap gap-3 text-xs text-slate-500">

                        <span class="flex items-center gap-2">
                            <i data-lucide="mail" class="h-4 w-4 text-sky-600"></i>
                            {{ $user->email }}
                        </span>

                        @if (filled($user->nip))
                            <span class="flex items-center gap-2">
                                <i data-lucide="id-card" class="h-4 w-4 text-sky-600"></i>
                                NIP: {{ $user->nip }}
                            </span>
                        @endif

                    </div>

                </div>

            </section>

            <div class="grid gap-5 xl:grid-cols-3">

                <!-- INFORMASI PRIBADI -->
                <section class="overflow-hidden rounded-xl border border-slate-200 bg-white xl:col-span-2">

                    <div class="border-b border-slate-100 px-5 py-4">
                        <h2 class="flex items-center gap-2 text-sm font-bold text-slate-900">
                            <i data-lucide="user-round" class="h-4 w-4 text-sky-600"></i>
                            Informasi Dosen
                        </h2>
                    </div>

                    <div class="grid gap-5 p-5 sm:grid-cols-2">

                        <div>
                            <p class="text-xs text-slate-400">
                                Nama Lengkap
                            </p>

                            <p class="mt-1 text-sm font-semibold text-slate-800">
                                {{ $user->name }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-slate-400">
                                NIP
                            </p>

                            <p class="mt-1 text-sm font-semibold text-slate-800">
                                {{ $user->nip ?: 'Belum tersedia' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-slate-400">
                                Email
                            </p>

                            <p class="mt-1 break-all text-sm font-semibold text-slate-800">
                                {{ $user->email }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-slate-400">
                                Peran Akun
                            </p>

                            <p class="mt-1 text-sm font-semibold text-slate-800">
                                Dosen Pembimbing
                            </p>
                        </div>

                    </div>

                </section>

                <!-- INFORMASI AKUN -->
                <section class="overflow-hidden rounded-xl border border-slate-200 bg-white">

                    <div class="border-b border-slate-100 px-5 py-4">
                        <h2 class="flex items-center gap-2 text-sm font-bold text-slate-900">
                            <i data-lucide="shield-check" class="h-4 w-4 text-sky-600"></i>
                            Informasi Akun
                        </h2>
                    </div>

                    <div class="space-y-4 p-5">

                        <div>
                            <p class="text-xs text-slate-400">
                                Status Akun
                            </p>
                            <p class="mt-1 text-sm font-semibold text-emerald-700">
                                Terdaftar
                            </p>
                        </div>

                        <div class="border-t border-slate-100 pt-4">
                            <p class="text-xs text-slate-400">
                                Tanggal Pendaftaran
                            </p>
                            <p class="mt-1 text-sm font-semibold text-slate-800">
                                {{ $user->created_at ? $user->created_at->format('d/m/Y') : '-' }}
                            </p>
                        </div>

                        <div class="border-t border-slate-100 pt-4">
                            <p class="text-xs text-slate-400">
                                Keamanan
                            </p>
                            <p class="mt-1 text-xs leading-6 text-slate-600">
                                Informasi akun ditampilkan sesuai pengguna yang sedang login.
                            </p>
                        </div>

                    </div>

                </section>

            </div>

            <!-- KETERANGAN -->
            <div class="mt-5 flex items-start gap-3 rounded-xl border border-sky-100 bg-white p-4">
                <i data-lucide="info" class="mt-0.5 h-5 w-5 shrink-0 text-sky-600"></i>

                <p class="text-xs leading-6 text-slate-600">
                    Halaman profil saat ini bersifat hanya-baca.
                    Fitur mengubah data profil atau kata sandi
                    belum tersedia pada tahap ini.
                </p>
            </div>

        </div>

    </main>

</div>

<script>
    if (window.lucide) {
        lucide.createIcons();
    }
</script>

</body>
</html>