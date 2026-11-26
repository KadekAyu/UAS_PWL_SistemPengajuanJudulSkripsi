@php
    $user = auth()->user();

    $namaDospem1 = $pengajuan->dospem_1_nama
        ?? $pengajuan->nama_dospem_1
        ?? optional($daftarDosen->firstWhere('id', $pengajuan->dospem_1_id))->name
        ?? '-';

    $namaDospem2 = $pengajuan->dospem_2_nama
        ?? $pengajuan->nama_dospem_2
        ?? optional($daftarDosen->firstWhere('id', $pengajuan->dospem_2_id))->name
        ?? '-';
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revisi Pengajuan - SISTA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-[#E8F5FF] text-slate-800">

    <div class="min-h-screen md:flex">

        <!-- SIDEBAR -->
        <x-sidebar-mahasiswa />

        <!-- MAIN CONTENT -->
        <div class="min-w-0 flex-1 flex flex-col">

            <!-- TOPBAR -->
            <x-topbar-mahasiswa>
                <span>Mahasiswa</span>
                <span class="text-slate-300">›</span>
                <a href="{{ route('mahasiswa.riwayat') }}" class="hover:underline">
                    Riwayat Pengajuan
                </a>
                <span class="text-slate-300">›</span>
                <span class="font-semibold text-slate-800">
                    Revisi Pengajuan
                </span>
            </x-topbar-mahasiswa>

            <!-- PAGE CONTENT -->
            <main class="flex-1 p-6 md:p-8 max-w-4xl mx-auto space-y-6 w-full">

                <!-- HEADER -->
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Form Revisi Pengajuan Judul
                    </h1>
                    <p class="mt-1 text-xs text-slate-500">
                        Perbarui informasi judul, abstrak, dan berkas proposal skripsi sesuai catatan revisi.
                    </p>
                </div>

                <!-- SUCCESS MESSAGE -->
                @if (session('success'))
                    <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-xs text-emerald-700">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- ERROR MESSAGE -->
                @if ($errors->any())
                    <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-xs text-red-700">
                        <p class="font-bold mb-1">Pengajuan belum dapat diperbarui:</p>
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- FORM REVISI -->
                <form
                    action="{{ route('mahasiswa.pengajuan.update', $pengajuan->id) }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="bg-white rounded-2xl border border-sky-100 shadow-sm p-6 space-y-5"
                >
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="dospem_1_id" value="{{ $pengajuan->dospem_1_id }}">
                    <input type="hidden" name="dospem_2_id" value="{{ $pengajuan->dospem_2_id }}">

                    <!-- JUDUL -->
                    <div>
                        <label for="judul" class="block text-xs font-bold uppercase text-slate-600 mb-1.5">
                            Judul Skripsi
                            <span class="text-rose-500">*</span>
                        </label>

                        <input
                            type="text"
                            id="judul"
                            name="judul"
                            value="{{ old('judul', $pengajuan->judul) }}"
                            required
                            placeholder="Masukkan judul skripsi"
                            class="w-full rounded-xl border border-sky-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500"
                        >

                        @error('judul')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- ABSTRAK -->
                    <div>
                        <label for="abstrak" class="block text-xs font-bold uppercase text-slate-600 mb-1.5">
                            Abstrak Penelitian
                            <span class="text-rose-500">*</span>
                        </label>

                        <textarea
                            id="abstrak"
                            name="abstrak"
                            rows="5"
                            required
                            placeholder="Jelaskan latar belakang, tujuan, dan gambaran singkat penelitian..."
                            class="w-full rounded-xl border border-sky-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500"
                        >{{ old('abstrak', $pengajuan->abstrak) }}</textarea>

                        @error('abstrak')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- DOSEN PEMBIMBING (TERKUNCI DARI PENGAJUAN AWAL) -->
                    <div class="border-t border-slate-100 pt-5 space-y-4">

                        <div>
                            <h3 class="text-sm font-bold text-slate-800">
                                Dosen Pembimbing
                            </h3>
                            <p class="mt-1 text-xs text-slate-500">
                                Dosen pembimbing mengikuti pengajuan awal dan tidak diubah saat revisi.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <!-- DOSPEM 1 -->
                            <div class="rounded-xl border border-sky-100 bg-sky-50/50 p-3.5">
                                <p class="text-[11px] font-bold text-slate-500 mb-1">
                                    Dosen Pembimbing 1
                                </p>
                                <p class="text-sm font-semibold text-slate-800">
                                    {{ $namaDospem1 }}
                                </p>
                            </div>

                            <!-- DOSPEM 2 -->
                            <div class="rounded-xl border border-sky-100 bg-sky-50/50 p-3.5">
                                <p class="text-[11px] font-bold text-slate-500 mb-1">
                                    Dosen Pembimbing 2
                                </p>
                                <p class="text-sm font-semibold text-slate-800">
                                    {{ $namaDospem2 }}
                                </p>
                            </div>

                        </div>
                    </div>

                    <!-- UPLOAD PROPOSAL -->
                    <div class="p-4 bg-sky-50/50 rounded-2xl border border-sky-100 space-y-3">

                        <div>
                            <label for="file_proposal" class="block text-xs font-bold uppercase text-slate-600">
                                Berkas Proposal PDF Baru (Opsional)
                            </label>

                            <p class="mt-1 text-[11px] text-slate-500">
                                Unggah proposal PDF baru jika ingin memperbarui berkas sebelumnya.
                            </p>
                        </div>

                        <!-- FILE LAMA -->
                        @if ($pengajuan->file_proposal)
                            <div class="flex items-center gap-3 bg-white p-3 rounded-xl border border-sky-200">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-rose-50 text-rose-600 font-bold text-xs">
                                    PDF
                                </div>

                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-semibold text-slate-700 truncate">
                                        {{ basename($pengajuan->file_proposal) }}
                                    </p>
                                    <a
                                        href="{{ asset('storage/' . $pengajuan->file_proposal) }}"
                                        target="_blank"
                                        class="text-[11px] text-sky-600 hover:underline"
                                    >
                                        Lihat proposal sebelumnya
                                    </a>
                                </div>
                            </div>
                        @endif

                        <!-- INPUT FILE BARU -->
                        <div class="flex items-center gap-3 bg-white p-3 rounded-xl border border-sky-200">

                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-sky-100 text-sky-600 font-bold text-xs">
                                PDF
                            </div>

                            <div class="flex-1 min-w-0">
                                <input
                                    type="file"
                                    id="file_proposal"
                                    name="file_proposal"
                                    accept=".pdf,application/pdf"
                                    class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100"
                                >
                                <p id="file-name" class="mt-1 text-[10px] text-slate-400">
                                    Format PDF • Maksimal 5 MB
                                </p>
                            </div>

                        </div>

                        @error('file_proposal')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror

                        <p class="text-[10px] text-slate-400">
                            Biarkan kosong jika tidak ingin mengganti file PDF yang lama.
                        </p>
                    </div>

                    <!-- BUTTONS -->
                    <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-4 border-t border-slate-100">

                        <a
                            href="{{ route('mahasiswa.pengajuan.show', $pengajuan->id) }}"
                            class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl text-center transition"
                        >
                            Batal
                        </a>

                        <button
                            type="submit"
                            id="submit-button"
                            class="px-5 py-2.5 bg-sky-600 hover:bg-sky-700 text-white text-xs font-semibold rounded-xl shadow-sm transition"
                        >
                            Simpan & Kirim Revisi
                        </button>

                    </div>

                </form>

            </main>

        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script>
        const fileInput = document.getElementById('file_proposal');
        const fileName = document.getElementById('file-name');

        if (fileInput) {
            fileInput.addEventListener('change', function () {
                const file = this.files[0];

                if (!file) {
                    fileName.textContent = 'Format PDF • Maksimal 5 MB';
                    return;
                }

                fileName.textContent = file.name + ' (' +
                    (file.size / 1024 / 1024).toFixed(2) + ' MB)';
            });
        }
    </script>

</body>
</html>