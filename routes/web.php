<?php

use App\Http\Controllers\DospemDashboardController;
use App\Http\Controllers\KaprodiDashboardController;
use App\Http\Controllers\PengajuanJudulController;
use App\Http\Controllers\ProfilController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

// =====================================
// HALAMAN UTAMA
// =====================================

Route::redirect('/', '/login');

// =====================================
// REGISTER MAHASISWA
// =====================================

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', function (Request $request) {

    $validated = $request->validate([
        'name'     => 'required|string|max:255',
        'npm'      => 'required|string|max:20|unique:users,npm',
        'email'    => 'required|string|email|max:255|unique:users,email',
        'password' => 'required|string|min:6|confirmed',
    ]);

    User::create([
        'name'     => $validated['name'],
        'npm'      => $validated['npm'],
        'email'    => $validated['email'],
        'password' => Hash::make($validated['password']),
        'role'     => 'mahasiswa',
    ]);

    return back()->with(
        'success',
        'Akun berhasil dibuat! Silakan klik teks login di bawah jika ingin masuk.'
    );
});

// =====================================
// LOGIN
// =====================================

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {

    $credentials = $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {

        $request->session()->regenerate();

        return redirect()->intended('dashboard');
    }

    return back()->withErrors([
        'email' => 'Email atau password yang Anda masukkan salah.',
    ])->onlyInput('email');
});

// =====================================
// REDIRECT DASHBOARD BERDASARKAN ROLE
// =====================================

Route::get('/dashboard', function () {

    return match (Auth::user()->role) {

        'kaprodi' => redirect()->route('kaprodi.dashboard'),

        'dospem' => redirect()->route('dospem.dashboard'),

        'mahasiswa' => redirect()->route('mahasiswa.dashboard'),

        default => abort(403, 'Role tidak dikenali.'),

    };

})->name('dashboard')->middleware('auth');

// =====================================
// DASHBOARD DAN PENGAJUAN MAHASISWA
// =====================================

Route::middleware('auth')
    ->prefix('mahasiswa')
    ->name('mahasiswa.')
    ->group(function () {

        // DASHBOARD MAHASISWA
        Route::get(
            '/dashboard',
            [PengajuanJudulController::class, 'index']
        )->name('dashboard');

        // FORM PENGAJUAN JUDUL
        Route::get(
            '/pengajuan',
            [PengajuanJudulController::class, 'create']
        )->name('pengajuan.create');

        // SIMPAN PENGAJUAN JUDUL
        Route::post(
            '/pengajuan',
            [PengajuanJudulController::class, 'store']
        )->name('pengajuan.store');

        // HALAMAN RIWAYAT PENGAJUAN
        Route::get(
            '/riwayat',
            [PengajuanJudulController::class, 'riwayat']
        )->name('riwayat');

        // HALAMAN DETAIL PENGAJUAN
        Route::get(
            '/pengajuan/{id}',
            [PengajuanJudulController::class, 'show']
        )->name('pengajuan.show');

        // FORM EDIT / REVISI PENGAJUAN
        Route::get(
            '/pengajuan/{id}/edit',
            [PengajuanJudulController::class, 'edit']
        )->name('pengajuan.edit');

        // PROSES UPDATE REVISI PENGAJUAN
        Route::put(
            '/pengajuan/{id}',
            [PengajuanJudulController::class, 'update']
        )->name('pengajuan.update');

        // CETAK / DOWNLOAD SURAT PENGESAHAN PDF
        Route::get(
            '/pengajuan/{id}/surat',
            [PengajuanJudulController::class, 'cetakSurat']
        )->name('pengajuan.surat');

        // HALAMAN PROFIL MAHASISWA
        Route::get(
            '/profil',
            [ProfilController::class, 'index']
        )->name('profil');

        // SIMPAN PERUBAHAN PROFIL MAHASISWA
        Route::put(
            '/profil',
            [ProfilController::class, 'update']
        )->name('profil.update');

    });

// =====================================
// DASHBOARD KAPRODI
// =====================================

Route::middleware('auth')
    ->prefix('kaprodi')
    ->name('kaprodi.')
    ->group(function () {

        // DASHBOARD KAPRODI
        Route::get(
            '/dashboard',
            [KaprodiDashboardController::class, 'index']
        )->name('dashboard');

        // HALAMAN PENGAJUAN MASUK
        Route::get(
            '/pengajuan',
            [KaprodiDashboardController::class, 'pengajuanMasuk']
        )->name('pengajuan.index');

        // HALAMAN RIWAYAT KEPUTUSAN
        Route::get(
            '/riwayat',
            [KaprodiDashboardController::class, 'riwayatKeputusan']
        )->name('riwayat');

        // PROSES PENGESAHAN
        Route::post(
            '/pengajuan/{pengajuan}/sahkan',
            [KaprodiDashboardController::class, 'sahkan']
        )
        ->whereNumber('pengajuan')
        ->name('pengajuan.sahkan');

    });

// =====================================
// DASHBOARD DOSEN PEMBIMBING
// =====================================

Route::middleware('auth')
    ->prefix('dospem')
    ->name('dospem.')
    ->group(function () {

        // DASHBOARD DOSEN PEMBIMBING
        Route::get(
            '/dashboard',
            [DospemDashboardController::class, 'index']
        )->name('dashboard');

        // HALAMAN PENGAJUAN MASUK
        Route::get(
            '/pengajuan',
            [DospemDashboardController::class, 'pengajuanMasuk']
        )->name('pengajuan.index');

        // HALAMAN DETAIL PENGAJUAN
        Route::get(
            '/pengajuan/{id}',
            [DospemDashboardController::class, 'detail']
        )
        ->whereNumber('id')
        ->name('pengajuan.detail');

        // SIMPAN CATATAN DAN KEPUTUSAN REVIEW
        Route::post(
            '/pengajuan/{id}/review',
            [DospemDashboardController::class, 'review']
        )
        ->whereNumber('id')
        ->name('pengajuan.review');

        // LIHAT FILE PROPOSAL PDF
        Route::get(
            '/pengajuan/{id}/proposal',
            [DospemDashboardController::class, 'proposal']
        )
        ->whereNumber('id')
        ->name('pengajuan.proposal');

        // HALAMAN RIWAYAT REVIEW DOSPEM
        Route::get(
            '/riwayat',
            [DospemDashboardController::class, 'riwayatReview']
        )->name('riwayat');

        // HALAMAN MAHASISWA BIMBINGAN
        Route::get(
            '/mahasiswa-bimbingan',
            [DospemDashboardController::class, 'mahasiswaBimbingan']
        )->name('mahasiswa-bimbingan');

        // HALAMAN PROFIL DOSEN PEMBIMBING
        Route::get(
            '/profil',
            [DospemDashboardController::class, 'profil']
        )->name('profil');

    });

// =====================================
// LOGOUT
// =====================================

Route::post('/logout', function (Request $request) {

    Auth::logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect('/login');

})->name('logout');
