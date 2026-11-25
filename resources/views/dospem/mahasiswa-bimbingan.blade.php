@php
    $user = auth()->user();
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mahasiswa Bimbingan - SISTA</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>

<body class="min-h-screen bg-[#E8F5FF] text-slate-800">

    <div class="min-h-screen md:flex">

        <x-sidebar-dospem />

        <main class="min-w-0 flex-1">

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

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-3 w-3 text-slate-400"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6"/>
                    </svg>

                    <span class="font-semibold text-slate-800">
                        Mahasiswa Bimbingan
                    </span>
                </div>
            </x-topbar-dospem>

            <div class="p-4 md:p-6">

                <!-- HEADER -->
                <header class="mb-5">
                    <h1 class="text-xl font-bold tracking-tight text-slate-800">
                        Mahasiswa Bimbingan
                    </h1>

                    <p class="mt-1 text-xs text-slate-500">
                        Daftar mahasiswa yang telah ditetapkan sebagai bimbingan Anda.
                    </p>
                </header>

                <!-- STATISTIK -->
                <section class="mb-5">
                    <article class="flex w-full items-center justify-between rounded-xl border border-sky-100 bg-white px-5 py-4 shadow-sm sm:w-72">

                        <div class="flex items-center gap-3">
                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-sky-50 text-sky-600">
                                <svg class="h-5 w-5"
                                     viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                    <circle cx="10" cy="7" r="4"/>
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M20 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                                </svg>
                            </div>

                            <div>
                                <p class="text-xs font-medium text-slate-500">
                                    Total Mahasiswa
                                </p>
                                <p class="mt-0.5 text-[11px] text-slate-400">
                                    Seluruh mahasiswa bimbingan
                                </p>
                            </div>
                        </div>

                        <p class="ml-3 text-2xl font-bold tabular-nums text-slate-800">
                            {{ $mahasiswaBimbingan->count() }}
                        </p>
                    </article>
                </section>

                <!-- DAFTAR MAHASISWA -->
                <section class="w-full overflow-hidden rounded-xl border border-sky-100 bg-white shadow-sm">

                    <!-- HEADER TABEL -->
                    <div class="flex flex-col justify-between gap-3 border-b border-slate-100 px-5 py-4 sm:flex-row sm:items-center">

                        <h2 class="text-sm font-bold text-slate-900">
                            Daftar Mahasiswa
                        </h2>

                        <!-- PENCARIAN -->
                        <div class="relative w-full sm:w-72">
                            <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.8">
                                <circle cx="11" cy="11" r="7"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16 16 4 4"/>
                            </svg>

                            <input
                                type="text"
                                id="searchMahasiswa"
                                placeholder="Cari nama atau NPM..."
                                class="w-full rounded-lg border border-slate-200 py-2.5 pl-9 pr-3 text-xs outline-none transition focus:border-sky-400 focus:ring-2 focus:ring-sky-100"
                            >
                        </div>
                    </div>

                    <!-- TABEL -->
                    <div class="w-full overflow-x-auto">

                        <table class="w-full table-fixed border-separate border-spacing-0 text-left text-[11px]">

                            <colgroup>
                                <col style="width: 10%">
                                <col style="width: 15%">
                                <col style="width: 15%">
                                <col style="width: 14%">
                                <col style="width: 13%">
                                <col style="width: 15%">
                                <col style="width: 10%">
                            </colgroup>

                            <thead class="bg-slate-50 text-[10px] uppercase tracking-wide text-slate-500">
                                <tr>
                                    <th class="py-3 pl-6 pr-2 font-semibold">No.</th>
                                    <th class="px-3 py-3 font-semibold">Mahasiswa</th>
                                    <th class="px-3 py-3 font-semibold">Judul Skripsi</th>
                                    <th class="px-3 py-3 font-semibold">Posisi Anda</th>
                                    <th class="px-3 py-3 font-semibold">Nomor SK</th>
                                    <th class="px-3 py-3 font-semibold">Tgl. Pengesahan</th>
                                    <th class="px-3 py-3 text-center font-semibold">Status</th>
                                </tr>
                            </thead>

                            <tbody id="tabelMahasiswa" class="divide-y divide-slate-100">

                                @forelse ($mahasiswaBimbingan as $index => $mahasiswa)

                                    @php
                                        $status = $mahasiswa->status ?? '-';

                                        if ($status === 'ACC Final') {
                                            $statusClass = 'bg-emerald-50 text-emerald-700';
                                        } elseif (stripos($status, 'revisi') !== false) {
                                            $statusClass = 'bg-amber-50 text-amber-700';
                                        } elseif (stripos($status, 'tolak') !== false) {
                                            $statusClass = 'bg-red-50 text-red-700';
                                        } else {
                                            $statusClass = 'bg-sky-50 text-sky-700';
                                        }
                                    @endphp

                                    <tr class="baris-mahasiswa h-[64px] transition hover:bg-sky-50/50">

                                        <td class="py-2 pl-6 pr-2 align-middle text-slate-500">

                                            {{ $index + 1 }}
                                        </td>

                                        <td class="px-3 py-2 align-middle">
                                            <div class="flex h-11 flex-col justify-center overflow-hidden">
                                                <p class="truncate font-semibold text-slate-700"
                                                   title="{{ $mahasiswa->nama_mahasiswa }}">
                                                    {{ $mahasiswa->nama_mahasiswa }}
                                                </p>

                                                <p class="mt-1 truncate text-[10px] text-slate-400">
                                                    NPM: {{ $mahasiswa->npm_mahasiswa ?? '-' }}
                                                </p>
                                            </div>
                                        </td>

                                        <td class="px-3 py-2 align-middle text-slate-600">
                                            <p class="line-clamp-2 leading-4"
                                               title="{{ $mahasiswa->judul }}">
                                                {{ $mahasiswa->judul ?? '-' }}
                                            </p>
                                        </td>

                                        <td class="px-3 py-2 align-middle">
                                            <span class="inline-flex whitespace-nowrap rounded-full bg-sky-50 px-2.5 py-1 text-[9px] font-semibold text-sky-700">
                                                {{ $mahasiswa->posisi_dospem }}
                                            </span>
                                        </td>

                                        <td class="px-3 py-2 align-middle text-slate-600">
                                            <p class="line-clamp-2 break-words leading-4">
                                                {{ $mahasiswa->nomor_sk ?? '-' }}
                                            </p>
                                        </td>

                                        <td class="px-3 py-2 align-middle whitespace-nowrap text-slate-600">
                                            {{ $mahasiswa->tanggal_disetujui
                                                ? \Carbon\Carbon::parse($mahasiswa->tanggal_disetujui)->format('d M Y')
                                                : '-' }}
                                        </td>

                                        <td class="px-3 py-2 text-center align-middle">
                                            <span class="inline-flex max-w-full justify-center rounded-full px-2 py-1 text-[9px] font-semibold {{ $statusClass }}">
                                                {{ $status }}
                                            </span>
                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="7" class="px-4 py-14 text-center">

                                            <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-sky-50 text-sky-500">
                                                <svg class="h-5 w-5"
                                                     viewBox="0 0 24 24"
                                                     fill="none"
                                                     stroke="currentColor"
                                                     stroke-width="1.7">
                                                    <circle cx="10" cy="8" r="4"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M3 21a7 7 0 0 1 14 0M19 8v6m3-3h-6"/>
                                                </svg>
                                            </div>

                                            <h3 class="text-xs font-semibold text-slate-700">
                                                Belum Ada Mahasiswa Bimbingan
                                            </h3>
                                        </td>
                                    </tr>

                                @endforelse

                                @if ($mahasiswaBimbingan->count() > 0)
                                    <tr id="hasilTidakDitemukan" class="hidden">
                                        <td colspan="7" class="px-4 py-12 text-center text-xs text-slate-400">
                                            Mahasiswa tidak ditemukan.
                                        </td>
                                    </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>

                    <!-- FOOTER -->
                    @if ($mahasiswaBimbingan->count() > 0)
                        <div class="border-t border-slate-100 px-5 py-3">
                            <p class="text-[11px] text-slate-500">
                                Menampilkan {{ $mahasiswaBimbingan->count() }} mahasiswa bimbingan.
                            </p>
                        </div>
                    @endif

                </section>

            </div>
        </main>
    </div>

    <!-- SEARCH SCRIPT -->
    <script>
        const searchInput = document.getElementById('searchMahasiswa');
        const rows = document.querySelectorAll('.baris-mahasiswa');
        const noResult = document.getElementById('hasilTidakDitemukan');

        if (searchInput) {
            searchInput.addEventListener('input', function () {
                const keyword = this.value.toLowerCase().trim();
                let jumlahTampil = 0;

                rows.forEach(function (row) {
                    const cocok = row.textContent.toLowerCase().includes(keyword);

                    row.classList.toggle('hidden', !cocok);

                    if (cocok) {
                        jumlahTampil++;
                    }
                });

                if (noResult) {
                    noResult.classList.toggle('hidden', jumlahTampil > 0);
                }
            });
        }
    </script>

</body>
</html>