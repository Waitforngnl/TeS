<x-admin>
    <header
        class="h-16 border-b border-ef-bg-4 bg-ef-bg-0 flex items-center justify-between px-8 sticky top-0 z-10 shadow-sm">
        <div class="flex items-center gap-4">
            <h1 class="text-xl text-ef-fg font-black tracking-tight uppercase">QUẢN LÝ ĐƠN HÀNG</h1>
            <span class="bg-ef-bg-4 text-ef-grey-1 text-[10px] px-2 py-0.5 rounded-full font-bold">
                TỔNG ĐƠN: {{ $orders->total() }}
            </span>
        </div>
    </header>

    <main class="p-8 max-w-7xl mx-auto">
        <div id="flash-message-container">
            @if (session('success'))
                <div
                    class="alert-box mb-6 p-4 bg-ef-bg-4 border-l-4 border-ef-green text-ef-green text-sm font-bold rounded-r-lg shadow-sm flex items-center transition-all duration-500">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div
                    class="alert-box mb-6 p-4 bg-ef-bg-4 border-l-4 border-ef-red text-ef-red text-sm font-bold rounded-r-lg shadow-sm flex items-center transition-all duration-500">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ session('error') }}
                </div>
            @endif
        </div>

        <form action="{{ route('admin.orders.index') }}" method="GET" id="filter-form">
            <div
                class="mb-8 flex flex-col md:flex-row gap-4 items-center justify-between bg-ef-bg-1 p-5 rounded-2xl border border-ef-bg-4 shadow-sm">

                <div class="w-full md:w-1/2 relative group">
                    <span
                        class="absolute inset-y-0 left-0 pl-4 flex items-center text-ef-grey-1 group-focus-within:text-ef-blue transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Nhập mã đơn hàng (ID)..."
                        class="w-full pl-12 pr-4 py-3 bg-ef-bg-0 border border-ef-bg-4 rounded-xl focus:outline-none focus:border-ef-blue focus:ring-1 focus:ring-ef-blue text-sm text-ef-fg transition-all">
                </div>

                <div class="w-full md:w-auto">
                    <!-- Bộ lọc trạng thái đơn hàng  -->
                    <select name="status" onchange="document.getElementById('filter-form').submit()"
                        class="bg-ef-bg-0 border border-ef-bg-4 rounded-xl px-4 py-2 text-sm text-ef-fg focus:outline-none focus:border-ef-blue cursor-pointer transition-all">
                        <option value="">Tất cả trạng thái</option>
                        <option value="PENDING" {{ request('status') == 'PENDING' ? 'selected' : '' }}>Đang xử lý</option>
                        <option value="COMPLETED" {{ request('status') == 'COMPLETED' ? 'selected' : '' }}>Hoàn thành</option>
                        <option value="CANCELED" {{ request('status') == 'CANCELED' ? 'selected' : '' }}>Đã hủy</option>
                    </select>

                    <!-- Bộ lọc phương thức giao hàng -->
                    <select name="delivery_method" onchange="document.getElementById('filter-form').submit()"
                        class="bg-ef-bg-0 border border-ef-bg-4 rounded-xl px-4 py-2 text-sm text-ef-fg focus:outline-none focus:border-ef-blue cursor-pointer transition-all">
                        <option value="">Tất cả phương thức</option>
                        <option value="PICKUP" {{ request('delivery_method') == 'PICKUP' ? 'selected' : '' }}>Tại quầy</option>
                        <option value="DELIVERY" {{ request('delivery_method') == 'DELIVERY' ? 'selected' : '' }}>Giao hàng</option>
                    </select>
                </div>

                <button type="submit" class="hidden">Tìm kiếm</button>
            </div>
        </form>

        <div class="bg-ef-bg-1 rounded-2xl border border-ef-bg-4 shadow-sm overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-ef-bg-2 border-b border-ef-bg-4">
                        <th class="px-6 py-4 text-[10px] font-black text-ef-grey-1 uppercase tracking-widest">Mã đơn /
                            Ngày đặt</th>
                        <th class="px-6 py-4 text-[10px] font-black text-ef-grey-1 uppercase tracking-widest">Khách hàng
                        </th>
                        <th
                            class="px-6 py-4 text-[10px] font-black text-ef-grey-1 uppercase tracking-widest text-right">
                            Tổng tiền</th>
                        <th
                            class="px-6 py-4 text-[10px] font-black text-ef-grey-1 uppercase tracking-widest text-center">
                            PT Giao hàng</th>
                        <th
                            class="px-6 py-4 text-[10px] font-black text-ef-grey-1 uppercase tracking-widest text-center">
                            Trạng thái</th>
                        <th
                            class="px-6 py-4 text-[10px] font-black text-ef-grey-1 uppercase tracking-widest text-right">
                            Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ef-bg-4">
                    @forelse($orders as $order)
                        <tr class="hover:bg-ef-bg-0/50 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="text-sm font-black text-ef-fg">
                                    #{{ $order->id }}</div>
                                <div class="text-[10px] text-ef-grey-1 font-medium italic">
                                    {{ $order->created_at->format('d/m/Y H:i') }}</div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-ef-fg">{{ $order->user->full_name }}</div>
                                <div class="text-[11px] text-ef-grey-1">{{ $order->user->email }}</div>
                            </td>

                            <td class="px-6 py-4 text-right">
                                <div class="text-sm font-black text-ef-blue">
                                    {{ number_format($order->total_price, 0, ',', '.') }}đ
                                </div>
                                <div class="text-[9px] text-ef-grey-1 uppercase tracking-tighter">Phí ship:
                                    +{{ number_format($order->shipping_fee, 0, ',', '.') }}đ</div>
                            </td>

                            <td class="px-6 py-4 text-center">
                                @if ($order->delivery_method === 'DELIVERY')
                                    <span
                                        class="text-[10px] font-bold text-ef-fg border border-ef-bg-4 px-2 py-0.5 rounded-full bg-ef-bg-2">Giao
                                        hàng</span>
                                @else
                                    <span
                                        class="text-[10px] font-bold text-ef-grey-1 border border-ef-bg-4 px-2 py-0.5 rounded-full">Tại
                                        quầy</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-center">
                                @switch($order->status)
                                    @case('PENDING')
                                        <span
                                            class="px-2 py-1 bg-ef-orange/10 text-ef-orange text-[10px] font-black rounded border border-ef-orange/20 animate-pulse">CHỜ
                                            XỬ LÝ</span>
                                    @break

                                    @case('COMPLETED')
                                        <span
                                            class="px-2 py-1 bg-ef-green/10 text-ef-green text-[10px] font-black rounded border border-ef-green/20">HOÀN
                                            THÀNH</span>
                                    @break

                                    @case('CANCELED')
                                        <span
                                            class="px-2 py-1 bg-ef-red/10 text-ef-red text-[10px] font-black rounded border border-ef-red/20">ĐÃ
                                            HỦY</span>
                                    @break
                                @endswitch
                            </td>

                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-1">
                                    <a href="{{ route('admin.orders.show', $order->id) }}"
                                        class="p-2 text-ef-grey-1 hover:text-ef-blue hover:bg-ef-bg-3 rounded-lg transition-all"
                                        title="Chi tiết">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>

                                    <a href="{{ route('admin.orders.edit', $order->id) }}"
                                        class="p-2 text-ef-grey-1 hover:text-ef-orange hover:bg-ef-bg-3 rounded-lg transition-all"
                                        title="Cập nhật">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                    </a>

                                    <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST"
                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?')"
                                        class="{{ $order->status !== 'CANCELED' ? 'hidden' : '' }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-2 text-ef-grey-1 hover:text-ef-red hover:bg-ef-bg-3 rounded-lg transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-20 text-center text-ef-grey-1">Không tìm thấy đơn hàng
                                    nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        </main>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const alerts = document.querySelectorAll('.alert-box');
                alerts.forEach(alert => {
                    setTimeout(() => {
                        alert.style.opacity = '0';
                        alert.style.transform = 'translateX(20px)';
                        setTimeout(() => alert.remove(), 500);
                    }, 3000);
                });
            });
        </script>
    </x-admin>
