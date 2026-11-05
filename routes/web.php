<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\KaprodiDashboardController;

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

    Auth::login($user);

    return redirect()->route('dashboard');
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
// DASHBOARD MAHASISWA
// =====================================

Route::middleware('auth')
    ->prefix('mahasiswa')
    ->name('mahasiswa.')
    ->group(function () {

        Route::get('/dashboard', function () {

            abort_unless(
                Auth::user()->role === 'mahasiswa',
                403
            );

            $statistics = [
                'total' => 0,
                'pending' => 0,
                'revisi' => 0,
                'ditolak' => 0,
            ];

            $pengajuan = collect();

            return view(
                'mahasiswa.dashboard',
                compact('statistics', 'pengajuan')
            );

        })->name('dashboard');

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

        Route::get('/dashboard', function () {

            abort_unless(
                Auth::user()->role === 'dospem',
                403
            );

            return view('dospem.dashboard');

        })->name('dashboard');

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