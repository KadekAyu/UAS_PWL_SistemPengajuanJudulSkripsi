@php
    $user = auth()->user();
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Judul - SISTA</title>

    <!-- Menggunakan CDN Tailwind langsung agar aman dan rapi tanpa build npm -->
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
                <a href="{{ route('mahasiswa.riwayat') }}" class="hover:underline">Riwayat Pengajuan</a>
                <span class="text-slate-300">›</span>
                <span class="font-semibold text-slate-800">Buat Pengajuan</span>
            </x-topbar-mahasiswa>

            <!-- PAGE CONTENT -->
            <div class="p-6 max-w-4xl mx-auto">

                <header class="mb-6">
                    <h1 class="text-xl font-bold tracking-tight text-sky-600">
                        Pengajuan Judul
                    </h1>

                    <p class="mt-1 text-xs text-slate-500">
                        Lengkapi judul, abstrak, pilih Dosen Pembimbing, dan unggah proposal PDF untuk dikirim.
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
                        <p class="font-semibold">
                            Periksa kembali data yang diisi:
                        </p>

                        <ul class="mt-1.5 list-inside list-disc">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('mahasiswa.pengajuan.store') }}"
                      method="POST"
                      enctype="multipart/form-data"
                      class="space-y-6">

                    @csrf

                    <!-- FORM JUDUL DAN ABSTRAK -->
                    <div class="bg-white rounded-2xl p-6 border border-sky-100 shadow-sm space-y-4">

                        <div>
                            <label for="judul" class="block text-xs font-bold text-slate-700 mb-1.5">
                                Judul Skripsi <span class="text-rose-500">*</span>
                            </label>

                            <input
                                type="text"
                                id="judul"
                                name="judul"
                                value="{{ old('judul') }}"
                                placeholder="Masukkan judul skripsi yang diajukan"
                                required
                                class="w-full px-3.5 py-2 text-xs rounded-xl border border-gray-200 focus:border-[#38B6FF] focus:ring-1 focus:ring-[#38B6FF] outline-none text-slate-700 placeholder-gray-300 transition"
                            >

                            <p class="mt-1 text-[11px] text-slate-400">
                                Gunakan judul yang jelas dan menggambarkan objek penelitian.
                            </p>
                        </div>

                        <div>
                            <label for="abstrak" class="block text-xs font-bold text-slate-700 mb-1.5">
                                Abstrak / Latar Belakang <span class="text-rose-500">*</span>
                            </label>

                            <textarea
                                id="abstrak"
                                name="abstrak"
                                rows="4"
                                placeholder="Jelaskan latar belakang, tujuan, dan gambaran singkat penelitian..."
                                required
                                class="w-full px-3.5 py-2 text-xs rounded-xl border border-gray-200 focus:border-[#38B6FF] focus:ring-1 focus:ring-[#38B6FF] outline-none text-slate-700 placeholder-gray-300 transition leading-5"
                            >{{ old('abstrak') }}</textarea>

                            <p class="mt-1 text-[11px] text-slate-400">
                                Jelaskan latar belakang, masalah, dan tujuan penelitian.
                            </p>
                        </div>

                    </div>

                    <!-- FORM PILIHAN DOSEN PEMBIMBING (DOSPEM 1 & DOSPEM 2) -->
                    <div class="bg-white rounded-2xl p-6 border border-sky-100 shadow-sm grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div>
                            <label for="dospem_1_id" class="block text-xs font-bold text-slate-700 mb-1.5">
                                Dosen Pembimbing 1 <span class="text-rose-500">*</span>
                            </label>
                            <select name="dospem_1_id" id="dospem_1_id" required class="w-full px-3.5 py-2 text-xs rounded-xl border border-gray-200 focus:border-[#38B6FF] focus:ring-1 focus:ring-[#38B6FF] outline-none text-slate-700 bg-white">
                                <option value="">-- Pilih Dospem 1 --</option>
                                @foreach($dosenList ?? [] as $dosen)
                                    <option value="{{ $dosen->id }}" {{ old('dospem_1_id') == $dosen->id ? 'selected' : '' }}>
                                        {{ $dosen->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="dospem_2_id" class="block text-xs font-bold text-slate-700 mb-1.5">
                                Dosen Pembimbing 2 <span class="text-rose-500">*</span>
                            </label>
                            <select name="dospem_2_id" id="dospem_2_id" required class="w-full px-3.5 py-2 text-xs rounded-xl border border-gray-200 focus:border-[#38B6FF] focus:ring-1 focus:ring-[#38B6FF] outline-none text-slate-700 bg-white">
                                <option value="">-- Pilih Dospem 2 --</option>
                                @foreach($dosenList ?? [] as $dosen)
                                    <option value="{{ $dosen->id }}" {{ old('dospem_2_id') == $dosen->id ? 'selected' : '' }}>
                                        {{ $dosen->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <!-- FORM FILE PROPOSAL -->
                    <div class="bg-white rounded-2xl p-6 border border-sky-100 shadow-sm">

                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Proposal PDF <span class="text-rose-500">*</span>
                        </label>

                        <p class="mb-3 text-xs text-slate-500">
                            Unggah proposal PDF untuk dilampirkan bersama pengajuan.
                        </p>

                        <div class="flex items-center justify-between p-4 border border-dashed border-sky-200 rounded-xl bg-sky-50/50">

                            <div class="flex items-center gap-3 min-w-0">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-sky-100 text-sky-600 font-bold text-xs">
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

                            <label for="file_proposal" class="cursor-pointer inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-sky-200 hover:bg-sky-50 text-sky-600 font-semibold rounded-lg text-xs transition shadow-sm shrink-0">
                                <span id="file-action">Pilih file</span>
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
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
                    <div class="flex items-center justify-between pt-2">
                        <p class="text-[10px] text-slate-400">
                            * Bidang wajib diisi.
                        </p>

                        <div class="flex items-center gap-3">
                            <a href="{{ route('mahasiswa.dashboard') }}"
                               class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-slate-600 font-semibold rounded-xl text-xs transition">
                                Batal
                            </a>

                            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 bg-sky-500 hover:bg-sky-600 text-white font-semibold rounded-xl text-xs transition shadow-sm">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
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
            fileSize.textContent = 'Ukuran file: ' + (file.size / 1024 / 1024).toFixed(2) + ' MB';
            fileAction.textContent = 'Ganti file';
        });
    </script>

</body>
</html>