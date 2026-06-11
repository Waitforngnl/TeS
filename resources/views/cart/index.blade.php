<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Giỏ hàng - {{ env('APP_NAME') }}</title>
  
  @vite([
      'resources/css/app.css', 
      'resources/js/app.js',
      'resources/css/navbar.css',
      'resources/css/cart.css', // File CSS tùy chỉnh cho giỏ hàng
      'resources/js/cart.js'    // File JS xử lý Modal và số lượng
  ])
</head>

<body class="antialiased font-sans bg-gray-50 text-gray-800">

  @include('partials.navbar')

  <main class="pt-24 pb-10 px-6 max-w-7xl mx-auto min-h-screen">
      
      <h1 class="text-2xl font-bold text-amber-800 uppercase tracking-wide mb-6 border-b border-gray-200 pb-2">
          Giỏ hàng của bạn
      </h1>

      @if(isset($cart) && count($cart) > 0)
        <div class="flex flex-col gap-6">
            
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-100 text-gray-600 uppercase text-xs font-bold">
                        <tr>
                            <th class="py-4 px-6 w-2/5">Sản phẩm</th>
                            <th class="py-4 px-6 text-center">Đơn giá</th>
                            <th class="py-4 px-6 text-center">Số lượng</th>
                            <th class="py-4 px-6 text-center">Số tiền</th>
                            <th class="py-4 px-6 text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($cart as $id => $item)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-4">
                                    <div class="h-16 w-16 flex-shrink-0 overflow-hidden rounded border border-gray-200">
                                        <img src="{{ asset($item['image'] ?? 'images/no-img.jpg') }}" class="h-full w-full object-cover">
                                    </div>
                                    <span class="font-semibold text-gray-800">{{ $item['name'] }}</span>
                                </div>
                            </td>

                            <td class="py-4 px-6 text-center text-gray-600">
                                {{ number_format($item['price']) }}đ
                            </td>

                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center border border-gray-200 rounded w-fit mx-auto">
                                    
                                    <form action="{{ route('cart.update', $id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="action" value="decrease">
                                        
                                        <button type="button" 
                                                onclick="checkQuantity(this, {{ $item['quantity'] }})"
                                                class="px-3 py-1 bg-gray-50 text-gray-600 hover:bg-gray-200 transition-colors border-r border-gray-200">
                                            -
                                        </button>
                                    </form>

                                    <span class="px-4 py-1 text-sm font-medium bg-white text-gray-800 min-w-[40px]">
                                        {{ $item['quantity'] }}
                                    </span>

                                    <form action="{{ route('cart.update', $id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="action" value="increase">
                                        <button type="submit" class="px-3 py-1 bg-gray-50 text-gray-600 hover:bg-gray-200 transition-colors border-l border-gray-200">
                                            +
                                        </button>
                                    </form>
                                    
                                </div>
                            </td>

                            <td class="py-4 px-6 text-center font-bold text-amber-800">
                                {{ number_format($item['price'] * $item['quantity']) }}đ
                            </td>

                            <td class="py-4 px-6 text-center">
                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors p-2" title="Xóa sản phẩm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex flex-col items-end gap-4 mt-2">
                
                <div class="flex items-center gap-6 text-xl">
                    <span class="text-gray-500 font-medium">Tổng thanh toán:</span>
                    <span class="text-amber-800 font-bold text-2xl">{{ number_format($total) }}đ</span>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('products') }}" class="px-6 py-3 text-gray-600 hover:text-amber-800 font-medium text-sm transition-colors">
                        Tiếp tục mua sắm
                    </a>

                    <button type="button" onclick="openCheckoutModal()" class="bg-amber-800 hover:bg-amber-900 text-white px-10 py-3 rounded shadow-md font-bold text-base uppercase tracking-wide transition-all transform hover:-translate-y-0.5">
                        Mua hàng
                    </button>
                </div>

            </div>

        </div>
      @else
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 flex flex-col items-center justify-center text-center h-96">
            <div class="h-32 w-32 bg-gray-50 rounded-full flex items-center justify-center mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
            </div>
            <h2 class="text-xl font-bold text-gray-800 mb-2">Giỏ hàng trống</h2>
            <p class="text-gray-500 mb-8">Bạn chưa thêm sản phẩm nào vào giỏ hàng.</p>
            <a href="{{ route('products') }}" class="px-8 py-3 bg-amber-800 hover:bg-amber-900 text-white font-bold rounded shadow transition uppercase">
                Mua sắm ngay
            </a>
        </div>
      @endif

  </main>

    <div id="confirm-delete-modal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 backdrop-blur-sm transition-opacity cursor-pointer" onclick="closeModal()"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
            <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </div>
                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                    <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Xác nhận xóa sản phẩm</h3>
                    <div class="mt-2">
                    <p class="text-sm text-gray-500">Bạn đang giảm số lượng về 0. Hành động này sẽ xóa sản phẩm khỏi giỏ hàng. Bạn có chắc chắn không?</p>
                    </div>
                </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                <button type="button" id="confirm-btn" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">
                    Đồng ý xóa
                </button>
                <button type="button" onclick="closeModal()" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
                    Hủy bỏ
                </button>
            </div>
            </div>
        </div>
        </div>
    </div>

    <div id="checkout-modal" class="fixed inset-0 z-50 hidden">
        <div class="fixed inset-0 bg-black/30 backdrop-blur-sm transition-opacity cursor-pointer" onclick="closeCheckoutModal()"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto flex items-center justify-center p-4">
            <div class="bg-white rounded-lg shadow-2xl w-full max-w-5xl overflow-hidden animate-fade-in-up flex flex-col max-h-[90vh]">
                <div class="bg-amber-800 text-white px-6 py-4 flex justify-between items-center">
                    <h2 class="text-lg font-bold uppercase tracking-widest">Xác nhận đơn hàng</h2>
                    <button onclick="closeCheckoutModal()" class="text-white hover:text-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form id="checkout_form" action="{{ route('orders.store') }}" method="POST" class="flex-1 overflow-y-auto p-0 flex flex-col">
                    @csrf
                    <div class="grid grid-cols-1 lg:grid-cols-4 h-full">
                        
                        <div class="lg:col-span-3 p-6 border-r border-gray-200 space-y-6">
                            
                            <div>
                                <h3 class="font-bold text-gray-700 mb-3 uppercase text-sm border-b border-gray-200 pb-2">Chi tiết sản phẩm</h3>
                                <div class="overflow-x-auto max-h-40 overflow-y-auto border border-gray-100 rounded">
                                    <table class="w-full text-left text-sm text-gray-600">
                                        <thead class="bg-gray-100 uppercase text-xs sticky top-0">
                                            <tr>
                                                <th class="px-4 py-2">Món</th>
                                                <th class="px-4 py-2 text-center">SL</th>
                                                <th class="px-4 py-2 text-right">Thành tiền</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100">
                                            @foreach($cart as $item)
                                            <tr>
                                                <td class="px-4 py-3 font-medium">{{ $item['name'] }}</td>
                                                <td class="px-4 py-3 text-center">x{{ $item['quantity'] }}</td>
                                                <td class="px-4 py-3 text-right">{{ number_format($item['price'] * $item['quantity']) }}đ</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div>
                                <h3 class="font-bold text-gray-700 mb-3 uppercase text-sm border-b border-gray-200 pb-2">Thông tin nhận hàng</h3>
                                
                                <div class="flex gap-6 mb-4">
                                    <label class="flex items-center gap-2 cursor-pointer text-sm font-medium text-gray-700 hover:text-amber-800 transition">
                                        <input type="radio" name="delivery_method" value="DELIVERY" id="method_delivery" checked class="text-amber-800 focus:ring-amber-800">
                                        Giao tận nơi
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer text-sm font-medium text-gray-700 hover:text-amber-800 transition">
                                        <input type="radio" name="delivery_method" value="PICKUP" id="method_pickup" class="text-amber-800 focus:ring-amber-800">
                                        Tự đến quán lấy
                                    </label>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="col-span-1 md:col-span-2">
                                        <label class="text-xs text-gray-500 block mb-1">Số điện thoại <span class="text-red-500">*</span></label>
                                        <input type="text" name="phone_number" required class="w-full p-2.5 border border-gray-300 rounded text-sm focus:ring-amber-800 focus:border-amber-800 transition">
                                    </div>
                                    
                                    <div class="col-span-1 md:col-span-2" id="address_container">
                                        <label class="text-xs text-gray-500 block mb-1">Địa chỉ giao hàng <span class="text-red-500">*</span></label>
                                        <input type="text" name="shipping_address" id="shipping_address_input" class="w-full p-2.5 border border-gray-300 rounded text-sm focus:ring-amber-800 focus:border-amber-800 transition" placeholder="Số nhà, tên đường, phường/xã...">
                                    </div>

                                    <div class="col-span-1 md:col-span-2">
                                        <label class="text-xs text-gray-500 block mb-1">Ghi chú cho quán (Tùy chọn)</label>
                                        <textarea name="note" class="w-full p-2.5 border border-gray-300 rounded text-sm focus:ring-amber-800 focus:border-amber-800 transition" rows="2" placeholder="Ví dụ: Lấy nhiều đá, ít ngọt..."></textarea>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h3 class="font-bold text-gray-700 mb-3 uppercase text-sm border-b border-gray-200 pb-2">Phương thức thanh toán</h3>
                                <div class="space-y-3">
                                    <label class="flex items-center gap-3 cursor-pointer text-sm p-3 border border-gray-200 rounded hover:bg-amber-50 hover:border-amber-200 transition">
                                        <input type="radio" name="payment_method" value="COD" checked class="text-amber-800 focus:ring-amber-800">
                                        <span class="font-medium text-gray-700">Thanh toán khi nhận hàng (COD)</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer text-sm p-3 border border-gray-200 rounded hover:bg-amber-50 hover:border-amber-200 transition">
                                        <input type="radio" name="payment_method" value="VNPAY" class="text-amber-800 focus:ring-amber-800">
                                        <span class="font-medium text-gray-700">Ví điện tử VNPAY (Giả lập)</span>
                                    </label>
                                </div>
                            </div>

                        </div>

                        <div class="lg:col-span-1 bg-gray-50 p-6 flex flex-col justify-between h-full border-t lg:border-t-0">
                            <div class="space-y-4">
                                <h3 class="font-bold text-gray-700 uppercase text-sm border-b border-gray-200 pb-2">Thanh toán</h3>
                                
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Tạm tính:</span>
                                    <span class="font-medium">{{ number_format($total) }}đ</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Phí ship:</span>
                                    <span class="font-medium" id="shipping_fee_text">30,000đ</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Giảm giá:</span>
                                    <span class="font-medium text-green-600">-0đ</span>
                                </div>

                                <div class="border-t border-gray-200 pt-3 mt-3">
                                    <div class="flex flex-col items-end">
                                        <span class="text-xs text-gray-500 font-bold uppercase mb-1">Tổng cộng</span>
                                        <span class="text-2xl font-bold text-amber-800" id="total_price_text">{{ number_format($total + 30000) }}đ</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8">
                                <button type="submit" class="w-full bg-amber-800 hover:bg-amber-900 text-white font-bold py-4 rounded shadow-lg uppercase text-sm transition-transform transform active:scale-95">
                                    XÁC NHẬN ĐẶT HÀNG
                                </button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

    @if(session('conflict'))
        <div id="cart-conflict-modal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 backdrop-blur-sm transition-opacity cursor-pointer" onclick="closeConflictModal()"></div>
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                        <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"></path>
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                    <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Có vấn đề với sản phẩm trong giỏ</h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">{{ session('conflict.message') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6" id="cart-conflict-actions">
                            @php $conflict = session('conflict'); @endphp

                            <form method="POST" action="{{ url('/cart/remove') }}/{{ $conflict['id'] }}" class="inline-block">
                                @csrf
                                @method('DELETE')
                            </form>
                            <button type="button" onclick="closeConflictModal()" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Đóng</button>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="qr-modal" class="fixed inset-0 z-[60] hidden">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity"></div>
    
    <div class="fixed inset-0 z-10 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl p-8 w-full max-w-sm text-center transform transition-all animate-fade-in-up">
            
            <div class="flex justify-center mb-4">
                <img src="https://vnpay.vn/s1/statics.vnpay.vn/2023/9/06ncktiwd6dc1694418186387.png" alt="VNPAY Logo" class="h-8">
            </div>

            <h3 class="text-xl font-bold text-gray-800 mb-2">Thanh toán đơn hàng</h3>
            <p class="text-sm text-gray-500 mb-6">Mở ứng dụng ngân hàng hoặc ví VNPAY để quét mã</p>
            
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 inline-block mb-6 relative">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=ThanhToan_CoffeeShop" alt="QR VNPAY" class="mx-auto w-48 h-48 mix-blend-multiply">
            </div>

            <div class="space-y-3">
                <button type="button" id="simulate_paid_btn" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg shadow-md transition-all flex justify-center items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    Giả lập: Quét mã thành công
                </button>
                <button type="button" onclick="closeQrModal()" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold py-3 rounded-lg transition-all">
                    Hủy giao dịch
                </button>
            </div>
        </div>
    </div>
