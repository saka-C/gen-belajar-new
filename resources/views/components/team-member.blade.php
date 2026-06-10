@props(['name', 'role', 'image'])

<div class="flex flex-col group">
    <div class="aspect-square w-full overflow-hidden rounded-[32px]">
        <img
            src="{{ asset('images/' . $image) }}"
            alt="{{ $name }}"
            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
        >
    </div>

    <div class="mt-4">
        <h3 class="text-xl font-bold text-[#1a1c1c]">{{ $name }}</h3>
        <p class="text-[11px] md:text-xs font-bold text-primary tracking-widest uppercase mt-1">
            {{ $role }}
        </p>
    </div>
</div>
