@props(['title', 'value', 'icon', 'color' => 'gray'])

<div class="bg-white rounded-3xl shadow-lg p-6">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-gray-600 text-sm">{{ $title }}</p>
            <p class="text-3xl font-bold text-gray-900">{{ $value }}</p>
        </div>
        <div class="bg-{{ $color }}-100 p-3 rounded-2xl">
            <x-heroicon-o-gift class="h-6 w-6" />
        </div>
    </div>
</div>
