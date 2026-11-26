<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengajuan - SISTA</title>

    <script src="https://unpkg.com/lucide@0.468.0/dist/umd/lucide.min.js"></script>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif

    @php
        $proposalPath = $pengajuan->file_proposal ?? null;
        $proposalAda = $proposalPath && \Illuminate\Support\Facades\Storage::disk('public')->exists($proposalPath);

        $proposalNama = $proposalAda
            ? preg_replace('/^\d+_/', '', basename($proposalPath))
            : null;

        $proposalUkuran = $proposalAda
            ? \Illuminate\Support\Facades\Storage::disk('public')->size($proposalPath)
            : 0;

        if ($proposalUkuran >= 1048576) {
            $proposalUkuranText = number_format($proposalUkuran / 1048576, 2) . ' MB';
        } else {
            $proposalUkuranText = number_format($proposalUkuran / 1024, 2) . ' KB';
        }

        $riwayatCatatan = $catatanRevisi ?? collect();
        $bolehReview = trim((string) $pengajuan->status) === 'Menunggu Review Dospem';
    @endphp
</head>

<body class="min-h-screen bg-[#E8F5FF] text-slate-800">

    <!-- NOTIFIKASI CUSTOM -->
    <div id="customToast" class="custom-toast" role="alert" aria-live="assertive">
        <div class="toast-icon">
            <i data-lucide="alert-circle" class="h-5 w-5"></i>
        </div>

        <div class="min-w-0">
            <p class="toast-title" id="toastTitle">Catatan Review belum diisi</p>
            <p class="toast-message" id="toastMessage">
                Silakan isi Catatan Review terlebih dahulu.
            </p>
        </div>

        <button type="button" class="toast-close" onclick="hideToast()">
            <i data-lucide="x" class="h-4 w-4"></i>
        </button>
    </div>

    <div class="min-h-screen md:flex">

        <x-sidebar-dospem />

        <main class="min-w-0 flex-1">

            <x-topbar-dospem>
                <div class="flex items-center gap-2 text-xs font-medium text-slate-500">
                    <i data-lucide="house" class="h-4 w-4"></i>
                    <span>Dosen Pembimbing</span>
                    <i data-lucide="chevron-right" class="h-3 w-3"></i>

                    <a href="{{ route('dospem.pengajuan.index') }}" class="hover:text-sky-600">
                        Pengajuan Masuk
                    </a>

                    <i data-lucide="chevron-right" class="h-3 w-3"></i>
                    <span class="font-semibold text-slate-800">Detail</span>
                </div>
            </x-topbar-dospem>

            <div class="detail-content">

                <!-- HEADER -->
                <div class="detail-header mb-4">
                    <div class="flex flex-wrap items-center gap-3">
                        <h1 class="text-xl font-bold text-slate-800">
                            Detail Pengajuan
                        </h1>

                        <span class="inline-flex items-center gap-1.5 rounded-full border border-amber-200 bg-amber-50 px-3 py-1 text-[10px] font-semibold text-amber-700">
                            <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                            {{ ucfirst($pengajuan->status) }}
                        </span>
                    </div>

                    <p class="mt-1 text-xs text-slate-500">
                        Periksa informasi pengajuan dan berikan hasil review.
                    </p>
                </div>

                <!-- ALERT LARAVEL -->
                @if (session('success'))
                    <div class="mb-3 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-2.5 text-xs text-emerald-700">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-3 rounded-lg border border-rose-200 bg-rose-50 px-4 py-2.5 text-xs text-rose-700">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-3 rounded-lg border border-rose-200 bg-rose-50 px-4 py-2.5 text-xs text-rose-700">
                        <p class="mb-1 font-semibold">Periksa kembali data review:</p>
                        <ul class="list-inside list-disc">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="detail-grid">

                    <!-- KOLOM KIRI -->
                    <div>

                        <!-- IDENTITAS MAHASISWA -->
                        <section class="detail-card">

                            <div class="section-heading">
                                <div class="section-icon">
                                    <i data-lucide="user-round" class="h-4 w-4"></i>
                                </div>

                                <h2 class="section-title">Identitas Mahasiswa</h2>
                            </div>

                            <div class="identity-grid">

                                <div class="identity-item">
                                    <p class="info-label">Nama Mahasiswa</p>
                                    <p class="info-value">
                                        {{ $pengajuan->nama_mahasiswa ?? '-' }}
                                    </p>
                                </div>

                                <div class="identity-item">
                                    <p class="info-label">NPM</p>
                                    <p class="info-value">
                                        {{ $pengajuan->npm ?? '-' }}
                                    </p>
                                </div>

                                <div class="identity-item">
                                    <p class="info-label">Email</p>
                                    <p class="info-value text-[11px] font-medium">
                                        {{ $pengajuan->email ?? '-' }}
                                    </p>
                                </div>

                            </div>
                        </section>

                        <!-- INFORMASI SKRIPSI -->
                        <section class="detail-card skripsi-card">

                            <div class="section-heading">
                                <div class="section-icon">
                                    <i data-lucide="book-open" class="h-4 w-4"></i>
                                </div>

                                <h2 class="section-title">Informasi Skripsi</h2>
                            </div>

                            <div>
                                <p class="info-label">Judul Skripsi</p>
                                <p class="skripsi-title font-semibold text-slate-800">
                                    {{ $pengajuan->judul }}
                                </p>
                            </div>

                            <div class="skripsi-divider border-t border-slate-100">
                                <p class="info-label">Abstrak / Latar Belakang</p>
                                <p class="skripsi-abstract whitespace-pre-line break-words text-slate-600">{{ $pengajuan->abstrak }}</p>
                            </div>

                            <div class="skripsi-divider flex items-center justify-between border-t border-slate-100">
                                <p class="info-label mb-0">Tanggal Pengajuan</p>
                                <p class="text-xs font-semibold text-slate-700">
                                    {{ \Carbon\Carbon::parse($pengajuan->created_at)->format('d/m/Y') }}
                                </p>
                            </div>

                        </section>

                        <!-- DOSEN PEMBIMBING -->
                        <section class="detail-card">

                            <div class="section-heading">
                                <div class="section-icon">
                                    <i data-lucide="users" class="h-4 w-4"></i>
                                </div>

                                <h2 class="section-title">Dosen Pembimbing</h2>
                            </div>

                            <div class="grid grid-cols-1 gap-2 sm:grid-cols-2">

                                <div class="rounded-lg border border-sky-100 bg-sky-50/60 p-3">
                                    <p class="info-label">Dosen Pembimbing 1</p>
                                    <p class="info-value">
                                        {{ $pengajuan->nama_dospem_1 ?? '-' }}
                                    </p>
                                </div>

                                <div class="rounded-lg border border-sky-100 bg-sky-50/60 p-3">
                                    <p class="info-label">Dosen Pembimbing 2</p>
                                    <p class="info-value">
                                        {{ $pengajuan->nama_dospem_2 ?? '-' }}
                                    </p>
                                </div>

                            </div>
                        </section>

                        <!-- RIWAYAT CATATAN REVISI -->
                        <section class="detail-card">

                            <div class="section-heading">
                                <div class="section-icon">
                                    <i data-lucide="history" class="h-4 w-4"></i>
                                </div>

                                <h2 class="section-title">Riwayat Catatan Revisi</h2>
                            </div>

                            @if (count($riwayatCatatan) > 0)
                                <div class="space-y-2.5">
                                    @foreach ($riwayatCatatan as $item)
                                        <div class="rounded-lg border border-slate-100 bg-slate-50/80 p-3">
                                            <div class="flex items-center justify-between gap-2 text-[11px]">
                                                <span class="font-semibold text-slate-700">
                                                    {{ $item->nama_dosen ?? ($item->dosen_nama ?? 'Dosen') }}
                                                </span>
                                                @if (!empty($item->created_at))
                                                    <span class="text-[10px] text-slate-400">
                                                        {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i') }}
                                                    </span>
                                                @endif
                                            </div>
                                            <p class="mt-1 whitespace-pre-line break-words text-xs text-slate-600">
                                                {{ $item->catatan ?? ($item->catatan_revisi ?? ($item->komentar ?? '-')) }}
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-xs text-slate-400">
                                    Belum ada catatan revisi untuk pengajuan ini.
                                </p>
                            @endif

                        </section>

                    </div>

                    <!-- KOLOM KANAN -->
                    <div>

                        <!-- PROPOSAL -->
                        <section class="detail-card">

                            <div class="section-heading">
                                <div class="section-icon">
                                    <i data-lucide="file-text" class="h-4 w-4"></i>
                                </div>

                                <h2 class="section-title">Proposal Skripsi</h2>
                            </div>

                            @if ($proposalAda)

                                <div class="proposal-detail">

                                    <!-- IKON PDF SAMA SEPERTI MAHASISWA -->
                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-rose-50">
                                        <svg class="h-6 w-6 text-rose-500"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.7"
                                            stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                            <path d="M14 2v6h6"/>
                                            <path d="M8 13h2a1.5 1.5 0 0 1 0 3H8v-3z"/>
                                            <path d="M14 16v-3h1a1.5 1.5 0 0 1 0 3h-1z"/>
                                            <path d="M19 13h-2v3"/>
                                            <path d="M17 14.5h1.5"/>
                                        </svg>
                                    </div>

                                    <div class="min-w-0 flex-1">
                                        <p class="proposal-filename" title="{{ $proposalNama }}">
                                            {{ $proposalNama }}
                                        </p>

                                        <div class="proposal-meta">
                                            <span>PDF</span>
                                            <span>{{ $proposalUkuranText }}</span>
                                        </div>
                                    </div>

                                    <a href="{{ route('dospem.pengajuan.proposal', $pengajuan->id) }}"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       class="inline-flex shrink-0 items-center gap-1.5 rounded-lg bg-sky-500 px-3 py-2 text-[10px] font-semibold text-white transition hover:bg-sky-600">
                                        <i data-lucide="eye" class="h-3.5 w-3.5"></i>
                                        Lihat PDF
                                    </a>

                                </div>

                            @else

                                <div class="flex items-center gap-3 rounded-lg border border-amber-200 bg-amber-50 p-3">
                                    <i data-lucide="file-warning" class="h-5 w-5 text-amber-600"></i>
                                    <p class="text-xs text-amber-700">
                                        File proposal belum tersedia.
                                    </p>
                                </div>

                            @endif

                        </section>

                        <!-- REVIEW -->
                        <section class="detail-card review-card">

                            <div class="section-heading">
                                <div class="section-icon">
                                    <i data-lucide="clipboard-check" class="h-4 w-4"></i>
                                </div>

                                <div>
                                    <h2 class="section-title">Review Pengajuan</h2>
                                    <p class="mt-0.5 text-[10px] text-slate-500">
                                        {{ $bolehReview ? 'Berikan catatan dan keputusan untuk mahasiswa.' : 'Keputusan review pengajuan ini telah tercatat.' }}
                                    </p>
                                </div>
                            </div>

                            @if ($bolehReview)
                            <form id="reviewForm"
                                  action="{{ route('dospem.pengajuan.review', $pengajuan->id) }}"
                                  method="POST">
                                @csrf

                                <div>
                                    <label for="catatan" class="mb-1.5 block text-xs font-semibold text-slate-700">
                                        Catatan Review
                                    </label>

                                    <textarea
                                        id="catatan"
                                        name="catatan"
                                        rows="4"
                                        placeholder="Tuliskan catatan atau masukan untuk mahasiswa..."
                                        class="review-textarea"
                                    >{{ old('catatan') }}</textarea>

                                    @error('catatan')
                                        <p class="mt-1 text-[11px] text-rose-600">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="decision-area">

                                    <p class="mb-2 text-xs font-semibold text-slate-700">
                                        Keputusan Review
                                    </p>

                                    <div class="decision-grid">

                                        <button type="submit"
                                                name="status"
                                                value="ACC"
                                                class="decision-button border border-emerald-200 bg-emerald-50 text-emerald-700 hover:bg-emerald-100">
                                            <i data-lucide="check-circle" class="h-4 w-4"></i>
                                            <span>ACC Pengajuan</span>
                                        </button>

                                        <button type="submit"
                                                name="status"
                                                value="Revisi"
                                                class="decision-button border border-amber-200 bg-amber-50 text-amber-700 hover:bg-amber-100">
                                            <i data-lucide="message-square-text" class="h-4 w-4"></i>
                                            <span>Minta Revisi</span>
                                        </button>

                                        <button type="submit"
                                                name="status"
                                                value="Ditolak"
                                                class="decision-button border border-rose-200 bg-rose-50 text-rose-700 hover:bg-rose-100">
                                            <i data-lucide="x-circle" class="h-4 w-4"></i>
                                            <span>Tolak Pengajuan</span>
                                        </button>

                                    </div>
                                </div>

                            </form>
                            @else
                                <div class="rounded-xl border border-sky-100 bg-sky-50 p-5 text-center">
                                    <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-white text-sky-600">
                                        <i data-lucide="check-circle-2" class="h-6 w-6"></i>
                                    </div>
                                    <h3 class="text-sm font-bold text-slate-800">Review Pengajuan Telah Selesai</h3>
                                    <p class="mt-2 text-xs leading-6 text-slate-600">
                                        Pengajuan ini telah mendapatkan keputusan. Riwayat catatan tetap dapat dilihat di sebelah kiri.
                                    </p>
                                    <div class="mt-3 inline-flex rounded-full bg-white px-4 py-2 text-xs font-semibold text-sky-700">
                                        Status: {{ $pengajuan->status }}
                                    </div>
                                    <p class="mt-3 text-[11px] text-slate-500">
                                        Review baru tersedia jika pengajuan kembali berstatus Menunggu Review Dospem.
                                    </p>
                                </div>
                            @endif
                        </section>

                    </div>

                </div>

            </div>
        </main>
    </div>

    <script>
        lucide.createIcons();

        let toastTimer;

        function showToast(title, message) {
            const toast = document.getElementById('customToast');

            document.getElementById('toastTitle').textContent = title;
            document.getElementById('toastMessage').textContent = message;

            toast.classList.add('show');

            clearTimeout(toastTimer);

            toastTimer = setTimeout(() => {
                hideToast();
            }, 3500);
        }

        function hideToast() {
            document.getElementById('customToast').classList.remove('show');
        }

        const reviewForm = document.getElementById('reviewForm');
        const catatanInput = document.getElementById('catatan');

        reviewForm?.addEventListener('submit', function(event) {
            const clickedButton = event.submitter;
            const status = clickedButton ? clickedButton.value : '';
            const catatan = catatanInput.value.trim();

            if ((status === 'Revisi' || status === 'Ditolak') && catatan === '') {
                event.preventDefault();

                if (status === 'Revisi') {
                    showToast(
                        'Catatan revisi belum diisi',
                        'Silakan isi Catatan Review terlebih dahulu sebelum meminta revisi.'
                    );
                } else {
                    showToast(
                        'Alasan penolakan belum diisi',
                        'Silakan isi Catatan Review terlebih dahulu sebelum menolak pengajuan.'
                    );
                }

                catatanInput.focus();
                catatanInput.style.borderColor = '#f43f5e';

                setTimeout(() => {
                    catatanInput.style.borderColor = '';
                }, 2500);
            }
        });
    </script>

</body>
</html>