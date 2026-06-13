@php
    $cart = session()->get('cart', []);
    $total = 0;
    foreach($cart as $item) {
        $total += $item['price'] * $item['quantity'];
    }
@endphp

@vite('resources/css/navbar.css')

<header class="fixed inset-x-0 top-0 z-50 bg-white border-b border-gray-100 shadow-sm font-sans">
    <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">

      <div class="flex-1 flex items-center">
          <a href="{{ route('home') }}" class="flex items-center gap-1">
            <img src="{{ asset('images/logo_2.png') }}" alt="Logo" class="h-18 w-auto object-contain">
            <span class="font-bold text-xl text-amber-800 tracking-tight uppercase">Tea shop</span>
          </a>
      </div>

      <nav class="hidden md:flex items-center justify-center gap-9">
        <a href="{{ route('home') }}" class="text-gray-600 hover:text-amber-600 font-medium text-base uppercase tracking-wide transition-colors">Trang chủ</a>
        <a href="{{ route('products') }}" class="text-gray-600 hover:text-amber-600 font-medium text-base uppercase tracking-wide transition-colors">Sản phẩm</a>
        <a href="{{ route('store') }}" class="text-gray-600 hover:text-amber-600 font-medium text-base uppercase tracking-wide transition-colors">Ưu đãi</a>
        <a href="{{ route('contact') }}" class="text-gray-600 hover:text-amber-600 font-medium text-base uppercase tracking-wide transition-colors">Liên hệ</a>
      </nav>

      <div class="flex-1 flex items-center justify-end gap-5">

        <div class="relative group h-full flex items-center cursor-pointer">
            <a href="{{ route('cart') }}" class="relative text-gray-600 hover:text-amber-600 transition-colors py-2">
                <img src="{{ asset('images/cart.jpg') }}" alt="Cart" class="w-6 h-6 object-contain opacity-70 hover:opacity-100 transition-opacity">
                <span class="absolute -top-2 -right-2 bg-amber-600 text-white text-[10px] font-bold h-4 w-4 rounded-full flex items-center justify-center">
                    {{ count($cart) }}
                </span>
            </a>

            <div class="absolute right-0 top-full mt-2 w-80 bg-white shadow-xl rounded-lg border border-black z-50 invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all duration-200 origin-top-right">

                <div class="absolute -top-2 right-2 w-4 h-4 bg-white border-t border-l border-black transform rotate-45"></div>

                <div class="p-4">
                    @if(isset($cart) && count($cart) > 0)
                    <div class="text-xs text-gray-400 mb-2">Sản phẩm mới thêm</div>
                        <div class="max-h-60 w-full overflow-y-auto space-y-5 mb-3 pr-1">
                            @foreach($cart as $item)
                            <div class="flex items-center gap-3 hover:bg-gray-50 p-1 rounded transition">
                                <img src="{{ asset($item['image'] ?? 'images/no-img.jpg') }}" class="w-10 h-10 object-cover rounded border border-gray-200">

                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-semibold text-gray-800 truncate">{{ $item['name'] }}</h4>
                                    <p class="text-xs text-gray-500">{{ number_format($item['price']) }}đ x {{ $item['quantity'] }}</p>
                                </div>

                                <span class="text-sm font-bold text-amber-700">
                                    {{ number_format($item['price'] * $item['quantity']) }}đ
                                </span>
                            </div>
                            @endforeach
                        </div>

                        <div class="border-t border-gray-100 pt-2 mb-2 flex justify-between items-center">
                            <span class="text-xs font-bold text-gray-500 uppercase">Tổng cộng</span>
                            <span class="text-base font-bold text-amber-800">{{ number_format($total ?? 0) }}đ</span>
                        </div>

                        <div class="border-t border-gray-100 pt-3 flex justify-end">
                            <a href="{{ route('cart') }}" class="px-4 py-2 bg-amber-800 hover:bg-amber-900 text-white text-xs font-bold rounded shadow-sm transition uppercase">
                                Xem giỏ hàng
                            </a>
                        </div>
                    @else
                        <div class="min-h-64 min-w-64 mx-auto flex flex-col items-center justify-center text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-3 opacity-40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <span class="text-sm font-medium whitespace-nowrap">Chưa có sản phẩm nào</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4">
            @auth
                <div class="relative h-full flex items-center cursor-pointer py-2 user-dropdown-group">
                    <button class="flex items-center gap-1 text-gray-800 font-semibold text-sm focus:outline-none">
                        <span>Hi, {{ auth()->user()->full_name }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="user-dropdown-menu absolute right-0 top-full mt-2 w-48 bg-white shadow-xl rounded-lg border border-black z-50">
                        <div class="absolute -top-2 right-4 w-4 h-4 bg-white border-t border-l border-black transform rotate-45"></div>
                        <div class="relative bg-white rounded-lg overflow-hidden">
                            <a href="{{ route('history.index') }}" class="block w-full px-4 py-3 text-sm text-gray-600 hover:bg-gray-50 hover:text-amber-800 transition-colors">
                                Lịch sử đơn hàng
                            </a>
                            <form action="{{ route('logout') }}" method="POST" class="block w-full m-0">
                                @csrf
                                <button type="submit" class="cursor-pointer block w-full text-left px-4 py-3 text-sm text-gray-600 hover:bg-red-50 hover:text-red-600 transition-colors">
                                    Đăng xuất
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <a href="{{ route('auth', ['tab' => 'login']) }}" class="text-gray-600 font-medium text-sm hover:text-amber-600 transition">Đăng nhập</a>
                <a href="{{ route('auth', ['tab' => 'register']) }}" class="px-4 py-2 bg-amber-800 hover:bg-amber-900 text-white text-sm font-bold rounded-full shadow-md transition">Đăng ký</a>
            @endauth
        </div>

      </div>
    </div>
</header>
