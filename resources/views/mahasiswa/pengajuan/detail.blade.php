@php
    $user = auth()->user();
    $status = strtolower(trim((string) $pengajuan->status));
    $isSudahDisahkanKaprodi = $status === 'acc final';

    $statusClass = match ($status) {
        'acc final', 'disahkan', 'disetujui' => 'bg-emerald-50 text-emerald-700',
        'revisi' => 'bg-orange-50 text-orange-700',
        'ditolak' => 'bg-rose-50 text-rose-700',
        'acc dospem', 'acc dosen' => 'bg-sky-50 text-sky-700',
        default => 'bg-amber-50 text-amber-700',
    };

    $statusDot = match ($status) {
        'acc final', 'disahkan', 'disetujui' => 'bg-emerald-500',
        'revisi' => 'bg-orange-500',
        'ditolak' => 'bg-rose-500',
        'acc dospem', 'acc dosen' => 'bg-sky-500',
        default => 'bg-amber-500',
    };
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengajuan - SISTA</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        * {
            box-sizing: border-box;
        }

        @media (min-width: 768px) {
            body {
                height: 100vh;
                overflow: hidden;
            }

            .page-layout {
                height: 100vh;
                overflow: hidden;
            }

            .main-content {
                min-height: 0;
                overflow-y: auto;
            }
        }

        .catatan-scroll {
            max-height: 260px;
            overflow-y: auto;
            overscroll-behavior: contain;
            scrollbar-width: thin;
            scrollbar-color: #bae6fd #f8fafc;
        }

        .catatan-scroll::-webkit-scrollbar {
            width: 5px;
        }

        .catatan-scroll::-webkit-scrollbar-track {
            background: #f8fafc;
            border-radius: 10px;
        }

        .catatan-scroll::-webkit-scrollbar-thumb {
            background: #bae6fd;
            border-radius: 10px;
        }

        .catatan-scroll::-webkit-scrollbar-thumb:hover {
            background: #7dd3fc;
        }
    </style>
</head>

