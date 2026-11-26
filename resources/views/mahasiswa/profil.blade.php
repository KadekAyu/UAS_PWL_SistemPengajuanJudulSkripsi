@php
    $user = auth()->user();
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - SISTA</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif

    <script src="https://unpkg.com/lucide@0.468.0/dist/umd/lucide.min.js"></script>
</head>

<body class="min-h-screen bg-[#E8F5FF] text-slate-800">

    <div class="min-h-screen md:flex">

        {{-- SIDEBAR --}}
        <x-sidebar-mahasiswa />

        {{-- MAIN CONTENT --}}
        <main class="min-w-0 flex-1">

            {{-- TOPBAR --}}
            <x-topbar-mahasiswa>
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

                    <span class="text-slate-400">Mahasiswa</span>

                    <i data-lucide="chevron-right" class="h-3 w-3 text-slate-400"></i>

                    <span class="font-semibold text-slate-800">
                        Profil Saya
                    </span>

                </div>
            </x-topbar-mahasiswa>

            {{-- PAGE CONTENT --}}
            <div class="p-4 md:p-5">

                {{-- HEADER --}}
                <header class="mb-4">
                    <h1 class="text-xl font-bold tracking-tight text-slate-800">
                        Profil Saya
                    </h1>

                    <p class="mt-1 text-xs text-slate-500">
                        Lihat informasi identitas dan perbarui email atau kata sandi akun Anda.
                    </p>
                </header>

                {{-- NOTIFIKASI BERHASIL --}}
                @if (session('success'))
                    <div
                        id="success-notification"
                        class="fixed right-4 top-20 z-50 flex max-w-[calc(100vw-2rem)] items-center gap-2 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-xs text-emerald-700 shadow-lg md:right-6 md:max-w-sm"
                        role="alert"
                    >
                        <i data-lucide="check-circle" class="h-4 w-4 shrink-0"></i>

                        <span>
                            {{ session('success') }}
                        </span>

                        <button
                            type="button"
                            onclick="hideNotification('success-notification')"
                            class="ml-2 text-emerald-500 transition hover:text-emerald-700"
                            aria-label="Tutup notifikasi"
                        >
                            <i data-lucide="x" class="h-4 w-4"></i>
                        </button>
                    </div>
                @endif

                {{-- NOTIFIKASI ERROR --}}
                <div
                    id="validation-summary"
                    class="{{ $errors->any() ? 'flex' : 'hidden' }} fixed right-4 top-20 z-50 max-w-[calc(100vw-2rem)] items-center gap-2 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-xs text-red-700 shadow-lg md:right-6 md:max-w-sm"
                    role="alert"
                >
                    <i data-lucide="alert-circle" class="h-4 w-4 shrink-0"></i>

                    <span>
                        Periksa kembali data yang kamu masukkan.
                    </span>

                    <button
                        type="button"
                        onclick="hideSummary()"
                        class="ml-2 text-red-500 transition hover:text-red-700"
                        aria-label="Tutup notifikasi"
                    >
                        <i data-lucide="x" class="h-4 w-4"></i>
                    </button>
                </div>

                {{-- HEADER PROFIL --}}
                <section class="mb-4 flex items-center gap-4 rounded-xl border border-sky-100 bg-white px-4 py-3 shadow-sm md:px-5">

                    {{-- FOTO PROFIL / INISIAL --}}
                    <div class="flex h-[66px] w-[66px] shrink-0 items-center justify-center rounded-full border-[3px] border-white bg-[#DDF2FF] text-2xl font-bold uppercase text-[#269FE8] shadow-[0_0_0_2px_#BAE6FD]">
                        {{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}
                    </div>

                    <div class="min-w-0">
                        <h2 class="truncate text-base font-bold text-slate-800 md:text-lg">
                            {{ $user->name }}
                        </h2>

                        <p class="mt-1 text-xs text-slate-500">
                            Mahasiswa
                        </p>

                        <div class="mt-2 inline-flex items-center gap-1.5 rounded-full bg-green-50 px-2.5 py-1 text-[10px] font-semibold text-green-600">
                            <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>
                            Akun Aktif
                        </div>
                    </div>

                </section>

                {{-- FORM PROFIL --}}
                <section class="w-full rounded-xl border border-sky-100 bg-white p-4 shadow-sm md:p-5">

                    <form
                        id="profilForm"
                        action="{{ route('mahasiswa.profil.update') }}"
                        method="POST"
                        novalidate
                    >
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 lg:gap-6">

                            {{-- INFORMASI PRIBADI --}}
                            <section>

                                <div class="mb-3 flex items-center gap-3">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-sky-50 text-sky-600">
                                        <i data-lucide="user-round" class="h-4 w-4"></i>
                                    </div>

                                    <div>
                                        <h2 class="text-sm font-bold text-slate-800">
                                            Informasi Pribadi
                                        </h2>

                                        <p class="mt-0.5 text-[11px] text-slate-400">
                                            Informasi identitas akun mahasiswa.
                                        </p>
                                    </div>
                                </div>

                                <div class="space-y-2.5">

                                    {{-- NAMA (READ-ONLY) --}}
                                    <div>
                                        <label for="name" class="mb-1 block text-xs font-semibold text-slate-700">
                                            Nama Lengkap
                                        </label>

                                        <div class="relative">
                                            <i data-lucide="user" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>

                                            <input
                                                type="text"
                                                id="name"
                                                name="name"
                                                value="{{ $user->name }}"
                                                readonly
                                                aria-readonly="true"
                                                class="profil-input w-full cursor-not-allowed rounded-lg border border-slate-200 bg-slate-50 py-2 pl-10 pr-3 text-xs text-slate-500 outline-none"
                                            >
                                        </div>

                                        <p class="profil-error" id="name-error">@error('name'){{ $message }}@enderror</p>
                                    </div>

                                    {{-- NPM (READ-ONLY) --}}
                                    <div>
                                        <label for="npm" class="mb-1 block text-xs font-semibold text-slate-700">
                                            NPM
                                        </label>

                                        <div class="relative">
                                            <i data-lucide="id-card" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>

                                            <input
                                                type="text"
                                                id="npm"
                                                name="npm"
                                                value="{{ $user->npm }}"
                                                readonly
                                                aria-readonly="true"
                                                class="profil-input w-full cursor-not-allowed rounded-lg border border-slate-200 bg-slate-50 py-2 pl-10 pr-3 text-xs text-slate-500 outline-none"
                                            >
                                        </div>

                                        <p class="profil-error" id="npm-error">@error('npm'){{ $message }}@enderror</p>
                                    </div>

                                    {{-- EMAIL (BISA DIEDIT) --}}
                                    <div>
                                        <label for="email" class="mb-1 block text-xs font-semibold text-slate-700">
                                            Email
                                        </label>

                                        <div class="relative">
                                            <i data-lucide="mail" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>

                                            <input
                                                type="email"
                                                id="email"
                                                name="email"
                                                value="{{ old('email', $user->email) }}"
                                                required
                                                maxlength="255"
                                                class="profil-input w-full rounded-lg border border-slate-200 py-2 pl-10 pr-3 text-xs text-slate-700 outline-none transition focus:border-sky-400 focus:ring-2 focus:ring-sky-100"
                                                placeholder="contoh@gmail.com"
                                            >
                                        </div>

                                        <p class="profil-error" id="email-error">@error('email'){{ $message }}@enderror</p>
                                    </div>

                                </div>
                            </section>

                            {{-- UBAH KATA SANDI --}}
                            <section class="border-t border-slate-100 pt-4 lg:border-l lg:border-t-0 lg:pl-6 lg:pt-0">

                                <div class="mb-3 flex items-center gap-3">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-sky-50 text-sky-600">
                                        <i data-lucide="lock-keyhole" class="h-4 w-4"></i>
                                    </div>

                                    <div>
                                        <h2 class="text-sm font-bold text-slate-800">
                                            Ubah Kata Sandi
                                        </h2>

                                        <p class="mt-0.5 text-[11px] text-slate-400">
                                            Kosongkan jika tidak ingin mengubah kata sandi.
                                        </p>
                                    </div>
                                </div>

                                <div class="space-y-2.5">

                                    {{-- PASSWORD LAMA --}}
                                    <div>
                                        <label for="current_password" class="mb-1 block text-xs font-semibold text-slate-700">
                                            Kata Sandi Lama
                                        </label>

                                        <div class="relative">
                                            <i data-lucide="lock" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>

                                            <input
                                                type="password"
                                                id="current_password"
                                                name="current_password"
                                                autocomplete="current-password"
                                                class="profil-input w-full rounded-lg border border-slate-200 py-2 pl-10 pr-10 text-xs text-slate-700 outline-none transition focus:border-sky-400 focus:ring-2 focus:ring-sky-100"
                                                placeholder="Masukkan kata sandi lama"
                                            >

                                            <button type="button" onclick="togglePassword('current_password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 transition hover:text-sky-500" aria-label="Tampilkan kata sandi">
                                                <i data-lucide="eye" class="h-4 w-4"></i>
                                            </button>
                                        </div>

                                        <p class="profil-error" id="current_password-error">@error('current_password'){{ $message }}@enderror</p>
                                    </div>

                                    {{-- PASSWORD BARU --}}
                                    <div>
                                        <label for="password" class="mb-1 block text-xs font-semibold text-slate-700">
                                            Kata Sandi Baru
                                        </label>

                                        <div class="relative">
                                            <i data-lucide="lock-keyhole" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>

                                            <input
                                                type="password"
                                                id="password"
                                                name="password"
                                                autocomplete="new-password"
                                                class="profil-input w-full rounded-lg border border-slate-200 py-2 pl-10 pr-10 text-xs text-slate-700 outline-none transition focus:border-sky-400 focus:ring-2 focus:ring-sky-100"
                                                placeholder="Masukkan kata sandi baru"
                                            >

                                            <button type="button" onclick="togglePassword('password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 transition hover:text-sky-500" aria-label="Tampilkan kata sandi">
                                                <i data-lucide="eye" class="h-4 w-4"></i>
                                            </button>
                                        </div>

                                        <p class="profil-error" id="password-error">@error('password'){{ $message }}@enderror</p>
                                    </div>

                                    {{-- KONFIRMASI PASSWORD --}}
                                    <div>
                                        <label for="password_confirmation" class="mb-1 block text-xs font-semibold text-slate-700">
                                            Konfirmasi Kata Sandi Baru
                                        </label>

                                        <div class="relative">
                                            <i data-lucide="shield-check" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>

                                            <input
                                                type="password"
                                                id="password_confirmation"
                                                name="password_confirmation"
                                                autocomplete="new-password"
                                                class="profil-input w-full rounded-lg border border-slate-200 py-2 pl-10 pr-10 text-xs text-slate-700 outline-none transition focus:border-sky-400 focus:ring-2 focus:ring-sky-100"
                                                placeholder="Ulangi kata sandi baru"
                                            >

                                            <button type="button" onclick="togglePassword('password_confirmation', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 transition hover:text-sky-500" aria-label="Tampilkan kata sandi">
                                                <i data-lucide="eye" class="h-4 w-4"></i>
                                            </button>
                                        </div>

                                        <p class="profil-error" id="password_confirmation-error">@error('password_confirmation'){{ $message }}@enderror</p>
                                    </div>

                                </div>
                            </section>

                        </div>

                        {{-- TOMBOL --}}
                        <div class="mt-4 flex justify-end gap-2 border-t border-slate-100 pt-3">

                            <a
                                href="{{ route('mahasiswa.dashboard') }}"
                                class="rounded-lg border border-sky-200 bg-white px-4 py-2 text-xs font-semibold text-sky-600 transition hover:bg-sky-50"
                            >
                                Batal
                            </a>

                            <button
                                type="submit"
                                class="inline-flex items-center gap-2 rounded-lg bg-sky-500 px-5 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-sky-600"
                            >
                                <i data-lucide="save" class="h-4 w-4"></i>
                                Simpan Perubahan
                            </button>

                        </div>

                    </form>

                </section>

            </div>

        </main>

    </div>

    {{-- STYLE VALIDASI --}}
    <style>
        .profil-error {
            display: none;
            margin-top: 4px;
            font-size: 10px;
            color: #dc2626;
        }

        .profil-error.show {
            display: block;
        }

        .profil-input.is-invalid {
            border-color: #f87171;
            background-color: #fffafa;
        }
    </style>

    {{-- JAVASCRIPT --}}
    <script>
        lucide.createIcons();

        const form = document.getElementById('profilForm');
        const summary = document.getElementById('validation-summary');

        const fields = {
            email: document.getElementById('email'),
            current_password: document.getElementById('current_password'),
            password: document.getElementById('password'),
            password_confirmation: document.getElementById('password_confirmation')
        };

        function showSummary() {
            summary.classList.remove('hidden');
            summary.classList.add('flex');
            lucide.createIcons();
        }

        function hideSummary() {
            summary.classList.add('hidden');
            summary.classList.remove('flex');
        }

        function hideNotification(id) {
            const notification = document.getElementById(id);

            if (notification) {
                notification.classList.add('hidden');
            }
        }

        function togglePassword(fieldId, button) {
            const input = document.getElementById(fieldId);
            const icon = button.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.setAttribute('data-lucide', 'eye-off');
                button.setAttribute('aria-label', 'Sembunyikan kata sandi');
            } else {
                input.type = 'password';
                icon.setAttribute('data-lucide', 'eye');
                button.setAttribute('aria-label', 'Tampilkan kata sandi');
            }

            lucide.createIcons();
        }

        function showError(field, message) {
            const input = fields[field];
            const error = document.getElementById(field + '-error');

            input.classList.add('is-invalid');
            error.textContent = message;
            error.classList.add('show');

            showSummary();
        }

        function clearError(field) {
            const input = fields[field];
            const error = document.getElementById(field + '-error');

            input.classList.remove('is-invalid');
            error.textContent = '';
            error.classList.remove('show');
        }

        function validateField(field) {
            const value = fields[field].value.trim();

            if (field === 'email') {
                const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

                if (!value) {
                    showError(field, 'Email wajib diisi.');
                    return false;
                }

                if (!emailPattern.test(value)) {
                    showError(field, 'Email harus menggunakan format yang benar.');
                    return false;
                }
            }

            if (field === 'current_password' && fields.password.value && !value) {
                showError(field, 'Kata sandi lama wajib diisi.');
                return false;
            }

            if (field === 'password' && value) {
                if (value.length < 8) {
                    showError(field, 'Kata sandi baru minimal 8 karakter.');
                    return false;
                }

                if (!fields.current_password.value.trim()) {
                    showError('current_password', 'Kata sandi lama wajib diisi.');
                    return false;
                }

                if (!fields.password_confirmation.value) {
                    showError('password_confirmation', 'Konfirmasi kata sandi wajib diisi.');
                    return false;
                }

                if (value !== fields.password_confirmation.value) {
                    showError('password_confirmation', 'Konfirmasi kata sandi tidak cocok.');
                    return false;
                }
            }

            if (field === 'password_confirmation' && fields.password.value) {
                if (!value) {
                    showError(field, 'Konfirmasi kata sandi wajib diisi.');
                    return false;
                }

                if (value !== fields.password.value) {
                    showError(field, 'Konfirmasi kata sandi tidak cocok.');
                    return false;
                }
            }

            clearError(field);
            return true;
        }

        // VALIDASI SAAT INPUT DAN KELUAR DARI FIELD
        Object.keys(fields).forEach(function (field) {

            fields[field].addEventListener('blur', function () {
                this.dataset.touched = 'true';
                validateField(field);
            });

            fields[field].addEventListener('input', function () {

                if (this.dataset.touched === 'true') {
                    validateField(field);
                }

                if (
                    field === 'password' &&
                    fields.password_confirmation.dataset.touched === 'true'
                ) {
                    validateField('password_confirmation');
                }

                if (
                    field === 'current_password' &&
                    fields.current_password.dataset.touched === 'true'
                ) {
                    validateField('current_password');
                }
            });
        });

        // VALIDASI SEBELUM FORM DIKIRIM
        form.addEventListener('submit', function (event) {
            let valid = true;

            Object.keys(fields).forEach(function (field) {
                fields[field].dataset.touched = 'true';

                if (!validateField(field)) {
                    valid = false;
                }
            });

            if (!valid) {
                event.preventDefault();
                showSummary();

                const firstInvalid = form.querySelector('.profil-input.is-invalid');

                if (firstInvalid) {
                    firstInvalid.focus();
                }
            }
        });

        // MENAMPILKAN ERROR DARI LARAVEL
        let hasServerError = false;

        Object.keys(fields).forEach(function (field) {
            const error = document.getElementById(field + '-error');

            if (error.textContent.trim() !== '') {
                fields[field].classList.add('is-invalid');
                error.classList.add('show');
                hasServerError = true;
            }
        });

        if (hasServerError) {
            showSummary();
        }
    </script>

</body>
</html>