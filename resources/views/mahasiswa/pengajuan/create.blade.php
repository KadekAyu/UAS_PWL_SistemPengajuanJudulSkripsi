@php
    $user = auth()->user();
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Judul - SISTA</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>

<body class="min-h-screen bg-[#E8F5FF] text-slate-800">

    <div class="min-h-screen md:flex">

        <!-- SIDEBAR -->
        <aside class="sista-sidebar flex w-full flex-col md:sticky md:top-0 md:h-screen md:w-60 md:shrink-0">

            <!-- LOGO -->
            <div class="px-5 py-5">
                <p class="text-2xl font-black tracking-tight text-sky-600">
                    SISTA
                </p>

                <p class="mt-1 text-[8px] font-semibold uppercase tracking-widest text-slate-400">
                    Portal Skripsi Mahasiswa
                </p>
            </div>

            <!-- NAVIGASI -->
            <nav class="flex gap-2 overflow-x-auto px-3 pb-3 md:flex-1 md:flex-col">

                <p class="px-4 pb-1 pt-2 text-[10px] font-semibold uppercase tracking-widest text-slate-400">
                    Ruang Akademik
                </p>

                <a href="{{ route('mahasiswa.dashboard') }}" class="sista-nav">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <rect x="4" y="4" width="6" height="6" rx="1"/>
                        <rect x="14" y="4" width="6" height="6" rx="1"/>
                        <rect x="4" y="14" width="6" height="6" rx="1"/>
                        <rect x="14" y="14" width="6" height="6" rx="1"/>
                    </svg>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('mahasiswa.pengajuan.create') }}" class="sista-nav active">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M13 3H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V10z"/>
                        <path d="M13 3v7h7M8 15h8M8 18h5"/>
                    </svg>
                    <span>Pengajuan Judul</span>
                </a>

                <a href="#riwayat" class="sista-nav">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <circle cx="12" cy="12" r="9"/>
                        <path d="M12 7v5l3 2"/>
                    </svg>
                    <span>Riwayat Pengajuan</span>
                </a>

                <a href="#profil" class="sista-nav">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <circle cx="12" cy="8" r="4"/>
                        <path d="M5 21v-2a7 7 0 0 1 14 0v2"/>
                    </svg>
                    <span>Profil</span>
                </a>

            </nav>

            <!-- LOGOUT -->
            <div class="border-t border-slate-100 p-3">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf

                    <button type="submit" class="sista-logout">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M10 17l5-5-5-5M15 12H3"/>
                            <path d="M12 3h6a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-6"/>
                        </svg>
                        <span>Logout</span>
                    </button>
                </form>
            </div>

        </aside>

        <!-- MAIN CONTENT -->
        <main class="min-w-0 flex-1">

            <!-- HEADER -->
            <div class="sista-topbar">

                <div class="flex items-center gap-2 text-xs text-slate-500">
                    <svg class="h-4 w-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="m3 11 9-8 9 8"/>
                        <path d="M5 10v10h14V10"/>
                        <path d="M9 20v-6h6v6"/>
                    </svg>

                    <span>Mahasiswa</span>
                    <span class="text-slate-300">›</span>
                    <span class="font-semibold text-slate-800">Pengajuan Judul</span>
                </div>

                <!-- PROFIL -->
                <div class="flex items-center gap-2.5">

                    <div class="text-right">
                        <p class="sista-user-name">
                            {{ $user->name }}
                        </p>

                        <p class="text-[10px] text-slate-400">
                            NPM {{ $user->npm }}
                        </p>
                    </div>

                    <div class="sista-avatar">
                        {{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}
                    </div>

                </div>

            </div>

            <!-- PAGE CONTENT -->
            <div class="sista-page-content">

                <header class="sista-page-header">
                    <h1 class="sista-page-heading">
                        Pengajuan Judul
                    </h1>

                    <p class="sista-page-description">
                        Lengkapi judul, abstrak, dan unggah proposal PDF untuk dikirim ke pembimbing.
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
                      enctype="multipart/form-data">

                    @csrf

                    <!-- FORM JUDUL DAN ABSTRAK -->
                    <section class="sista-form-section">

                        <div class="sista-form-group">

                            <label for="judul" class="sista-form-label">
                                Judul Skripsi <span class="text-rose-500">*</span>
                            </label>

                            <input
                                type="text"
                                id="judul"
                                name="judul"
                                value="{{ old('judul') }}"
                                placeholder="Masukkan judul skripsi yang diajukan"
                                required
                                class="input-sista"
                            >

                            <p class="sista-form-hint">
                                Gunakan judul yang jelas dan menggambarkan objek penelitian.
                            </p>

                        </div>

                        <div>

                            <label for="abstrak" class="sista-form-label">
                                Abstrak / Latar Belakang <span class="text-rose-500">*</span>
                            </label>

                            <textarea
                                id="abstrak"
                                name="abstrak"
                                rows="4"
                                placeholder="Jelaskan latar belakang, tujuan, dan gambaran singkat penelitian..."
                                required
                                class="input-sista leading-5"
                            >{{ old('abstrak') }}</textarea>

                            <p class="sista-form-hint">
                                Jelaskan latar belakang, masalah, dan tujuan penelitian.
                            </p>

                        </div>

                    </section>

                    <!-- FORM FILE PROPOSAL -->
                    <section class="sista-form-section">

                        <label class="sista-form-label">
                            Proposal PDF <span class="text-rose-500">*</span>
                        </label>

                        <p class="mb-3 text-xs text-slate-500">
                            Unggah proposal PDF untuk dilampirkan bersama pengajuan.
                        </p>

                        <div class="sista-file-box">

                            <div class="flex min-w-0 items-center gap-3">

                                <div class="sista-file-icon">
                                    PDF
                                </div>

                                <div class="min-w-0">
                                    <p id="file-name" class="truncate text-xs font-semibold text-slate-700">
                                        Belum ada file dipilih
                                    </p>

                                    <p id="file-size" class="mt-1 text-[10px] text-slate-400">
                                        Format PDF • Maksimal 5 MB
                                    </p>
                                </div>

                            </div>

                            <label for="file_proposal" class="sista-action-link">
                                <span id="file-action">Pilih file</span>

                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
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

                    </section>

                    <!-- BUTTONS -->
                    <div class="sista-form-actions">

                        <p class="text-[10px] text-slate-400">
                            * Bidang wajib diisi.
                        </p>

                        <div class="flex items-center gap-3">

                            <a href="{{ route('mahasiswa.dashboard') }}"
                               class="sista-button sista-button-cancel">
                                Batal
                            </a>

                            <button type="submit" class="sista-button sista-button-submit">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
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
