<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\KaprodiDashboardController;

Route::redirect('/', '/login');

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

Route::get('/dashboard', function () {
    return match (Auth::user()->role) {
        'kaprodi' => redirect()->route('kaprodi.dashboard'),
        'dospem' => redirect()->route('dospem.dashboard'),
        default => "Selamat datang di Dashboard Mahasiswa, " . Auth::user()->name . "!",
    };
})->name('dashboard')->middleware('auth');

Route::middleware('auth')->prefix('kaprodi')->name('kaprodi.')->group(function () {
    Route::get('/dashboard', [KaprodiDashboardController::class, 'index'])->name('dashboard');
    Route::post('/pengajuan/{pengajuan}/sahkan', [KaprodiDashboardController::class, 'sahkan'])
        ->whereNumber('pengajuan')
        ->name('pengajuan.sahkan');
});

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware('auth')->prefix('dospem')->name('dospem.')->group(function () {

    Route::get('/dashboard', function () {

        abort_unless(Auth::user()->role === 'dospem', 403);

        return view('dospem.dashboard');

    })->name('dashboard');

});