<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Pembeli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session('role') === 'admin') {
            return redirect()->route('dashboard.admin');
        }

        if (session('role') === 'pembeli') {
            return redirect()->route('dashboard.pembeli');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email = $request->email;
        $password = $request->password;

        // 1. Cek tabel admin
        $admin = Admin::where('email', $email)->first();

        if ($admin && $this->passwordCocok($password, $admin->password)) {
            $request->session()->regenerate();

            session([
                'role' => 'admin',
                'user_id' => $admin->getKey(),
                'email' => $admin->email,
            ]);

            return redirect()->route('dashboard.admin');
        }

        // 2. Cek tabel pembeli
        $pembeli = Pembeli::where('email', $email)->first();

        if ($pembeli && $this->passwordCocok($password, $pembeli->password)) {
            $request->session()->regenerate();

            session([
                'role' => 'pembeli',
                'user_id' => $pembeli->getKey(),
                'email' => $pembeli->email,
            ]);

            return redirect()->route('dashboard.pembeli');
        }

        // 3. Jika email atau password salah
        return back()
            ->withInput($request->only('email'))
            ->with('error', 'Password atau email tidak ditemukan');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:pembeli,email|unique:admin,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'email.unique' => 'Email sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak sama.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        $pembeli = Pembeli::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $request->session()->regenerate();

        session([
            'role' => 'pembeli',
            'user_id' => $pembeli->getKey(),
            'email' => $pembeli->email,
        ]);

        return redirect()->route('dashboard.pembeli');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Mendukung password ter-hash maupun teks biasa.
     */
    private function passwordCocok(string $input, string $tersimpan): bool
    {
        if (
            str_starts_with($tersimpan, '$2y$') ||
            str_starts_with($tersimpan, '$argon')
        ) {
            return Hash::check($input, $tersimpan);
        }

        return hash_equals($tersimpan, $input);
    }
}