@props(['campaign'])

@php
    $collected = $campaign->collected_amount ?? 0;
    $target = $campaign->target_amount;
    $percentage = $target > 0 ? min(100, round(($collected / $target) * 100)) : 0;
@endphp

<div class="flex flex-col md:flex-row max-w-5xl w-full mx-auto items-stretch gap-4 md:gap-6 relative">

    <div class="flex flex-col items-start gap-6 p-6 sm:p-8 relative flex-1 bg-white rounded-3xl sm:rounded-4xl shadow-lg">

        <div class="w-full">
            <h2 class="text-[#1a1c1c] text-xl sm:text-2xl md:text-3xl font-bold leading-tight">
                {{ $campaign->title }}
            </h2>
        </div>

        <div class="flex flex-col items-start gap-4 w-full relative">

            <div class="relative w-full h-3 sm:h-4 bg-[#eeeeee] rounded-full overflow-hidden">
                <div
                    class="h-full bg-primary rounded-full"
                    style="width: {{ $percentage }}%">
                </div>
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 w-full font-inter text-sm sm:text-base">

                <div class="flex flex-wrap items-center gap-1.5">
                    <span class="text-primary font-medium">
                        Rp{{ number_format($collected, 0, ',', '.') }}
                    </span>

                    <span class="text-gray-500 font-medium">
                        dana terkumpul dari
                    </span>

                    <span class="text-[#1a1c1c] font-bold">
                        Rp{{ number_format($target, 0, ',', '.') }}
                    </span>
                </div>

                <a href="{{ route('campaigns.show', $campaign->campaign_id) }}"
                    class="group inline-flex items-center text-primary gap-1 font-normal transition-all whitespace-nowrap">

                    <span class="group-hover:underline">
                        Lihat Detail Donasi Ini
                    </span>

                    <i class="bx bx-arrow-out-up-right-square bx-remove-padding"></i>

                </a>

            </div>

        </div>

    </div>

    <div class="flex flex-row md:flex-col gap-3 md:w-30 shrink-0 font-inter">

        <a href="{{ route('program') }}"
            class="bg-white h-20 md:w-20 w-full hover:scale-105 transition-all text-slate-400 rounded-3xl sm:rounded-4xl text-3xl flex items-center justify-center cursor-pointer">

            <i class="bx bx-grid bx-remove-padding"></i>

        </a>

        <a href="{{ route('campaigns.show', $campaign->campaign_id) }}"
            class="bg-primary h-20 md:w-20 w-full hover:scale-105 transition-all text-white rounded-3xl sm:rounded-4xl text-3xl flex items-center justify-center cursor-pointer">

            <i class="bx bx-donate-heart bx-remove-padding"></i>

        </a>

    </div>

</div>