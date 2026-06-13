@props(['image', 'category', 'title', 'description', 'percentage', 'target', 'donors'])

<div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex flex-col md:flex-row gap-8">
    <div class="w-full md:w-1/2 h-64 overflow-hidden rounded-2xl">
        <img src="{{ asset($image) }}" class="w-full h-full object-cover" alt="{{ $title }}">
    </div>
    <div class="flex-1 flex flex-col justify-center">
        <span class="inline-block bg-red-100 text-red-600 text-xs font-bold px-3 py-1 rounded-full w-fit mb-4">{{ $category }}</span>
        <h3 class="text-2xl font-bold mb-3">{{ $title }}</h3>
        <p class="text-gray-600 mb-6">{{ $description }}</p>

        <div class="w-full bg-gray-100 h-2 rounded-full mb-2">
            <div class="bg-primary h-2 rounded-full" style="width: {{ $percentage }}%"></div>
        </div>
        <div class="flex justify-between text-sm mb-6">
            <span class="text-gray-500">{{ $percentage }}% Terkumpul</span>
            <span class="font-semibold">Target: {{ $target }}</span>
        </div>
        <div class="flex justify-between items-center">
            <span class="text-sm text-gray-500 flex items-center gap-1"><i class='bx bx-user'></i> {{ $donors }} Donatur</span>
            <a href="/detail" class="text-primary font-bold">Donasi Sekarang &rarr;</a>
        </div>
    </div>
</div>
