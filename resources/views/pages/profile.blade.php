@extends('layouts.app')

@section('title', 'Profil Saya | Gen Belajar')

@section('content')
<div class="min-h-screen pt-32 pb-12 px-4 md:px-10">
    <div class="max-w-4xl mx-auto">

        {{-- FORM HANYA ADA SATU DI SINI (Bungkus semuanya) --}}
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @csrf @method('PUT')

            {{-- Kolom Kiri: Foto --}}
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 h-fit">
                <div class="flex flex-col items-center text-center relative">
<div class="relative w-32 h-32 mb-4 group">
    <div class="w-full h-full rounded-full overflow-hidden border-4 border-gray-50 shadow-md">

        {{-- Logika untuk menentukan URL foto --}}
        @php
            $url = $user->profile->profile_picture_url ?? null;
            $hasPhoto = !empty($url);

            // Logika: Jika link mengandung 'http', ambil langsung. Jika tidak, tambahkan 'storage/'
            $finalUrl = $hasPhoto
                        ? (str_starts_with($url, 'http') ? $url : asset('storage/' . $url))
                        : '';
        @endphp

        {{-- Gambar: Akan muncul jika ada foto, disembunyikan jika tidak --}}
        <img id="profile-preview"
             src="{{ $finalUrl }}"
             class="w-full h-full object-cover {{ $hasPhoto ? '' : 'hidden' }}">

        {{-- Inisial: Akan muncul jika TIDAK ada foto --}}
        <div id="initial-div"
             class="w-full h-full bg-[#BA1A1A] flex items-center justify-center text-white text-4xl font-bold {{ $hasPhoto ? 'hidden' : '' }}">
            {{ strtoupper(substr($user->username, 0, 1)) }}
        </div>
    </div>

    {{-- Tombol Edit --}}
    <label for="profile_picture" class="absolute bottom-0 right-0 bg-[#BA1A1A] text-white p-2 rounded-full border-4 border-white cursor-pointer shadow-lg hover:bg-red-800 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
        </svg>
    </label>
    <input type="file" id="profile_picture" name="profile_picture" class="hidden" accept="image/*" onchange="previewImage(event)">
</div>

                    <h2 class="font-bold text-xl">{{ $user->username }}</h2>
                    <span class="text-xs bg-red-100 text-[#BA1A1A] px-3 py-1 rounded-full mt-2 uppercase font-bold">{{ $user->role }}</span>
                </div>

                <div class="mt-8 border-t pt-6 space-y-4 text-sm text-left">
                    <p class="text-gray-500">Metode Login: <span class="font-bold text-gray-800 uppercase">{{ $user->auth_provider }}</span></p>
                    <p class="text-gray-500">Email: <span class="font-bold text-gray-800">{{ $user->email }}</span></p>
                </div>
            </div>

            {{-- Kolom Kanan: Informasi Data Diri --}}
            <div class="md:col-span-2 bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                <h2 class="text-xl font-bold mb-6">Informasi Data Diri</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Username</label>
                        <input type="text" name="username" value="{{ old('username', $user->username) }}" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-[#BA1A1A] outline-none transition">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="full_name" value="{{ old('full_name', $user->profile->full_name ?? '') }}" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-[#BA1A1A] outline-none transition">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Telepon</label>
                        <input type="text" name="phone_number" value="{{ old('phone_number', $user->profile->phone_number ?? '') }}" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-[#BA1A1A] outline-none transition">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat</label>
                        <textarea name="address" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-[#BA1A1A] outline-none transition">{{ old('address', $user->profile->address ?? '') }}</textarea>
                    </div>
                    <button type="submit" class="bg-[#BA1A1A] text-white px-8 py-3 rounded-xl font-bold hover:bg-red-800 transition w-full md:w-auto">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form> {{-- Tanda penutup form ada di sini --}}

    </div>
</div>
<div id="status-msg" class="hidden mb-4 p-4 rounded-xl bg-green-100 text-green-700 font-medium fixed bottom-5 right-5 shadow-lg"></div>
@endsection

{{-- Tambahkan div pesan ini di bawah header atau di posisi yang Anda suka --}}

@push('scripts')
<script>
    function previewImage(event) {
        const input = event.target;
        const file = input.files[0];
        const preview = document.getElementById('profile-preview');
        const initial = document.getElementById('initial-div');
        const msg = document.getElementById('status-msg');

        // Dapatkan elemen form pembungkus input
        const form = input.closest('form');

        if (file) {
            // 1. Preview Instan
            msg.textContent = "Sedang mengunggah...";
            msg.classList.remove('hidden', 'bg-red-100', 'text-red-700');
            msg.classList.add('bg-green-100', 'text-green-700');

            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                initial.classList.add('hidden');
            };
            reader.readAsDataURL(file);

            // 2. AJAX Request (Otomatis ambil semua data form)
            const formData = new FormData(form);
            // Tambahkan _method: PUT agar Laravel menganggap ini sebagai Update
            formData.append('_method', 'PUT');

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(async response => {
                const data = await response.json();
                if (!response.ok) {
                    // Jika validasi gagal, lempar error dengan pesan dari Laravel
                    throw new Error(JSON.stringify(data.errors || data.message));
                }
                return data;
            })
            .then(data => {
                msg.textContent = "Foto berhasil diperbarui!";
                setTimeout(() => msg.classList.add('hidden'), 3000);
            })
            .catch(error => {
                // Tampilkan pesan error yang sebenarnya
                console.error('Error:', error);
                msg.textContent = "Error: " + error.message.replace(/["{}]/g, '');
                msg.classList.replace('bg-green-100', 'bg-red-100');
                msg.classList.replace('text-green-700', 'text-red-700');
            });
        }
    }
</script>
@endpush
