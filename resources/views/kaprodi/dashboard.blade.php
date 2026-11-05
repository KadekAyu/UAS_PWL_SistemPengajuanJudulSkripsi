<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kaprodi - SISTA</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>
<body class="min-h-screen bg-[#E8F5FF] text-slate-800">
    <div class="min-h-screen md:flex">
        <aside class="flex w-full flex-col border-b border-sky-100 bg-white md:min-h-screen md:w-60 md:border-b-0 md:border-r">
            <div class="px-6 py-6">
                <p class="text-2xl font-black tracking-tight text-sky-600">SISTA</p>
                <p class="mt-1 text-[11px] tracking-wide text-slate-500">Panel Ketua Program Studi</p>
            </div>
            <nav class="flex gap-2 overflow-x-auto px-3 pb-4 md:flex-1 md:flex-col">
                <a href="{{ route('kaprodi.dashboard') }}" class="whitespace-nowrap rounded-lg bg-sky-50 px-4 py-3 text-sm font-semibold text-sky-700">
                    Dashboard
                </a>
                <a href="#antrean" class="whitespace-nowrap rounded-lg px-4 py-3 text-sm text-slate-500 transition hover:bg-sky-50 hover:text-sky-700">
                    Pengajuan Masuk
                </a>
                <a href="#riwayat" class="whitespace-nowrap rounded-lg px-4 py-3 text-sm text-slate-500 transition hover:bg-sky-50 hover:text-sky-700">
                    Riwayat Keputusan
                </a>
            </nav>
            <div class="border-t border-slate-100 p-4">
                <div class="mb-4 px-2">
                    <p class="truncate text-sm font-semibold text-slate-700">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-400">Ketua Program Studi</p>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="w-full rounded-lg px-3 py-2.5 text-left text-sm text-slate-500 transition hover:bg-slate-50 hover:text-slate-800">
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <main class="min-w-0 flex-1 p-5 md:p-8">
            <header class="mb-6">
                <p class="text-xs font-medium text-slate-500">Dashboard Kaprodi</p>
                <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900 md:text-3xl">Selamat datang, {{ auth()->user()->name }}</h1>
                <p class="mt-2 text-sm text-slate-500">Pantau pengajuan dan sahkan judul skripsi mahasiswa.</p>
            </header>

            @if (session('success'))
                <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <section class="mb-7 grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
                @foreach ([
                    ['label' => 'Total Pengajuan', 'value' => $statistics['total'], 'tone' => 'sky'],
                    ['label' => 'Menunggu Pengesahan', 'value' => $statistics['menunggu'], 'tone' => 'amber'],
                    ['label' => 'Sudah Disahkan', 'value' => $statistics['disahkan'], 'tone' => 'emerald'],
                    ['label' => 'Ditolak', 'value' => $statistics['ditolak'], 'tone' => 'rose'],
                ] as $card)
                    <article class="rounded-xl border border-slate-200 bg-white px-4 py-4">
                        <p class="text-xs text-slate-500">{{ $card['label'] }}</p>
                        <p class="mt-1.5 text-2xl font-bold text-slate-900">{{ $card['value'] }}</p>
                        <div class="mt-3 h-1 w-10 rounded-full {{ ['sky' => 'bg-sky-400', 'amber' => 'bg-amber-400', 'emerald' => 'bg-emerald-500', 'rose' => 'bg-rose-400'][$card['tone']] }}"></div>
                    </article>
                @endforeach
            </section>

            <section id="antrean" class="mb-7 overflow-hidden rounded-xl border border-slate-200 bg-white">
                <div class="flex flex-wrap items-center justify-between gap-3 px-5 py-4">
                    <div>
                        <h2 class="text-sm font-bold text-slate-900">Pengajuan Masuk</h2>
                        <p class="mt-1 text-xs text-slate-500">Tinjau dan tentukan dosen pembimbing final.</p>
                    </div>
                    <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-medium text-amber-700">
                        {{ $menungguPengesahan->count() }} menunggu
                    </span>
                </div>

                @if ($menungguPengesahan->isEmpty())
                    <div class="border-t border-slate-100 px-6 py-12 text-center">
                        <h3 class="text-sm font-semibold text-slate-700">Belum ada pengajuan untuk disahkan</h3>
                        <p class="mt-1 text-xs text-slate-500">Pengajuan akan tampil di sini setelah mendapat persetujuan dosen pembimbing.</p>
                    </div>
                @else
                    <div class="overflow-x-auto border-t border-slate-100">
                        <div class="min-w-[760px]">
                            <div class="grid grid-cols-[1.1fr_0.9fr_2fr_1fr_0.65fr] gap-4 bg-slate-50 px-6 py-3 text-[11px] font-semibold text-slate-500">
                                <span>Mahasiswa</span>
                                <span>NPM</span>
                                <span>Judul</span>
                                <span>Status</span>
                                <span>Aksi</span>
                            </div>
                            <div class="divide-y divide-slate-100">
                                @foreach ($menungguPengesahan as $pengajuan)
                                    <details class="group">
                                        <summary class="grid cursor-pointer list-none grid-cols-[1.1fr_0.9fr_2fr_1fr_0.65fr] items-center gap-4 px-6 py-3 text-xs hover:bg-sky-50/50 [&::-webkit-details-marker]:hidden">
                                            <span class="font-medium text-slate-700">{{ $pengajuan->nama_mahasiswa }}</span>
                                            <span class="text-slate-600">{{ $pengajuan->npm }}</span>
                                            <span class="truncate text-slate-700" title="{{ $pengajuan->judul }}">{{ $pengajuan->judul }}</span>
                                            <span>
                                                <span class="rounded-full bg-amber-50 px-2.5 py-1 text-[10px] font-medium text-amber-700">{{ $pengajuan->status }}</span>
                                            </span>
                                            <span class="inline-flex w-fit rounded-md bg-blue-500 px-3 py-1.5 text-[10px] font-semibold text-white group-open:bg-slate-600">
                                                <span class="group-open:hidden">Review</span>
                                                <span class="hidden group-open:inline">Tutup</span>
                                            </span>
                                        </summary>
                                        <div class="border-t border-slate-100 bg-slate-50/70 px-6 py-4">
                                            <div class="grid gap-4 lg:grid-cols-[1fr_auto]">
                                                <div>
                                                    <p class="text-xs text-slate-500">Diajukan {{ \Illuminate\Support\Carbon::parse($pengajuan->created_at)->format('d M Y') }}</p>
                                                    <h3 class="mt-1 font-semibold text-slate-900">{{ $pengajuan->judul }}</h3>
                                                    <p class="mt-2 max-w-4xl text-xs leading-5 text-slate-600">{{ \Illuminate\Support\Str::limit($pengajuan->abstrak, 500) }}</p>
                                                    <div class="mt-3 flex flex-wrap gap-2 text-xs">
                                                        <span class="rounded-md bg-white px-3 py-2 text-slate-600 ring-1 ring-slate-200">Opsi 1: {{ $pengajuan->nama_dospem_1 }}</span>
                                                        <span class="rounded-md bg-white px-3 py-2 text-slate-600 ring-1 ring-slate-200">Opsi 2: {{ $pengajuan->nama_dospem_2 }}</span>
                                                        <a href="{{ \Illuminate\Support\Facades\Storage::url($pengajuan->file_proposal) }}" target="_blank" rel="noopener" class="rounded-md px-3 py-2 font-semibold text-sky-700 hover:bg-sky-50">
                                                            Lihat Proposal PDF
                                                        </a>
                                                    </div>
                                                </div>
                                                <form action="{{ route('kaprodi.pengajuan.sahkan', $pengajuan->id) }}" method="POST" class="flex flex-col gap-3 rounded-lg bg-white p-3 ring-1 ring-slate-200 lg:min-w-64">
                                                    @csrf
                                                    <label class="text-xs font-semibold text-slate-600">
                                                        Dosen Pembimbing Final
                                                        <select name="dospem_final_id" required class="mt-2 w-full rounded-md border-slate-200 text-xs text-slate-700 focus:border-sky-400 focus:ring-sky-400">
                                                            <option value="">Pilih dosen pembimbing</option>
                                                            <option value="{{ $pengajuan->dospem_1_id }}">{{ $pengajuan->nama_dospem_1 }}</option>
                                                            <option value="{{ $pengajuan->dospem_2_id }}">{{ $pengajuan->nama_dospem_2 }}</option>
                                                        </select>
                                                    </label>
                                                    <button type="submit" onclick="return confirm('Sahkan judul ini dan terbitkan nomor SK?')" class="rounded-md bg-blue-500 px-4 py-2 text-xs font-semibold text-white transition hover:bg-blue-600">
                                                        Sahkan Judul
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </details>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </section>

            <section id="riwayat" class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
                <div class="border-b border-slate-100 px-5 py-5 md:px-6">
                    <h2 class="font-bold text-slate-900">Riwayat Keputusan</h2>
                    <p class="mt-1 text-sm text-slate-500">Pengajuan terbaru yang sudah disahkan atau ditolak.</p>
                </div>
                @if ($riwayat->isEmpty())
                    <p class="px-6 py-8 text-center text-sm text-slate-500">Belum ada riwayat keputusan.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[640px] text-left text-sm">
                            <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                                <tr>
                                    <th class="px-6 py-3 font-semibold">Mahasiswa</th>
                                    <th class="px-6 py-3 font-semibold">Judul</th>
                                    <th class="px-6 py-3 font-semibold">Status</th>
                                    <th class="px-6 py-3 font-semibold">Nomor SK</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach ($riwayat as $item)
                                    <tr>
                                        <td class="px-6 py-4">
                                            <p class="font-semibold text-slate-800">{{ $item->nama_mahasiswa }}</p>
                                            <p class="text-xs text-slate-500">{{ $item->npm }}</p>
                                        </td>
                                        <td class="max-w-md px-6 py-4 text-slate-600">{{ $item->judul }}</td>
                                        <td class="px-6 py-4">
                                            <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $item->status === 'ACC Final' ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' }}">
                                                {{ $item->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-slate-600">{{ $item->nomor_sk ?? '—' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </section>
        </main>
    </div>
</body>
</html>
