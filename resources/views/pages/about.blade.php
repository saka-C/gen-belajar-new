@extends('layouts.app') {{-- Menunjuk file layout utama --}}

@section('title', 'Tentang Kami | Gen Belajar') {{-- Isi title --}}

@section('content')
    <x-hero subtitle="Generasi Belajar" title="Misi Menanam Masa Depan Lewat Pendidikan."
        description="Kami percaya bahwa akar kemajuan sebuah bangsa terletak pada pendidikan yang inklusif dan kelestarian alam yang terjaga. GEN menghubungkan urgensi pendidikan di daerah terpencil dengan restorasi ekosistem nusantara."
        buttonText="Ikut Berdonasi" bgImage="images/sunrise-jungle.jpg" />

    <section class="py-24 bg-base">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center gap-16">

            <div class="relative w-full md:w-1/2">
                <img src="{{ asset('images/1.png') }}" class="rounded-3xl w-full" />
                <div class="absolute -bottom-8 -right-8 bg-primary text-white p-8 rounded-2xl w-48 shadow-xl">
                    <h3 class="text-4xl font-bold">15k+</h3>
                    <p class="text-sm font-semibold mt-2">POHON DITANAM TAHUN INI</p>
                </div>
            </div>

            <div class="w-full md:w-1/2">
                <h2 class="text-4xl font-bold mb-6">Tentang Kami</h2>
                <p class="text-gray-600 mb-6 leading-relaxed">Gerakan Eksplorasi Nusantara (GEN) lahir dari kegelisahan akan kesenjangan
                    fasilitas belajar di pedalaman Indonesia yang seringkali beriringan dengan
                    degradasi lahan hutan di sekitarnya.</p>
                <p class="text-gray-600 mb-6 leading-relaxed">Setiap donasi yang masuk tidak hanya menyediakan bangku dan buku untuk
                    anak-anak di pelosok, tetapi juga mendanai bibit pohon endemik yang
                    ditanam oleh komunitas lokal. Kami menciptakan siklus kebaikan: pendidikan
                    yang memberdayakan manusia, dan hutan yang menjaga kehidupan mereka.</p>

                <div class="flex gap-12 border-t pt-8">
                    <div>
                        <h3 class="text-3xl font-bold text-primary">98%</h3>
                        <p class="text-sm uppercase tracking-wider text-gray-500 font-semibold">Efisiensi Program</p>
                    </div>
                    <div>
                        <h3 class="text-3xl font-bold text-primary">12</h3>
                        <p class="text-sm uppercase tracking-wider text-gray-500 font-semibold">Provinsi Terjangkau</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

<section class="py-16 px-6 bg-[#F3F3F4]">
    <div class="max-w-6xl mx-auto flex flex-col items-center">
        <h2 class="text-4xl font-bold mb-4 text-center">Nilai-Nilai Kami</h2>
        <p class="text-gray-600 mb-12 text-center max-w-lg">Fondasi kami dalam menggerakkan perubahan nyata bagi nusantara.</p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 w-full">

            <div class="bg-white p-8 rounded-3xl shadow-lg flex flex-col items-center text-center h-full">
                <div class="rounded-full bg-red-100 w-20 h-20 flex items-center justify-center mb-6">
                    <i class="bx bx-check-shield text-primary text-4xl"></i>
                </div>
                <h3 class="text-2xl font-semibold mb-3">Trust</h3>
                <p class="text-sm text-gray-600 leading-relaxed flex-grow">
                    Membangun kepercayaan publik melalui audit independen dan kemitraan strategis dengan pemangku kepentingan lokal.
                </p>
            </div>

            <div class="bg-white p-8 rounded-3xl shadow-lg flex flex-col items-center text-center h-full">
                <div class="rounded-full bg-red-100 w-20 h-20 flex items-center justify-center mb-6">
                    <i class="bx bx-eye text-primary text-4xl"></i>
                </div>
                <h3 class="text-2xl font-semibold mb-3">Transparency</h3>
                <p class="text-sm text-gray-600 leading-relaxed flex-grow">
                    Setiap rupiah yang didonasikan dapat dilacak secara real-time melalui platform transparansi digital kami yang terbuka untuk publik.
                </p>
            </div>

            <div class="bg-white p-8 rounded-3xl shadow-lg flex flex-col items-center text-center h-full">
                <div class="rounded-full bg-red-100 w-20 h-20 flex items-center justify-center mb-6">
                    <i class="bx bx-chart-line text-primary text-4xl"></i>
                </div>
                <h3 class="text-2xl font-semibold mb-3">Real Impact</h3>
                <p class="text-sm text-gray-600 leading-relaxed flex-grow">
                    Kami tidak hanya memberikan bantuan jangka pendek, tapi berinvestasi pada perubahan sistemik jangka panjang.
                </p>
            </div>

        </div>
    </div>
</section>

<section class="w-full py-16 px-6 sm:px-12 bg-white">
    <div class="max-w-7xl mx-auto">

        <div class="flex flex-col gap-2 mb-8">
            <h2 class="text-3xl md:text-4xl font-bold text-[#1a1c1c]">Tim Penggerak</h2>
            <p class="text-gray-600 font-inter">Para profesional dan aktivis yang mendedikasikan hidupnya untuk Indonesia.</p>
        </div>

        <div class="w-full h-px bg-[#e7bdb7]/50 mb-12"></div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">

            <x-team-member name="Budi Darmawan" role="KETUA YAYASAN" image="profile.png" />

            <x-team-member name="Sari Lestari" role="KEPALA PROGRAM" image="profile.png" />

            <x-team-member name="Hendra Wijaya" role="KOORDINATOR KONSERVASI" image="profile.png" />

            <x-team-member name="Maria Utami" role="DIREKTUR KEUANGAN" image="profile.png" />

        </div>
    </div>
</section>

<section class="w-full bg-[#BA1A1A] py-20 px-6">
    <div class="max-w-4xl mx-auto flex flex-col items-center text-center space-y-8">

        <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white tracking-tight">
            Siap Berkontribusi untuk Indonesia?
        </h2>

        <p class="text-white/90 text-sm sm:text-base md:text-lg leading-relaxed max-w-2xl font-inter">
            Bergabunglah dengan ribuan orang lainnya yang telah memberikan dampak nyata bagi masa depan pendidikan dan kelestarian alam nusantara.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 w-full justify-center pt-4">
            <a href="/register" class="bg-white text-[#BA1A1A] hover:bg-gray-100 transition-colors px-8 py-4 rounded-full font-semibold text-center shadow-lg">
                Bergabung dengan Gerakan Kami
            </a>

            <a href="/laporan" class="border-2 border-white text-white hover:bg-white/10 transition-colors px-8 py-4 rounded-full font-semibold text-center">
                Baca Laporan Transparansi
            </a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
    <script>
        console.log('Script ini khusus berjalan di halaman dashboard saja');
    </script>
@endpush
