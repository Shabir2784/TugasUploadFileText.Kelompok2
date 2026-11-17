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
            // File KTP wajib gambar (JPG/PNG), maksimal 2MB
            'ktp_path' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Simpan foto KTP di disk 'local' (storage/app/ktp) agar privat dan tidak bisa diakses publik
        $ktpPath = $request->file('ktp_path')->store('ktp', 'local');

        // Buat akun baru dengan default role dan status[cite: 2]
        $user = User::create([
            'name'                => $request->name,
            'email'               => $request->email,
            'password'            => Hash::make($request->password), // Password di-hash[cite: 2]
            'phone'               => $request->phone,
            'ktp_path'            => $ktpPath,
            'role'                => 'customer',
            'verification_status' => 'pending',
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

            // 3. Tampilkan halaman utama sesuai peran (Role-based redirection)
            $userRole = Auth::user()->role;

            if ($userRole === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            }

            // Jika bukan admin, lempar ke halaman pelanggan
            return redirect()->intended(route('pelanggan.home'));
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

        return redirect('/login')->with('success', 'Anda telah berhasil keluar.');
    }
}
