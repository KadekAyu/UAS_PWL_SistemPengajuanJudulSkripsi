@php
    $user = auth()->user();
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - SISTA</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif

    <script src="https://unpkg.com/lucide@0.468.0/dist/umd/lucide.min.js"></script>
</head>

<body class="min-h-screen bg-[#E8F5FF] text-slate-800">

    <div class="min-h-screen md:flex">

        {{-- SIDEBAR --}}
        <x-sidebar-dospem />

        {{-- MAIN CONTENT --}}
        <main class="min-w-0 flex-1">

            {{-- TOPBAR --}}
            <x-topbar-dospem>
                <div class="flex items-center gap-2 text-xs font-medium text-slate-600">

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

                    <i data-lucide="chevron-right" class="h-3 w-3 text-slate-400"></i>

                    <span class="font-semibold text-slate-800">
                        Profil Saya
                    </span>

                </div>
            </x-topbar-dospem>

            {{-- PAGE CONTENT --}}
            <div class="p-4 md:p-5">

                {{-- HEADER --}}
                <header class="mb-4">
                    <h1 class="text-xl font-bold tracking-tight text-slate-800">
                        Profil Saya
                    </h1>

                    <p class="mt-1 text-xs text-slate-500">
                        Lihat informasi identitas akun Anda.
                    </p>
                </header>

                {{-- KARTU PROFIL --}}
                <section class="mb-4 flex items-center gap-4 rounded-xl border border-sky-100 bg-white px-4 py-3 shadow-sm md:px-5">

                    {{-- AVATAR --}}
                    <div class="flex h-[66px] w-[66px] shrink-0 items-center justify-center rounded-full border-[3px] border-white bg-[#DDF2FF] text-2xl font-bold uppercase text-[#269FE8] shadow-[0_0_0_2px_#BAE6FD]">
                        {{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}
                    </div>

                    {{-- NAMA DAN STATUS --}}
                    <div class="min-w-0">
                        <h2 class="truncate text-base font-bold text-slate-800 md:text-lg">
                            {{ $user->name }}
                        </h2>

                        <p class="mt-1 text-xs text-slate-500">
                            Dosen Pembimbing
                        </p>

                        <div class="mt-2 inline-flex items-center gap-1.5 rounded-full bg-green-50 px-2.5 py-1 text-[10px] font-semibold text-green-600">
                            <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>
                            Akun Aktif
                        </div>
                    </div>

                </section>

                {{-- INFORMASI PROFIL --}}
                <div class="grid gap-4 lg:grid-cols-2">

                    {{-- INFORMASI PRIBADI --}}
                    <section class="overflow-hidden rounded-xl border border-sky-100 bg-white shadow-sm">

                        <div class="flex items-center gap-3 border-b border-slate-100 px-4 py-3">

                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-sky-50 text-sky-600">
                                <i data-lucide="user-round" class="h-4 w-4"></i>
                            </div>

                            <div>
                                <h2 class="text-sm font-bold text-slate-800">
                                    Informasi Pribadi
                                </h2>

                                <p class="mt-0.5 text-[11px] text-slate-400">
                                    Informasi identitas akun dosen pembimbing.
                                </p>
                            </div>

                        </div>

                        <div class="space-y-3 p-4">

                            {{-- NAMA --}}
                            <div>
                                <p class="mb-1.5 text-xs font-semibold text-slate-700">
                                    Nama Lengkap
                                </p>

                                <div class="flex items-center gap-2.5 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5">
                                    <i data-lucide="user" class="h-4 w-4 shrink-0 text-sky-600"></i>

                                    <p class="text-xs font-semibold text-slate-700">
                                        {{ $user->name }}
                                    </p>
                                </div>
                            </div>

                            {{-- NIP --}}
                            <div>
                                <p class="mb-1.5 text-xs font-semibold text-slate-700">
                                    NIP
                                </p>

                                <div class="flex items-center gap-2.5 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5">
                                    <i data-lucide="id-card" class="h-4 w-4 shrink-0 text-sky-600"></i>

                                    <p class="text-xs font-semibold text-slate-700">
                                        {{ $user->nip ?: 'Belum tersedia' }}
                                    </p>
                                </div>
                            </div>

                            {{-- EMAIL --}}
                            <div>
                                <p class="mb-1.5 text-xs font-semibold text-slate-700">
                                    Email
                                </p>

                                <div class="flex items-center gap-2.5 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5">
                                    <i data-lucide="mail" class="h-4 w-4 shrink-0 text-sky-600"></i>

                                    <p class="break-all text-xs font-semibold text-slate-700">
                                        {{ $user->email }}
                                    </p>
                                </div>
                            </div>

                        </div>

                    </section>

                    {{-- INFORMASI AKUN --}}
                    <section class="overflow-hidden rounded-xl border border-sky-100 bg-white shadow-sm">

                        <div class="flex items-center gap-3 border-b border-slate-100 px-4 py-3">

                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-sky-50 text-sky-600">
                                <i data-lucide="shield-check" class="h-4 w-4"></i>
                            </div>

                            <div>
                                <h2 class="text-sm font-bold text-slate-800">
                                    Informasi Akun
                                </h2>

                                <p class="mt-0.5 text-[11px] text-slate-400">
                                    Detail akun dan akses sistem.
                                </p>
                            </div>

                        </div>

                        <div class="space-y-3 p-4">

                            {{-- STATUS AKUN --}}
                            <div>
                                <p class="mb-1.5 text-xs font-semibold text-slate-700">
                                    Status Akun
                                </p>

                                <div class="flex items-center gap-2.5 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5">
                                    <i data-lucide="check-circle" class="h-4 w-4 shrink-0 text-emerald-600"></i>

                                    <p class="text-xs font-semibold text-emerald-600">
                                        Terdaftar
                                    </p>
                                </div>
                            </div>

                            {{-- PERAN --}}
                            <div>
                                <p class="mb-1.5 text-xs font-semibold text-slate-700">
                                    Peran Akun
                                </p>

                                <div class="flex items-center gap-2.5 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5">
                                    <i data-lucide="briefcase-business" class="h-4 w-4 shrink-0 text-sky-600"></i>

                                    <p class="text-xs font-semibold text-slate-700">
                                        Dosen Pembimbing
                                    </p>
                                </div>
                            </div>

                            {{-- TANGGAL PENDAFTARAN --}}
                            <div>
                                <p class="mb-1.5 text-xs font-semibold text-slate-700">
                                    Tanggal Pendaftaran
                                </p>

                                <div class="flex items-center gap-2.5 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5">
                                    <i data-lucide="calendar-days" class="h-4 w-4 shrink-0 text-sky-600"></i>

                                    <p class="text-xs font-semibold text-slate-700">
                                        {{ $user->created_at ? $user->created_at->format('d/m/Y') : '-' }}
                                    </p>
                                </div>
                            </div>

                        </div>

                    </section>

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
