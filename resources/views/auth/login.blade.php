@extends('layouts.auth')

@section('title', 'Masuk | Gen Belajar')

@section('content')
<div class="flex h-screen w-full overflow-hidden">

    <div class="flex w-full lg:w-1/2 items-center justify-center p-8 lg:p-20">
        <div class="w-full max-w-md">
            <div class="mb-10">
                <h1 class="text-4xl font-bold text-gray-900 mb-3">Selamat Datang</h1>
                <p class="text-gray-500">Silakan masuk ke akun Anda</p>
            </div>

            <form action="#" method="POST" class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Email</label>
                    <input type="email" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-[#BA1A1A] focus:ring-1 focus:ring-[#BA1A1A] outline-none transition" placeholder="nama@email.com">
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="block text-sm font-semibold text-gray-700">Kata Sandi</label>
                        <a href="#" class="text-xs text-[#BA1A1A] font-semibold hover:underline">Lupa Sandi?</a>
                    </div>
                    <input type="password" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-[#BA1A1A] focus:ring-1 focus:ring-[#BA1A1A] outline-none transition" placeholder="••••••••">
                </div>

                <button type="submit" class="w-full bg-[#BA1A1A] text-white py-4 rounded-xl font-bold hover:bg-red-800 transition active:scale-[0.98]">
                    Masuk Sekarang
                </button>

                <div class="relative py-2">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="bg-white px-2 text-gray-500">atau</span>
                    </div>
                </div>

                <button type="button" class="w-full flex items-center justify-center gap-3 py-3 border border-gray-300 rounded-xl font-semibold text-gray-700 hover:bg-gray-50 transition">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg" alt="Google" class="w-5 h-5">
                    Masuk dengan Google
                </button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-8">
                Belum punya akun? <a href="#" class="text-[#BA1A1A] font-bold hover:underline">Daftar sekarang</a>
            </p>
        </div>
    </div>

    <div class="hidden lg:block w-1/2 bg-gray-200 relative">
        <img src="{{ asset('images/hero-bg.jpg') }}" alt="Login Image" class="absolute inset-0 h-full w-full object-cover">
        <div class="absolute inset-0 bg-black/10"></div>
    </div>

</div>
@endsection
