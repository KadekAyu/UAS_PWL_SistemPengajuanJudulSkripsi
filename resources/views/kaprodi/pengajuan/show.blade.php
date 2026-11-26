@php
    $status = strtolower(trim((string) $detail->status));
    $isSiapDisahkan = $status === 'disetujui';
    $isAccFinal = $status === 'acc final';

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

    $fileBasename = $detail->file_proposal ? basename($detail->file_proposal) : null;
    $displayFilename = $fileBasename ? \Illuminate\Support\Str::after($fileBasename, '_') : null;
    $cleanFilename = $displayFilename ?: $fileBasename;
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengajuan - SISTA</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif

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
    </style>
</head>

<body class="min-h-screen bg-[#E8F5FF] text-slate-800">

    <div class="page-layout min-h-screen md:flex">

        <x-sidebar-kaprodi />

        <main class="main-content min-w-0 flex-1">

            <x-topbar-kaprodi>
                <span>Ketua Program Studi</span>
                <span class="text-slate-300">›</span>
                <a href="{{ route('kaprodi.pengajuan.index') }}" class="hover:text-sky-700">
                    Pengajuan Masuk
                </a>
                <span class="text-slate-300">›</span>
                <span class="font-medium text-slate-700">Detail Pengajuan</span>
            </x-topbar-kaprodi>

            <div class="mx-auto max-w-6xl space-y-4 p-4 md:p-5">

                <!-- HEADER -->
                <header class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <h1 class="text-xl font-bold tracking-tight text-slate-800">
                            Detail Pengajuan
                        </h1>
                        <p class="mt-1 text-xs text-slate-500">
                            Informasi lengkap pengajuan judul skripsi yang telah disetujui kedua pembimbing.
                        </p>
                    </div>
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
                                        {{ $detail->status }}
                                    </span>
                                </div>

                                <div class="text-right">
                                    <p class="mb-1 text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                        Tanggal Kirim
                                    </p>
                                    <p class="text-xs font-medium text-slate-700">
                                        {{ \Illuminate\Support\Carbon::parse($detail->created_at)->format('d M Y, H:i') }}
                                    </p>
                                </div>
                            </div>

                            <!-- IDENTITAS MAHASISWA -->
                            <div class="mb-4 grid grid-cols-1 gap-3 border-b border-slate-100 pb-3 sm:grid-cols-2">
                                <div>
                                    <h3 class="mb-1 text-[10px] font-bold uppercase tracking-wide text-slate-400">
                                        Mahasiswa
                                    </h3>
                                    <p class="text-xs font-semibold text-slate-800">
                                        {{ $detail->nama_mahasiswa }}
                                    </p>
                                </div>

                                <div>
                                    <h3 class="mb-1 text-[10px] font-bold uppercase tracking-wide text-slate-400">
                                        NPM
                                    </h3>
                                    <p class="text-xs font-semibold text-slate-800">
                                        {{ $detail->npm }}
                                    </p>
                                </div>
                            </div>

                            <!-- JUDUL -->
                            <div class="mb-4">
                                <h3 class="mb-1.5 text-[10px] font-bold uppercase tracking-wide text-slate-400">
                                    Judul Skripsi
                                </h3>
                                <p class="text-sm font-semibold leading-relaxed text-slate-800">
                                    {{ $detail->judul }}
                                </p>
                            </div>

                            <!-- ABSTRAK -->
                            <div>
                                <h3 class="mb-1.5 text-[10px] font-bold uppercase tracking-wide text-slate-400">
                                    Abstrak / Latar Belakang
                                </h3>
                                <div class="whitespace-pre-line rounded-lg border border-slate-100 bg-slate-50 px-3.5 py-3 text-xs leading-relaxed text-slate-600">
                                    {{ $detail->abstrak ?: 'Abstrak belum tersedia.' }}
                                </div>
                            </div>

                        </section>

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
                                        {{ $detail->nama_dospem_1 ?? '-' }}
                                    </p>
                                </div>

                                <div class="border-t border-slate-100 pt-3">
                                    <p class="mb-1 text-[10px] text-slate-400">
                                        Pembimbing 2
                                    </p>
                                    <p class="text-xs font-semibold text-slate-700">
                                        {{ $detail->nama_dospem_2 ?? '-' }}
                                    </p>
                                </div>
                            </div>
                        </section>

                        <!-- BERKAS PROPOSAL -->
                        <section class="rounded-xl border border-sky-100 bg-white p-4 shadow-sm">
                            <h3 class="mb-3 border-b border-slate-100 pb-2 text-xs font-bold text-slate-800">
                                Berkas Proposal
                            </h3>

                            @if ($detail->file_proposal)
                                <div class="mb-3 flex min-w-0 items-center gap-2 rounded-lg bg-slate-50 p-3">
                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-rose-50 text-[10px] font-bold text-rose-500">
                                        PDF
                                    </div>

                                    <p class="truncate text-xs font-medium text-slate-600"
                                       title="{{ $fileBasename }}">
                                        {{ $cleanFilename }}
                                    </p>
                                </div>

                                <a href="{{ asset('storage/' . $detail->file_proposal) }}"
                                   target="_blank"
                                   class="flex w-full items-center justify-center gap-2 rounded-lg border border-sky-200 bg-white px-3 py-2.5 text-xs font-semibold text-sky-600 shadow-sm transition hover:bg-sky-50 hover:text-sky-700">

                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7Z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>

                                    Buka File PDF
                                </a>
                            @else
                                <div class="rounded-lg bg-slate-50 px-3 py-4 text-center">
                                    <p class="text-xs text-slate-400">
                                        Berkas proposal belum tersedia.
                                    </p>
                                </div>
                            @endif
                        </section>

                        <!-- PENGESAHAN JUDUL -->
                        <section class="rounded-xl border border-sky-100 bg-white p-4 shadow-sm">
                            <h3 class="mb-3 border-b border-slate-100 pb-2 text-xs font-bold text-slate-800">
                                Pengesahan Judul
                            </h3>

                            @if ($isSiapDisahkan)
                                <p class="mb-3 text-xs leading-relaxed text-slate-500">
                                    Judul telah disetujui kedua dosen pembimbing. Sahkan judul untuk menerbitkan nomor SK.
                                </p>

                                <form action="{{ route('kaprodi.pengajuan.sahkan', $detail->id) }}"
                                      method="POST">
                                    @csrf
                                    <button type="submit"
                                            onclick="return confirm('Sahkan judul ini beserta Pembimbing 1 & 2 dan terbitkan nomor SK?')"
                                            class="flex w-full items-center justify-center gap-2 rounded-lg bg-sky-600 px-3 py-2.5 text-xs font-semibold text-white shadow-sm transition hover:bg-sky-700">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Sahkan Judul
                                    </button>
                                </form>
                            @elseif ($isAccFinal)
                                <div class="rounded-lg border border-emerald-200 bg-emerald-50 p-3 text-xs text-emerald-800">
                                    <p class="font-bold">Judul Telah Disahkan</p>
                                    <p class="mt-1 text-[11px] text-emerald-700">
                                        Nomor SK: <span class="font-semibold">{{ $detail->nomor_sk ?? '-' }}</span>
                                    </p>
                                </div>
                            @else
                                <div class="rounded-lg bg-slate-50 px-3 py-4 text-center">
                                    <p class="text-xs text-slate-400">
                                        Pengajuan ini belum siap disahkan oleh Kaprodi.
                                    </p>
                                </div>
                            @endif
                        </section>

                    </div>
                </div>

            </div>
        </main>
    </div>

    <script src="https://unpkg.com/lucide@0.468.0/dist/umd/lucide.min.js"></script>
    <script>
        if (window.lucide) {
            lucide.createIcons();
        }
    </script>
</body>
</html>