<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISTA - Daftar Akun Mahasiswa</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>
<body class="bg-[#E8F5FF] h-screen w-screen overflow-hidden flex items-center justify-center p-4 font-sans">

    <div class="w-full max-w-4xl h-full max-h-[90vh] flex flex-col md:flex-row items-center justify-between gap-6 md:gap-8 my-auto">
        
        <div class="w-full md:w-5/12 flex flex-col items-center text-center space-y-3">
            <div class="relative flex justify-center items-center w-40 h-40 md:w-48 md:h-48">
                <span class="absolute top-2 left-4 text-sky-500 text-lg font-bold">★</span>
                <span class="absolute top-4 right-6 text-sky-500 text-xs font-bold">★</span>
                <span class="absolute top-14 left-6 text-sky-400 text-xs font-bold">★</span>
                <span class="absolute top-10 right-2 text-sky-500 text-2xl font-bold">★</span>
                
                <img src="{{ asset('images/toga 1.png') }}" alt="Logo SISTA" class="w-36 md:w-44 h-auto object-contain relative z-10">
            </div>

            <div class="space-y-1">
                <h1 class="text-3xl font-extrabold text-[#38B6FF] tracking-wide">SISTA</h1>
                <p class="text-base font-bold text-[#38B6FF] leading-snug">
                    Sistem Informasi<br>Pengajuan Judul Skripsi / TA
                </p>
            </div>

            <p class="text-sky-600 text-xs max-w-xs font-normal">
                Mulai langkah akademikmu dengan lebih mudah dan terarah
            </p>
        </div>

        <div class="w-full md:w-7/12 bg-white rounded-3xl p-6 shadow-sm border border-sky-100 flex flex-col justify-center">
            <div class="mb-4 space-y-0.5">
                <h2 class="text-xl font-bold text-[#38B6FF]">Daftar Akun Mahasiswa</h2>
                <p class="text-[11px] text-gray-400">Lengkapi data diri untuk membuat akun</p>
            </div>

            <form action="{{ route('register') }}" method="POST" class="space-y-2.5">
                @csrf

                <div class="space-y-0.5">
                    <label for="name" class="block text-[11px] font-bold text-gray-700">Nama Lengkap</label>
                    <input type="text" id="name" name="name" placeholder="Masukkan nama lengkap" required
                        class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-200 focus:border-[#38B6FF] focus:ring-1 focus:ring-[#38B6FF] outline-none text-gray-700 placeholder-gray-300 transition">
                </div>

                <div class="space-y-0.5">
                    <label for="npm" class="block text-[11px] font-bold text-gray-700">NPM</label>
                    <input type="text" id="npm" name="npm" placeholder="Masukkan NPM" required
                        class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-200 focus:border-[#38B6FF] focus:ring-1 focus:ring-[#38B6FF] outline-none text-gray-700 placeholder-gray-300 transition">
                </div>

                <div class="space-y-0.5">
                    <label for="email" class="block text-[11px] font-bold text-gray-700">Email</label>
                    <input type="email" id="email" name="email" placeholder="Masukkan email" required
                        class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-200 focus:border-[#38B6FF] focus:ring-1 focus:ring-[#38B6FF] outline-none text-gray-700 placeholder-gray-300 transition">
                </div>

                <div class="space-y-0.5">
                    <label for="password" class="block text-[11px] font-bold text-gray-700">Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan password" required
                        class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-200 focus:border-[#38B6FF] focus:ring-1 focus:ring-[#38B6FF] outline-none text-gray-700 placeholder-gray-300 transition">
                </div>

                <div class="space-y-0.5">
                    <label for="password_confirmation" class="block text-[11px] font-bold text-gray-700">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Masukkan konfirmasi password" required
                        class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-200 focus:border-[#38B6FF] focus:ring-1 focus:ring-[#38B6FF] outline-none text-gray-700 placeholder-gray-300 transition">
                </div>

                <div class="pt-2">
                    <button type="submit" 
                        class="w-full py-2.5 bg-[#69C9F5] hover:bg-[#38B6FF] text-white font-semibold rounded-xl text-xs transition duration-200 shadow-sm">
                        Register
                    </button>
                </div>
            </form>

            <div class="mt-4 text-center text-[11px] text-gray-400">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="font-bold text-[#38B6FF] hover:underline">Login di sini</a>
            </div>
        </div>

    </div>

</body>
</html>