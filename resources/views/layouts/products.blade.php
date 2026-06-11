<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sản phẩm - {{ env('APP_NAME') }}</title>
  
  @vite([
      'resources/css/app.css', 
      'resources/js/app.js',
      'resources/css/navbar.css',
      'resources/css/product.css', 
      'resources/js/product.js'
  ])
</head>

<body class="antialiased font-sans bg-gray-50">

  @include('partials.navbar')

  <main class="pt-24 pb-10 px-6 max-w-7xl mx-auto min-h-screen">

      @if(session('conflict'))
        <div id="conflict-modal-backdrop" class="fixed inset-0 bg-black bg-opacity-40 z-50 flex items-center justify-center hidden">
          <div id="conflict-modal" class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
            <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
              <div class="sm:flex sm:items-start">
                <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                  <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"></path>
                  </svg>
                </div>
                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                  <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Sản phẩm đã không còn</h3>
                  <div class="mt-2">
                    <p class="text-sm text-gray-500">{{ session('conflict.message') }}</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
              <button type="button" id="confirm-go-product" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">
                Đi tới sản phẩm
              </button>
              <button type="button" id="close-conflict-modal" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
                Đóng
              </button>
            </div>
          </div>
        </div>
      @endif

      <div class="flex items-center justify-between mb-8">
          <h1 class="text-3xl font-bold text-amber-800 uppercase tracking-wide">
              Thực đơn
              @if(isset($products))
                  <span class="text-sm font-normal text-gray-500 ml-2">({{ $products->total() }} món)</span>
              @endif
          </h1>
      </div>

      @if(isset($products) && $products->count() > 0)
        <div id="product-list" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            
            @foreach($products as $product)
                <div id="product-{{ $product->id }}" class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 group border border-gray-100 overflow-hidden flex flex-col">
                    
                    <a href="{{ route('products.show', $product->id) }}" class="relative h-48 w-full bg-gray-100 overflow-hidden block">
                        <img src="{{ $product->image_url }}" 
                                alt="{{ $product->name }}" 
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                onerror="this.src='https://placehold.co/600x400?text=No+Image'">
                        
                        @if($product->stock_status == 'OUT_OF_STOCK')
                            <span class="absolute top-2 right-2 px-2 py-1 text-[9px] font-black uppercase bg-ef-red/10 text-ef-red border border-ef-red/20 rounded-md backdrop-blur-sm whitespace-nowrap shadow-sm">
                                ● Hết hàng
                            </span>
                        @else
                            <span class="absolute top-2 right-2 px-2 py-1 text-[9px] font-black uppercase bg-ef-green/10 text-ef-green border border-ef-green/20 rounded-md backdrop-blur-sm whitespace-nowrap shadow-sm">
                                ● Còn hàng
                            </span>
                        @endif
                    </a>

                    <div class="p-4 flex flex-col flex-1">
                        <a href="{{ route('products.show', $product->id) }}">
                            <h3 class="text-lg font-bold text-gray-800 mb-1 leading-tight group-hover:text-amber-700">
                                {{ $product->name }}
                            </h3>
                        </a>
                        
                        <p class="text-gray-500 text-sm line-clamp-2 mb-4 flex-1">
                            {{ $product->description }}
                        </p>

                        <div class="flex items-center justify-between mt-auto">
                            <span class="text-lg font-extrabold text-amber-800">
                                {{ number_format($product->price, 0, ',', '.') }}đ
                            </span>

                            @if($product->stock_status == 'AVAILABLE')
                                <div class="flex items-center gap-2">
                                    <span class="text-sm text-gray-600">SL: <span class="font-bold text-amber-800">{{ $product->stock_quantity }}</span></span>

                                    @auth
                                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="w-8 h-8 rounded-full bg-amber-100 text-amber-800 flex items-center justify-center hover:bg-amber-800 hover:text-white transition-colors" title="Thêm vào giỏ hàng">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                                </svg>
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('auth', ['tab' => 'login']) }}" 
                                            class="w-8 h-8 rounded-full bg-amber-100 text-amber-800 flex items-center justify-center hover:bg-amber-800 hover:text-white transition-colors" 
                                            title="Đăng nhập để mua hàng">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                            </svg>
                                        </a>
                                    @endauth
                                </div>

                            @else
                                <button disabled class="px-3 py-1 bg-gray-100 text-gray-400 text-xs rounded cursor-not-allowed">
                                    Hết
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach

        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>

      @else
        <div class="p-10 text-center border-2 border-dashed border-gray-300 rounded text-gray-500">
            Chưa có sản phẩm nào trong Database.
        </div>
      @endif

  </main>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const conflict = {!! json_encode(session('conflict')) !!};
      if (conflict) {
        const backdrop = document.getElementById('conflict-modal-backdrop');
        const closeBtn = document.getElementById('close-conflict-modal');
        const confirmBtn = document.getElementById('confirm-go-product');
        const openModal = () => backdrop.classList.remove('hidden');
        const closeModal = () => backdrop.classList.add('hidden');

        openModal();

        if (closeBtn) closeBtn.addEventListener('click', closeModal);

        if (confirmBtn) confirmBtn.addEventListener('click', function() {
          const el = document.getElementById('product-' + conflict.id);
          if (el) {
            // scroll and highlight
            el.scrollIntoView({ behavior: 'smooth', block: 'center' });
            el.classList.add('ring-4', 'ring-amber-300');
            // close modal after short delay
            setTimeout(closeModal, 400);
          } else {
            // fallback: go to products list anchor
            window.location.href = '{{ route("products") }}#product-' + conflict.id;
          }
        });
      }
    });
  </script>

@include('partials.chatbox')

</body>
</html>