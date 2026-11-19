
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - SISTA</title>

    <script src="https://cdn.tailwindcss.com"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#E8F5FF] text-slate-700">

    <div class="flex min-h-screen">

        <x-sidebar-mahasiswa />

        <div class="min-w-0 flex-1">

            {{-- TOPBAR --}}
            <x-topbar-mahasiswa>
                <div class="flex items-center gap-2 text-xs font-medium text-slate-600">

                    <a href="{{ route('mahasiswa.dashboard') }}"
                       class="text-slate-400 transition hover:text-sky-500">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-4 w-4"
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

                    </a>

                    <span class="text-slate-400">
                        Mahasiswa
                    </span>

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
                        Profil Saya
                    </span>

                </div>
            </x-topbar-mahasiswa>

            <main class="p-4 md:p-6">

                {{-- JUDUL --}}
                <div class="mb-4">
                    <h1 class="text-xl font-bold tracking-tight text-slate-800">
                        Profil Saya
                    </h1>

                    <p class="mt-1 text-xs text-slate-500">
                        Perbarui informasi akun dan kata sandi Anda.
                    </p>
                </div>

                {{-- NOTIFIKASI BERHASIL --}}
                @if (session('success'))
                    <div class="mb-3 rounded-xl border border-green-200 bg-green-50 px-4 py-2.5 text-xs font-medium text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- NOTIFIKASI ERROR --}}
                @if ($errors->any())
                    <div class="mb-3 rounded-xl border border-red-200 bg-red-50 px-4 py-2.5 text-xs text-red-700">
                        Periksa kembali data yang kamu masukkan.
                    </div>
                @endif

                {{-- CARD PROFIL --}}
                <div class="w-full rounded-xl border border-sky-100 bg-white p-4 shadow-sm md:p-5">

                    <form
                        id="profilForm"
                        action="{{ route('mahasiswa.profil.update') }}"
                        method="POST"
                        novalidate
                    >
                        @csrf
                        @method('PUT')

                        {{-- INFORMASI PROFIL --}}
                        <div class="mb-3">
                            <h2 class="text-sm font-bold text-slate-800">
                                Informasi Profil
                            </h2>

                            <p class="mt-0.5 text-[11px] text-slate-400">
                                Perbarui informasi akun Anda.
                            </p>
                        </div>

                        <div class="space-y-3">

                            {{-- NAMA LENGKAP --}}
                            <div>
                                <label for="name"
                                       class="mb-1 block text-xs font-bold text-slate-700">
                                    Nama Lengkap
                                </label>

                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old('name', $user->name) }}"
                                    required
                                    maxlength="255"
                                    class="profil-input w-full rounded-lg border border-slate-200 px-3 py-2 text-xs text-slate-700 outline-none transition focus:border-sky-400 focus:ring-2 focus:ring-sky-100"
                                    placeholder="Masukkan nama lengkap"
                                >

                                <p class="profil-error" id="name-error">@error('name'){{ $message }}@enderror</p>
                            </div>

                            {{-- NPM --}}
                            <div>
                                <label for="npm"
                                       class="mb-1 block text-xs font-bold text-slate-700">
                                    NPM
                                </label>

                                <input
                                    type="text"
                                    id="npm"
                                    name="npm"
                                    value="{{ old('npm', $user->npm) }}"
                                    required
                                    maxlength="10"
                                    inputmode="numeric"
                                    class="profil-input w-full rounded-lg border border-slate-200 px-3 py-2 text-xs text-slate-700 outline-none transition focus:border-sky-400 focus:ring-2 focus:ring-sky-100"
                                    placeholder="Masukkan 10 angka NPM"
                                >

                                <p class="profil-error" id="npm-error">@error('npm'){{ $message }}@enderror</p>
                            </div>

                            {{-- EMAIL --}}
                            <div>
                                <label for="email"
                                       class="mb-1 block text-xs font-bold text-slate-700">
                                    Email
                                </label>

                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email', $user->email) }}"
                                    required
                                    maxlength="255"
                                    class="profil-input w-full rounded-lg border border-slate-200 px-3 py-2 text-xs text-slate-700 outline-none transition focus:border-sky-400 focus:ring-2 focus:ring-sky-100"
                                    placeholder="contoh@gmail.com"
                                >

                                <p class="profil-error" id="email-error">@error('email'){{ $message }}@enderror</p>
                            </div>

                        </div>

                        {{-- PEMISAH --}}
                        <div class="my-4 border-t border-slate-100"></div>

                        {{-- INFORMASI PASSWORD --}}
                        <div class="mb-3">
                            <h2 class="text-sm font-bold text-slate-800">
                                Ubah Kata Sandi
                            </h2>

                            <p class="mt-0.5 text-[11px] text-slate-400">
                                Kosongkan bagian ini jika tidak ingin mengubah kata sandi.
                            </p>
                        </div>

                        <div class="space-y-3">

                            {{-- KATA SANDI LAMA --}}
                            <div>
                                <label for="current_password"
                                       class="mb-1 block text-xs font-bold text-slate-700">
                                    Kata Sandi Lama
                                </label>

                                <input
                                    type="password"
                                    id="current_password"
                                    name="current_password"
                                    autocomplete="current-password"
                                    class="profil-input w-full rounded-lg border border-slate-200 px-3 py-2 text-xs text-slate-700 outline-none transition focus:border-sky-400 focus:ring-2 focus:ring-sky-100"
                                    placeholder="Masukkan kata sandi lama"
                                >

                                <p class="profil-error" id="current_password-error">@error('current_password'){{ $message }}@enderror</p>
                            </div>

                            {{-- KATA SANDI BARU --}}
                            <div>
                                <label for="password"
                                       class="mb-1 block text-xs font-bold text-slate-700">
                                    Kata Sandi Baru
                                </label>

                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    autocomplete="new-password"
                                    class="profil-input w-full rounded-lg border border-slate-200 px-3 py-2 text-xs text-slate-700 outline-none transition focus:border-sky-400 focus:ring-2 focus:ring-sky-100"
                                    placeholder="Masukkan kata sandi baru"
                                >

                                <p class="profil-error" id="password-error">@error('password'){{ $message }}@enderror</p>
                            </div>

                            {{-- KONFIRMASI KATA SANDI --}}
                            <div>
                                <label for="password_confirmation"
                                       class="mb-1 block text-xs font-bold text-slate-700">
                                    Konfirmasi Kata Sandi Baru
                                </label>

                                <input
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    autocomplete="new-password"
                                    class="profil-input w-full rounded-lg border border-slate-200 px-3 py-2 text-xs text-slate-700 outline-none transition focus:border-sky-400 focus:ring-2 focus:ring-sky-100"
                                    placeholder="Ulangi kata sandi baru"
                                >

                                <p class="profil-error" id="password_confirmation-error">@error('password_confirmation'){{ $message }}@enderror</p>
                            </div>

                        </div>

                        {{-- TOMBOL --}}
                        <div class="mt-5 flex justify-end gap-2 border-t border-slate-100 pt-4">

                            <a
                                href="{{ route('mahasiswa.dashboard') }}"
                                class="rounded-lg border border-sky-200 bg-white px-4 py-2 text-xs font-semibold text-sky-600 transition hover:bg-sky-50"
                            >
                                Batal
                            </a>

                            <button
                                type="submit"
                                class="rounded-lg bg-[#38B6FF] px-5 py-2 text-xs font-semibold text-white transition hover:bg-sky-500"
                            >
                                Simpan Perubahan
                            </button>

                        </div>

                    </form>

                </div>

            </main>
        </div>
    </div>

    {{-- JAVASCRIPT VALIDASI --}}
    <script>
        const form = document.getElementById('profilForm');

        const fields = {
            name: document.getElementById('name'),
            npm: document.getElementById('npm'),
            email: document.getElementById('email'),
            current_password: document.getElementById('current_password'),
            password: document.getElementById('password'),
            password_confirmation: document.getElementById('password_confirmation')
        };

        function showError(field, message) {
            const input = fields[field];
            const error = document.getElementById(field + '-error');

            input.classList.add('is-invalid');
            error.textContent = message;
            error.classList.add('show');
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

            if (field === 'name' && !value) {
                showError(field, 'Nama lengkap wajib diisi.');
                return false;
            }

            if (field === 'npm' && !/^[0-9]{10}$/.test(value)) {
                showError(field, 'NPM harus terdiri dari tepat 10 angka.');
                return false;
            }

            if (field === 'email') {
                const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.com$/;

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

        // NPM HANYA BOLEH ANGKA
        fields.npm.addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);

            if (this.dataset.touched === 'true') {
                validateField('npm');
            }
        });

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

                if (field === 'password' &&
                    fields.password_confirmation.dataset.touched === 'true') {
                    validateField('password_confirmation');
                }

                if (field === 'current_password' &&
                    fields.current_password.dataset.touched === 'true') {
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

                const firstInvalid = form.querySelector('.profil-input.is-invalid');

                if (firstInvalid) {
                    firstInvalid.focus();
                }
            }
        });

        // MENAMPILKAN ERROR DARI LARAVEL
        Object.keys(fields).forEach(function (field) {
            const error = document.getElementById(field + '-error');

            if (error.textContent.trim() !== '') {
                fields[field].classList.add('is-invalid');
                error.classList.add('show');
            }
        });
    </script>

</body>
</html>
