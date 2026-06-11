<x-admin>
    <div class="p-8 max-w-4xl mx-auto">
        <div class="mb-8">
            <h1 class="text-2xl font-black text-ef-fg tracking-tight uppercase">CẬP NHẬT ĐƠN HÀNG #{{ $order->id }}
            </h1>
            <p class="text-ef-grey-1 text-sm">Thay đổi trạng thái xử lý hoặc thông tin giao nhận.</p>
        </div>

        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="bg-ef-bg-1 rounded-2xl border border-ef-bg-4 shadow-sm overflow-hidden">
                <div class="p-8 space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-ef-fg mb-3 uppercase tracking-widest">Trạng thái xử
                            lý</label>
                        <select name="status"
                            class="w-full px-4 py-3 bg-ef-bg-0 border border-ef-bg-4 rounded-xl focus:border-ef-orange outline-none text-ef-fg font-bold transition-all">
                            <option value="PENDING" {{ $order->status == 'PENDING' ? 'selected' : '' }}>🕒 CHỜ XỬ LÝ
                                (PENDING)</option>
                            <option value="COMPLETED" {{ $order->status == 'COMPLETED' ? 'selected' : '' }}>✅ HOÀN THÀNH
                                (COMPLETED)</option>
                            <option value="CANCELED" {{ $order->status == 'CANCELED' ? 'selected' : '' }}>❌ ĐÃ HỦY
                                (CANCELED)</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-ef-fg mb-3 uppercase tracking-widest">Phương thức
                                giao hàng</label>
                            <select name="delivery_method" id="delivery_method"
                                class="w-full px-4 py-3 bg-ef-bg-0 border border-ef-bg-4 rounded-xl focus:border-ef-blue outline-none text-ef-fg transition-all">
                                <option value="DELIVERY" {{ $order->delivery_method == 'DELIVERY' ? 'selected' : '' }}>
                                    🚚 Giao hàng tận nơi</option>
                                <option value="PICKUP" {{ $order->delivery_method == 'PICKUP' ? 'selected' : '' }}>🏠
                                    Nhận tại cửa hàng</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-ef-fg mb-3 uppercase tracking-widest">Phí vận
                                chuyển (VNĐ)</label>
                            <input type="number" name="shipping_fee" id="shipping_fee"
                                value="{{ old('shipping_fee', $order->shipping_fee) }}"
                                class="w-full px-4 py-3 bg-ef-bg-0 border border-ef-bg-4 rounded-xl focus:border-ef-blue outline-none text-ef-fg"
                                {{ $order->delivery_method == 'PICKUP' ? 'readonly' : '' }}>
                        </div>
                    </div>

                    <div id="address_container" class="{{ $order->delivery_method == 'PICKUP' ? 'opacity-50' : '' }}">
                        <label class="block text-sm font-bold text-ef-fg mb-3 uppercase tracking-widest">Địa chỉ giao
                            hàng</label>
                        <textarea name="shipping_address" rows="3"
                            class="w-full px-4 py-3 bg-ef-bg-0 border border-ef-bg-4 rounded-xl focus:border-ef-blue outline-none text-ef-fg">{{ old('shipping_address', $order->shipping_address) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-ef-fg mb-3 uppercase tracking-widest">Ghi chú đơn
                            hàng (Admin)</label>
                        <textarea name="note" rows="2" placeholder="Lý do hủy đơn hoặc chỉ dẫn đặc biệt..."
                            class="w-full px-4 py-3 bg-ef-bg-0 border border-ef-bg-4 rounded-xl focus:border-ef-blue outline-none text-ef-fg">{{ old('note', $order->note) }}</textarea>
                    </div>
                </div>

                <div class="p-6 bg-ef-bg-2 border-t border-ef-bg-4 flex gap-4">
                    <button type="submit"
                        class="flex-1 py-4 bg-ef-blue text-ef-bg-0 rounded-xl font-black text-xs tracking-widest hover:brightness-110 shadow-lg shadow-ef-blue/20 transition-all uppercase">
                        LƯU THAY ĐỔI
                    </button>
                    <a href="{{ route('admin.orders.index') }}"
                        class="px-8 py-4 bg-ef-bg-4 text-ef-grey-1 rounded-xl font-bold text-xs tracking-widest uppercase hover:text-ef-fg transition-all">
                        HỦY
                    </a>
                </div>
            </div>
        </form>
    </div>

    <script>
        const deliverySelect = document.getElementById('delivery_method');
        const shippingInput = document.getElementById('shipping_fee');
        const addressContainer = document.getElementById('address_container');

        deliverySelect.addEventListener('change', function() {
            if (this.value === 'PICKUP') {
                shippingInput.value = 0;
                shippingInput.readOnly = true;
                addressContainer.classList.add('opacity-50');
            } else {
                shippingInput.readOnly = false;
                addressContainer.classList.remove('opacity-50');
            }
        });
    </script>
</x-admin>
