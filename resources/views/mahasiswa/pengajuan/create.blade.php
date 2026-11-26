@php
    $user = auth()->user();
    $terkunci = $hasUnrejectedSubmission ?? false;
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Judul - SISTA</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        * {
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            min-height: 100%;
            margin: 0;
            overflow-x: hidden;
            overflow-y: auto;
        }

        .form-actions {
            margin-top: 20px !important;
            transform: translateY(4px);
        }

        .page-layout {
            min-height: 100vh;
        }

        .main-content {
            min-height: 0;
        }

        .page-content {
            min-height: 0;
            overflow-y: auto;
        }

        @media (max-width: 767px) {
            .page-content {
                padding-left: 12px;
                padding-right: 12px;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }
        }
    </style>
</head>

<body class="min-h-screen overflow-x-hidden bg-[#E8F5FF] text-slate-800">

    <div class="page-layout flex min-h-screen">

        <x-sidebar-mahasiswa />

        <main class="main-content flex min-w-0 flex-1 flex-col">

            <x-topbar-mahasiswa>
                <div class="flex items-center gap-2 text-xs font-medium text-slate-600">
                    <svg class="h-4 w-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="m3 10 9-7 9 7"/>
                        <path d="M5 9v11h14V9"/>
                        <path d="M9 20v-6h6v6"/>
                    </svg>

                    <span class="text-slate-400">Mahasiswa</span>

                    <svg class="h-3 w-3 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="m9 18 6-6-6-6"/>
                    </svg>

                    <span class="font-semibold text-slate-800">Pengajuan Judul</span>
                </div>
            </x-topbar-mahasiswa>

            <div class="page-content min-h-0 flex-1 overflow-y-auto px-6 pt-5 pb-6">

                <!-- HEADER -->
                <header class="mb-4">
                    <h1 class="text-xl font-bold tracking-tight text-slate-800">
                        Pengajuan Judul
                    </h1>

                    <p class="mt-1 text-xs text-slate-500">
                        Lengkapi informasi judul dan unggah proposal skripsi untuk dikirim.
                    </p>
                </header>

                @if ($terkunci)
                    <div class="mb-3 flex items-center justify-between gap-3 rounded-lg border border-amber-200 bg-amber-50 px-4 py-2.5 text-xs text-amber-800">
                        <div>
                            Kamu masih memiliki pengajuan judul yang sedang berjalan. Pengajuan judul baru hanya bisa dilakukan jika pengajuan sebelumnya berstatus ditolak.
                        </div>
                        <a
                            href="{{ route('mahasiswa.riwayat') }}"
                            class="shrink-0 rounded-lg border border-amber-300 bg-white px-3 py-1.5 text-[11px] font-semibold text-amber-800 transition hover:bg-amber-100"
                        >
                            Lihat Riwayat
                        </a>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-3 rounded-lg border border-red-200 bg-red-50 px-4 py-2 text-xs text-red-700">
                        {{ session('error') }}
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-3 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-2 text-xs text-emerald-800">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-3 rounded-lg border border-red-200 bg-red-50 px-4 py-2 text-xs text-red-700">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form
                    action="{{ route('mahasiswa.pengajuan.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="space-y-3"
                >

                    @csrf

                    <!-- JUDUL DAN ABSTRAK -->
                    <div class="rounded-xl border border-sky-100 bg-white p-3.5 shadow-sm {{ $terkunci ? 'opacity-75' : '' }}">

                        <div class="mb-3">
                            <label for="judul" class="mb-1.5 block text-xs font-bold text-slate-700">
                                Judul Skripsi <span class="text-rose-500">*</span>
                            </label>

                            <input
                                type="text"
                                id="judul"
                                name="judul"
                                value="{{ old('judul') }}"
                                placeholder="Masukkan judul skripsi yang diajukan"
                                required
                                {{ $terkunci ? 'disabled' : '' }}
                                class="w-full rounded-lg border border-gray-200 px-3.5 py-2 text-xs text-slate-700 outline-none transition placeholder:text-gray-300 focus:border-[#38B6FF] focus:ring-1 focus:ring-[#38B6FF] disabled:cursor-not-allowed disabled:bg-slate-100"
                            >
                        </div>

                        <div>
                            <label for="abstrak" class="mb-1.5 block text-xs font-bold text-slate-700">
                                Abstrak / Latar Belakang <span class="text-rose-500">*</span>
                            </label>

                            <textarea
                                id="abstrak"
                                name="abstrak"
                                rows="3"
                                placeholder="Jelaskan latar belakang, masalah, dan tujuan penelitian..."
                                required
                                {{ $terkunci ? 'disabled' : '' }}
                                class="h-[56px] w-full resize-none rounded-lg border border-gray-200 px-3.5 py-1.5 text-xs leading-5 text-slate-700 outline-none transition placeholder:text-gray-300 focus:border-[#38B6FF] focus:ring-1 focus:ring-[#38B6FF] disabled:cursor-not-allowed disabled:bg-slate-100"
                            >{{ old('abstrak') }}</textarea>
                        </div>

                    </div>

                    <!-- PILIHAN DOSEN -->
                    <div class="rounded-xl border border-sky-100 bg-white p-3.5 shadow-sm {{ $terkunci ? 'opacity-75' : '' }}">

                        <h2 class="mb-3 text-xs font-bold text-slate-700">
                            Pilihan Dosen Pembimbing
                        </h2>

                        <div class="form-grid grid grid-cols-2 gap-4">

                            <div>
                                <label for="dospem_1_id" class="mb-1.5 block text-xs font-semibold text-slate-700">
                                    Dosen Pembimbing 1 <span class="text-rose-500">*</span>
                                </label>

                                <select
                                    id="dospem_1_id"
                                    name="dospem_1_id"
                                    required
                                    {{ $terkunci ? 'disabled' : '' }}
                                    class="w-full rounded-lg border border-gray-200 bg-white px-3.5 py-2 text-xs text-slate-700 outline-none transition focus:border-[#38B6FF] focus:ring-1 focus:ring-[#38B6FF] disabled:cursor-not-allowed disabled:bg-slate-100"
                                >
                                    <option value="">Pilih Dosen</option>

                                    @foreach ($dosenList as $dosen)
                                        <option
                                            value="{{ $dosen->id }}"
                                            {{ old('dospem_1_id') == $dosen->id ? 'selected' : '' }}
                                        >
                                            {{ $dosen->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="dospem_2_id" class="mb-1.5 block text-xs font-semibold text-slate-700">
                                    Dosen Pembimbing 2 <span class="text-rose-500">*</span>
                                </label>

                                <select
                                    id="dospem_2_id"
                                    name="dospem_2_id"
                                    required
                                    {{ $terkunci ? 'disabled' : '' }}
                                    class="w-full rounded-lg border border-gray-200 bg-white px-3.5 py-2 text-xs text-slate-700 outline-none transition focus:border-[#38B6FF] focus:ring-1 focus:ring-[#38B6FF] disabled:cursor-not-allowed disabled:bg-slate-100"
                                >
                                    <option value="">Pilih Dosen</option>

                                    @foreach ($dosenList as $dosen)
                                        <option
                                            value="{{ $dosen->id }}"
                                            {{ old('dospem_2_id') == $dosen->id ? 'selected' : '' }}
                                        >
                                            {{ $dosen->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </div>

                    <!-- FILE PROPOSAL -->
                    <div class="rounded-xl border border-sky-100 bg-white p-3.5 shadow-sm {{ $terkunci ? 'opacity-75' : '' }}">

                        <label for="file_proposal" class="mb-3 block text-xs font-bold text-slate-700">
                            Proposal PDF <span class="text-rose-500">*</span>
                        </label>

                        <div class="flex items-center justify-between rounded-xl border border-dashed border-sky-200 bg-sky-50/50 px-3 py-2">

                            <div class="flex min-w-0 items-center gap-3">
                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-rose-50 text-[10px] font-bold text-rose-500">
                                    PDF
                                </div>

                                <div class="min-w-0">
                                    <p id="file-name" class="truncate text-xs font-semibold text-slate-700">
                                        Belum ada file dipilih
                                    </p>

                                    <p id="file-size" class="mt-0.5 text-[10px] text-slate-400">
                                        Format PDF • Maksimal 5 MB
                                    </p>
                                </div>
                            </div>

                            @if ($terkunci)
                                <span class="inline-flex shrink-0 cursor-not-allowed items-center gap-1.5 rounded-lg border border-slate-200 bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-400">
                                    Terkunci
                                </span>
                            @else
                                <label
                                    for="file_proposal"
                                    class="inline-flex shrink-0 cursor-pointer items-center gap-1.5 rounded-lg border border-sky-200 bg-white px-3 py-1.5 text-xs font-semibold text-sky-600 shadow-sm transition hover:bg-sky-50"
                                >
                                    <span id="file-action">Pilih file</span>

                                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path d="M12 16V4m-4 4 4-4 4 4"/>
                                        <path d="M4 16v4h16v-4"/>
                                    </svg>
                                </label>
                            @endif

                        </div>

                        <input
                            type="file"
                            id="file_proposal"
                            name="file_proposal"
                            accept=".pdf,application/pdf"
                            required
                            {{ $terkunci ? 'disabled' : '' }}
                            class="hidden"
                        >
                    </div>

                    <!-- BUTTON -->
                    <div class="form-actions flex items-center justify-between pt-0">

                        <p class="text-[10px] text-slate-400">
                            * Bidang wajib diisi.
                        </p>

                        <div class="flex items-center gap-2">

                            <a
                                href="{{ route('mahasiswa.dashboard') }}"
                                class="rounded-xl border border-sky-300 bg-white px-4 py-2 text-xs font-semibold text-sky-600 transition hover:bg-sky-50"
                            >
                                Batal
                            </a>

                            <button
                                type="submit"
                                {{ $terkunci ? 'disabled' : '' }}
                                class="inline-flex items-center gap-2 rounded-lg bg-sky-500 px-5 py-2.5 text-xs font-semibold text-white shadow-sm transition hover:bg-sky-600 disabled:cursor-not-allowed disabled:bg-slate-300 disabled:text-slate-500"
                            >
                                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path d="m22 2-7 20-4-9-9-4Z"/>
                                    <path d="M22 2 11 13"/>
                                </svg>

                                <span>{{ $terkunci ? 'Pengajuan Dikunci' : 'Kirim Pengajuan' }}</span>
                            </button>

                        </div>
                    </div>

                </form>
            </div>
        </main>
    </div>

    @unless ($terkunci)
        <script>
            const fileInput = document.getElementById('file_proposal');
            const fileName = document.getElementById('file-name');
            const fileSize = document.getElementById('file-size');
            const fileAction = document.getElementById('file-action');

            const dospem1 = document.getElementById('dospem_1_id');
            const dospem2 = document.getElementById('dospem_2_id');

            fileInput.addEventListener('change', function () {
                const file = this.files[0];

                if (!file) {
                    fileName.textContent = 'Belum ada file dipilih';
                    fileSize.textContent = 'Format PDF • Maksimal 5 MB';
                    fileAction.textContent = 'Pilih file';
                    return;
                }

                fileName.textContent = file.name;

                fileSize.textContent = 'Ukuran file: ' +
                    (file.size / 1024 / 1024).toFixed(2) + ' MB';

                fileAction.textContent = 'Ganti file';
            });

            function updatePilihanDosen() {
                if (dospem1.value && dospem1.value === dospem2.value) {
                    dospem2.value = '';
                }

                const pilihan1 = dospem1.value;
                const pilihan2 = dospem2.value;

                Array.from(dospem1.options).forEach(option => {
                    option.disabled = option.value !== '' && option.value === pilihan2;
                });

                Array.from(dospem2.options).forEach(option => {
                    option.disabled = option.value !== '' && option.value === pilihan1;
                });
            }

            dospem1.addEventListener('change', updatePilihanDosen);
            dospem2.addEventListener('change', updatePilihanDosen);

            updatePilihanDosen();
        </script>
    @endunless

</body>
</html>