@php
    $user = auth()->user();
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pengajuan - SISTA</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>

<body class="min-h-screen bg-[#E8F5FF] text-slate-800">

    <div class="min-h-screen md:flex">

        <x-sidebar-mahasiswa />

        <!-- MAIN CONTENT -->
        <main class="min-w-0 flex-1">

            <!-- TOPBAR -->
            <x-topbar-mahasiswa>
                <div class="flex items-center gap-2 text-xs font-medium text-slate-600">

                    <!-- ICON HOME -->
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-4 w-4 text-slate-400"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.8">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="m3 10 9-7 9 7"/>
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M5 9v11h14V9"/>
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M9 20v-6h6v6"/>
                    </svg>

                    <span class="text-slate-400">Mahasiswa</span>

                    <!-- SEPARATOR -->
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-3 w-3 text-slate-400"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="m9 18 6-6-6-6"/>
                    </svg>

                    <span class="font-semibold text-slate-800">
                        Riwayat Pengajuan
                    </span>

                </div>
            </x-topbar-mahasiswa>

            <!-- PAGE CONTENT -->
            <div class="p-4 md:p-6">

                <!-- HEADER -->
                <header class="mb-5">

                    <h1 class="text-xl font-bold tracking-tight text-slate-800">
                        Riwayat Pengajuan
                    </h1>

                    <p class="mt-1 text-xs text-slate-500">
                        Daftar berkas dan pengajuan judul yang pernah dikirim.
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

                <!-- DAFTAR PENGAJUAN -->
                <section class="overflow-hidden rounded-xl border border-sky-100 bg-white shadow-sm">

                    <!-- CARD HEADER -->
                    <div class="flex items-center gap-3 border-b border-slate-100 px-4 py-3">

                        <div class="rounded-lg bg-sky-50 p-2">

                            <!-- ICON RIWAYAT -->
                            <svg class="h-5 w-5 text-sky-600"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M12 8v4l3 2m6-2a9 9 0 1 1-2.64-6.36"/>
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M21 3v6h-6"/>
                            </svg>

                        </div>

                        <div>
                            <h2 class="text-sm font-bold text-slate-900">
                                Daftar Pengajuan
                            </h2>

                        </div>

                    </div>

                    @if ($pengajuan->isEmpty())

                        <!-- EMPTY STATE -->
                        <div class="px-5 py-10 text-center">

                            <div class="mx-auto mb-3 flex h-11 w-11 items-center justify-center rounded-full bg-sky-50">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="h-5 w-5 text-sky-500"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="1.7">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M7 3.75h7l5 5V20a1 1 0 0 1-1 1H7a2 2 0 0 1-2-2V5.75a2 2 0 0 1 2-2Z"/>
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M14 3.75v5h5M9 13h6"/>
                                </svg>

                            </div>

                            <h3 class="text-xs font-semibold text-slate-700">
                                Belum Ada Pengajuan
                            </h3>

                            <p class="mt-1 text-xs text-slate-500">
                                Berkas dan judul yang Anda ajukan akan muncul di sini.
                            </p>

                        </div>

                    @else

                        <!-- TABLE -->
                        <div class="overflow-x-auto">

                            <table class="w-full min-w-[700px] text-left text-xs">

                                <thead class="bg-slate-50 text-[10px] uppercase tracking-wide text-slate-500">

                                    <tr>

                                        <th class="w-12 px-5 py-3 font-semibold">
                                            No
                                        </th>

                                        <th class="px-5 py-3 font-semibold">
                                            Judul Skripsi
                                        </th>

                                        <th class="w-32 px-5 py-3 font-semibold">
                                            Tanggal
                                        </th>

                                        <th class="w-36 px-5 py-3 font-semibold">
                                            Status
                                        </th>

                                        <th class="w-44 px-5 py-3 font-semibold">
                                            Berkas PDF
                                        </th>

                                        <th class="w-28 px-5 py-3 font-semibold">
                                            Aksi
                                        </th>

                                    </tr>

                                </thead>

                                <tbody class="divide-y divide-slate-100">

                                    @foreach ($pengajuan as $item)

                                        <tr class="transition hover:bg-sky-50/50">

                                            <!-- NOMOR -->
                                            <td class="px-5 py-3.5 text-slate-500">
                                                {{ $loop->iteration }}
                                            </td>

                                            <!-- JUDUL -->
                                            <td class="max-w-md px-5 py-3.5 font-medium leading-relaxed text-slate-700">
                                                {{ $item->judul }}
                                            </td>

                                            <!-- TANGGAL -->
                                            <td class="whitespace-nowrap px-5 py-3.5 text-slate-600">
                                                {{ \Illuminate\Support\Carbon::parse($item->created_at)->format('d M Y') }}
                                            </td>

                                            <!-- STATUS -->
                                            <td class="whitespace-nowrap px-5 py-3.5">

                                                <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-[10px] font-semibold {{
                                                    match($item->status) {
                                                        'ACC Final', 'Disahkan' => 'bg-emerald-50 text-emerald-700',
                                                        'Revisi' => 'bg-orange-50 text-orange-700',
                                                        'Ditolak' => 'bg-rose-50 text-rose-700',
                                                        'ACC Dospem', 'ACC Dosen' => 'bg-sky-50 text-sky-700',
                                                        default => 'bg-amber-50 text-amber-700',
                                                    }
                                                }}">

                                                    <span class="h-1.5 w-1.5 rounded-full {{
                                                        match($item->status) {
                                                            'ACC Final', 'Disahkan' => 'bg-emerald-500',
                                                            'Revisi' => 'bg-orange-500',
                                                            'Ditolak' => 'bg-rose-500',
                                                            'ACC Dospem', 'ACC Dosen' => 'bg-sky-500',
                                                            default => 'bg-amber-500',
                                                        }
                                                    }}"></span>

                                                    {{ $item->status }}

                                                </span>

                                            </td>

                                            <!-- BERKAS PDF -->
                                            <td class="max-w-[180px] px-5 py-3.5">

                                                <a href="{{ asset('storage/' . $item->file_proposal) }}"
                                                   target="_blank"
                                                   class="flex max-w-[180px] items-center gap-2 text-xs font-medium text-sky-600 transition hover:text-sky-700 hover:underline"
                                                   title="{{ basename($item->file_proposal) }}">

                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         class="h-4 w-4 shrink-0 text-rose-500"
                                                         fill="none"
                                                         viewBox="0 0 24 24"
                                                         stroke="currentColor"
                                                         stroke-width="1.8">
                                                        <path stroke-linecap="round"
                                                              stroke-linejoin="round"
                                                              d="M7 3.75h7l5 5V20a1 1 0 0 1-1 1H7a2 2 0 0 1-2-2V5.75a2 2 0 0 1 2-2Z"/>
                                                        <path stroke-linecap="round"
                                                              stroke-linejoin="round"
                                                              d="M14 3.75v5h5"/>
                                                    </svg>

                                                    <span class="truncate">
                                                        {{ Str::after(basename($item->file_proposal), '_') }}
                                                    </span>

                                                </a>

                                            </td>

                                            <!-- AKSI -->
                                            <td class="whitespace-nowrap px-5 py-3.5">

                                                <a href="{{ route('mahasiswa.pengajuan.show', $item->id) }}"
                                                   class="inline-flex items-center gap-1.5 rounded-lg border border-sky-200 bg-white px-3 py-1.5 text-[10px] font-semibold text-sky-600 transition hover:bg-sky-50">

                                                    Lihat Detail

                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         class="h-3 w-3"
                                                         fill="none"
                                                         viewBox="0 0 24 24"
                                                         stroke="currentColor"
                                                         stroke-width="2">
                                                        <path stroke-linecap="round"
                                                              stroke-linejoin="round"
                                                              d="m9 18 6-6-6-6"/>
                                                    </svg>

                                                </a>

                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                        <!-- TABLE FOOTER -->
                        <div class="border-t border-slate-100 bg-white px-5 py-3">

                            <p class="text-[10px] text-slate-400">
                                Menampilkan {{ $pengajuan->count() }} pengajuan.
                            </p>

                        </div>

                    @endif

                </section>

            </div>

        </main>

    </div>

</body>
</html>
