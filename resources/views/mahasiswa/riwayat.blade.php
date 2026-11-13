@php
    $user = auth()->user();
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pengajuan - SISTA</title>

    <!-- Menggunakan CDN Tailwind langsung agar rapi dan aman -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-[#E8F5FF] text-slate-800">

    <div class="min-h-screen md:flex">

        <x-sidebar-mahasiswa />

        <!-- MAIN CONTENT -->
        <main class="min-w-0 flex-1">

            <x-topbar-mahasiswa>
                <span>Mahasiswa</span>
                <span class="text-slate-300">›</span>
                <span class="font-semibold text-slate-800">Riwayat Pengajuan</span>
            </x-topbar-mahasiswa>

            <!-- PAGE CONTENT -->
            <div class="p-8">

                <header class="mb-6">
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                        Riwayat pengajuan
                    </h1>

                    <p class="mt-1 text-xs text-slate-500">
                        Daftar berkas dan pengajuan judul yang pernah dikirim.
                    </p>
                </header>

                <!-- TABEL RIWAYAT / DAFTAR PENGAJUAN -->
                <section class="overflow-hidden rounded-2xl border border-sky-100 bg-white shadow-sm">

                    <div class="border-b border-slate-100 px-6 py-4">
                        <h2 class="text-sm font-bold text-slate-900">
                            Daftar pengajuan
                        </h2>
                    </div>

                    @if ($pengajuan->isEmpty())
                        <div class="px-6 py-10 text-center">
                            <p class="text-xs font-semibold text-slate-700">Belum Ada Pengajuan</p>
                            <p class="mt-1 text-xs text-slate-400">Berkas dan judul yang Anda ajukan akan muncul di sini.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs whitespace-nowrap">
                                <thead class="bg-slate-50/75 text-[10px] uppercase tracking-wider text-slate-400 border-b border-slate-100">
                                    <tr>
                                        <th class="px-6 py-3.5 font-semibold text-left">Judul</th>
                                        <th class="px-6 py-3.5 font-semibold text-left">Tanggal</th>
                                        <th class="px-6 py-3.5 font-semibold text-left">Status</th>
                                        <th class="px-6 py-3.5 font-semibold text-left">Berkas PDF</th>
                                        <th class="px-6 py-3.5 font-semibold text-left">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-slate-100">
                                    @foreach ($pengajuan as $item)
                                        <tr class="hover:bg-slate-50/50 transition">
                                            
                                            <!-- JUDUL -->
                                            <td class="px-6 py-4 font-medium text-slate-800 max-w-xs md:max-w-md whitespace-normal leading-relaxed text-left">
                                                {{ $item->judul }}
                                            </td>

                                            <!-- TANGGAL -->
                                            <td class="px-6 py-4 text-slate-500 text-left">
                                                {{ \Illuminate\Support\Carbon::parse($item->created_at)->format('d M Y') }}
                                            </td>

                                            <!-- STATUS -->
                                            <td class="px-6 py-4 text-left">
                                                <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-[11px] font-medium {{
                                                    match($item->status) {
                                                        'ACC Final', 'Disahkan' => 'bg-emerald-50 text-emerald-700',
                                                        'Revisi' => 'bg-amber-50 text-amber-700',
                                                        'Ditolak' => 'bg-rose-50 text-rose-700',
                                                        default => 'bg-sky-50 text-sky-700',
                                                    }
                                                }}">
                                                    <span class="h-1.5 w-1.5 rounded-full {{
                                                        match($item->status) {
                                                            'ACC Final', 'Disahkan' => 'bg-emerald-500',
                                                            'Revisi' => 'bg-amber-500',
                                                            'Ditolak' => 'bg-rose-500',
                                                            default => 'bg-sky-500',
                                                        }
                                                    }}"></span>
                                                    {{ ucfirst($item->status) }}
                                                </span>
                                            </td>

                                            <!-- BERKAS PDF -->
                                            <td class="px-6 py-4 text-sky-600 font-medium max-w-[200px] truncate text-left">
                                                <a href="{{ asset('storage/' . $item->file_proposal) }}" target="_blank" class="hover:underline block truncate" title="{{ Str::after(basename($item->file_proposal), '_') }}">
                                                    {{ Str::after(basename($item->file_proposal), '_') }}
                                                </a>
                                            </td>

                                            <!-- AKSI (Rata Kiri) -->
                                            <td class="px-6 py-4 text-left">
                                                <a href="{{ route('mahasiswa.pengajuan.show', $item->id) }}" class="text-sky-600 hover:text-sky-700 font-semibold inline-block">
                                                    Lihat Detail
                                                </a>
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