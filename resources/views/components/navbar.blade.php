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

        @auth
            @php
                $profile = Auth::user()->profile;
                $url = $profile->profile_picture_url ?? null;
                $hasPhoto = !empty($url);
                $finalUrl = $hasPhoto ? (str_starts_with($url, 'http') ? $url : asset('storage/' . $url)) : '';
            @endphp

            <div class="hidden md:flex relative group items-center z-50 font-inter">
                <button class="flex items-center justify-center w-10 h-10 bg-primary text-white rounded-full font-bold shadow-md hover:bg-[#ba000c] transition-colors focus:outline-none cursor-pointer overflow-hidden border border-gray-100">
                    @if($hasPhoto)
                        <img src="{{ $finalUrl }}" class="w-full h-full object-cover" alt="Profile">
                    @else
                        {{ strtoupper(substr(Auth::user()->username, 0, 1)) }}
                    @endif
                </button>

                <div class="absolute right-0 top-full mt-2 w-48 bg-white border border-gray-100 rounded-xl shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
                    <a href="/profile" class="block px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-t-xl transition">Lihat Profil</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-3 text-sm font-medium text-[#ba000c] hover:bg-red-50 rounded-b-xl transition">Logout</button>
                    </form>
                </div>
            </div>
        @else
            <a href="/login" class="hidden md:inline-flex font-inter items-center justify-center px-8 py-3 bg-primary rounded-full text-white text-sm font-normal tracking-[0.70px] shadow-[0px_4px_6px_-1px_#0000001a] hover:bg-[#ba000c] transition-colors cursor-pointer z-50">
                Bergabung
            </a>
        @endauth


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

    @auth
        <div class="flex flex-col gap-4 mt-2 pt-4 border-t border-gray-100 font-inter">
            <div class="flex items-center gap-3">
                <div class="flex items-center justify-center w-10 h-10 bg-primary text-white rounded-full font-bold overflow-hidden border border-gray-100">
                    @if($hasPhoto)
                        <img src="{{ $finalUrl }}" class="w-full h-full object-cover" alt="Profile">
                    @else
                        {{ strtoupper(substr(Auth::user()->username, 0, 1)) }}
                    @endif
                </div>
                <span class="text-sm font-semibold text-gray-700 truncate">{{ Auth::user()->username }}</span>
            </div>
            <a href="/profile" class="text-sm font-medium text-[#5f5e5e] hover:text-[#ba000c] transition-all py-2 border-b border-gray-100">Lihat Profil</a>
            <form action="{{ route('logout') }}" method="POST" class="w-full mt-2">
                @csrf
                <button type="submit" class="w-full py-3 border border-[#ba000c] text-[#ba000c] rounded-full text-center text-sm font-semibold hover:bg-[#ba000c] hover:text-white transition-colors cursor-pointer">
                    Logout
                </button>
            </form>
        </div>
    @else
        <a href="/login" class="w-full mt-4 font-inter py-3 bg-primary rounded-full text-white text-center text-sm font-normal shadow-md hover:bg-[#ba000c] transition-colors cursor-pointer">
            Bergabung
        </a>
    @endauth
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
            mobileSidebar.classList.toggle('translate-x-full');

            if (sidebarOverlay.classList.contains('hidden')) {
                sidebarOverlay.classList.remove('hidden');
                setTimeout(() => sidebarOverlay.classList.add('opacity-100'), 10);
            } else {
                sidebarOverlay.classList.remove('opacity-100');
                setTimeout(() => sidebarOverlay.classList.add('hidden'), 300);
            }

            lineTop.classList.toggle('rotate-45');
            lineTop.classList.toggle('translate-y-[5px]');
            lineBottom.classList.toggle('-rotate-45');
            lineBottom.classList.toggle('-translate-y-[5px]');
        }

        hamburgerBtn.addEventListener('click', toggleMenu);
        sidebarOverlay.addEventListener('click', toggleMenu);
    });
</script>
