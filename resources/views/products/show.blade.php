<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $product->name }} - {{ env('APP_NAME') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/navbar.css'])
</head>
<body class="antialiased font-sans bg-gray-50 text-gray-800">

    @include('partials.navbar')

    <main class="pt-24 pb-10 px-6 max-w-5xl mx-auto min-h-screen">
        
        <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
            <a href="{{ route('home') }}" class="hover:text-emerald-700 transition-colors">Sản phẩm</a>
            <span>&rsaquo;</span>
            <span class="text-emerald-800 font-medium truncate">{{ $product->name }}</span>
        </nav>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8">
                
                <div class="rounded-xl overflow-hidden bg-gray-50 border border-gray-100 h-96 flex items-center justify-center relative group">
                    <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onerror="this.src='https://placehold.co/600x400?text=No+Image'">
                </div>

                <div class="flex flex-col justify-start">
                    
                    <h1 class="text-3xl font-bold text-emerald-800 mb-2 leading-tight">{{ $product->name }}</h1>
                    
                    <p class="text-3xl font-extrabold text-emerald-700 mb-4">
                        {{ number_format($product->price, 0, ',', '.') }}<span class="text-xl underline ml-0.5">đ</span>
                    </p>

                    <div class="text-sm text-gray-500 mb-6 space-y-2 border-b border-gray-100 pb-4">
                        <p>{{ $product->description ? trim($product->description) : 'Thông tin sản phẩm đang được cập nhật.' }}</p>
                        <p class="flex items-center gap-2">
                            <span class="inline-block w-2 h-2 rounded-full {{ $product->stock_status == 'AVAILABLE' ? 'bg-green-500' : 'bg-red-500' }}"></span>
                            {{ $product->stock_status == 'AVAILABLE' ? 'Đang giao dịch' : 'Hết hàng tạm thời' }}
                        </p>
                    </div>

                    @if($product->stock_status == 'AVAILABLE')
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" id="purchase-form" class="space-y-6">
                            @csrf
                            
                            <div class="flex items-center gap-4">
                                <span class="text-sm font-semibold text-gray-700">Số lượng:</span>
                                <div class="flex items-center border border-gray-300 rounded-full bg-white shadow-sm overflow-hidden">
                                    <button type="button" id="btn-decrease" class="w-10 h-10 flex items-center justify-center text-gray-600 hover:bg-gray-100 font-bold transition-colors select-none">&minus;</button>
                                    <input type="number" name="quantity" id="quantity-input" value="1" min="1" max="{{ $product->stock_quantity ?? 99 }}" class="w-12 h-10 text-center border-none focus:ring-0 text-sm font-semibold text-gray-800 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none" />
                                    <button type="button" id="btn-increase" class="w-10 h-10 flex items-center justify-center text-gray-600 hover:bg-gray-100 font-bold transition-colors select-none">&plus;</button>
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row gap-3 pt-4">
                                <button type="submit" name="action" value="buy_now" style="background-color: #047857 !important; color: #ffffff !important;" class="flex-1 hover:bg-emerald-800 text-white font-bold py-3 px-6 rounded-full shadow transition-all uppercase text-sm tracking-wider active:scale-98">
                                Mua ngay
                                </button>
                                <button type="submit" name="action" value="add_to_cart" style="background-color: #ffffff !important; color: #047857 !important; border-color: #059669 !important;"class="flex-1 hover:bg-emerald-50 border-2 font-bold py-3 px-6 rounded-full transition-all uppercase text-sm tracking-wider active:scale-98">
                                Thêm vào giỏ hàng
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="pt-4">
                            <button disabled class="w-full bg-gray-200 text-gray-500 font-bold py-3 px-6 rounded-full uppercase tracking-wide cursor-not-allowed text-sm">
                                Sản phẩm tạm hết hàng
                            </button>
                        </div>
                    @endif

                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <div class="flex border-b border-gray-200 gap-8 mb-6 overflow-x-auto">
                <button class="tab-btn pb-3 text-base font-bold text-emerald-800 border-b-2 border-emerald-700 whitespace-nowrap focus:outline-none" data-tab="description">
                    Mô tả sản phẩm
                </button>
                <button class="tab-btn pb-3 text-base font-medium text-gray-400 hover:text-gray-600 whitespace-nowrap focus:outline-none" data-tab="ingredients">
                    Thành phần
                </button>
                <button class="tab-btn pb-3 text-base font-medium text-gray-400 hover:text-gray-600 whitespace-nowrap focus:outline-none" data-tab="usage">
                    Hướng dẫn sử dụng
                </button>
            </div>

            <div class="tab-content text-gray-600 leading-relaxed text-sm">
                <div id="tab-description" class="tab-panel">
                    <p>{!! $product->description ? nl2br(e($product->description)) : 'Thông tin sản phẩm đang được cập nhật.' !!}</p>
                </div>
                
                <div id="tab-ingredients" class="tab-panel hidden">
                    <p>{!! $product->ingredients ? nl2br(e($product->ingredients)) : 'Thông tin sản phẩm đang được cập nhật.' !!}</p>
                </div>
                
                <div id="tab-usage" class="tab-panel hidden">
                    <p>{!! $product->usage_instruction ? nl2br(e($product->usage_instruction)) : 'Thông tin sản phẩm đang được cập nhật.' !!}</p>
                </div>
            </div>
        </div>

    </main>

    @include('partials.chatbox')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const decreaseBtn = document.getElementById('btn-decrease');
            const increaseBtn = document.getElementById('btn-increase');
            const qtyInput = document.getElementById('quantity-input');

            if(qtyInput) {
                decreaseBtn.addEventListener('click', function() {
                    let currentVal = parseInt(qtyInput.value) || 1;
                    if(currentVal > 1) {
                        qtyInput.value = currentVal - 1;
                    }
                });

                increaseBtn.addEventListener('click', function() {
                    let currentVal = parseInt(qtyInput.value) || 1;
                    let maxVal = parseInt(qtyInput.getAttribute('max')) || 99;
                    if(currentVal < maxVal) {
                        qtyInput.value = currentVal + 1;
                    }
                });
            }

            const tabs = document.querySelectorAll('.tab-btn');
            const panels = document.querySelectorAll('.tab-panel');

            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    tabs.forEach(t => {
                        t.classList.remove('text-emerald-800', 'border-b-2', 'border-emerald-700', 'font-bold');
                        t.classList.add('text-gray-400', 'font-medium');
                    });

                    panels.forEach(p => p.classList.add('hidden'));

                    this.classList.add('text-emerald-800', 'border-b-2', 'border-emerald-700', 'font-bold');
                    this.classList.remove('text-gray-400', 'font-medium');

                    const targetPanel = document.getElementById('tab-' + this.getAttribute('data-tab'));
                    if(targetPanel) {
                        targetPanel.classList.remove('hidden');
                    }
                });
            });
        });
    </script>
</body>
</html>