<div class="bg-white rounded-3xl shadow-lg p-8">
    <h2 class="text-2xl font-bold text-gray-900 mb-6">Lịch sử đơn hàng</h2>

    @if($orderHistory->isEmpty())
        <p class="text-gray-600">Bạn chưa có đơn hàng nào.</p>
    @else
        <div class="space-y-4">
            @foreach($orderHistory as $order)
                <div class="border border-gray-200 rounded-2xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="font-semibold text-gray-900">Đơn hàng #{{ $order->id }}</h3>
                            <p class="text-gray-600 text-sm">{{ $order->created_at->format('d/m/Y') }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-sm font-medium
                            @if($order->status === 'Đã giao')
                                bg-green-100 text-green-800
                            @elseif($order->status === 'Đang giao')
                                bg-blue-100 text-blue-800
                            @else
                                bg-red-100 text-red-800
                            @endif">
                            {{ $order->status }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="text-gray-600">
                            {{ $order->items_count ?? '0' }} sản phẩm
                        </div>
                        <div class="font-semibold text-gray-900">
                            {{ number_format($order->total, 0, ',', '.') }}đ
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
