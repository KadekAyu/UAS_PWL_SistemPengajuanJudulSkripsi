@php
    $user = auth()->user();
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Judul - SISTA</title>

    <script src="https://cdn.tailwindcss.com"></script>
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
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="m3 10 9-7 9 7"/>
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M5 9v11h14V9"/>
                        <path stroke-linecap="round" stroke-linejoin="round"
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
                        Pengajuan Judul
                    </span>

                </div>
            </x-topbar-mahasiswa>

            <!-- PAGE CONTENT -->
            <div class="p-6">

                <!-- HEADER -->
                <header class="mb-4">

                    <h1 class="text-xl font-bold tracking-tight text-slate-800">
                        Pengajuan Judul
                    </h1>

                    <p class="mt-1 text-xs text-slate-500">
                        Lengkapi informasi judul dan unggah proposal skripsi untuk dikirim.
                    </p>

                </header>

                <!-- PESAN BERHASIL -->
                @if (session('success'))
                    <div class="mb-3 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-2.5 text-xs text-emerald-800">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- PESAN ERROR -->
                @if ($errors->any())
                    <div class="mb-3 rounded-lg border border-red-200 bg-red-50 px-4 py-2.5 text-xs text-red-700">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('mahasiswa.pengajuan.store') }}"
                      method="POST"
                      enctype="multipart/form-data"
                      class="space-y-3">

                    @csrf

                    <!-- FORM JUDUL DAN ABSTRAK -->
                    <div class="rounded-xl border border-sky-100 bg-white p-5 shadow-sm space-y-3">

                        <!-- JUDUL -->
                        <div>
                            <label for="judul"
                                   class="mb-1.5 block text-xs font-bold text-slate-700">
                                Judul Skripsi
                                <span class="text-rose-500">*</span>
                            </label>

                            <input
                                type="text"
                                id="judul"
                                name="judul"
                                value="{{ old('judul') }}"
                                placeholder="Masukkan judul skripsi yang diajukan"
                                required
                                class="w-full rounded-lg border border-gray-200 px-3.5 py-2.5 text-xs text-slate-700 outline-none transition placeholder:text-gray-300 focus:border-[#38B6FF] focus:ring-1 focus:ring-[#38B6FF]"
                            >

                            <p class="mt-1 text-[10px] text-slate-400">
                                Gunakan judul yang jelas dan menggambarkan objek penelitian.
                            </p>
                        </div>

                        <!-- ABSTRAK -->
                        <div>
                            <label for="abstrak"
                                   class="mb-1.5 block text-xs font-bold text-slate-700">
                                Abstrak / Latar Belakang
                                <span class="text-rose-500">*</span>
                            </label>

                            <textarea
                                id="abstrak"
                                name="abstrak"
                                rows="4"
                                placeholder="Jelaskan latar belakang, tujuan, dan gambaran singkat penelitian..."
                                required
                                class="w-full resize-none rounded-lg border border-gray-200 px-3.5 py-2.5 text-xs leading-5 text-slate-700 outline-none transition placeholder:text-gray-300 focus:border-[#38B6FF] focus:ring-1 focus:ring-[#38B6FF]"
                            >{{ old('abstrak') }}</textarea>

                            <p class="mt-1 text-[10px] text-slate-400">
                                Jelaskan latar belakang, masalah, dan tujuan penelitian.
                            </p>
                        </div>

                    </div>

                    <!-- FORM FILE PROPOSAL -->
                    <div class="rounded-xl border border-sky-100 bg-white p-5 shadow-sm">

                        <label for="file_proposal"
                               class="mb-1 block text-xs font-bold text-slate-700">
                            Proposal PDF
                            <span class="text-rose-500">*</span>
                        </label>

                        <p class="mb-3 text-[11px] text-slate-500">
                            Unggah proposal PDF untuk dilampirkan bersama pengajuan.
                        </p>

                        <div class="flex items-center justify-between rounded-xl border border-dashed border-sky-200 bg-sky-50/50 p-3">

                            <div class="flex min-w-0 items-center gap-3">

                                <!-- PDF ICON -->
                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-rose-50 text-[10px] font-bold text-rose-500">
                                    PDF
                                </div>

                                <div class="min-w-0">
                                    <p id="file-name"
                                       class="truncate text-xs font-semibold text-slate-700">
                                        Belum ada file dipilih
                                    </p>

                                    <p id="file-size"
                                       class="mt-0.5 text-[10px] text-slate-400">
                                        Format PDF • Maksimal 5 MB
                                    </p>
                                </div>

                            </div>

                            <label for="file_proposal"
                                   class="inline-flex shrink-0 cursor-pointer items-center gap-1.5 rounded-lg border border-sky-200 bg-white px-3 py-2 text-xs font-semibold text-sky-600 shadow-sm transition hover:bg-sky-50">

                                <span id="file-action">Pilih file</span>

                                <svg class="h-3.5 w-3.5"
                                     viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="1.8">
                                    <path d="M12 16V4m-4 4 4-4 4 4"/>
                                    <path d="M4 16v4h16v-4"/>
                                </svg>

                            </label>

                        </div>

                        <input
                            type="file"
                            id="file_proposal"
                            name="file_proposal"
                            accept=".pdf,application/pdf"
                            required
                            class="hidden"
                        >

                    </div>

                    <!-- BUTTONS -->
                    <div class="flex items-center justify-between pt-1">

                        <p class="text-[10px] text-slate-400">
                            * Bidang wajib diisi.
                        </p>

                        <div class="flex items-center gap-2">

                            <a href="{{ route('mahasiswa.dashboard') }}"
                               class="rounded-xl border border-sky-300 bg-white px-4 py-2 text-xs font-semibold text-sky-600 transition hover:bg-sky-50">
                                Batal
                            </a>

                            <button
                                type="submit"
                                class="inline-flex items-center gap-2 rounded-lg bg-sky-500 px-5 py-2.5 text-xs font-semibold text-white shadow-sm transition hover:bg-sky-600">

                                <svg class="h-3.5 w-3.5"
                                     viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="1.8">
                                    <path d="m22 2-7 20-4-9-9-4Z"/>
                                    <path d="M22 2 11 13"/>
                                </svg>

                                <span>Kirim Pengajuan</span>

                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </main>

    </div>

    <!-- JAVASCRIPT PILIH FILE -->
    <script>
        const fileInput = document.getElementById('file_proposal');
        const fileName = document.getElementById('file-name');
        const fileSize = document.getElementById('file-size');
        const fileAction = document.getElementById('file-action');

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
    </script>

</body>
</html>
