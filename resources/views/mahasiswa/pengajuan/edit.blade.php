@php
    $user = auth()->user();
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
        <x-sidebar-mahasiswa />

        <x-topbar-mahasiswa>
            <span>Mahasiswa</span>
            <span class="text-slate-300">›</span>
            <a href="{{ route('mahasiswa.riwayat') }}" class="hover:underline">Riwayat Pengajuan</a>
            <span class="text-slate-300">›</span>
            <span class="font-semibold text-slate-800">Revisi Pengajuan</span>
        </x-topbar-mahasiswa>

        <main class="min-w-0 flex-1 p-8 max-w-4xl mx-auto space-y-6">
            <h1 class="text-2xl font-bold text-slate-900">Form Revisi Pengajuan Judul</h1>
            
            <form action="{{ route('mahasiswa.pengajuan.update', $pengajuan->id) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl border border-sky-100 shadow-sm p-6 space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Judul Skripsi</label>
                    <input type="text" name="judul" value="{{ old('judul', $pengajuan->judul) }}" required class="w-full rounded-xl border border-sky-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Abstrak Penelitian</label>
                    <textarea name="abstrak" rows="5" required class="w-full rounded-xl border border-sky-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">{{ old('abstrak', $pengajuan->abstrak) }}</textarea>
                </div>

                <!-- Pilihan Dosen Pembimbing Dikunci (Read-Only) Saat Revisi -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Dosen Pembimbing 1</label>
                        <input type="text" value="{{ $pengajuan->dospem_1_nama ?? 'Dosen Pembimbing 1' }}" disabled class="w-full rounded-xl border border-slate-200 bg-slate-100 px-4 py-2.5 text-sm text-slate-600 cursor-not-allowed">
                        <input type="hidden" name="dospem_1_id" value="{{ $pengajuan->dospem_1_id }}">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Dosen Pembimbing 2</label>
                        <input type="text" value="{{ $pengajuan->dospem_2_nama ?? 'Dosen Pembimbing 2' }}" disabled class="w-full rounded-xl border border-slate-200 bg-slate-100 px-4 py-2.5 text-sm text-slate-600 cursor-not-allowed">
                        <input type="hidden" name="dospem_2_id" value="{{ $pengajuan->dospem_2_id }}">
                    </div>
                </div>

                <!-- Kotak Pembatas / Card Upload File PDF (Seragam dengan Form Buat Pengajuan) -->
                <div class="p-4 bg-sky-50/50 rounded-2xl border border-sky-100 space-y-3">
                    <label class="block text-xs font-bold uppercase text-slate-600">Berkas Proposal PDF Baru (Opsional)</label>
                    <p class="text-[11px] text-slate-500">Unggah proposal PDF baru jika ingin memperbarui berkas sebelumnya.</p>
                    
                    <div class="flex items-center gap-4 bg-white p-3 rounded-xl border border-sky-200">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-sky-100 text-sky-600 font-bold text-xs">
                            PDF
                        </div>
                        <div class="flex-1 min-w-0">
                            <input type="file" name="file_proposal" accept="application/pdf" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100">
                        </div>
                    </div>
                    <p class="text-[10px] text-slate-400">Biarkan kosong jika tidak ingin mengganti file PDF yang lama.</p>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                    <a href="{{ route('mahasiswa.pengajuan.show', $pengajuan->id) }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl">Batal</a>
                    <button type="submit" class="px-5 py-2.5 bg-sky-600 hover:bg-sky-700 text-white text-xs font-semibold rounded-xl shadow-sm">Simpan & Kirim Revisi</button>
                </div>
            </form>
        </main>
    </div>
</body>
</html>