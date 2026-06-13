@extends('layouts.app') {{-- Menunjuk file layout utama --}}

@section('title', 'Kontak Kami | Gen Belajar') {{-- Isi title --}}

@section('content')

{{-- ===================== HERO SECTION ===================== --}}
<section class="relative w-full min-h-[320px] flex items-center">
    {{-- Background image overlay --}}
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
         style="background-image: url('{{ asset('images/forest2.png') }}');">
    </div>
    {{-- Dark overlay --}}
    <div class="absolute inset-0 bg-black/60"></div>

    {{-- Hero content --}}
    <div class="relative z-10 max-w-6xl mx-auto px-6 py-20">
        <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4 leading-tight">
            Hubungi Kami
        </h1>
        <p class="text-base md:text-lg text-gray-200 max-w-md leading-relaxed">
            Jadilah bagian dari gerakan pendidikan dan pemulihan ekosistem
            Indonesia. Sapa kami untuk kolaborasi atau bantuan informasi.
        </p>
    </div>
</section>

{{-- ===================== CONTACT MAIN SECTION ===================== --}}
<section class="bg-gray-50 py-16 px-4">
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-10 items-start">

        {{-- LEFT: Informasi Kontak --}}
        <div>
            <h2 class="text-2xl font-extrabold text-gray-900 mb-2">Informasi Kontak</h2>
            <p class="text-gray-500 text-sm mb-8 leading-relaxed">
                Kami siap mendengar masukan dan pertanyaan Anda mengenai program
                pendidikan dan reboisasi kami.
            </p>

            {{-- Kantor Pusat --}}
            <div class="bg-white rounded-xl px-5 py-4 mb-4 flex items-start gap-4 shadow-sm border border-gray-100">
                <span class="mt-0.5 flex-shrink-0 w-9 h-9 bg-red-50 rounded-full flex items-center justify-center">
                    {{-- Location pin icon --}}
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 2C8.686 2 6 4.686 6 8c0 5.25 6 13 6 13s6-7.75 6-13c0-3.314-2.686-6-6-6z"/>
                        <circle cx="12" cy="8" r="2.25" fill="currentColor" stroke="none"/>
                    </svg>
                </span>
                <div>
                    <p class="text-xs font-bold text-gray-700 mb-0.5">Kantor Pusat</p>
                    <p class="text-sm text-gray-500 leading-snug">
                        Jl. Pendidikan No. 12, Jakarta<br>Selatan, 12150
                    </p>
                </div>
            </div>

            {{-- Email --}}
            <div class="bg-white rounded-xl px-5 py-4 mb-4 flex items-start gap-4 shadow-sm border border-gray-100">
                <span class="mt-0.5 flex-shrink-0 w-9 h-9 bg-red-50 rounded-full flex items-center justify-center">
                    {{-- Envelope icon --}}
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <rect x="2" y="4" width="20" height="16" rx="2" ry="2"/>
                        <polyline points="2,4 12,13 22,4"/>
                    </svg>
                </span>
                <div>
                    <p class="text-xs font-bold text-gray-700 mb-0.5">Email</p>
                    <p class="text-sm text-gray-500">halo@genbelajar.org</p>
                </div>
            </div>

            {{-- Telepon --}}
            <div class="bg-white rounded-xl px-5 py-4 mb-8 flex items-start gap-4 shadow-sm border border-gray-100">
                <span class="mt-0.5 flex-shrink-0 w-9 h-9 bg-red-50 rounded-full flex items-center justify-center">
                    {{-- Phone icon --}}
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 1.27h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.84a16 16 0 0 0 6 6l.38-.38a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
                    </svg>
                </span>
                <div>
                    <p class="text-xs font-bold text-gray-700 mb-0.5">Telepon</p>
                    <p class="text-sm text-gray-500">+62 21 555 0123</p>
                </div>
            </div>

            {{-- Ikuti Kami --}}
            <div>
                <p class="text-sm font-semibold text-gray-700 mb-3">Ikuti Kami</p>
                <div class="flex gap-3">
                    {{-- Share / General Social --}}
                    <a href="#"
                       class="w-10 h-10 rounded-full border-2 border-gray-200 bg-white flex items-center justify-center hover:border-red-500 hover:text-red-600 transition-colors text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/>
                            <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/>
                            <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/>
                        </svg>
                    </a>
                    {{-- Globe / Web --}}
                    <a href="#"
                       class="w-10 h-10 rounded-full border-2 border-gray-200 bg-white flex items-center justify-center hover:border-red-500 hover:text-red-600 transition-colors text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="2" y1="12" x2="22" y2="12"/>
                            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                        </svg>
                    </a>
                    {{-- Video / YouTube --}}
                    <a href="#"
                       class="w-10 h-10 rounded-full border-2 border-gray-200 bg-white flex items-center justify-center hover:border-red-500 hover:text-red-600 transition-colors text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="2" y="7" width="20" height="15" rx="2" ry="2"/>
                            <polyline points="17 2 12 7 7 2"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        {{-- RIGHT: Kirim Pesan Form --}}
        <div class="bg-white rounded-2xl shadow-md border border-gray-100 px-8 py-8">
            <h2 class="text-2xl font-extrabold text-gray-900 mb-7">Kirim Pesan</h2>

            <form action="#" method="POST" id="contact-form" novalidate>
                @csrf

                {{-- Row: Nama + Email --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="nama" class="block text-xs font-semibold text-gray-700 mb-1.5">
                            Nama Lengkap
                        </label>
                        <input
                            type="text"
                            id="nama"
                            name="nama"
                            placeholder="Contoh: Andi Wijaya"
                            value="{{ old('nama') }}"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400
                                   focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition
                                   @error('nama') border-red-500 @enderror"
                        >
                        @error('nama')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-xs font-semibold text-gray-700 mb-1.5">
                            Alamat Email
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="andi@email.com"
                            value="{{ old('email') }}"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400
                                   focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition
                                   @error('email') border-red-500 @enderror"
                        >
                        @error('email')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Subjek --}}
                <div class="mb-4">
                    <label for="subjek" class="block text-xs font-semibold text-gray-700 mb-1.5">
                        Subjek
                    </label>
                    <input
                        type="text"
                        id="subjek"
                        name="subjek"
                        placeholder="Bantuan Donasi / Kerjasama"
                        value="{{ old('subjek') }}"
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400
                               focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition
                               @error('subjek') border-red-500 @enderror"
                    >
                    @error('subjek')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Pesan --}}
                <div class="mb-7">
                    <label for="pesan" class="block text-xs font-semibold text-gray-700 mb-1.5">
                        Pesan Anda
                    </label>
                    <textarea
                        id="pesan"
                        name="pesan"
                        rows="5"
                        placeholder="Tuliskan pesan Anda di sini..."
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400
                               focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition resize-none
                               @error('pesan') border-red-500 @enderror"
                    >{{ old('pesan') }}</textarea>
                    @error('pesan')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <button
                    type="submit"
                    class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 active:bg-red-800 text-white font-semibold
                           text-sm px-7 py-3 rounded-full transition-colors duration-200 shadow-sm">
                    Kirim Sekarang
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <line x1="5" y1="12" x2="19" y2="12"/>
                        <polyline points="12 5 19 12 12 19"/>
                    </svg>
                </button>

                {{-- Success message --}}
                @if(session('success'))
                    <div class="mt-4 text-sm text-green-600 bg-green-50 border border-green-200 rounded-lg px-4 py-3">
                        {{ session('success') }}
                    </div>
                @endif
            </form>
        </div>

    </div>
