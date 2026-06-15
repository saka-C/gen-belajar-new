<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Proses login
     */
public function login(Request $request)
{
    $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    // Cari user berdasarkan email
    $user = User::where('email', $request->email)->first();

    // Cek apakah user ada dan password benar
    if (!$user || !Hash::check($request->password, $user->password_hash)) {
        return back()->withErrors([
            'email' => 'Email atau Password salah.',
        ])->withInput();
    }

    // Login manual
    Auth::login($user);

    $request->session()->regenerate();
    

    // Redirect berdasarkan role
    if ($user->role === 'admin') {
        return redirect('/admin');
    }

    if ($user->role === 'volunteer') {
        return redirect('/volunteer');
    }

    return redirect('/');
}

    /**
     * Halaman Register
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Proses Register
     */
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|min:3|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password_hash' => Hash::make($request->password),
            'auth_provider' => 'local',
            'role' => 'donatur',
        ]);

        return redirect('/login')->with('success', 'Akun berhasil dibuat.');
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}