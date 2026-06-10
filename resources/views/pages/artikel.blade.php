@extends('layouts.app') {{-- Menunjuk file layout utama --}}

@section('title', 'Artikel | Gen Belajar') {{-- Isi title --}}

@section('content')
@php
    $dataArtikel = [
        [
            'image'       => 'images/forest1.png',
            'tag'         => 'Reforestasi',
            'date'        => '12 Okt 2024',
            'read_time'   => '8 min baca',
            'title'       => 'Inovasi Kurikulum Hijau: Menanam Masa Depan di Pedalaman Kalimantan',
            'description' => 'Bagaimana integrasi pendidikan ekologi dan aksi penanaman hutan kembali menjadi solusi jangka panjang.',
            'link'        => '/artikel/kurikulum-hijau',
        ],
        [
            'image'       => 'images/sawah.png',
            'tag'         => 'Lingkungan',
            'date'        => '3 Okt 2024',
            'read_time'   => '6 min baca',
            'title'       => 'Reboisasi Mangrove: Upaya Nyata Selamatkan Pesisir',
            'description' => 'Upaya pemulihan pesisir untuk mencegah abrasi dan menjaga keanekaragaman hayati.',
            'link'        => '/artikel/reboisasi-mangrove',
        ],
    ];
@endphp

<x-article-carousel :articles="$dataArtikel" />

@php
    // Definisi data untuk Sidebar & Kategori
    $categories = [
        ['name' => 'Pendidikan', 'count' => 12],
        ['name' => 'Reforestasi', 'count' => 24],
        ['name' => 'Komunitas', 'count' => 8],
        ['name' => 'Teknologi', 'count' => 5],
        ['name' => 'Laporan Transparansi', 'count' => 15],
    ];

    // Simulasi data artikel (untuk ArticleHero dan ArticleCard)
    $articles = [
        ['tag' => 'PENDIDIKAN', 'title' => 'Digitalisasi Pendidikan di SDN 01 Wakanda', 'desc' => 'Meninjau dampak pemberian bantuan tablet dan akses internet satelit...', 'author' => 'Tim GEN Belajar', 'image' => 'path/ke/gambar1.jpg'],
        ['tag' => 'EKOLOGI', 'title' => 'Mangrove Nusantara: Benteng Terakhir', 'desc' => 'Eksplorasi mendalam mengenai rehabilitasi ekosistem pesisir...', 'author' => 'Dr. Andi Pratama', 'image' => 'path/ke/gambar2.jpg'],
    ];
@endphp

<div class="max-w-7xl mx-auto px-4 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-12">

        <div class="lg:col-span-3">
            <h2 class="text-2xl font-bold mb-8">Terbaru</h2>

            <div class="space-y-10">
                </div>
        </div>

        <aside class="space-y-10">
            <div class="bg-gray-50 p-6 rounded-xl">
                <h3 class="font-bold mb-4">Cari Artikel</h3>
                <input type="text" placeholder="Ketik kata kunci..." class="w-full p-3 border rounded-lg">
            </div>

            <div>
                <h3 class="font-bold mb-4">Kategori</h3>
                <ul class="space-y-2">
                    @foreach($categories as $cat)
                        <li class="flex justify-between border-b pb-2">
                            <span>{{ $cat['name'] }}</span>
                            <span class="text-gray-500">{{ $cat['count'] }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="bg-red-50 p-6 rounded-xl">
                <h3 class="font-bold mb-2">Dapatkan Update Mingguan</h3>
                <p class="text-sm text-gray-600 mb-4">Berlangganan untuk berita terbaru.</p>
                <input type="email" placeholder="Email Anda" class="w-full p-3 border rounded-lg mb-2">
                <button class="w-full bg-red-600 text-white p-3 rounded-lg font-bold">Berlangganan</button>
            </div>
        </aside>

    </div>
</div>
@endsection

@push('scripts')
    <script>
        console.log('Script ini khusus berjalan di halaman dashboard saja');
    </script>
@endpush
