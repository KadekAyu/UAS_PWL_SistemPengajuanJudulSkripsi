<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISTA - Masuk ke Akun Anda</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>
<body class="bg-[#E8F5FF] h-screen w-screen overflow-hidden flex items-center justify-center p-4 font-sans">

    <div class="w-full max-w-4xl h-full max-h-[85vh] flex flex-col md:flex-row items-center justify-between gap-6 md:gap-8 my-auto">
        
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
                Akses sistem sesuai peran Anda
            </p>
        </div>

        <div class="w-full md:w-7/12 bg-white rounded-3xl p-8 md:p-10 shadow-sm border border-sky-100 flex flex-col justify-center">
            <!-- Header Form -->
            <div class="mb-6 space-y-1">
                <h2 class="text-2xl font-bold text-[#38B6FF]">Masuk ke Akun Anda</h2>
                <p class="text-xs text-gray-400">Silakan login untuk melanjutkan</p>
            </div>

            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-xl text-xs text-red-600">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" autocomplete="off" class="space-y-4">
                @csrf

                <div class="space-y-1">
                    <label for="email" class="block text-xs font-bold text-gray-700">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email" required
                        class="w-full px-4 py-2.5 text-xs rounded-xl border border-gray-200 focus:border-[#38B6FF] focus:ring-1 focus:ring-[#38B6FF] outline-none text-gray-700 placeholder-gray-300 transition">
                </div>

                <div class="space-y-1">
                    <label for="password" class="block text-xs font-bold text-gray-700">Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan password" required
                        class="w-full px-4 py-2.5 text-xs rounded-xl border border-gray-200 focus:border-[#38B6FF] focus:ring-1 focus:ring-[#38B6FF] outline-none text-gray-700 placeholder-gray-300 transition">
                </div>

                <div class="pt-2">
                    <button type="submit" 
                        class="w-full py-3 bg-[#69C9F5] hover:bg-[#38B6FF] text-white font-semibold rounded-xl text-xs transition duration-200 shadow-sm">
                        Login
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center text-xs text-gray-400">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="font-bold text-[#38B6FF] hover:underline">Register</a>
            </div>
        </div>

    </div>

</body>
</html>