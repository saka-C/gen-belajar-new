<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile; // <--- PENTING: Jangan lupa tambahkan ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    // 1. Proses Pendaftaran (Manual)
    public function register(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        User::create([
            'username'      => $validated['username'],
            'email'         => $validated['email'],
            'password_hash' => Hash::make($validated['password']),
            'auth_provider' => 'local',
            'role'          => 'donatur',
        ]);

        return redirect('/login')->with('success', 'Akun berhasil dibuat! Silakan masuk.');
    }

    // 2. Proses Login (Manual)
    public function login(Request $request)
    {
        // dd($request->all());
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Catatan: Jika password di DB bukan bernama 'password',
        // pastikan model User Anda sudah memanggil getAuthPassword()
        // atau gunakan Hash::check() manual
        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            return $this->redirectByRole(Auth::user());
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    // 3. Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // 4. Redirect ke Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // 5. Callback dari Google
    public function handleGoogleCallback()
    {
        $socialiteUser = Socialite::driver('google')->user();

        // 1. Cari atau buat User
        $user = User::updateOrCreate([
            'email' => $socialiteUser->getEmail(),
        ], [
            'username' => $socialiteUser->getName(),
            'google_id' => $socialiteUser->getId(),
            'auth_provider' => 'google',
        ]);

        // 2. Update/Buat Profile (PENTING: Gunakan Model Profile secara langsung)
        // Ini menghindari bug "duplicate entry" pada relasi
        Profile::updateOrCreate(
            ['user_id' => $user->user_id], // Kriteria cari berdasarkan user_id
            [
                'profile_picture_url' => $socialiteUser->getAvatar(), // Simpan foto dari Google
            ]
        );

        Auth::login($user);

        return $this->redirectByRole($user);
    }

    // Helper: Tentukan tujuan redirect berdasarkan role user
    private function redirectByRole($user)
    {
        return match ($user->role) {
            'admin', 'volunteer' => redirect('/admin')->with('success', 'Selamat datang, ' . $user->username . '!'),
            default              => redirect('/')->with('success', 'Selamat datang kembali, ' . $user->username . '!'),
        };
    }
}
