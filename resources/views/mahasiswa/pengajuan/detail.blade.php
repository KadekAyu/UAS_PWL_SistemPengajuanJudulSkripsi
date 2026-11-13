@php
    $user = auth()->user();
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengajuan - SISTA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-[#E8F5FF] text-slate-800">

    <div class="min-h-screen md:flex">

        <!-- Sidebar Mahasiswa -->
        <x-sidebar-mahasiswa />

        <!-- MAIN CONTENT -->
        <main class="min-w-0 flex-1">

            <!-- Topbar Terpusat -->
            <x-topbar-mahasiswa>
                <span>Mahasiswa</span>
                <span class="text-slate-300">›</span>
                <a href="{{ route('mahasiswa.riwayat') }}" class="hover:underline">Riwayat Pengajuan</a>
                <span class="text-slate-300">›</span>
                <span class="font-semibold text-slate-800">Detail Pengajuan</span>
            </x-topbar-mahasiswa>

            <!-- PAGE CONTENT CONTAINER -->
            <div class="p-8 max-w-5xl mx-auto space-y-6">

                <!-- HEADER & BREADCRUMB/STATUS INFO -->
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs font-semibold text-sky-600 tracking-wide uppercase">Pengajuan Aktif</span>
                            <span class="text-slate-300">•</span>
                            <span class="text-xs text-slate-400">ID #{{ $pengajuan->id }}</span>
                        </div>
                        <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                            Detail Pengajuan
                        </h1>
                        <p class="mt-1 text-xs text-slate-500">
                            Tinjau status, informasi proposal, dan catatan dosen pembimbing untuk pengajuan ini.
                        </p>
                    </div>

                    <div class="flex items-center gap-3">
                        <!-- TOMBOL REVISI (Hanya muncul jika status 'revisi') -->
                        @if(strtolower($pengajuan->status) === 'revisi')
                            <a href="{{ route('mahasiswa.pengajuan.edit', $pengajuan->id) }}" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white text-xs font-semibold rounded-xl shadow-sm transition flex items-center gap-2">
                                ✎ Revisi Pengajuan
                            </a>
                        @endif

                        <a href="{{ route('mahasiswa.riwayat') }}" class="px-4 py-2 bg-white border border-sky-200 text-sky-600 hover:bg-sky-50 text-xs font-semibold rounded-xl shadow-sm transition">
                            ← Kembali ke Riwayat
                        </a>
                    </div>
                </div>

                <!-- MAIN INFO GRID -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    <!-- KOLOM KIRI / UTAMA (2 Kolom di LG): Judul & Abstrak -->
                    <div class="lg:col-span-2 space-y-6">

                        <!-- CARD INFORMASI UTAMA -->
                        <div class="bg-white rounded-2xl border border-sky-100 shadow-sm p-6 space-y-5">
                            
                            <!-- Status Badge -->
                            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                                <div>
                                    <span class="text-[10px] uppercase tracking-wider text-slate-400 block mb-1">Status Saat Ini</span>
                                    <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-medium {{
                                        match($pengajuan->status) {
                                            'ACC Final', 'Disahkan' => 'bg-emerald-50 text-emerald-700',
                                            'Revisi' => 'bg-amber-50 text-amber-700',
                                            'Ditolak' => 'bg-rose-50 text-rose-700',
                                            default => 'bg-sky-50 text-sky-700',
                                        }
                                    }}">
                                        <span class="h-1.5 w-1.5 rounded-full {{
                                            match($pengajuan->status) {
                                                'ACC Final', 'Disahkan' => 'bg-emerald-500',
                                                'Revisi' => 'bg-amber-500',
                                                'Ditolak' => 'bg-rose-500',
                                                default => 'bg-sky-500',
                                            }
                                        }}"></span>
                                        {{ ucfirst($pengajuan->status) }}
                                    </span>
                                </div>

                                <div class="text-right">
                                    <span class="text-[10px] uppercase tracking-wider text-slate-400 block mb-1">Tanggal Kirim</span>
                                    <span class="text-xs font-medium text-slate-700">
                                        {{ \Illuminate\Support\Carbon::parse($pengajuan->created_at)->format('d M Y, H:i') }}
                                    </span>
                                </div>
                            </div>

                            <!-- Judul Skripsi -->
                            <div>
                                <h3 class="text-[10px] uppercase tracking-wider text-slate-400 mb-1.5">Judul Skripsi</h3>
                                <p class="text-sm font-bold text-slate-900 leading-relaxed">
                                    {{ $pengajuan->judul }}
                                </p>
                            </div>

                            <!-- Abstrak -->
                            <div>
                                <h3 class="text-[10px] uppercase tracking-wider text-slate-400 mb-1.5">Abstrak Penelitian</h3>
                                <div class="p-4 bg-slate-50/70 rounded-xl text-xs text-slate-700 leading-relaxed whitespace-pre-line border border-slate-100">
                                    {{ $pengajuan->abstrak }}
                                </div>
                            </div>

                        </div>

                        <!-- SECTION CATATAN / REVISI DARI DOSEN -->
                        <div class="space-y-4">
                            <h3 class="text-sm font-bold text-slate-900 px-1">
                                Catatan & Evaluasi Dosen Pembimbing
                            </h3>

                            <!-- Card Komentar Dospem 1 -->
                            <div class="bg-white rounded-2xl border border-sky-100 shadow-sm p-5 space-y-3">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-sky-100 font-bold text-sky-700 text-xs">
                                        {{ $pengajuan->dospem_1_nama ? mb_strtoupper(mb_substr($pengajuan->dospem_1_nama, 0, 2)) : 'D1' }}
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-900">{{ $pengajuan->dospem_1_nama ?? 'Dosen Pembimbing 1' }}</p>
                                        <p class="text-[10px] text-slate-400">Dosen Pembimbing 1 (Utama)</p>
                                    </div>
                                </div>
                                <p class="text-xs text-slate-700 leading-relaxed pl-13">
                                    {{ $pengajuan->catatan_dospem_1 ?? 'Belum ada catatan atau evaluasi dari Dosen Pembimbing 1.' }}
                                </p>
                                <p class="text-[10px] text-slate-400 pl-13 pt-1">
                                    {{ \Illuminate\Support\Carbon::parse($pengajuan->updated_at)->format('d M Y • H:i') }}
                                </p>
                            </div>

                            <!-- Card Komentar Dospem 2 -->
                            <div class="bg-white rounded-2xl border border-sky-100 shadow-sm p-5 space-y-3">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-sky-100 font-bold text-sky-700 text-xs">
                                        {{ $pengajuan->dospem_2_nama ? mb_strtoupper(mb_substr($pengajuan->dospem_2_nama, 0, 2)) : 'D2' }}
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-900">{{ $pengajuan->dospem_2_nama ?? 'Dosen Pembimbing 2' }}</p>
                                        <p class="text-[10px] text-slate-400">Dosen Pembimbing 2 (Pendamping)</p>
                                    </div>
                                </div>
                                <p class="text-xs text-slate-700 leading-relaxed pl-13">
                                    {{ $pengajuan->catatan_dospem_2 ?? 'Belum ada catatan atau evaluasi dari Dosen Pembimbing 2.' }}
                                </p>
                                <p class="text-[10px] text-slate-400 pl-13 pt-1">
                                    {{ \Illuminate\Support\Carbon::parse($pengajuan->updated_at)->format('d M Y • H:i') }}
                                </p>
                            </div>

                        </div>

                    </div>

                    <!-- KOLOM KANAN / SIDEBAR INFO -->
                    <div class="space-y-6">

                        <!-- CARD DOSEN PEMBIMBING -->
                        <div class="bg-white rounded-2xl border border-sky-100 shadow-sm p-6 space-y-4">
                            <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider pb-2 border-b border-slate-100">
                                Tim Pembimbing
                            </h3>
                            
                            <div class="space-y-3">
                                <div>
                                    <span class="text-[10px] uppercase text-slate-400 block">Pembimbing 1</span>
                                    <span class="text-xs font-bold text-slate-800">{{ $pengajuan->dospem_1_nama }}</span>
                                </div>
                                <div>
                                    <span class="text-[10px] uppercase text-slate-400 block">Pembimbing 2</span>
                                    <span class="text-xs font-bold text-slate-800">{{ $pengajuan->dospem_2_nama }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- CARD BERKAS PROPOSAL -->
                        <div class="bg-white rounded-2xl border border-sky-100 shadow-sm p-6 space-y-4">
                            <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider pb-2 border-b border-slate-100">
                                Berkas Proposal
                            </h3>

                            <div class="space-y-2">
                                <p class="text-xs font-medium text-slate-600 truncate" title="{{ Str::after(basename($pengajuan->file_proposal), '_') }}">
                                    📄 {{ Str::after(basename($pengajuan->file_proposal), '_') }}
                                </p>
                                <a href="{{ asset('storage/' . $pengajuan->file_proposal) }}" target="_blank" class="w-full py-2.5 bg-sky-600 hover:bg-sky-700 text-white text-xs font-semibold rounded-xl shadow-sm transition flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Buka File PDF
                                </a>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </main>

    </div>

</body>
</html>