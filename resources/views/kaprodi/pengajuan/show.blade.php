@php

    // Menentukan tahap pengajuan.

    $status = strtolower(trim((string) $detail->status));

    $isMenungguPenunjukan = $status === 'menunggu';

    $isSedangDireview = $status === 'menunggu review dospem';

    $isSiapDisahkan = in_array($status, ['acc dospem', 'acc dosen'], true);

    $isAccFinal = $status === 'acc final';

    $isDataLama = $status === 'disetujui';

    $statusClass = match ($status) {

        'acc final' => 'bg-emerald-50 text-emerald-700',

        'acc dospem', 'acc dosen' => 'bg-sky-50 text-sky-700',

        'menunggu review dospem' => 'bg-indigo-50 text-indigo-700',

        'revisi' => 'bg-orange-50 text-orange-700',

        'ditolak' => 'bg-rose-50 text-rose-700',

        'disetujui' => 'bg-emerald-50 text-emerald-700',

        default => 'bg-amber-50 text-amber-700',

    };

    $statusDot = match ($status) {

        'acc final' => 'bg-emerald-500',

        'acc dospem', 'acc dosen' => 'bg-sky-500',

        'menunggu review dospem' => 'bg-indigo-500',

        'revisi' => 'bg-orange-500',

        'ditolak' => 'bg-rose-500',

        'disetujui' => 'bg-emerald-500',

        default => 'bg-amber-500',

    };

    $fileBasename = $detail->file_proposal

        ? basename($detail->file_proposal)

        : null;

    $displayFilename = $fileBasename

        ? \Illuminate\Support\Str::after($fileBasename, '_')

        : null;

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

    <!-- SIDEBAR KAPRODI -->

    <x-sidebar-kaprodi />

    <main class="main-content min-w-0 flex-1">

        <!-- TOPBAR KAPRODI -->

        <x-topbar-kaprodi>

            <span>Ketua Program Studi</span>

            <span class="text-slate-300">›</span>

            <a href="{{ route('kaprodi.pengajuan.index') }}"

               class="hover:text-sky-700">

                Pengajuan Masuk

            </a>

            <span class="text-slate-300">›</span>

            <span class="font-medium text-slate-700">

                Detail Pengajuan

            </span>

        </x-topbar-kaprodi>

        <div class="mx-auto max-w-6xl space-y-4 p-4 md:p-5">

            <!-- HEADER -->

            <header class="flex flex-wrap items-center justify-between gap-3">

                <div>

                    <h1 class="text-xl font-bold tracking-tight text-slate-800">

                        Detail Pengajuan

                    </h1>

                    <p class="mt-1 text-xs text-slate-500">

                        Tinjau pengajuan mahasiswa, tunjuk dosen pembimbing,

                        dan lakukan pengesahan setelah review dosen.

                    </p>

                </div>

            </header>

            <!-- NOTIFIKASI -->

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

                        <!-- JUDUL SKRIPSI -->

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

                    <!-- CALON DOSEN PEMBIMBING -->

                    <section class="rounded-xl border border-sky-100 bg-white p-4 shadow-sm">

                        <h3 class="mb-3 border-b border-slate-100 pb-2 text-xs font-bold text-slate-800">

                            Calon Dosen Pembimbing

                        </h3>

                        <div class="space-y-3">

                            <div>

                                <p class="mb-1 text-[10px] text-slate-400">

                                    Pilihan Mahasiswa 1

                                </p>

                                <p class="text-xs font-semibold text-slate-700">

                                    {{ $detail->nama_dospem_1 ?? '-' }}

                                </p>

                            </div>

                            <div class="border-t border-slate-100 pt-3">

                                <p class="mb-1 text-[10px] text-slate-400">

                                    Pilihan Mahasiswa 2

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

                               rel="noopener"

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

                    <!-- PROSES KAPRODI -->

                    <section class="rounded-xl border border-sky-100 bg-white p-4 shadow-sm">

                        <!-- TAHAP 1: PENUNJUKAN DOSPEM -->

                        @if ($isMenungguPenunjukan)

                            <h3 class="mb-3 border-b border-slate-100 pb-2 text-xs font-bold text-slate-800">

                                Penunjukan Dosen Pembimbing

                            </h3>

                            <p class="mb-3 text-xs leading-relaxed text-slate-500">

                                Pilih dosen yang akan memeriksa pengajuan judul mahasiswa.

                                Kaprodi dapat memilih dosen usulan mahasiswa atau dosen lainnya.

                            </p>

                            <form id="formTunjukDospem"

                                  action="{{ route('kaprodi.pengajuan.tunjuk-dospem', $detail->id) }}"

                                  method="POST">

                                @csrf

                                <label for="dospem_final_id"

                                       class="mb-2 block text-xs font-semibold text-slate-600">

                                    Dosen yang Ditunjuk

                                </label>

                                <select id="dospem_final_id"

                                        name="dospem_final_id"

                                        required

                                        class="mb-3 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-xs text-slate-700 focus:border-sky-400 focus:ring-sky-400">

                                    <option value="">

                                        Pilih dosen pembimbing

                                    </option>

                                    @foreach ($daftarDosen as $dosen)

                                        <option value="{{ $dosen->id }}"

                                            @selected(old('dospem_final_id') == $dosen->id)>

                                            {{ $dosen->name }}

                                            @if ($dosen->id == ($detail->dospem_1_id ?? null))

                                                (Pilihan Mahasiswa 1)

                                            @elseif ($dosen->id == ($detail->dospem_2_id ?? null))

                                                (Pilihan Mahasiswa 2)

                                            @endif

                                        </option>

                                    @endforeach

                                </select>

                                <button type="button"

                                         onclick="bukaModalTunjuk()"

                                         class="flex w-full items-center justify-center gap-2 rounded-lg bg-sky-600 px-3 py-2.5 text-xs font-semibold text-white shadow-sm transition hover:bg-sky-700">

                                    Tunjuk Dospem

                                </button>

                            </form>

                        <!-- TAHAP 2: MENUNGGU REVIEW DOSPEM -->

                        @elseif ($isSedangDireview)

                            <h3 class="mb-3 border-b border-slate-100 pb-2 text-xs font-bold text-slate-800">

                                Review Dosen Pembimbing

                            </h3>

                            <div class="rounded-lg border border-sky-200 bg-sky-50 p-3">

                                <p class="text-xs font-semibold text-sky-800">

                                    Menunggu Review Dospem

                                </p>

                                <p class="mt-2 text-[11px] leading-relaxed text-sky-700">

                                    Dosen telah ditunjuk oleh Kaprodi.

                                    Pengajuan sedang menunggu keputusan ACC,

                                    Revisi, atau Tolak dari dosen pembimbing.

                                </p>

                            </div>

                        <!-- TAHAP 3: PENGESAHAN AKHIR -->

                        @elseif ($isSiapDisahkan)

                            <h3 class="mb-3 border-b border-slate-100 pb-2 text-xs font-bold text-slate-800">

                                Pengesahan Judul

                            </h3>

                            <div class="mb-3 rounded-lg border border-emerald-200 bg-emerald-50 p-3">

                                <p class="text-xs font-semibold text-emerald-800">

                                    Review Dospem: ACC

                                </p>

                                <p class="mt-1 text-[11px] leading-relaxed text-emerald-700">

                                    Pengajuan telah mendapatkan ACC dari dosen pembimbing

                                    dan dapat diproses untuk pengesahan akhir.

                                </p>

                            </div>

                            <form id="formSahkanJudul" action="{{ route('kaprodi.pengajuan.sahkan', $detail->id) }}"

                                  method="POST">

                                @csrf

                                <button type="button"
                                        onclick="document.getElementById('modalSahkanJudul').showModal()"

                                        class="flex w-full items-center justify-center gap-2 rounded-lg bg-sky-600 px-3 py-2.5 text-xs font-semibold text-white shadow-sm transition hover:bg-sky-700">

                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">

                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>

                                    </svg>

                                    Sahkan Judul

                                </button>

                            </form>

                        <!-- TAHAP 4: SUDAH DISAHKAN -->

                        @elseif ($isAccFinal)

                            <h3 class="mb-3 border-b border-slate-100 pb-2 text-xs font-bold text-slate-800">

                                Pengesahan Judul

                            </h3>

                            <div class="rounded-lg border border-emerald-200 bg-emerald-50 p-3 text-xs text-emerald-800">

                                <p class="font-bold">

                                    Judul Telah Disahkan

                                </p>

                                <p class="mt-1 text-[11px] text-emerald-700">

                                    Nomor SK:

                                    <span class="font-semibold">

                                        {{ $detail->nomor_sk ?? '-' }}

                                    </span>

                                </p>

                                @if ($detail->tanggal_disetujui)

                                    <p class="mt-1 text-[11px] text-emerald-700">

                                        Tanggal Pengesahan:

                                        {{ \Illuminate\Support\Carbon::parse($detail->tanggal_disetujui)->format('d M Y') }}

                                    </p>

                                @endif

                            </div>

                        <!-- PENGAJUAN LAMA -->

                        @elseif ($isDataLama)

                            <h3 class="mb-3 border-b border-slate-100 pb-2 text-xs font-bold text-slate-800">

                                Pengajuan Lama

                            </h3>

                            @if ($detail->dospem_final_id)

                                <div class="mb-3 rounded-lg border border-emerald-200 bg-emerald-50 p-3">

                                    <p class="text-xs font-semibold text-emerald-800">

                                        Dosen final: {{ $detail->nama_dospem_final }}

                                    </p>

                                    <p class="mt-1 text-[11px] leading-relaxed text-emerald-700">

                                        Pengajuan berstatus disetujui dan siap untuk pengesahan akhir.

                                    </p>

                                </div>

                                <form id="formSahkanJudul" action="{{ route('kaprodi.pengajuan.sahkan', $detail->id) }}"
                                      method="POST">
                                    @csrf
                                    <button type="button"
                                            onclick="document.getElementById('modalSahkanJudul').showModal()"
                                            class="flex w-full items-center justify-center gap-2 rounded-lg bg-sky-600 px-3 py-2.5 text-xs font-semibold text-white shadow-sm transition hover:bg-sky-700">
                                        Sahkan Judul
                                    </button>
                                </form>

                            @else

                                <div class="mb-3 rounded-lg border border-amber-200 bg-amber-50 p-3">
                                    <p class="text-xs font-semibold text-amber-800">
                                        Dosen final belum ditunjuk
                                    </p>
                                    <p class="mt-1 text-[11px] leading-relaxed text-amber-700">
                                        Pilih dosen final terlebih dahulu sebelum melakukan pengesahan.
                                    </p>
                                </div>

                                <form id="formTunjukDospem"
                                      action="{{ route('kaprodi.pengajuan.tunjuk-dospem', $detail->id) }}"
                                      method="POST">
                                    @csrf
                                    <label for="dospem_final_id"
                                           class="mb-2 block text-xs font-semibold text-slate-600">
                                        Dosen Final
                                    </label>
                                    <select id="dospem_final_id"
                                            name="dospem_final_id"
                                            required
                                            class="mb-3 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-xs text-slate-700 focus:border-sky-400 focus:ring-sky-400">
                                        <option value="">Pilih dosen final</option>
                                        @foreach ($daftarDosen as $dosen)
                                            <option value="{{ $dosen->id }}"
                                                @selected(old('dospem_final_id') == $dosen->id)>
                                                {{ $dosen->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="button"
                                            onclick="bukaModalTunjuk()"
                                            class="flex w-full items-center justify-center gap-2 rounded-lg bg-sky-600 px-3 py-2.5 text-xs font-semibold text-white shadow-sm transition hover:bg-sky-700">
                                        Tunjuk Dosen Final
                                    </button>
                                </form>

                            @endif

                        <!-- STATUS LAIN -->

                        @else

                            <h3 class="mb-3 border-b border-slate-100 pb-2 text-xs font-bold text-slate-800">

                                Status Pengajuan

                            </h3>

                            <div class="rounded-lg bg-slate-50 px-3 py-4 text-center">

                                <p class="text-xs leading-relaxed text-slate-500">

                                    Pengajuan ini belum dapat diproses untuk pengesahan.

                                    Silakan periksa status dan catatan review dosen.

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

<!-- MODAL KONFIRMASI PENUNJUKAN DOSPEM -->

<dialog id="modalTunjukDospem"

        aria-labelledby="judulModalTunjuk"

        class="m-auto w-[calc(100%-2rem)] max-w-md rounded-2xl border-0 bg-white p-0 shadow-2xl backdrop:bg-slate-900/50">

    <div class="p-6 text-center">

        <!-- IKON -->

        <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-sky-100 text-sky-600">

            <svg class="h-7 w-7" fill="none" stroke="currentColor"

                 stroke-width="1.8" viewBox="0 0 24 24">

                <path stroke-linecap="round" stroke-linejoin="round"

                      d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2M12 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM19 8v6m-3-3h6"/>

            </svg>

        </div>

         <!-- JUDUL -->

        <h2 id="judulModalTunjuk"

            class="text-lg font-bold text-slate-900">

            Konfirmasi Penunjukan Dosen

        </h2>

        <!-- PESAN -->

        <p class="mt-3 text-sm leading-6 text-slate-500">

            Apakah Anda yakin ingin menunjuk

            <span id="namaDosenModal"

                  class="font-bold text-sky-700"></span>

            untuk memeriksa pengajuan judul mahasiswa?

        </p>

         <!-- TOMBOL AKSI -->

        <div class="mt-6 flex gap-3">

            <button type="button"

                    onclick="document.getElementById('modalTunjukDospem').close()"

                    class="flex-1 rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">

                Batal

            </button>

            <button type="button"

                    onclick="konfirmasiTunjuk()"

                    class="flex-1 rounded-lg bg-sky-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-sky-700">

                Ya, Tunjuk Dosen

            </button>

            </div>

    </div>

</dialog>

<script>

    function bukaModalTunjuk() {

        const form = document.getElementById('formTunjukDospem');

        const select = document.getElementById('dospem_final_id');

        // Wajib memilih dosen sebelum melanjutkan.

        if (!form.reportValidity()) {

            return;

        }

        const namaDosen = select.options[select.selectedIndex].text.trim();

        document.getElementById('namaDosenModal').textContent = namaDosen;

        document.getElementById('modalTunjukDospem').showModal();

    }

    function konfirmasiTunjuk() {

        const form = document.getElementById('formTunjukDospem');

        if (!form.reportValidity()) {

            return;

        }

        document.getElementById('modalTunjukDospem').close();

        // Kirim pengajuan setelah pengguna mengonfirmasi.

        form.requestSubmit();

    }

</script>


<!-- MODAL KONFIRMASI PENGESAHAN JUDUL -->
<dialog id="modalSahkanJudul"
        aria-labelledby="judulModalSahkan"
        class="m-auto w-[calc(100%-2rem)] max-w-md rounded-2xl border-0 bg-white p-0 shadow-2xl backdrop:bg-slate-900/50">
    <div class="p-6 text-center">
        <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-emerald-100 text-emerald-600">
            <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.8"
                 stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <path d="M9 12l2 2 4-4" />
                <circle cx="12" cy="12" r="9" />
            </svg>
        </div>

        <h2 id="judulModalSahkan" class="text-lg font-bold text-slate-900">
            Konfirmasi Pengesahan Judul
        </h2>
        <p class="mt-3 text-sm leading-6 text-slate-500">
            Apakah Anda yakin ingin mengesahkan judul skripsi
            <span class="font-bold text-sky-700">{{ $detail->nama_mahasiswa }}</span>
            dan menerbitkan nomor SK?
        </p>
        <div class="mt-6 flex gap-3">
            <button type="button"
                    onclick="document.getElementById('modalSahkanJudul').close()"
                    class="flex-1 rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                Batal
            </button>
            <button type="button"
                    onclick="konfirmasiSahkan(this)"
                    class="flex-1 rounded-lg bg-sky-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-sky-700">
                Ya, Sahkan Judul
            </button>
        </div>
    </div>
</dialog>
<script>
    function konfirmasiSahkan(button) {
        const form = document.getElementById('formSahkanJudul');
        if (!form || !form.reportValidity()) return;
        button.disabled = true;
        button.textContent = 'Memproses...';
        document.getElementById('modalSahkanJudul').close();
        form.requestSubmit();
    }
</script>

</body>

</html>