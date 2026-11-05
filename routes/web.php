<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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
    return "Selamat datang di Dashboard Mahasiswa, " . Auth::user()->name . "!";
})->name('dashboard')->middleware('auth');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// Route::get('/', function () {
//     return view('welcome');
// });
