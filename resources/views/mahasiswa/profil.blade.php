@php
    $user = auth()->user();
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - SISTA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-[#E8F5FF] text-slate-800">
    <div class="min-h-screen md:flex">
        
        <!-- SIDEBAR -->
        <x-sidebar-mahasiswa />

        <!-- MAIN CONTAINER -->
        <main class="min-w-0 flex-1">
            
            <!-- TOPBAR TERPUSAT -->
            <x-topbar-mahasiswa>
                <span>Mahasiswa</span>
                <span class="text-slate-300">›</span>
                <span class="font-semibold text-slate-800">Profil Saya</span>
            </x-topbar-mahasiswa>

            <!-- PAGE CONTENT -->
            <div class="p-8 max-w-4xl mx-auto space-y-6">
                
                <!-- HEADER & TOMBOL KEMBALI SIMBOL < -->
                <div class="flex items-center gap-3">
                    <div>
                        <h1 class="text-2xl font-bold text-slate-900">Profil Pengguna</h1>
                    </div>
                </div>
                
                <!-- KARTU PROFIL UTAMA -->
                <div class="bg-white rounded-2xl border border-sky-100 shadow-sm p-6 space-y-6">
                    
                    <!-- Header Kartu (Avatar & Nama Tanpa Role) -->
                    <div class="flex items-center gap-4 pb-6 border-b border-slate-100">
                        <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-sky-100 text-sky-600 font-bold text-2xl shadow-inner">
                            {{ mb_strtoupper(mb_substr($user->name, 0, 2)) }}
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-slate-900">{{ $user->name }}</h2>                        </div>
                    </div>

                    <!-- Informasi Detail Data Diri -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <label class="block text-xs font-bold uppercase text-slate-400">Nama Lengkap</label>
                            <div class="w-full rounded-xl border border-sky-100 bg-sky-50/30 px-4 py-3 text-sm text-slate-700 font-medium">
                                {{ $user->name }}
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label class="block text-xs font-bold uppercase text-slate-400">Nomor Pokok Mahasiswa (NPM)</label>
                            <div class="w-full rounded-xl border border-sky-100 bg-sky-50/30 px-4 py-3 text-sm text-slate-700 font-medium">
                                {{ $user->npm ?? '-' }}
                            </div>
                        </div>

                        <div class="space-y-1 md:col-span-2">
                            <label class="block text-xs font-bold uppercase text-slate-400">Alamat Email</label>
                            <div class="w-full rounded-xl border border-sky-100 bg-sky-50/30 px-4 py-3 text-sm text-slate-700 font-medium">
                                {{ $user->email }}
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </main>
    </div>
</body>
</html>