</section>

{{-- ===================== FAQ CTA SECTION ===================== --}}
<section class="bg-white py-16 px-4 text-center border-t border-gray-100">
    <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 mb-3">
        Punya Pertanyaan Lain?
    </h2>
    <p class="text-gray-500 text-sm max-w-lg mx-auto mb-8 leading-relaxed">
        Kami telah merangkum beberapa pertanyaan yang sering diajukan untuk membantu
        Anda memahami misi kami lebih dalam.
    </p>
    <div class="flex flex-wrap justify-center gap-3">
        <a href="#"
           class="inline-block border-2 border-red-600 text-red-600 font-semibold text-sm px-7 py-2.5 rounded-full
                  hover:bg-red-600 hover:text-white transition-colors duration-200">
            Lihat FAQ
        </a>
        <a href="#"
           class="inline-block border-2 border-gray-300 text-gray-700 font-semibold text-sm px-7 py-2.5 rounded-full
                  hover:border-gray-500 hover:bg-gray-50 transition-colors duration-200">
            Tentang Donasi
        </a>
    </div>
</section>

@endsection

@push('scripts')
{{-- Optional: Konfirmasi submit & validasi client-side ringan --}}
<script>
    document.getElementById('contact-form')?.addEventListener('submit', function (e) {
        const btn = this.querySelector('[type="submit"]');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = `
                <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M21 12a9 9 0 1 1-6.219-8.56" stroke-linecap="round"/>
                </svg>
                Mengirim...
            `;
        }
    });
</script>
@endpush
