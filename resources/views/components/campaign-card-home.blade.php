@props(['campaign'])

@php
   $collected = $campaign->collected_amount ?? 0;
    $target = $campaign->target_amount ?? 0;

    $percentage = $target > 0
        ? min(100, round(($collected / $target) * 100))
        : 0;

    $image = $campaign->image
        ? asset('storage/' . $campaign->image)
        : asset('images/no-image.png');
@endphp

<a href="{{ route('campaigns.show', $campaign->campaign_id) }}"
    class="flex flex-col w-full bg-white rounded-[32px] overflow-hidden shadow-[0px_4px_20px_rgba(0,0,0,0.05)] transition-all hover:shadow-[0px_10px_30px_rgba(0,0,0,0.08)]">

    <div class="h-56 w-full relative">

        <img src="{{ $image }}"
            alt="{{ $campaign->title }}"
            class="w-full h-full object-cover">

        <div
            class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-4 py-1.5 rounded-full font-inter text-xs font-normal text-secondary">

            Program

        </div>

    </div>

    <div class="flex flex-col flex-1 p-6 sm:p-8 gap-4 justify-between">

        <div class="flex flex-col gap-4">

            <h3 class="text-[#1a1c1c] text-xl sm:text-2xl font-semibold leading-tight tracking-tight min-h-[62px] line-clamp-2">
                {{ $campaign->title }}
            </h3>

            <div class="w-full h-2 bg-[#eeeeee] rounded-full overflow-hidden">

                <div class="h-full bg-primary rounded-full transition-all duration-500"
                    style="width: {{ $percentage }}%">
                </div>

            </div>

            <div class="flex items-center justify-between font-inter text-xs sm:text-sm">

                <span class="text-secondary font-normal">

                    {{ $percentage }}% Terkumpul

                </span>

                <span class="text-[#1a1c1c] font-medium">

                    Target:
                    <span class="text-primary-hover">
                        Rp{{ number_format($target, 0, ',', '.') }}
                    </span>

                </span>

            </div>

        </div>

        <div
            class="w-full py-3 border-2 border-primary text-primary hover:bg-primary hover:text-white transition-all font-inter text-base text-center font-normal rounded-full">

            Donasi Sekarang

        </div>

    </div>

</a>