</div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const modal = document.getElementById('cart-conflict-modal');
                if (modal) {
                    modal.classList.remove('hidden');
                }
            });

            function closeConflictModal() {
                const modal = document.getElementById('cart-conflict-modal');
                if (modal) modal.classList.add('hidden');
            }
        </script>
    @endif
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const methodDelivery = document.getElementById('method_delivery');
            const methodPickup = document.getElementById('method_pickup');
            const addressContainer = document.getElementById('address_container');
            const addressInput = document.getElementById('shipping_address_input');
            const shippingFeeText = document.getElementById('shipping_fee_text');
            const totalPriceText = document.getElementById('total_price_text');
            
            // Dữ liệu giá trị (Lấy tổng tiền thực tế từ PHP)
            const baseTotal = {{ $total ?? 0 }};
            const shippingFee = 30000;

            // Hàm định dạng tiền Việt Nam
            function formatCurrency(amount) {
                return new Intl.NumberFormat('vi-VN').format(amount) + 'đ';
            }

            // Hàm cập nhật giao diện khi đổi phương thức giao hàng
            function updateCheckoutUI() {
                if (methodDelivery.checked) {
                    // Chọn Giao hàng -> Hiện ô địa chỉ, cộng phí ship
                    addressContainer.style.display = 'block';
                    addressInput.required = true;
                    shippingFeeText.textContent = formatCurrency(shippingFee);
                    totalPriceText.textContent = formatCurrency(baseTotal + shippingFee);
                } else {
                    // Chọn Tự lấy -> Ẩn ô địa chỉ, free ship
                    addressContainer.style.display = 'none';
                    addressInput.required = false;
                    shippingFeeText.textContent = '0đ';
                    totalPriceText.textContent = formatCurrency(baseTotal);
                }
            }

            methodDelivery.addEventListener('change', updateCheckoutUI);
            methodPickup.addEventListener('change', updateCheckoutUI);
            updateCheckoutUI();
        });
    </script>
    <div id="qr-modal" class="fixed inset-0 hidden" style="z-index: 9999;">
        <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity"></div>
        
        <div class="fixed inset-0 flex items-center justify-center p-4 z-10">
            <div class="bg-white rounded-xl shadow-2xl p-6 w-full text-center" style="max-width: 400px;">
                
                <h3 class="text-xl font-bold text-gray-800 mb-2 uppercase">Thanh toán VNPAY</h3>
                <p class="text-sm text-gray-500 mb-6">Mở ứng dụng ngân hàng hoặc ví VNPAY để quét mã</p>
                
                <div class="bg-white p-2 rounded-lg border border-gray-200 inline-block mb-6 shadow-sm">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=ThanhToan_VNPAY_{{ $total + 30000 }}VND" alt="QR VNPAY" class="mx-auto w-48 h-48">
                </div>

                <div class="space-y-3">
                    <button type="button" id="simulate_paid_btn" class="w-full bg-amber-800 hover:bg-amber-900 text-white font-bold py-3 rounded-lg shadow-md transition-all flex justify-center items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        Giả lập: Quét mã thành công
                    </button>
                    <button type="button" onclick="closeQrModal()" class="w-full bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-3 rounded-lg transition-all">
                        Hủy giao dịch
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        
        const checkoutForm = document.getElementById('checkout_form');
        const qrModal = document.getElementById('qr-modal');
        const simulatePaidBtn = document.getElementById('simulate_paid_btn');

        function openQrModal() {
            if (qrModal) qrModal.classList.remove('hidden');
        }

        window.closeQrModal = function() {
            if (qrModal) qrModal.classList.add('hidden');
        }

        if (checkoutForm) {
            checkoutForm.addEventListener('submit', function(e) {
                const selectedPayment = document.querySelector('input[name="payment_method"]:checked').value;
                
                if (selectedPayment === 'VNPAY') {
                    e.preventDefault(); 
                    
                    // THÊM DÒNG NÀY: Đóng bảng Xác nhận đơn hàng đi
                    if (typeof closeCheckoutModal === 'function') {
                        closeCheckoutModal(); 
                    }
                    
                    openQrModal();     
                }
            });
        }

        if (simulatePaidBtn) {
            simulatePaidBtn.addEventListener('click', function() {
                simulatePaidBtn.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Đang xử lý thanh toán...
                `;
                simulatePaidBtn.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                simulatePaidBtn.classList.add('bg-green-500', 'cursor-not-allowed');
                
                setTimeout(() => {
                    simulatePaidBtn.innerHTML = "Thanh toán thành công!";
                    setTimeout(() => {
                        checkoutForm.submit(); 
                    }, 500);
                }, 1500);
            });
        }
    });
</script>
@include('partials.chatbox')

</body>
</html>