<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validasi input sesuai kebutuhan sistem
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone'    => 'nullable|string|max:20',
            'ktp_path' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Simpan foto KTP di disk 'local' (storage/app/ktp) agar privat dan tidak bisa diakses publik
        $ktpPath = $request->file('ktp_path')->store('ktp', 'local');

        // Buat akun baru dengan default role dan status
        $user = User::create([
            'nama'              => $request->name,
            'email'             => $request->email,
            'kata_sandi'        => Hash::make($request->password),
            'nomor_telepon'     => $request->phone,
            'berkas_ktp'        => $ktpPath,
            'peran'             => 'pelanggan',
            'status_verifikasi' => 'menunggu',
        ]);

        // Login otomatis (opsional) atau arahkan ke halaman pemberitahuan
        Auth::login($user);

        return redirect()->route('home')->with('success', 'Registrasi berhasil! Menunggu verifikasi KTP oleh Admin.');
    }
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showLinkRequestForm()
    {
        return view('auth.forget-password');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.reset-password')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function login(Request $request)
    {
        // 1. Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Verifikasi kredensial ke database
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return $request->user()->peran === 'admin'
                ? redirect()->route('admin.dashboard')
                : redirect()->intended(route('home'));
        }

        // 4. Pesan error jika kredensial tidak valid
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda telah berhasil keluar.');
    }
}
