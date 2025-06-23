<div class="bg-white rounded-3xl shadow-lg p-8">
    <h2 class="text-2xl font-bold text-gray-900 mb-6">Sản phẩm yêu thích</h2>

    @if($favoriteProducts->isEmpty())
        <p class="text-gray-600">Bạn chưa có sản phẩm nào yêu thích.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($favoriteProducts as $product)
                <div class="border border-gray-200 rounded-2xl p-4">
                    <div class="flex items-center space-x-4">
                        <img
                            src="{{ $product->image }}"
                            alt="{{ $product->name }}"
                            class="w-16 h-16 object-cover rounded-xl"
                        />
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900">{{ $product->name }}</h3>
                            <p class="text-orange-600 font-semibold">
                                {{ number_format($product->price, 0, ',', '.') }}đ
                            </p>
                        </div>
                        <form method="POST" action="{{ route('favorites.remove', $product->id) }}">
                            @csrf
                            @method('DELETE')
                            <button
                                type="submit"
                                class="text-red-500 hover:text-red-600 transition-colors"
                                title="Xóa khỏi yêu thích"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 fill-current" viewBox="0 0 24 24" stroke="none">
                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5
                                             2 5.42 4.42 3 7.5 3c1.74 0 3.41.81
                                             4.5 2.09C13.09 3.81 14.76 3
                                             16.5 3 19.58 3 22 5.42 22 8.5c0
                                             3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
