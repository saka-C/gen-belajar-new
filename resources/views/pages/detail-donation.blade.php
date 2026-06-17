@extends('layouts.app')

@section('title', $campaign->title . ' - Gen Belajar')

@section('content')

@php
    $imageSrc = $campaign->image ?: 'images/elementary.jpg';

    if (! \Illuminate\Support\Str::startsWith($imageSrc, ['http://', 'https://', '/'])) {
        if (! \Illuminate\Support\Str::startsWith($imageSrc, ['images/', 'storage/'])) {
            $imageSrc = 'storage/' . $imageSrc;
        }

        $imageSrc = asset($imageSrc);
    }

    $totalAllocated = $campaign->allocations()->sum('amount_used') ?? 0;
    $currentAmount = ($campaign->collected_amount ?? 0) - $totalAllocated;
    if ($currentAmount < 0) {
        $currentAmount = 0;
    }
    $targetAmount = $campaign->target_amount ?? 0;
    $percentage = $targetAmount > 0 ? min(100, round(($currentAmount / $targetAmount) * 100, 1)) : 0;
    
    $statusText = match ($campaign->status) {
        'telah_disalurkan' => 'Telah Disalurkan',
        'completed', 'complete' => 'Selesai',
        default => 'Aktif',
    };
@endphp

