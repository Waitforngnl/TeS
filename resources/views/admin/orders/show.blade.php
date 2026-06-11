<x-admin>
    <header
        class="h-16 border-b border-ef-bg-4 bg-ef-bg-0 flex items-center justify-between px-8 sticky top-0 z-10 shadow-sm">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.orders.index') }}" class="p-2 hover:bg-ef-bg-2 rounded-full transition-colors">
                <svg class="w-5 h-5 text-ef-grey-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-xl text-ef-fg font-black tracking-tight uppercase">CHI TIẾT ĐƠN HÀNG
                #{{ $order->id }}</h1>
        </div>

        <div class="flex gap-3">
            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                @csrf @method('PUT')
                <input type="hidden" name="status" value="CANCELED">
                <input type="hidden" name="delivery_method" value="{{ $order->delivery_method }}">
                <input type="hidden" name="shipping_fee" value="{{ $order->shipping_fee }}">
                <button type="submit"
                    class="px-4 py-2 bg-ef-bg-2 text-ef-red text-xs font-black rounded-lg border border-ef-red/20 hover:bg-ef-red hover:text-ef-bg-0 transition-all {{ $order->status !== 'PENDING' ? 'hidden' : '' }}">HỦY
                    ĐƠN</button>
            </form>

            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                @csrf @method('PUT')
                <input type="hidden" name="status" value="COMPLETED">
                <input type="hidden" name="delivery_method" value="{{ $order->delivery_method }}">
                <input type="hidden" name="shipping_fee" value="{{ $order->shipping_fee }}">
                <button type="submit"
                    class="px-4 py-2 bg-ef-green text-ef-bg-0 text-xs font-black rounded-lg shadow-lg shadow-ef-green/20 hover:brightness-110 transition-all {{ $order->status !== 'PENDING' ? 'hidden' : '' }}">XÁC
                    NHẬN HOÀN THÀNH</button>
            </form>
        </div>
    </header>

    <main class="p-8 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 space-y-6">
                <div class="bg-ef-bg-1 rounded-2xl border border-ef-bg-4 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-ef-bg-4 bg-ef-bg-2">
                        <h3 class="text-sm font-black text-ef-fg uppercase tracking-widest">Sản phẩm đã đặt</h3>
                    </div>
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-ef-bg-4">
                                <th class="px-6 py-4 text-[10px] font-black text-ef-grey-1 uppercase">Sản phẩm</th>
                                <th class="px-6 py-4 text-[10px] font-black text-ef-grey-1 uppercase text-center">Đơn
                                    giá</th>
                                <th class="px-6 py-4 text-[10px] font-black text-ef-grey-1 uppercase text-center">SL
                                </th>
                                <th class="px-6 py-4 text-[10px] font-black text-ef-grey-1 uppercase text-right">Thành
                                    tiền</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-ef-bg-4">
                            @foreach ($order->item as $item)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="w-12 h-12 bg-ef-bg-2 rounded-lg border border-ef-bg-4 flex-shrink-0">
                                                <img src="{{ $item->product->image_url ?? '' }}"
                                                    class="w-full h-full object-cover rounded-lg">
                                            </div>
                                            <div>
                                                <div class="text-sm font-bold text-ef-fg">{{ $item->product_name }}
                                                </div>
                                                <div class="text-[10px] text-ef-grey-1">ID: #{{ $item->product_id }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center text-sm text-ef-fg">
                                        {{ number_format($item->unit_price, 0, ',', '.') }}đ</td>
                                    <td class="px-6 py-4 text-center text-sm font-bold text-ef-fg">
                                        x{{ $item->quantity }}</td>
                                    <td class="px-6 py-4 text-right text-sm font-black text-ef-blue">
                                        {{ number_format($item->line_total, 0, ',', '.') }}đ</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="p-6 bg-ef-bg-0/30 space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-ef-grey-1">Tạm tính:</span>
                            <span
                                class="text-ef-fg font-bold">{{ number_format($order->sub_total, 0, ',', '.') }}đ</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-ef-grey-1">Phí vận chuyển ({{ $order->delivery_method }}):</span>
                            <span
                                class="text-ef-fg font-bold">+{{ number_format($order->shipping_fee, 0, ',', '.') }}đ</span>
                        </div>
                        <div class="flex justify-between text-lg border-t border-ef-bg-4 pt-3">
                            <span class="font-black text-ef-fg uppercase">Tổng cộng:</span>
                            <span
                                class="font-black text-ef-green">{{ number_format($order->total_price, 0, ',', '.') }}đ</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-ef-bg-1 p-6 rounded-2xl border border-ef-bg-4 shadow-sm">
                    <h3 class="text-xs font-black text-ef-fg uppercase tracking-widest mb-4 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-ef-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Khách hàng
                    </h3>
                    <div class="space-y-1">
                        <div class="text-sm font-bold text-ef-fg">{{ $order->user->full_name }}</div>
                        <div class="text-xs text-ef-grey-1">{{ $order->user->email }}</div>
                        <div class="text-xs text-ef-grey-1">{{ $order->user->phone ?? 'Không có SĐT' }}</div>
                    </div>
                </div>

                <div class="bg-ef-bg-1 p-6 rounded-2xl border border-ef-bg-4 shadow-sm">
                    <h3 class="text-xs font-black text-ef-fg uppercase tracking-widest mb-4 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-ef-orange" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Địa chỉ nhận hàng
                    </h3>
                    <div class="text-xs text-ef-fg leading-relaxed bg-ef-bg-2 p-3 rounded-lg border border-ef-bg-4">
                        {{ $order->shipping_address ?? 'Nhận tại cửa hàng (PICKUP)' }}
                    </div>
                    @if ($order->note)
                        <div class="mt-4">
                            <span class="text-[10px] font-bold text-ef-grey-1 uppercase">Ghi chú:</span>
                            <p class="text-xs text-ef-orange italic mt-1">"{{ $order->note }}"</p>
                        </div>
                    @endif
                </div>

                <div class="bg-ef-bg-2 p-4 rounded-xl border border-ef-bg-4 text-center">
                    <span class="text-[10px] text-ef-grey-1 uppercase block mb-1">Trạng thái hiện tại</span>
                    <span
                        class="text-sm font-black {{ $order->status === 'COMPLETED' ? 'text-ef-green' : ($order->status === 'CANCELED' ? 'text-ef-red' : 'text-ef-orange') }}">
                        {{ $order->status }}
                    </span>
                </div>
            </div>
        </div>
    </main>
</x-admin>
