<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Ưu đãi & Combo - {{ env('APP_NAME') }}</title>
  
  @vite(['resources/css/app.css', 'resources/css/navbar.css'])
</head>

<body class="antialiased font-sans bg-gray-50/50 text-gray-700">

  @include('partials.navbar')

  @php
      /**
       * Tự động tìm kiếm sản phẩm thuộc danh mục có tên hoặc slug là "Ưu đãi" hoặc "Combo"
       * Giải pháp này giúp bạn không cần sửa file web.php hay tạo thêm Controller mới.
       */
      $comboProducts = \App\Models\Products::whereHas('category', function($query) {
          $query->where('slug', 'like', '%uu-dai%')
                ->orWhere('slug', 'like', '%combo%')
                ->orWhere('name', 'like', '%Ưu đãi%')
                ->orWhere('name', 'like', '%Combo%');
      })->latest()->get();
  @endphp

  <main class="pt-28 pb-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 min-h-screen">
      
      <div class="mb-10">
          <h1 class="text-3xl font-bold text-amber-800 uppercase tracking-wide">Ưu Đãi & Combo</h1>
          <p class="text-gray-500 text-sm mt-1">Thưởng thức những combo và ưu đãi hấp dẫn nhất từ Tea Shop.</p>
      </div>

      @if($comboProducts->isEmpty())
          <div class="bg-white rounded-xl border border-gray-100 p-12 text-center shadow-xs max-w-2xl mx-auto mt-10">
              <div class="w-16 h-16 bg-amber-50 rounded-full flex items-center justify-center mx-auto mb-4 text-amber-800">
                  <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                  </svg>
              </div>
              <h3 class="text-lg font-bold text-gray-800 mb-2">Chưa có ưu đãi / combo</h3>
              <p class="text-gray-500 text-sm leading-relaxed mb-4">
                  Trang này đang được thiết lập để lấy sản phẩm động từ Admin. 
              </p>
              <div class="text-left bg-gray-50 p-4 rounded-lg text-xs text-gray-600 space-y-1 border border-gray-100">
                  <p class="font-bold text-amber-800 mb-1">Hướng dẫn kích hoạt dữ liệu:</p>
                  <p><strong>Bước 1:</strong> Vào Admin &gt; Quản lý danh mục &gt; Tạo danh mục mới tên là <strong>"Ưu đãi"</strong> hoặc <strong>"Combo"</strong>.</p>
                  <p><strong>Bước 2:</strong> Vào Admin &gt; Quản lý sản phẩm &gt; Tạo các gói combo rồi chọn danh mục vừa tạo ở Bước 1.</p>
              </div>
          </div>
      @else
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
              @foreach($comboProducts as $product)
                  <div class="bg-white rounded-xl shadow-xs border border-gray-100 overflow-hidden hover:shadow-md transition-all duration-300 flex flex-col justify-between group">
                      <div>
                          <div class="relative overflow-hidden aspect-video bg-gray-100 flex items-center justify-center border-b border-gray-100">
                              @if($product->image_url)
                                  <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 brightness-95">
                              @else
                                  <img src="{{ asset('images/hero.jpg') }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 brightness-95">
                              @endif
                              
                              <span class="absolute top-4 left-4 bg-amber-600 text-white text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider shadow-xs">
                                  {{ $product->category->name ?? 'Ưu đãi' }}
                              </span>
                          </div>
                          
                          <div class="p-6">
                              <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-1 group-hover:text-amber-800 transition-colors">
                                  {{ $product->name }}
                              </h3>
                              <p class="text-gray-500 text-sm line-clamp-2 mb-4 h-10 leading-relaxed">
                                  {{ $product->description ?? 'Chưa có mô tả chi tiết cho gói sản phẩm ưu đãi này.' }}
                              </p>
                              <div class="flex items-baseline gap-2">
                                  <span class="text-2xl font-bold text-amber-700">
                                      {{ number_format($product->price, 0, ',', '.') }}đ
                                  </span>
                              </div>
                          </div>
                      </div>
                      
                      <div class="p-6 pt-0">
                          <a href="{{ route('products.show', $product->id) }}" class="block text-center w-full py-2.5 border border-amber-800 text-amber-800 hover:bg-amber-800 hover:text-white font-bold text-sm rounded-lg transition-colors uppercase tracking-wider cursor-pointer">
                              Xem chi tiết
                          </a>
                      </div>
                  </div>
              @endforeach
          </div>
      @endif

  </main>

</body>
</html>