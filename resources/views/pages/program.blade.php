@extends('layouts.app') {{-- Menunjuk file layout utama --}}

@section('title', 'Program Kami | Gen Belajar') {{-- Isi title --}}

@section('content')
<section class="w-full bg-white py-16 lg:py-24 px-6 sm:px-12 lg:px-20">
    <div class="max-w-7xl mx-auto flex flex-col lg:flex-row items-center gap-12 lg:gap-20">

        <div class="flex-1 flex flex-col items-start space-y-6">

            <div class="flex items-center gap-2 text-[#BA1A1A] font-bold uppercase tracking-widest text-sm">
                <i class="bx bxs-graduation text-lg"></i>
                <span>INISIATIF UTAMA</span>
            </div>

            <h1 class="text-4xl sm:text-5xl font-bold text-[#1A1C1C] leading-[1.1] tracking-tight">
                Membangun Masa Depan, Satu Pohon dan Satu Buku di Satu Waktu.
            </h1>

            <p class="text-gray-600 text-base lg:text-lg leading-relaxed max-w-lg">
                Kami berfokus pada dua pilar utama: reformasi pendidikan berkualitas di daerah terpencil dan pemulihan ekosistem melalui reboisasi hutan nusantara.
            </p>

            <a href="#" class="inline-flex items-center gap-2 bg-[#BA1A1A] text-white px-8 py-4 rounded-full font-semibold hover:bg-red-800 transition-all duration-300 shadow-lg hover:shadow-red-900/20 active:scale-95">
                Dukung Program Kami
                <i class="bx bx-right-arrow-alt text-xl"></i>
            </a>
        </div>

        <div class="w-full lg:w-1/2 relative">
            <div class="relative rounded-[40px] overflow-hidden shadow-2xl">
                <img
                    src="{{ asset('images/header.png') }}"
                    alt="Header Image"
                    class="w-full h-auto object-cover"
                >
            </div>

            <div class="absolute -bottom-6 -left-6 sm:-bottom-10 sm:-left-10 bg-white p-6 rounded-2xl shadow-xl border border-gray-100 max-w-[220px]">
                <div class="flex items-start gap-3">
                    <i class="bx bx-leaf text-green-600 text-2xl"></i>
                    <div>
                        <p class="font-bold text-gray-900">12.5k+</p>
                        <p class="text-xs text-gray-500 leading-tight">Pohon telah ditanam di seluruh wilayah nusantara sepanjang tahun 2023.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<section class="max-w-7xl mx-auto px-6 py-16">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-12 gap-6">
        <div class="md:w-1/2">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Eksplorasi Program Kami</h2>
            <p class="text-gray-600">Dari ruang kelas hingga jantung hutan, saksikan bagaimana kontribusi Anda berubah menjadi aksi nyata yang berdampak langsung bagi generasi mendatang.</p>
        </div>
        <div class="bg-gray-200 p-1 rounded-full flex" id="tab-container">
            <button id="btn-active" class="px-6 py-2 rounded-full font-medium bg-primary text-white shadow-sm" onclick="showTab('active')">Program Aktif</button>
            <button id="btn-finished" class="px-6 py-2 rounded-full font-medium text-gray-600" onclick="showTab('finished')">Program Selesai</button>
        </div>
    </div>

    <div id="content-active" class="space-y-8">
        @forelse ($activeCampaigns as $campaign)
            @php
                $currentAmount = $campaign->collected_amount ?? 0;
                $percentage = $campaign->target_amount > 0
                    ? min(100, round(($currentAmount / $campaign->target_amount) * 100, 1))
                    : 0;
            @endphp

            <x-active-program-card
                :image="$campaign->image"
                category="Program"
                :title="$campaign->title"
                :description="\Illuminate\Support\Str::limit($campaign->description, 140)"
                :percentage="$percentage"
                :target="'Rp ' . number_format($campaign->target_amount, 0, ',', '.')"
                :donors="$campaign->donors_count"
                :href="route('campaigns.show', $campaign->campaign_id)"
            />
        @empty
            <p class="text-gray-600">Belum ada program aktif.</p>
        @endforelse
    </div>

    <div id="content-finished" class="hidden grid grid-cols-1 md:grid-cols-3 gap-8">
        @forelse ($completedCampaigns as $campaign)
            <x-finish-program-card
                :image="$campaign->image"
                category="Program"
                :title="$campaign->title"
                :description="\Illuminate\Support\Str::limit($campaign->description, 90)"
                :report-url="route('campaigns.show', $campaign->campaign_id)"
                :status="$campaign->status"
            />
        @empty
            <p class="text-gray-600">Belum ada program selesai.</p>
        @endforelse
    </div>
</section>

<section class="w-full px-6 py-16">
    <div class="max-w-6xl mx-auto bg-[#BA1A1A] rounded-[40px] py-16 px-8 md:px-20 text-center relative overflow-hidden">
        
        <h2 class="text-3xl md:text-5xl font-bold text-white mb-6 tracking-tight">
            Bersama Kita Bisa Membuat Perubahan Abadi
        </h2>

        <p class="text-white/90 text-base md:text-lg max-w-2xl mx-auto mb-10 leading-relaxed">
            Mulai langkah kecil Anda hari ini. Jadilah bagian dari gerakan yang mengakar kuat untuk masa depan Indonesia.
        </p>

        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <button class="bg-white text-[#BA1A1A] font-semibold py-4 px-8 rounded-full shadow-lg transition-transform hover:scale-105 active:scale-95 cursor-pointer">
                Jadilah Relawan
            </button>
            
            <button class="border-2 border-white text-white font-semibold py-4 px-8 rounded-full transition-all hover:bg-white/10 active:scale-95 cursor-pointer">
                Donasi Rutin
            </button>
        </div>
        
        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16 blur-2xl"></div>
    </div>
</section>

@endsection

@push('scripts')
    <script>
function showTab(tab) {
        const activeBtn = document.getElementById('btn-active');
        const finishedBtn = document.getElementById('btn-finished');
        const activeContent = document.getElementById('content-active');
        const finishedContent = document.getElementById('content-finished');

        if (tab === 'active') {
            activeContent.classList.remove('hidden');
            finishedContent.classList.add('hidden');
            activeBtn.classList.add('bg-primary', 'text-white', 'shadow-sm');
            finishedBtn.classList.remove('bg-primary', 'text-white', 'shadow-sm');
            finishedBtn.classList.add('text-gray-600');
        } else {
            activeContent.classList.add('hidden');
            finishedContent.classList.remove('hidden');
            finishedBtn.classList.add('bg-primary', 'text-white', 'shadow-sm');
            activeBtn.classList.remove('bg-primary', 'text-white', 'shadow-sm');
            activeBtn.classList.add('text-gray-600');
        }
    }
    </script>
@endpush
