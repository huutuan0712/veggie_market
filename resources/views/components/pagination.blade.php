@props(['meta'])

@if ($meta['last_page'] > 1)
    <div class="mt-6 flex justify-center space-x-1">
        {{-- Nút trang trước --}}
        <a href="{{ $meta['current_page'] > 1 ? request()->fullUrlWithQuery(['page' => $meta['current_page'] - 1]) : '#' }}"
           class="px-3 py-2 rounded {{ $meta['current_page'] > 1 ? 'bg-gray-100 text-gray-700 hover:bg-gray-200' : 'bg-gray-200 text-gray-400 cursor-not-allowed' }} transition">
            &laquo;
        </a>

        {{-- Các trang --}}
        @for ($page = 1; $page <= $meta['last_page']; $page++)
            <a href="{{ request()->fullUrlWithQuery(['page' => $page]) }}"
               class="px-4 py-2 rounded {{ $page == $meta['current_page'] ? 'bg-orange-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                {{ $page }}
            </a>
        @endfor

        {{-- Nút trang sau --}}
        <a href="{{ $meta['current_page'] < $meta['last_page'] ? request()->fullUrlWithQuery(['page' => $meta['current_page'] + 1]) : '#' }}"
           class="px-3 py-2 rounded {{ $meta['current_page'] < $meta['last_page'] ? 'bg-gray-100 text-gray-700 hover:bg-gray-200' : 'bg-gray-200 text-gray-400 cursor-not-allowed' }} transition">
            &raquo;
        </a>
    </div>
@endif
