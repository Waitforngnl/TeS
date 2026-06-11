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
        
        <a href="{{ route('products') }}" class="inline-flex items-center gap-2 text-amber-800 hover:text-amber-900 font-medium mb-8 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Quay lại thực đơn
        </a>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8">
                
                <div class="rounded-xl overflow-hidden bg-gray-100 h-96 flex items-center justify-center">
                    <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}" class="w-full h-full object-cover" onerror="this.src='https://placehold.co/600x600?text=No+Image'">
                </div>

                <div class="flex flex-col justify-center">
                    
                    @if($product->stock_status == 'AVAILABLE')
                        <span class="inline-block px-3 py-1 bg-green-100 text-green-700 text-xs font-bold uppercase rounded-full w-fit mb-4 tracking-wider">Còn hàng</span>
                    @else
                        <span class="inline-block px-3 py-1 bg-red-100 text-red-700 text-xs font-bold uppercase rounded-full w-fit mb-4 tracking-wider">Hết hàng</span>
                    @endif

                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
                    
                    <p class="text-3xl font-extrabold text-amber-800 mb-6">
                        {{ number_format($product->price, 0, ',', '.') }}đ
                    </p>

                    <div class="prose text-gray-600 mb-8">
                        <p class="leading-relaxed">{{ $product->description }}</p>
                    </div>

                    <div class="border-t border-gray-100 pt-6 mt-auto">
                        @if($product->stock_status == 'AVAILABLE')
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex gap-4">
                                @csrf
                                <button type="submit" class="flex-1 bg-amber-800 hover:bg-amber-900 text-white font-bold py-4 px-8 rounded-lg shadow-lg uppercase tracking-wide transition-transform transform active:scale-95 flex justify-center items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Thêm vào giỏ hàng
                                </button>
                            </form>
                        @else
                            <button disabled class="w-full bg-gray-200 text-gray-500 font-bold py-4 px-8 rounded-lg uppercase tracking-wide cursor-not-allowed">
                                Sản phẩm tạm hết
                            </button>
                        @endif
                    </div>

                </div>
            </div>
        </div>

    </main>

    @include('partials.chatbox')
</body>
</html>