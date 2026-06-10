<div class="flex flex-col w-full items-start px-4 md:px-10 py-4 bg-base fixed top-0 left-0 z-50 shadow-sm">
    <div class="flex w-full items-center justify-between relative px-2 md:px-6">

        <a href="/" class="inline-flex items-center gap-2 relative z-50">
            <div class="inline-flex flex-col items-start relative">
                <div class="relative flex items-center w-fit text-[#ba000c] text-4xl md:text-5xl font-normal tracking-[-0.96px] leading-none whitespace-nowrap">
                    GEN
                </div>
            </div>
            <div class="flex flex-col w-4.25 h-8 items-start px-2 py-0 relative">
                <div class="relative w-px h-8 bg-[#e7bdb7]"></div>
            </div>
            <div class="inline-flex flex-col items-start relative font-inter">
                <div class="relative w-fit text-[#5f5e5e] text-[9px] md:text-[10px] tracking-[1.00px] leading-[12.5px]">
                    GERAKAN<br />EKSPLORASI<br />NUSANTARA
                </div>
            </div>
        </a>

        <div class="hidden md:flex items-center justify-center gap-8 relative font-inter">
            <a href="/tentang" class="{{ request()->is('tentang') ? 'text-primary font-bold underline decoration-2 underline-offset-8' : 'text-[#5f5e5e] font-semibold' }} text-sm tracking-[0.70px] hover:text-[#ba000c] transition-all">Tentang</a>
            <a href="/program" class="{{ request()->is('program') ? 'text-primary font-bold underline decoration-2 underline-offset-8' : 'text-[#5f5e5e] font-semibold' }} text-sm tracking-[0.70px] hover:text-[#ba000c] transition-all">Program</a>
            <a href="/artikel" class="{{ request()->is('artikel') ? 'text-primary font-bold underline decoration-2 underline-offset-8' : 'text-[#5f5e5e] font-semibold' }} text-sm tracking-[0.70px] hover:text-[#ba000c] transition-all">Artikel</a>
            <a href="/kontak" class="{{ request()->is('kontak') ? 'text-primary font-bold underline decoration-2 underline-offset-8' : 'text-[#5f5e5e] font-semibold' }} text-sm tracking-[0.70px] hover:text-[#ba000c] transition-all">Kontak</a>
        </div>

        <button class="hidden md:inline-flex font-inter items-center justify-center px-8 py-3 bg-primary rounded-full text-white text-sm font-normal tracking-[0.70px] shadow-[0px_4px_6px_-1px_#0000001a] hover:bg-[#ba000c] transition-colors cursor-pointer">
            Bergabung
        </button>

        <button id="hamburger-btn" class="flex md:hidden flex-col justify-center items-center w-8 h-8 gap-2 relative z-50 cursor-pointer focus:outline-none" aria-label="Toggle Menu">
            <span id="line-top" class="w-6 h-0.5 bg-[#5f5e5e] transition-all duration-300 ease-in-out transform origin-center"></span>
            <span id="line-bottom" class="w-6 h-0.5 bg-[#5f5e5e] transition-all duration-300 ease-in-out transform origin-center"></span>
        </button>

    </div>
</div>

<div id="mobile-sidebar" class="fixed top-0 right-0 h-full w-70 bg-white z-40 shadow-2xl transform translate-x-full transition-transform duration-300 ease-in-out pt-24 px-8 font-inter flex flex-col gap-6 md:hidden">
    <nav class="flex flex-col gap-6 text-lg">
        <a href="/tentang" class="{{ request()->is('tentang') ? 'text-primary font-bold' : 'text-[#5f5e5e]' }} py-2 transition-all border-b border-gray-100">Tentang</a>
        <a href="/program" class="{{ request()->is('program') ? 'text-primary font-bold' : 'text-[#5f5e5e]' }} py-2 transition-all border-b border-gray-100">Program</a>
        <a href="/artikel" class="{{ request()->is('artikel') ? 'text-primary font-bold' : 'text-[#5f5e5e]' }} py-2 transition-all border-b border-gray-100">Artikel</a>
        <a href="/kontak" class="{{ request()->is('kontak') ? 'text-primary font-bold' : 'text-[#5f5e5e]' }} py-2 transition-all border-b border-gray-100">Kontak</a>
    </nav>

    <button class="w-full mt-4 font-inter py-3 bg-primary rounded-full text-white text-center text-sm font-normal shadow-md hover:bg-[#ba000c] transition-colors cursor-pointer">
        Bergabung
    </button>
</div>

<div id="sidebar-overlay" class="fixed inset-0 bg-black/40 z-30 hidden md:hidden opacity-0 transition-opacity duration-300"></div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const hamburgerBtn = document.getElementById('hamburger-btn');
        const mobileSidebar = document.getElementById('mobile-sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');

        const lineTop = document.getElementById('line-top');
        const lineBottom = document.getElementById('line-bottom');

        function toggleMenu() {
            // 1. Geser Sidebar Masuk/Keluar
            mobileSidebar.classList.toggle('translate-x-full');

            // 2. Munculkan/Sembunyikan Overlay latar belakang
            if (sidebarOverlay.classList.contains('hidden')) {
                sidebarOverlay.classList.remove('hidden');
                setTimeout(() => sidebarOverlay.classList.add('opacity-100'), 10);
            } else {
                sidebarOverlay.classList.remove('opacity-100');
                setTimeout(() => sidebarOverlay.classList.add('hidden'), 300);
            }

            // 3. Animasi Transformasi Hamburger 2 Baris menjadi 'X'
            // Garis atas diputar 45 derajat kebawah, digeser sedikit agar simetris
            lineTop.classList.toggle('rotate-45');
            lineTop.classList.toggle('translate-y-[5px]');

            // Garis bawah diputar -45 derajat keatas, digeser sedikit agar menyilang pas
            lineBottom.classList.toggle('-rotate-45');
            lineBottom.classList.toggle('-translate-y-[5px]');
        }

        // Jalankan fungsi saat tombol hamburger atau overlay diklik
        hamburgerBtn.addEventListener('click', toggleMenu);
        sidebarOverlay.addEventListener('click', toggleMenu);
    });
</script>
