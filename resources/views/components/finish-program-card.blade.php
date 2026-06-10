@props(['image', 'category', 'title', 'description', 'reportUrl' => '#'])

<div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100 flex flex-col h-full">
    <img src="{{ asset($image) }}" class="h-48 w-full object-cover" alt="{{ $title }}">
    <div class="p-6 flex-1 flex flex-col">
        <span class="text-xs font-bold text-gray-400 mb-2 uppercase">{{ $category }}</span>
        <h3 class="text-lg font-bold mb-2">{{ $title }}</h3>
        <p class="text-sm text-gray-500 mb-6 flex-grow">{{ $description }}</p>
        <div class="grid grid-cols-2 gap-4 bg-gray-50 p-4 rounded-xl text-center">
            <div><p class="text-xs text-gray-500">STATUS</p><p class="font-bold text-green-600">Selesai</p></div>
            <div><p class="text-xs text-gray-500">LAPORAN</p><a href="{{ $reportUrl }}" class="text-primary text-sm font-semibold">Unduh PDF</a></div>
        </div>
    </div>
</div>
