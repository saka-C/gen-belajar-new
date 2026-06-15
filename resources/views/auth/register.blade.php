@extends('layouts.auth')

@section('title', 'Daftar | Gen Belajar')

@section('content')
<div class="flex h-screen w-full overflow-hidden">

    <div class="flex w-full lg:w-1/2 items-center justify-center p-8 lg:p-20">
        <div class="w-full max-w-md">
            <div class="mb-10">
                <h1 class="text-4xl font-bold text-gray-900 mb-3">Buat Akun Baru</h1>
                <p class="text-gray-500">Daftar akun Anda</p>
            </div>

<form action="{{ route('register.post') }}" method="POST" class="space-y-5">
    @csrf

    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required
            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-[#BA1A1A] focus:ring-1 focus:ring-[#BA1A1A] outline-none transition"
            placeholder="nama@email.com">
        @error('email') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">Buat Username</label>
        <input type="text" name="username" value="{{ old('username') }}" required
            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-[#BA1A1A] focus:ring-1 focus:ring-[#BA1A1A] outline-none transition"
            placeholder="nama pengguna">
        @error('username') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Kata Sandi --}}
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">Kata Sandi</label>
        <div class="relative">
            <input type="password" name="password" id="password" required
                class="w-full px-4 py-3 pr-12 rounded-xl border border-gray-300 focus:border-[#BA1A1A] focus:ring-1 focus:ring-[#BA1A1A] outline-none transition"
                placeholder="••••••••"
                oninput="checkStrength(this.value)">
            <button type="button" onclick="togglePassword('password', this)"
                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                <svg id="eye-password" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            </button>
        </div>

        {{-- Strength bar --}}
        <div class="flex gap-1 mt-2">
            <div class="h-1 flex-1 rounded-full bg-gray-200 transition-all" id="bar1"></div>
            <div class="h-1 flex-1 rounded-full bg-gray-200 transition-all" id="bar2"></div>
            <div class="h-1 flex-1 rounded-full bg-gray-200 transition-all" id="bar3"></div>
            <div class="h-1 flex-1 rounded-full bg-gray-200 transition-all" id="bar4"></div>
        </div>
        <p class="text-xs mt-1 text-gray-400" id="strength-label">Masukkan kata sandi</p>

        {{-- Requirement pills --}}
        <div class="flex flex-wrap gap-2 mt-2 text-xs" id="pw-reqs">
            <span class="req-pill" id="r-len">8+ karakter</span>
            <span class="req-pill" id="r-up">Huruf besar</span>
            <span class="req-pill" id="r-low">Huruf kecil</span>
            <span class="req-pill" id="r-num">Angka</span>
            <span class="req-pill" id="r-sym">Simbol</span>
        </div>

        @error('password') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Konfirmasi Kata Sandi --}}
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Kata Sandi</label>
        <div class="relative">
            <input type="password" name="password_confirmation" id="password_confirmation" required
                class="w-full px-4 py-3 pr-12 rounded-xl border border-gray-300 focus:border-[#BA1A1A] focus:ring-1 focus:ring-[#BA1A1A] outline-none transition"
                placeholder="••••••••"
                oninput="checkMatch()">
            <button type="button" onclick="togglePassword('password_confirmation', this)"
                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            </button>
        </div>
        <p class="text-xs mt-1 text-red-500 hidden" id="match-error">Kata sandi tidak cocok.</p>
        @error('password_confirmation') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <button type="submit"
        class="w-full bg-[#BA1A1A] text-white py-4 rounded-xl font-bold hover:bg-red-800 transition active:scale-[0.98]">
        Buat Akun
    </button>

    <div class="relative py-2">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-gray-200"></div>
        </div>
        <div class="relative flex justify-center text-sm">
            <span class="bg-white px-2 text-gray-500">atau</span>
        </div>
    </div>

    <a href="{{ route('auth.google') }}"
        class="w-full flex items-center justify-center gap-3 py-3 border border-gray-300 rounded-xl font-semibold text-gray-700 hover:bg-gray-50 transition cursor-pointer">
        <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg" alt="Google" class="w-5 h-5">
        Daftar dengan Google
    </a>
</form>

            <p class="text-center text-sm text-gray-500 mt-8">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-[#BA1A1A] font-bold hover:underline">Masuk sekarang</a>
            </p>
        </div>
    </div>

    <div class="hidden lg:block w-1/2 bg-gray-200 relative">
        <img src="{{ asset('images/hero-bg.jpg') }}" alt="Login Image" class="absolute inset-0 h-full w-full object-cover">
        <div class="absolute inset-0 bg-black/10"></div>
    </div>

</div>

<style>
.req-pill {
    padding: 2px 10px;
    border-radius: 99px;
    background: #f3f4f6;
    color: #9ca3af;
    transition: all 0.2s;
}
.req-pill.met {
    background: #dcfce7;
    color: #15803d;
}
</style>

<script>
function togglePassword(id, btn) {
    const input = document.getElementById(id);
    input.type = input.type === 'password' ? 'text' : 'password';
}

function checkStrength(pw) {
    const rules = [
        { id: 'r-len', test: pw.length >= 8 },
        { id: 'r-up',  test: /[A-Z]/.test(pw) },
        { id: 'r-low', test: /[a-z]/.test(pw) },
        { id: 'r-num', test: /[0-9]/.test(pw) },
        { id: 'r-sym', test: /[^A-Za-z0-9]/.test(pw) },
    ];

    let score = rules.filter(r => {
        const el = document.getElementById(r.id);
        el.classList.toggle('met', r.test);
        return r.test;
    }).length;

    const colors  = ['bg-red-400', 'bg-orange-400', 'bg-yellow-400', 'bg-green-500'];
    const labels  = ['', 'Lemah', 'Sedang', 'Kuat', 'Sangat kuat'];
    const textCol = ['', 'text-red-500', 'text-orange-500', 'text-yellow-600', 'text-green-600'];
    const level   = score <= 1 ? 1 : score <= 2 ? 2 : score <= 4 ? 3 : 4;

    [1,2,3,4].forEach(i => {
        const bar = document.getElementById('bar' + i);
        bar.className = 'h-1 flex-1 rounded-full transition-all ';
        bar.className += i <= level ? colors[level - 1] : 'bg-gray-200';
    });

    const label = document.getElementById('strength-label');
    label.textContent = pw.length ? labels[level] : 'Masukkan kata sandi';
    label.className = 'text-xs mt-1 ' + (pw.length ? textCol[level] : 'text-gray-400');

    checkMatch();
}

function checkMatch() {
    const pw = document.getElementById('password').value;
    const cf = document.getElementById('password_confirmation').value;
    const err = document.getElementById('match-error');
    const inp = document.getElementById('password_confirmation');
    if (!cf) { err.classList.add('hidden'); return; }
    const match = pw === cf;
    err.classList.toggle('hidden', match);
    inp.classList.toggle('border-red-400', !match);
    inp.classList.toggle('border-green-400', match);
}
</script>
@endsection
