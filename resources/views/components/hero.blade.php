@props([
    'title' => 'Judul Hero',
    'subtitle' => 'Sub-judul atau kategori',
    'description' => 'Deskripsi hero...',
    'buttonText' => 'Ikut Berdonasi',
    'bgImage' => 'images/hero-bg.jpg'
])

<div class="flex w-full min-h-[500px] md:min-h-[700px] {{ request()->is('/') ? 'max-md:h-screen' : '' }} items-center justify-center relative overflow-hidden">

    <div class="flex flex-col w-full h-full items-start justify-center absolute top-0 left-0 z-0">
        <div class="relative flex-1 self-stretch w-full grow bg-cover bg-center"
             style="background-image: url('{{ asset($bgImage) }}');">
        </div>
        <div class="absolute w-full h-full top-0 left-0 bg-black/60"></div>
    </div>

    <div class="flex flex-col max-w-7xl w-full items-start px-6 sm:px-12 py-24 md:py-32 relative z-10">
        <div class="flex flex-col max-w-3xl w-full items-start gap-4 relative">

            <div class="inline-flex flex-col items-start relative pb-1">
                <div class="relative w-fit text-primary text-xl md:text-2xl font-semibold tracking-wide">
                    {{ $subtitle }}
                </div>
                <div class="absolute w-full left-0 bottom-0 h-0.5 bg-primary"></div>
            </div>

            <div class="flex self-stretch w-full flex-col items-start relative mt-2">
                <h1 class="relative self-stretch text-white text-3xl sm:text-4xl md:text-5xl font-bold tracking-tight leading-tight md:leading-snug">
                    {{ $title }}
                </h1>
            </div>

            <div class="flex flex-col max-w-xl w-full items-start pt-2 relative font-inter">
                <p class="text-[#e2e2e2] text-[16px] md:text-lg leading-relaxed">
                    {{ $description }}
                </p>
            </div>

            <div class="flex items-start pt-6 relative w-full font-inter">
                <button class="inline-flex items-center gap-2 px-8 py-4 bg-primary rounded-full text-white text-[16px] font-semibold tracking-wide shadow-lg hover:bg-primary-hover transition-all transform hover:-translate-y-0.5 cursor-pointer">
                    <span>{{ $buttonText }}</span>
                    <i class="bx bx-donate-heart text-2xl"></i>
                </button>
            </div>

        </div>
    </div>
</div>