<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>{{ env('APP_NAME') }}</title>
  @vite('resources/css/app.css')
</head>

<body class="antialiased font-sans">

  @include('partials.navbar')

  <main class="min-h-screen flex items-center justify-center relative">
    
    <img src="{{ asset('images/hero.jpg') }}" class="absolute inset-0 w-full h-full object-cover -z-10 brightness-50">

    <div class="text-center px-4 relative z-10">
        
        <h3 class="text-white text-lg md:text-xl uppercase tracking-[0.3em] font-light mb-2">
            Phong cách độc nhất
        </h3>

        <p class="text-white/80 text-base md:text-lg italic font-serif mb-6">
            Kể từ những năm 80
        </p>

        <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-amber-500 uppercase tracking-widest font-serif mb-10 drop-shadow-md">
            Coffee Đặc Biệt
        </h1>

        <a href="{{ route('products') }}" class="inline-block px-10 py-3 border-2 border-amber-500 text-amber-500 font-bold uppercase tracking-wider transition-all duration-300 hover:bg-amber-500 hover:text-white hover:shadow-lg hover:scale-105">
            Đặt hàng ngay
        </a>

    </div>
  </main>

</body>
</html>