{{-- ===================== HERO SECTION ===================== --}}
<div class="bg-gray-50 pt-8 px-4 sm:px-6 lg:px-8 mb-20">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mt-20">

            {{-- ===================== LEFT COLUMN: CONTENT ===================== --}}
            <div class="lg:col-span-8 ">

                {{-- Hero Image --}}
                <div class="relative w-full h-64 sm:h-80 lg:h-96 bg-gradient-to-br from-green-100 to-green-300 rounded-3xl overflow-hidden shadow-md group">
                    {{-- Image placeholder dengan gradient (ganti dengan img tag jika ada gambar) --}}
                    <img
                        src="{{ $imageSrc }}"
                        alt="{{ $campaign->title }}"
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                    >
                    {{-- Overlay badge kategori --}}
                    <div class="absolute top-4 left-4">
                        <span class="inline-flex items-center gap-2 bg-red-600 text-white text-xs font-bold px-4 py-2 rounded-full shadow-lg">
                            <span class="w-2 h-2 bg-white rounded-full"></span>
                            Program
                        </span>
                    </div>
                </div>

                {{-- Program Header --}}
                <div class="mt-8">
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-gray-900 leading-tight mb-3">
                        {{ $campaign->title }}
                    </h1>
                    <p class="text-gray-600 text-base sm:text-lg">
                        Inisiatif oleh
                        <span class="font-semibold text-gray-900">Gen Belajar Foundation</span>
                    </p>
                </div>

                {{-- Progress Bar Section --}}
                <div class="mt-8 bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-gray-100">
                    {{-- Progress metrics --}}
                    <div class="grid grid-cols-3 gap-4 mb-6">
                        <div>
                            <p class="text-xs font-semibold text-gray-600 uppercase mb-1">Terkumpul</p>
                            <p class="text-2xl sm:text-3xl font-extrabold text-gray-900">Rp {{ number_format($currentAmount, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-600 uppercase mb-1">Target</p>
                            <p class="text-2xl sm:text-3xl font-extrabold text-gray-900">Rp {{ number_format($targetAmount, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-600 uppercase mb-1">Status</p>
                            <p class="text-2xl sm:text-3xl font-extrabold text-red-600">{{ $statusText }}</p>
                        </div>
                    </div>

                    {{-- Progress bar --}}
                    <div class="mb-4">
                        <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden shadow-inner">
                            <div class="bg-gradient-to-r from-red-500 to-red-600 h-full rounded-full transition-all duration-700 ease-out"
                                 style="width: {{ $percentage }}%;">
                            </div>
                        </div>
                        <p class="text-right text-xs font-semibold text-gray-600 mt-2">{{ $percentage }}% Terkumpul</p>
                    </div>

                    {{-- Donors count --}}
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                        </svg>
                        <span>
                            <span class="font-semibold text-gray-900">{{ number_format($campaign->donors_count, 0, ',', '.') }}</span> orang telah berdonasi
                        </span>
                    </div>
                </div>

                {{-- Tabs Navigation --}}
                <div class="mt-8">
                    <div class="flex gap-0 border-b border-gray-200">
                        <button
                            class="tab-button active px-6 py-4 text-sm sm:text-[16px] font-semibold text-gray-900 border-b-2 border-red-600 cursor-pointer transition-colors"
                            data-tab="deskripsi">
                            Deskripsi
                        </button>
                        <button
                            class="tab-button px-6 py-4 text-sm sm:text-[16px] font-semibold text-gray-600 border-b-2 border-transparent hover:text-gray-900 cursor-pointer transition-colors"
                            data-tab="kabar">
                            Kabar Terbaru
                        </button>
                        <button
                            class="tab-button px-6 py-4 text-sm sm:text-[16px] font-semibold text-gray-600 border-b-2 border-transparent hover:text-gray-900 cursor-pointer transition-colors"
                            data-tab="donatur">
                            Donatur
                        </button>
                    </div>
                </div>

                {{-- Tab Content: Deskripsi --}}
                <div id="tab-deskripsi" class="tab-content active mt-8 bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-gray-100">
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-4">Tentang Program Ini</h3>
                    <div class="space-y-6 text-gray-600 leading-relaxed">
                        <p>{{ $campaign->description }}</p>

                        {{-- <div class="bg-gray-50 rounded-xl p-4 sm:p-6 border border-gray-200 my-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Alokasi Dana</h4>
                            <div class="space-y-4">
                                <div class="flex items-start gap-4">
                                    <div class="w-1/3">
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-green-500 h-2 rounded-full" style="width: 45%;"></div>
                                        </div>
                                        <p class="text-xs text-gray-600 font-semibold mt-1">45%</p>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-semibold text-gray-900">Pembelian & Penanaman Pohon</p>
                                        <p class="text-xs text-gray-500">Rp 90 Juta</p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-4">
                                    <div class="w-1/3">
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-blue-500 h-2 rounded-full" style="width: 30%;"></div>
                                        </div>
                                        <p class="text-xs text-gray-600 font-semibold mt-1">30%</p>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-semibold text-gray-900">Edukasi & Pelatihan Masyarakat</p>
                                        <p class="text-xs text-gray-500">Rp 60 Juta</p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-4">
                                    <div class="w-1/3">
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-purple-500 h-2 rounded-full" style="width: 15%;"></div>
                                        </div>
                                        <p class="text-xs text-gray-600 font-semibold mt-1">15%</p>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-semibold text-gray-900">Pemantauan & Evaluasi Program</p>
                                        <p class="text-xs text-gray-500">Rp 30 Juta</p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-4">
                                    <div class="w-1/3">
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-yellow-500 h-2 rounded-full" style="width: 10%;"></div>
                                        </div>
                                        <p class="text-xs text-gray-600 font-semibold mt-1">10%</p>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-semibold text-gray-900">Operasional & Administrasi</p>
                                        <p class="text-xs text-gray-500">Rp 20 Juta</p>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

                        <p>Dengan transparan penuh, kami melaporkan setiap penggunaan dana kepada donatur dan publik.</p>
                    </div>
                </div>

                {{-- Tab Content: Kabar Terbaru --}}
                <div id="tab-kabar" class="tab-content hidden mt-8">
                    <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-gray-100">
                        <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-6">Kabar Terbaru</h3>
                        <div class="space-y-6">
                            {{-- News item 1 --}}
                            <div class="border-l-4 border-red-500 pl-4 pb-6 border-b border-gray-200">
                                <p class="text-xs font-semibold text-red-600 uppercase mb-1">15 Juni 2024</p>
                                <h4 class="text-lg font-semibold text-gray-900 mb-2">Penanaman Pohon Fase 2 Dimulai!</h4>
                                <p class="text-gray-600 text-sm leading-relaxed">
                                    Kami telah berhasil menanam 25,000 pohon di fase pertama. Kini, kami melanjutkan dengan fase 2
                                    di wilayah Kalimantan dengan target 30,000 pohon lagi. Terima kasih atas dukungan Anda!
                                </p>
                            </div>

                            {{-- News item 2 --}}
                            <div class="border-l-4 border-red-500 pl-4 pb-6 border-b border-gray-200">
                                <p class="text-xs font-semibold text-red-600 uppercase mb-1">08 Juni 2024</p>
                                <h4 class="text-lg font-semibold text-gray-900 mb-2">Kemitraan dengan Universitas Lokal</h4>
                                <p class="text-gray-600 text-sm leading-relaxed">
                                    Kami resmi menjalin kemitraan dengan 5 universitas di Indonesia untuk melibatkan mahasiswa
                                    dalam program monitoring dan edukasi lingkungan.
                                </p>
                            </div>

                            {{-- News item 3 --}}
                            <div class="border-l-4 border-red-500 pl-4">
                                <p class="text-xs font-semibold text-red-600 uppercase mb-1">01 Juni 2024</p>
                                <h4 class="text-lg font-semibold text-gray-900 mb-2">Target 1000 Donatur Tercapai!</h4>
                                <p class="text-gray-600 text-sm leading-relaxed">
                                    Pencapaian luar biasa! Kami telah menerima dukungan dari lebih dari 1000 donatur yang peduli
                                    dengan masa depan lingkungan kita.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tab Content: Donatur --}}
                <div id="tab-donatur" class="tab-content hidden mt-8">
                    <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-gray-100">
                        <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-6">Daftar Donatur</h3>
                        <div class="space-y-4">
                            @forelse ($campaign->donations as $donation)
                                @php
                                    $donorName = $donation->is_anonymous
                                        ? 'Anonim'
                                        : ($donation->user->username ?? $donation->guest_name ?? 'Donatur');
                                    $initials = collect(explode(' ', $donorName))
                                        ->filter()
                                        ->take(2)
                                        ->map(fn ($word) => \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($word, 0, 1)))
                                        ->implode('');
                                @endphp

                                <div class="flex items-start gap-4 pb-4 border-b border-gray-200">
                                    <div class="w-10 h-10 bg-gradient-to-br from-red-400 to-red-600 rounded-full flex-shrink-0 flex items-center justify-center">
                                        <span class="text-white font-bold text-sm">{{ $initials ?: 'D' }}</span>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-900 text-sm">{{ $donorName }}</p>
                                        <p class="text-gray-600 text-xs">Berdonasi Rp {{ number_format($donation->amount, 0, ',', '.') }}</p>
                                    </div>
                                    <span class="text-red-600 text-xs font-semibold">Sukses</span>
                                </div>
                            @empty
                                <p class="text-gray-600 text-sm">Belum ada donatur yang ditampilkan.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>

            {{-- ===================== RIGHT COLUMN: STICKY DONATION CARD ===================== --}}
            <div class="lg:col-span-4">
                <div class="sticky top-24 bg-white rounded-3xl p-6 sm:p-7 shadow-lg border border-gray-100">

                    @if (in_array($campaign->status, ['completed', 'complete', 'telah_disalurkan']))
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4 text-[#BA1A1A]">
                                <i class="bx bx-check-shield text-3xl"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Program Selesai</h3>
                            <p class="text-sm text-gray-500 mb-6 leading-relaxed">
                                @if ($campaign->status === 'telah_disalurkan')
                                    Terima kasih! Seluruh dana untuk program ini telah berhasil disalurkan kepada penerima manfaat.
                                @else
                                    Terima kasih! Target donasi program ini telah terpenuhi dan penggalangan dana telah ditutup.
                                @endif
                            </p>
                            <a href="{{ route('program') }}" class="inline-flex w-full bg-[#BA1A1A] hover:bg-red-800 text-white font-semibold py-3 px-6 rounded-xl transition-all justify-center">
                                Lihat Program Lainnya
                            </a>
                        </div>
                    @else
                        {{-- Card title --}}
                        <h3 class="text-lg font-bold text-gray-900 mb-6">Mulai Berdonasi</h3>

                        {{-- Quick amount buttons --}}
                        <div class="mb-6">
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-3">Nominal Cepat</label>
                            <div class="grid grid-cols-3 gap-2">
                                <button class="quick-amount-btn py-3 px-3 rounded-lg border-2 border-gray-200 bg-white text-gray-900 font-semibold text-xs hover:border-red-500 hover:bg-red-50 transition-all cursor-pointer" data-amount="20000">
                                    <span class="block">Rp</span>
                                    <span class="block text-lg">20K</span>
                                </button>
                                <button class="quick-amount-btn py-3 px-3 rounded-lg border-2 border-gray-200 bg-white text-gray-900 font-semibold text-xs hover:border-red-500 hover:bg-red-50 transition-all cursor-pointer" data-amount="50000">
                                    <span class="block">Rp</span>
                                    <span class="block text-lg">50K</span>
                                </button>
                                <button class="quick-amount-btn py-3 px-3 rounded-lg border-2 border-gray-200 bg-white text-gray-900 font-semibold text-xs hover:border-red-500 hover:bg-red-50 transition-all cursor-pointer" data-amount="100000">
                                    <span class="block">Rp</span>
                                    <span class="block text-lg">100K</span>
                                </button>
                            </div>
                        </div>

                        {{-- Custom amount input --}}
                        <div class="mb-6">
                            <label for="amount" class="block text-xs font-semibold text-gray-700 uppercase mb-2">Nominal Lainnya</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-semibold">Rp</span>
                                <input
                                    type="number"
                                    id="amount"
                                    name="amount"
                                    placeholder="Masukkan nominal..."
                                    value=""
                                    class="w-full border-2 border-gray-200 rounded-xl pl-12 pr-4 py-3 text-gray-900 placeholder-gray-400 text-sm
                                           focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-200 transition-all"
                                >
                            </div>
                        </div>

                        {{-- Donor name --}}
                        <div class="mb-6">
                            <label for="guest_name" class="block text-xs font-semibold text-gray-700 uppercase mb-2">Nama Donatur</label>
                            <input
                                type="text"
                                id="guest_name"
                                name="guest_name"
                                maxlength="100"
                                placeholder="Nama Anda..."
                                value="{{ auth()->user()->username ?? '' }}"
                                class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-gray-900 placeholder-gray-400 text-sm
                                       focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-200 transition-all"
                            >
                        </div>

                        {{-- Message (optional) --}}
                        <div class="mb-6">
                            <label for="message" class="block text-xs font-semibold text-gray-700 uppercase mb-2">Pesan & Doa (Opsional)</label>
                            <textarea
                                id="message"
                                name="message"
                                rows="3"
                                placeholder="Tinggalkan pesan dukungan Anda..."
                                class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-gray-900 placeholder-gray-400 text-sm resize-none
                                       focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-200 transition-all"
                            ></textarea>
                        </div>

                        {{-- Anonymous checkbox --}}
                        <div class="mb-7 flex items-center gap-3">
                            <input
                                type="checkbox"
                                id="anonymous"
                                name="anonymous"
                                class="w-4 h-4 rounded border-2 border-gray-300 text-red-600 focus:ring-2 focus:ring-red-200 cursor-pointer"
                            >
                            <label for="anonymous" class="text-xs text-gray-600 cursor-pointer">
                                Donasi secara anonim
                            </label>
                        </div>

                        {{-- CTA Button --}}
                        <button
                            id="donate-btn"
                            class="w-full bg-red-600 hover:bg-red-700 active:bg-red-800 text-white font-semibold py-3 px-6 rounded-xl
                                   transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center gap-2
                                   disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Donasi Sekarang
                        </button>

                        {{-- Info text --}}
                        <p class="text-center text-xs text-gray-500 mt-4">
                            Donasi Anda aman dan terenkripsi dengan sistem pembayaran terpercaya.
                        </p>

                        {{-- Trust badges --}}
                        <div class="mt-4 pt-4 border-t border-gray-100 flex justify-center gap-3">
                            <div class="flex items-center gap-1 text-xs text-gray-600">
                                <i class="bx bx-check-shield"></i>
                                Aman
                            </div>
                            <div class="flex items-center gap-1 text-xs text-gray-600">
                                <i class="bx bx-check-shield"></i>
                                Terpercaya
                            </div>
                            <div class="flex items-center gap-1 text-xs text-gray-600">
                                <i class="bx bx-check-shield"></i>
                                Cepat
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script
    src="{{ config('services.midtrans.snap_js_url') }}"
    data-client-key="{{ config('services.midtrans.client_key') }}"
></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = '{{ csrf_token() }}';
    const createSnapUrl = '{{ route('donations.midtrans.snap') }}';
    const refreshStatusUrl = '{{ route('donations.midtrans.status') }}';
    const campaignId = {{ $campaign->campaign_id }};

    // ===================== TAB NAVIGATION =====================
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const tabName = this.getAttribute('data-tab');

            // Remove active state from all buttons and contents
            tabButtons.forEach(btn => {
                btn.classList.remove('active', 'border-red-600', 'text-gray-900');
                btn.classList.add('border-transparent', 'text-gray-600');
            });
            tabContents.forEach(content => {
                content.classList.remove('active');
                content.classList.add('hidden');
            });

            // Add active state to clicked button and corresponding content
            this.classList.remove('border-transparent', 'text-gray-600');
            this.classList.add('active', 'border-red-600', 'text-gray-900');
            document.getElementById(`tab-${tabName}`).classList.remove('hidden');
            document.getElementById(`tab-${tabName}`).classList.add('active');
        });
    });

    // ===================== QUICK AMOUNT BUTTONS =====================
    const quickAmountButtons = document.querySelectorAll('.quick-amount-btn');
    const amountInput = document.getElementById('amount');
    const donateBtn = document.getElementById('donate-btn');

    if (donateBtn && amountInput) {
        quickAmountButtons.forEach(button => {
            button.addEventListener('click', function() {
                const amount = this.getAttribute('data-amount');
                amountInput.value = amount;

                // Visual feedback
                quickAmountButtons.forEach(btn => {
                    btn.classList.remove('border-red-500', 'bg-red-50');
                    btn.classList.add('border-gray-200', 'bg-white');
                });
                this.classList.remove('border-gray-200', 'bg-white');
                this.classList.add('border-red-500', 'bg-red-50');

                // Update button state
                updateDonateButton();
            });
        });

        // ===================== CUSTOM AMOUNT INPUT =====================
        amountInput.addEventListener('input', function() {
            // Remove selection from quick buttons
            quickAmountButtons.forEach(btn => {
                btn.classList.remove('border-red-500', 'bg-red-50');
                btn.classList.add('border-gray-200', 'bg-white');
            });

            updateDonateButton();
        });

        function updateDonateButton() {
            const amount = parseInt(amountInput.value) || 0;
            donateBtn.disabled = amount < 1000;

            if (amount > 0) {
                const formattedAmount = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(amount);
                donateBtn.textContent = `Donasi ${formattedAmount}`;
            } else {
                donateBtn.innerHTML = `
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Donasi Sekarang
                `;
            }
        }

        // ===================== DONATE BUTTON ACTION =====================
        donateBtn.addEventListener('click', async function(e) {
            const amount = parseInt(amountInput.value) || 0;
            const guestName = document.getElementById('guest_name').value;
            const anonymous = document.getElementById('anonymous').checked;
            const message = document.getElementById('message').value;

            if (amount < 1000) {
                alert('Nominal donasi minimal Rp 1.000');
                return;
            }

            // Show loading state
            const originalContent = this.innerHTML;
            this.disabled = true;
            this.innerHTML = `
                <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M21 12a9 9 0 1 1-6.219-8.56" stroke-linecap="round"/>
                </svg>
                Memproses...
            `;

            try {
                const response = await fetch(createSnapUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({
                        campaign_id: campaignId,
                        amount: amount,
                        guest_name: guestName,
                        is_anonymous: anonymous,
                        message: message,
                    }),
                });

                const data = await response.json();

                if (! response.ok) {
                    throw new Error(data.message || 'Transaksi tidak dapat dibuat.');
                }

                if (! window.snap || ! data.snap_token) {
                    if (data.redirect_url) {
                        window.location.href = data.redirect_url;
                        return;
                    }

                    throw new Error('Midtrans Snap belum siap. Muat ulang halaman lalu coba lagi.');
                }

                window.snap.pay(data.snap_token, {
                    onSuccess: async function(result) {
                        await refreshDonationStatus(data.order_id);
                        alert('Terima kasih! Pembayaran donasi Anda berhasil.');
                        window.location.reload();
                    },
                    onPending: async function(result) {
                        await refreshDonationStatus(data.order_id);
                        alert('Transaksi dibuat dan menunggu pembayaran.');
                        window.location.reload();
                    },
                    onError: async function(result) {
                        await refreshDonationStatus(data.order_id);
                        alert('Pembayaran gagal. Silakan coba lagi.');
                        window.location.reload();
                    },
                    onClose: function() {
                        donateBtn.disabled = false;
                        donateBtn.innerHTML = originalContent;
                        updateDonateButton();
                    },
                });
            } catch (error) {
                this.disabled = false;
                this.innerHTML = originalContent;
                updateDonateButton();
                alert(error.message || 'Terjadi kesalahan saat memproses donasi.');
            }
        });

        async function refreshDonationStatus(orderId) {
            await fetch(refreshStatusUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({ order_id: orderId }),
            });
        }

        // Initialize button state
        updateDonateButton();
    }
});
</script>
@endpush
