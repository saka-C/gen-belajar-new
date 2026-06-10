@extends('layouts.app') {{-- Menunjuk file layout utama --}}

@section('title', 'Gen Belajar') {{-- Isi title --}}

@section('content')
    <x-hero subtitle="Generasi Belajar" title="Jadi Bagian Dari Gerakan Pendidikan Di Indonesia Dan Penanaman Hutan Kembali"
        description="Bersama kami, wujudkan masa depan pendidikan yang lebih baik di pelosok negeri sembari menjaga kelestarian ekosistem alam nusantara untuk generasi mendatang."
        buttonText="Ikut Berdonasi" bgImage="images/hero-bg.jpg" />
    <div class="relative z-20 -mt-16 sm:-mt-20 md:-mt-24 px-4">
    <x-pinned-campaign />
    </div>
    <div class="flex flex-col max-w-7xl w-full mx-auto items-start gap-10 px-6 py-16 md:py-24 relative">

        <div class="flex items-center justify-between w-full border-b border-gray-100 pb-4">
            <div class="relative pb-2">
                <h2 class="text-[#1a1c1c] text-2xl sm:text-[32px] font-semibold tracking-tight">
                    Kampanye Aktif
                </h2>
                <div class="absolute bottom-0 left-0 w-16 h-1 bg-primary rounded-full"></div>
            </div>

            <a href="/program"
                class="group inline-flex items-center gap-2 text-primary-hover font-inter text-sm sm:text-[16px] font-semibold text-primary transition-all">
                <span class="group-hover:underline">Lihat Semua Program</span>
                <i
                    class="bx bx-arrow-right-stroke bx-remove-padding text-2xl group-hover:-rotate-45 transition-transform"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8 w-full">

            {{-- Card 1: Lingkungan --}}
            <x-campaign-card-home image="images/mangrove.png" category="Lingkungan"
                title="Penghijauan Kembali Hutan Mangrove Pantai" percentage="65" target="Rp150jt" />

            {{-- Card 2: Pendidikan --}}
            <x-campaign-card-home image="images/books.png" category="Pendidikan" title="1000 Buku Untuk Anak Pelosok Papua"
                percentage="40" target="Rp45jt" />

            {{-- Card 3: Kesehatan --}}
            <x-campaign-card-home image="images/water.png" category="Kesehatan"
                title="Penyediaan Air Bersih Desa Kekeringan NTT" percentage="82" target="Rp85jt" />

        </div>
    </div>

    <div class="w-full bg-[#f9f9f9]">
        <div
            class="flex flex-col lg:flex-row max-w-7xl w-full mx-auto items-center gap-12 lg:gap-16 px-6 sm:px-12 py-16 md:py-24 relative">

            <div class="w-full lg:w-1/2 flex items-center justify-center relative">
                <img src="{{ asset('images/about.png') }}" alt="Tentang Gerakan Eksplorasi Nusantara"
                    class="w-full h-full object-cover rounded-[28px]" />
            </div>

            <div class="w-full lg:w-1/2 flex flex-col items-start gap-6 relative z-10">

                <div class="w-full">
                    <h2 class="text-[#1a1c1c] text-3xl sm:text-4xl md:text-5xl font-semibold tracking-tight leading-tight">
                        Tentang Kami
                    </h2>
                </div>

                <div class="w-full font-inter">
                    <p class="text-slate-500 text-[16px] leading-relaxed font-normal">
                        Gerakan Eksplorasi Nusantara (GEN) adalah inisiatif nirlaba yang lahir dari urgensi mendalam
                        terhadap dua pilar utama masa depan bangsa: Pendidikan dan Kelestarian Alam. Kami percaya bahwa
                        untuk menciptakan generasi yang tangguh, kita perlu memberikan akses pendidikan berkualitas
                        sekaligus lingkungan hidup yang sehat.
                    </p>
                </div>

                <div class="w-full font-inter">
                    <p class="text-slate-500 text-[16px] leading-relaxed font-normal">
                        Sejak 2020, kami telah menghubungkan ribuan donatur dengan sekolah-sekolah di pelosok Indonesia,
                        sambil secara aktif melakukan penanaman kembali hutan yang gundul. Setiap rupiah yang Anda berikan
                        adalah investasi bagi otak dan paru-paru Indonesia.
                    </p>
                </div>

                <div class="w-full pt-2 font-inter">
                    <a href="/misi"
                        class="inline-flex items-center justify-center px-10 py-3.5 border-2 border-primary rounded-full text-primary foslate-500 text-[16px]r tracking-wide hover:bg-primary hover:text-white transition-all transform active:scale-95 cursor-pointer">
                        Pelajari Misi Kami
                    </a>
                </div>

            </div>

        </div>
    </div>

@endsection

@push('scripts')
    <script>
        console.log('Script ini khusus berjalan di halaman dashboard saja');
    </script>
@endpush
