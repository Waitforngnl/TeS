<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Ưu đãi đặc biệt - {{ env('APP_NAME') }}</title>
  @vite('resources/css/app.css')
</head>

<body class="antialiased font-sans bg-gray-50/50">

  @include('partials.navbar')

  <div class="pt-28 pb-16 px-6 max-w-7xl mx-auto min-h-screen">
    
    <div class="mb-10">
        <h1 class="text-3xl font-bold text-amber-800 uppercase tracking-wide">Ưu Đãi Đặc Biệt</h1>
        <p class="text-gray-500 text-sm mt-1">Thưởng thức những combo trà sữa thơm ngon với mức giá hấp dẫn nhất trong tuần.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-all duration-300 flex flex-col justify-between">
            <div>
                <div class="relative">
                    <img src="{{ asset('images/inside-tea-village.jpg') }}" class="w-full h-56 object-cover brightness-95">
                    <span class="absolute top-4 left-4 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow">
                        Bán chạy
                    </span>
                </div>
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Combo Đôi Bạn</h3>
                    <p class="text-gray-500 text-sm line-clamp-2 mb-4">Gồm 2 ly Trà Sữa Trân Châu Truyền Thống size L đậm vị trà, béo ngậy vị sữa.</p>
                    <div class="flex items-baseline gap-2">
                        <span class="text-2xl font-bold text-amber-700">65.000đ</span>
                        <span class="text-sm text-gray-400 line-through">80.000đ</span>
                    </div>
                </div>
            </div>
            <div class="p-6 pt-0">
                <a href="{{ route('products') }}" class="block text-center w-full py-2.5 border border-amber-800 text-amber-800 hover:bg-amber-800 hover:text-white font-bold text-sm rounded-lg transition-colors uppercase tracking-wider">
                    Xem sản phẩm
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-all duration-300 flex flex-col justify-between">
            <div>
                <div class="relative">
                    <img src="{{ asset('images/inside-tea-village.jpg') }}" class="w-full h-56 object-cover brightness-95">
                    <span class="absolute top-4 left-4 bg-amber-600 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow">
                        Combo Tiết Kiệm
                    </span>
                </div>
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Combo Sảng Khoái</h3>
                    <p class="text-gray-500 text-sm line-clamp-2 mb-4">Sự kết hợp hoàn hảo giữa 1 ly Trà Trái Cây Nhiệt Đới thanh mát và 1 bánh ngọt Pháp đi kèm.</p>
                    <div class="flex items-baseline gap-2">
                        <span class="text-2xl font-bold text-amber-700">60.000đ</span>
                        <span class="text-sm text-gray-400 line-through">75.000đ</span>
                    </div>
                </div>
            </div>
            <div class="p-6 pt-0">
                <a href="{{ route('products') }}" class="block text-center w-full py-2.5 border border-amber-800 text-amber-800 hover:bg-amber-800 hover:text-white font-bold text-sm rounded-lg transition-colors uppercase tracking-wider">
                    Xem sản phẩm
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-all duration-300 flex flex-col justify-between">
            <div>
                <div class="relative">
                    <img src="{{ asset('images/inside-tea-village.jpg') }}" class="w-full h-56 object-cover brightness-95">
                    <span class="absolute top-4 left-4 bg-green-600 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow">
                        Mới
                    </span>
                </div>
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Combo Party Gia Đình</h3>
                    <p class="text-gray-500 text-sm line-clamp-2 mb-4">Gói tiệc nhỏ gồm 3 ly Trà Sữa tự chọn + 1 phần trân châu hoàng kim thêm siêu to.</p>
                    <div class="flex items-baseline gap-2">
                        <span class="text-2xl font-bold text-amber-700">115.000đ</span>
                        <span class="text-sm text-gray-400 line-through">140.000đ</span>
                    </div>
                </div>
            </div>
            <div class="p-6 pt-0">
                <a href="{{ route('products') }}" class="block text-center w-full py-2.5 border border-amber-800 text-amber-800 hover:bg-amber-800 hover:text-white font-bold text-sm rounded-lg transition-colors uppercase tracking-wider">
                    Xem sản phẩm
                </a>
            </div>
        </div>

    </div>
  </div>

</body>
</html>