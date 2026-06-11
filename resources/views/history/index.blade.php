<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Lịch sử đơn hàng - {{ env('APP_NAME') }}</title>
  
  @vite([
      'resources/css/app.css', 
      'resources/js/app.js', 
      'resources/css/navbar.css',
      'resources/css/history.css',
      'resources/js/history.js'
  ])
</head>

<body class="antialiased font-sans bg-gray-50 text-gray-800">

  @include('partials.navbar')

  <main class="pt-24 pb-10 px-6 max-w-7xl mx-auto min-h-screen">
      
      <div class="flex items-center justify-between mb-8 border-b border-gray-200 pb-4">
          <h1 class="text-2xl font-bold text-amber-800 uppercase tracking-wide">
              Lịch sử đơn hàng
          </h1>
          <a href="{{ route('products') }}" class="text-sm font-medium text-gray-500 hover:text-amber-800 transition">
              ← Quay lại mua sắm
          </a>
      </div>

      @if(isset($orders) && count($orders) > 0)
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-100 text-gray-600 uppercase text-xs font-bold border-b border-gray-200">
                        <tr>
                            <th class="py-4 px-6">Mã đơn</th>
                            <th class="py-4 px-6">Ngày đặt</th>
                            <th class="py-4 px-6">Tổng tiền</th>
                            <th class="py-4 px-6 text-center">Trạng thái</th>
                            <th class="py-4 px-6 text-right">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($orders as $order)
                        <tr class="order-row transition-colors">
                            <td class="py-4 px-6 font-bold text-gray-800">
                                #{{ $order->id }}
                            </td>
                            <td class="py-4 px-6 text-gray-600 text-sm">
                                {{ $order->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="py-4 px-6 font-bold text-amber-800">
                                {{ number_format($order->total_price ?? 0) }}đ
                            </td>
                            <td class="py-4 px-6 text-center">
                                @if($order->status == 'COMPLETED')
                                    <span class="status-badge status-completed">Hoàn thành</span>
                                @elseif($order->status == 'CANCELED')
                                    <span class="status-badge status-cancelled">Đã hủy</span>
                                @else
                                    <span class="status-badge status-pending">Đang xử lý</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                <button type="button" 
                                        onclick="openOrderDetail('{{ $order->id }}')"
                                        class="text-sm font-medium text-amber-700 hover:text-amber-900 hover:underline">
                                    Xem chi tiết
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($orders->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>

      @else
        <div class="flex flex-col items-center justify-center py-20 bg-white rounded-lg border border-dashed border-gray-300">
            <div class="bg-gray-50 p-4 rounded-full mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-1">Chưa có đơn hàng nào</h3>
            <p class="text-gray-500 text-sm mb-6">Hãy đặt món nước yêu thích đầu tiên của bạn nhé!</p>
            <a href="{{ route('products') }}" class="px-6 py-2 bg-amber-800 hover:bg-amber-900 text-white text-sm font-bold rounded shadow transition">
                Mua ngay
            </a>
        </div>
      @endif

  </main>

  <div id="order-detail-modal" class="fixed inset-0 z-50 hidden">
      <div class="fixed inset-0 bg-black/40 backdrop-blur-sm transition-opacity cursor-pointer" onclick="closeOrderDetail()"></div>

      <div class="fixed inset-0 z-10 w-screen overflow-y-auto flex items-center justify-center p-4">
          <div class="bg-white rounded-lg shadow-2xl w-full max-w-2xl overflow-hidden modal-content-animate flex flex-col max-h-[90vh]">
              
              <div class="bg-gray-50 px-6 py-4 flex justify-between items-center border-b border-gray-200">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Chi tiết đơn hàng <span id="modal-order-id" class="text-amber-700">#...</span></h3>
                    <p class="text-xs text-gray-500">Cảm ơn bạn đã mua sắm tại Coffee Shop</p>
                </div>
                <button onclick="closeOrderDetail()" class="text-gray-400 hover:text-gray-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
              </div>

              <div class="p-6 overflow-y-auto">
                  <div class="space-y-4" id="order-items-list">
                  </div>
              </div>

              <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 text-right">
                  <button onclick="closeOrderDetail()" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 font-bold rounded text-sm hover:bg-gray-100 transition">
                      Đóng
                  </button>
              </div>

          </div>
      </div>
  </div>

</body>
</html>