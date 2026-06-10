@props(['articles'])

<div class="w-full p-6 mt-16">

    {{-- Slides --}}
    <div class="relative rounded-2xl overflow-hidden h-[420px]">

        @foreach($articles as $index => $article)
            <div
                class="carousel-slide absolute inset-0 transition-opacity duration-500 {{ $index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }}"
                data-index="{{ $index }}"
            >
                {{-- Gambar --}}
                <img
                    src="{{ asset($article['image']) }}"
                    alt="{{ $article['title'] }}"
                    class="absolute inset-0 w-full h-full object-cover"
                >

                {{-- Overlay gradient --}}
                <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/50 to-transparent"></div>

                {{-- Konten --}}
                <div class="absolute inset-0 flex flex-col justify-center px-10 md:px-16 max-w-xl text-white">

                    {{-- Tag + Meta --}}
                    <div class="flex items-center gap-3 mb-4">
                        <span class="bg-[#e31d1d] text-white text-[11px] font-bold px-3 py-1 rounded uppercase tracking-wider">
                            {{ $article['tag'] }}
                        </span>
                        <span class="text-xs text-white/70">
                            {{ $article['date'] ?? '' }}
                            @if(!empty($article['date']) && !empty($article['read_time'])) &bull; @endif
                            {{ $article['read_time'] ?? '' }}
                        </span>
                    </div>

                    {{-- Judul --}}
                    <h2 class="text-2xl md:text-[30px] font-bold leading-snug mb-3">
                        {{ $article['title'] }}
                    </h2>

                    {{-- Deskripsi --}}
                    <p class="text-sm leading-relaxed text-white/85 mb-7 line-clamp-2">
                        {{ $article['description'] }}
                    </p>

                    {{-- Tombol CTA --}}
                    <a
                        href="{{ $article['link'] }}"
                        class="btn-cta-carousel inline-flex items-center gap-2 bg-white text-black text-sm font-bold px-6 py-2.5 rounded-full w-fit transition-colors duration-200"
                    >
                        Baca Selengkapnya &rarr;
                    </a>
                </div>
            </div>
        @endforeach

        {{-- Tombol Prev --}}
        <button
            onclick="carouselMove(-1)"
            class="absolute left-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-white/20 border border-white/40 text-white text-xl flex items-center justify-center hover:bg-white/40 transition"
        >
            &#8249;
        </button>

        {{-- Tombol Next --}}
        <button
            onclick="carouselMove(1)"
            class="absolute right-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-white/20 border border-white/40 text-white text-xl flex items-center justify-center hover:bg-white/40 transition"
        >
            &#8250;
        </button>
    </div>

    {{-- Dots --}}
    <div class="flex justify-center gap-2 mt-4" id="carouselDots">
        @foreach($articles as $index => $article)
            <button
                onclick="carouselGo({{ $index }})"
                class="carousel-dot w-2 h-2 rounded-full transition-all duration-200 {{ $index === 0 ? 'bg-[#e31d1d] scale-125' : 'bg-gray-300' }}"
                data-index="{{ $index }}"
            ></button>
        @endforeach
    </div>

</div>

@push('styles')
<style>
    .btn-cta-carousel:hover {
        background-color: #e31d1d !important;
        color: #fff !important;
    }
</style>
@endpush

@push('scripts')
<script>
    let carouselCurrent = 0;
    const carouselTotal = {{ count($articles) }};
    let carouselTimer = setInterval(() => carouselMove(1), 5000);

    function carouselShow(n) {
        document.querySelectorAll('.carousel-slide').forEach((s, i) => {
            s.classList.toggle('opacity-100', i === n);
            s.classList.toggle('z-10', i === n);
            s.classList.toggle('opacity-0', i !== n);
            s.classList.toggle('z-0', i !== n);
        });
        document.querySelectorAll('.carousel-dot').forEach((d, i) => {
            d.classList.toggle('bg-[#e31d1d]', i === n);
            d.classList.toggle('scale-125', i === n);
            d.classList.toggle('bg-gray-300', i !== n);
        });
        carouselCurrent = n;
    }

    function carouselMove(dir) {
        clearInterval(carouselTimer);
        carouselShow((carouselCurrent + dir + carouselTotal) % carouselTotal);
        carouselTimer = setInterval(() => carouselMove(1), 5000);
    }

    function carouselGo(n) {
        clearInterval(carouselTimer);
        carouselShow(n);
        carouselTimer = setInterval(() => carouselMove(1), 5000);
    }
</script>
@endpush
