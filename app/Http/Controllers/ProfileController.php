<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Profile;

class ProfileController extends Controller
{
    // Menampilkan halaman profil
    public function index()
    {
        $user = Auth::user();
        return view('pages.profile', compact('user'));
    }

    // Memproses update data profil
public function update(Request $request)
{
    $user = Auth::user();

    // 1. Validasi
    $request->validate([
        'username'        => 'required',
        'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // 2. Update Username
    $user->update(['username' => $request->username]);

    // 3. Siapkan data profil
    $data = [
        'full_name'    => $request->full_name,
        'phone_number' => $request->phone_number,
        'address'      => $request->address,
    ];

    // 4. Proses Foto
    if ($request->hasFile('profile_picture')) {
        // Hapus foto lama jika ada
        if ($user->profile && $user->profile->profile_picture_url) {
            Storage::disk('public')->delete($user->profile->profile_picture_url);
        }

        // Simpan foto baru
        $path = $request->file('profile_picture')->store('profiles', 'public');
        $data['profile_picture_url'] = $path;
    }

    // 5. Update atau Create Profil
    $user->profile()->updateOrCreate(
        ['user_id' => $user->user_id],
        $data
    );

    // 6. Respon yang fleksibel
    if ($request->ajax() || $request->wantsJson()) {
        return response()->json(['success' => 'Profil berhasil diperbarui']);
    }

    return back()->with('success', 'Profil berhasil diperbarui!');
}
}
