@props(['class' => ''])
<button type="submit" {{ $attributes->merge(['class' => "{$class} bg-gradient-to-r from-orange-500 to-red-500 text-white py-3 rounded-2xl font-semibold hover:from-orange-600 hover:to-red-600 transition-all duration-300 flex items-center justify-center space-x-2"]) }}>
    {{ $slot }}
</button>
