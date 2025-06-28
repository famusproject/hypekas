<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password harus diisi.'
        ]);

        // Coba login
        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            
            // Redirect ke dashboard UMKM
            return redirect()->intended(route('umkm.dashboard'))
                ->with('success', 'Selamat datang kembali, ' . Auth::user()->name . '!');
        }

        // Login gagal - tampilkan pesan error yang lebih spesifik
        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return back()
                ->withErrors([
                    'email' => 'Email tidak terdaftar dalam sistem.',
                ])
                ->withInput($request->only('email'))
                ->with('error', 'Login gagal! Email tidak ditemukan.');
        } else {
            return back()
                ->withErrors([
                    'password' => 'Password yang Anda masukkan salah.',
                ])
                ->withInput($request->only('email'))
                ->with('error', 'Login gagal! Password salah.');
        }
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('umkm.dashboard')
            ->with('success', 'Akun berhasil dibuat! Selamat datang, ' . $user->name . '!');
    }

    public function logout(Request $request)
    {
        $userName = Auth::user()->name ?? 'User';
        
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')
            ->with('success', 'Anda berhasil logout. Sampai jumpa, ' . $userName . '!');
    }
}