<body class="min-h-screen bg-[#E8F5FF] text-slate-800">

    <div class="page-layout min-h-screen md:flex">

        <x-sidebar-mahasiswa />

        <main class="main-content min-w-0 flex-1">

            <x-topbar-mahasiswa>
                <div class="flex items-center gap-2 text-xs font-medium text-slate-600">
                    <span class="text-slate-400">Mahasiswa</span>
                    <span class="text-slate-300">›</span>
                    <a href="{{ route('mahasiswa.riwayat') }}" class="hover:underline">
                        Riwayat Pengajuan
                    </a>
                    <span class="text-slate-300">›</span>
                    <span class="font-semibold text-slate-800">Detail Pengajuan</span>
                </div>
            </x-topbar-mahasiswa>

            <div class="mx-auto max-w-6xl space-y-4 p-4 md:p-5">

                <!-- HEADER -->
                <header class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <h1 class="text-xl font-bold tracking-tight text-slate-800">
                            Detail Pengajuan
                        </h1>
                        <p class="mt-1 text-xs text-slate-500">
                            Informasi lengkap pengajuan judul skripsi Anda.
                        </p>
                    </div>

                    @if ($status === 'revisi')
                        <a href="{{ route('mahasiswa.pengajuan.edit', $pengajuan->id) }}"
                           class="inline-flex items-center gap-2 rounded-lg border border-orange-200 bg-orange-50 px-3.5 py-2 text-xs font-semibold text-orange-700 transition hover:bg-orange-100">
                            Revisi Pengajuan
                        </a>
                    @endif
                </header>

                @if (session('success'))
                    <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-2.5 text-xs text-emerald-800">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-2.5 text-xs text-red-700">
                        {{ $errors->first() }}
                    </div>
                @endif

                <!-- INFORMASI PENGAJUAN -->
                <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">

                    <!-- KOLOM UTAMA -->
                    <div class="space-y-4 lg:col-span-2">

                        <!-- DETAIL JUDUL -->
                        <section class="rounded-xl border border-sky-100 bg-white p-4 shadow-sm">

                            <!-- STATUS DAN TANGGAL -->
                            <div class="mb-4 flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 pb-3">
                                <div>
                                    <p class="mb-1 text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                        Status Saat Ini
                                    </p>

                                    <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-[10px] font-semibold {{ $statusClass }}">
                                        <span class="h-1.5 w-1.5 rounded-full {{ $statusDot }}"></span>
                                        {{ $pengajuan->status }}
                                    </span>
                                </div>

                                <div class="text-right">
                                    <p class="mb-1 text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                        Tanggal Kirim
                                    </p>
                                    <p class="text-xs font-medium text-slate-700">
                                        {{ \Illuminate\Support\Carbon::parse($pengajuan->created_at)->format('d M Y, H:i') }}
                                    </p>
                                </div>
                            </div>

                            <!-- JUDUL -->
                            <div class="mb-4">
                                <h3 class="mb-1.5 text-[10px] font-bold uppercase tracking-wide text-slate-400">
                                    Judul Skripsi
                                </h3>
                                <p class="text-sm font-semibold leading-relaxed text-slate-800">
                                    {{ $pengajuan->judul }}
                                </p>
                            </div>

                            <!-- ABSTRAK -->
                            <div>
                                <h3 class="mb-1.5 text-[10px] font-bold uppercase tracking-wide text-slate-400">
                                    Abstrak / Latar Belakang
                                </h3>
                                <div class="whitespace-pre-line rounded-lg border border-slate-100 bg-slate-50 px-3.5 py-3 text-xs leading-relaxed text-slate-600">
                                    {{ $pengajuan->abstrak }}
                                </div>
                            </div>

                        </section>

                        <!-- CATATAN DOSEN -->
                        <section class="rounded-xl border border-sky-100 bg-white p-4 shadow-sm">

                            <div class="mb-3 flex items-center justify-between gap-2 border-b border-slate-100 pb-2">
                                <h2 class="text-sm font-bold text-slate-800">
                                    Catatan Dosen Pembimbing
                                </h2>

                                @if ($catatanRevisi->count() > 0)
                                    <span class="rounded-full bg-sky-50 px-2.5 py-1 text-[10px] font-semibold text-sky-600">
                                        {{ $catatanRevisi->count() }} Catatan
                                    </span>
                                @endif
                            </div>

                            @if ($catatanRevisi->count() > 0)
                                <div class="catatan-scroll space-y-3 pr-2">
                                    @foreach ($catatanRevisi as $catatan)
                                        <div class="rounded-lg border border-slate-100 bg-slate-50 p-3">

                                            <div class="flex items-center gap-3">
                                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-sky-100 text-xs font-bold text-sky-700">
                                                    {{ mb_strtoupper(mb_substr($catatan->nama_dosen, 0, 2)) }}
                                                </div>

                                                <div class="min-w-0">
                                                    <p class="text-xs font-semibold text-slate-800">
                                                        {{ $catatan->nama_dosen }}
                                                    </p>
                                                    <p class="text-[10px] text-slate-400">
                                                        Dosen Pembimbing
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="mt-3 whitespace-pre-line break-words text-xs leading-relaxed text-slate-600">
                                                {{ $catatan->catatan }}
                                            </div>

                                            <p class="mt-2 border-t border-slate-200 pt-2 text-[10px] text-slate-400">
                                                {{ \Illuminate\Support\Carbon::parse($catatan->created_at)->format('d M Y • H:i') }}
                                            </p>

                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="rounded-lg bg-slate-50 px-4 py-5 text-center">
                                    <p class="text-xs text-slate-400">
                                        Belum ada catatan dari Dosen Pembimbing.
                                    </p>
                                </div>
                            @endif

                        </section>

                        <!-- SURAT PENGESAHAN (HANYA SETELAH DISAHKAN KAPRODI) -->
                        @if ($isSudahDisahkanKaprodi)
                            <section class="flex flex-wrap items-center justify-between gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4">
                                <div>
                                    <h3 class="text-xs font-bold text-emerald-800">
                                        Judul Telah Disahkan Kaprodi!
                                    </h3>
                                    <p class="mt-1 text-[10px] text-emerald-600">
                                        Surat pengesahan sudah diterbitkan dan siap diunduh atau dicetak.
                                    </p>
                                </div>

                                <a href="{{ route('mahasiswa.pengajuan.surat', $pengajuan->id) }}"
                                   target="_blank"
                                   class="rounded-lg bg-emerald-600 px-4 py-2 text-xs font-semibold text-white transition hover:bg-emerald-700">
                                    Cetak Surat
                                </a>
                            </section>
                        @endif

                    </div>

                    <!-- KOLOM SAMPING -->
                    <div class="space-y-4">

                        <!-- DOSEN PEMBIMBING -->
                        <section class="rounded-xl border border-sky-100 bg-white p-4 shadow-sm">
                            <h3 class="mb-3 border-b border-slate-100 pb-2 text-xs font-bold text-slate-800">
                                Tim Pembimbing
                            </h3>

                            <div class="space-y-3">
                                <div>
                                    <p class="mb-1 text-[10px] text-slate-400">
                                        Pembimbing 1
                                    </p>
                                    <p class="text-xs font-semibold text-slate-700">
                                        {{ $pengajuan->dospem_1_nama ?? '-' }}
                                    </p>
                                </div>

                                <div class="border-t border-slate-100 pt-3">
                                    <p class="mb-1 text-[10px] text-slate-400">
                                        Pembimbing 2
                                    </p>
                                    <p class="text-xs font-semibold text-slate-700">
                                        {{ $pengajuan->dospem_2_nama ?? '-' }}
                                    </p>
                                </div>
                            </div>
                        </section>

                        <!-- BERKAS PROPOSAL -->
                        <section class="rounded-xl border border-sky-100 bg-white p-4 shadow-sm">
                            <h3 class="mb-3 border-b border-slate-100 pb-2 text-xs font-bold text-slate-800">
                                Berkas Proposal
                            </h3>

                            <div class="mb-3 flex min-w-0 items-center gap-2 rounded-lg bg-slate-50 p-3">
                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-rose-50 text-[10px] font-bold text-rose-500">
                                    PDF
                                </div>

                                <p class="truncate text-xs font-medium text-slate-600"
                                   title="{{ basename($pengajuan->file_proposal) }}">
                                    {{ Str::after(basename($pengajuan->file_proposal), '_') }}
                                </p>
                            </div>

                            <a href="{{ asset('storage/' . $pengajuan->file_proposal) }}"
                               target="_blank"
                               class="flex w-full items-center justify-center gap-2 rounded-lg border border-sky-200 bg-white px-3 py-2.5 text-xs font-semibold text-sky-600 shadow-sm transition hover:bg-sky-50 hover:text-sky-700">

                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7Z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>

                                Buka File PDF
                            </a>
                        </section>

                    </div>
                </div>

            </div>
        </main>
    </div>

</body>
</html>