@props([
    'image' => '',
    'category' => 'Kategori',
    'title' => 'Judul Kampanye',
    'percentage' => 0,
    'target' => 'Rp0'
])

<div class="flex flex-col w-full bg-white rounded-[32px] overflow-hidden shadow-[0px_4px_20px_rgba(0,0,0,0.05)] transition-all hover:shadow-[0px_10px_30px_rgba(0,0,0,0.08)]">

    <div class="h-56 w-full relative">
        <img src="{{ asset($image) }}" alt="{{ $title }}" class="w-full h-full object-cover">

        <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-4 py-1.5 rounded-full font-inter text-xs font-normal text-secondary">
            {{ $category }}
        </div>
    </div>

    <div class="flex flex-col flex-1 p-6 sm:p-8 gap-4 justify-between">

        <div class="flex flex-col gap-4">
            <h3 class="text-[#1a1c1c] text-xl sm:text-2xl font-semibold leading-tight tracking-tight min-h-[62px] line-clamp-2">
                {{ $title }}
            </h3>

            <div class="w-full h-2 bg-[#eeeeee] rounded-full overflow-hidden">
                <div class="h-full bg-primary rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
            </div>

            <div class="flex items-center justify-between font-inter text-xs sm:text-sm">
                <span class="text-secondary font-normal">{{ $percentage }}% Terkumpul</span>
                <span class="text-[#1a1c1c] font-medium">Target: <span class="text-primary-hover">{{ $target }}</span></span>
            </div>
        </div>

        <button class="w-full py-3 border-2 border-primary text-primary hover:bg-primary hover:text-white transition-all font-inter text-base text-center font-normal rounded-full cursor-pointer transform active:scale-[0.98]">
            Donasi Sekarang
        </button>

    </div>
</div>
