<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return view('mahasiswa.profil', compact('user'));
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'npm' => [
                'required',
                'digits:10',
                Rule::unique('users', 'npm')->ignore($user->id),
            ],

            'email' => [
                'required',
                'string',
                'email:rfc',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.com$/',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'current_password' => [
                'nullable',
                'required_with:password',
                'current_password',
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.max' => 'Nama lengkap maksimal 255 karakter.',

            'npm.required' => 'NPM wajib diisi.',
            'npm.digits' => 'NPM harus terdiri dari tepat 10 angka.',
            'npm.unique' => 'NPM sudah digunakan pengguna lain.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.regex' => 'Email harus menggunakan akhiran .com.',
            'email.max' => 'Email maksimal 255 karakter.',
            'email.unique' => 'Email sudah digunakan pengguna lain.',

            'current_password.required_with' => 'Kata sandi lama wajib diisi.',
            'current_password.current_password' => 'Kata sandi lama tidak sesuai.',

            'password.min' => 'Kata sandi baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $user->name = $validated['name'];
        $user->npm = $validated['npm'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()
            ->route('mahasiswa.profil')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}
