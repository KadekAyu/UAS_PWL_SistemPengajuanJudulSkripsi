<?php

use App\Http\Controllers\DospemDashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\KaprodiDashboardController;
use App\Http\Controllers\PengajuanJudulController;

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

    $user = User::create([
        'name'     => $validated['name'],
        'npm'      => $validated['npm'],
        'email'    => $validated['email'],
        'password' => Hash::make($validated['password']),
        'role'     => 'mahasiswa',
    ]);

    return back()->with('success', 'Akun berhasil dibuat! Silakan klik teks login di bawah jika ingin masuk.');
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

        'default' => abort(403, 'Role tidak dikenali.'),

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
        Route::get('/dashboard', [PengajuanJudulController::class, 'index'])->name('dashboard');

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

        // HALAMAN PROFIL MAHASISWA (TAMBAHAN BARU)
        Route::get(
            '/profil',
            [PengajuanJudulController::class, 'profil']
        )->name('profil');

    });

// =====================================
// DASHBOARD KAPRODI
// =====================================

Route::middleware('auth')
    ->prefix('kaprodi')
    ->name('kaprodi.')
    ->group(function () {

        Route::get(
            '/dashboard',
            [KaprodiDashboardController::class, 'index']
        )->name('dashboard');

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

        // Dashboard Dosen Pembimbing
        Route::get(
            '/dashboard',
            [DospemDashboardController::class, 'index']
        )->name('dashboard');

        // Halaman Pengajuan Masuk
        Route::get(
            '/pengajuan',
            [DospemDashboardController::class, 'pengajuanMasuk']
        )->name('pengajuan.index');

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