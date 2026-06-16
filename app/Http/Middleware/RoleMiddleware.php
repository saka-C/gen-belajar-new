<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Penggunaan di route: middleware('role:admin') atau middleware('role:admin,volunteer')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Jika belum login, arahkan ke halaman login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userRole = Auth::user()->role;

        // Jika role user tidak ada di daftar yang diizinkan
        if (!in_array($userRole, $roles)) {
            // Donatur yang coba akses /admin → balik ke landing page
            if ($userRole === 'donatur') {
                return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
            }

            // Admin/volunteer yang coba akses halaman donatur khusus → ke dashboard
            return redirect('/admin')->with('error', 'Akses ditolak.');
        }

        return $next($request);
    }
}
