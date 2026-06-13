<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Liên hệ - {{ env('APP_NAME') }}</title>
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">

  @vite(['resources/css/app.css', 'resources/css/navbar.css'])

  <style>
    body {
      font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif !important;
    }
    .font-serif {
      font-family: 'Playfair Display', Georgia, serif !important;
    }
  </style>
</head>

<body class="antialiased bg-gray-50/50 text-gray-700">

  @include('partials.navbar')

  <main class="pt-28 pb-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 min-h-screen">
      
      <div class="mb-12">
          <h1 class="text-3xl font-bold text-amber-800 uppercase tracking-wide font-serif">
              Liên hệ với chúng tôi
          </h1>
          <p class="text-gray-500 text-sm mt-1">
              Lắng nghe ý kiến, đóng góp và câu hỏi của bạn về các sản phẩm trà thượng hạng.
          </p>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start mb-16">
          
          <div class="lg:col-span-5 space-y-8 bg-white p-8 rounded-xl shadow-xs border border-gray-100">
              <div>
                  <h2 class="text-xl font-bold text-gray-800 font-serif uppercase tracking-wider border-b border-gray-100 pb-3 mb-6">
                      Tea Shop Office
                  </h2>
                  
                  <div class="space-y-6">
                      <div class="flex items-start gap-4">
                          <div class="p-2.5 bg-amber-50 text-amber-700 rounded-lg shrink-0 mt-0.5">
                              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                              </svg>
                          </div>
                          <div>
                              <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-0.5">Địa chỉ</h3>
                              <p class="text-sm text-gray-700 font-medium leading-relaxed">
                                  123 Đường Ô Long, Phường Matcha, Quận 12, TP. Hồ Chí Minh
                              </p>
                          </div>
                      </div>

                      <div class="flex items-start gap-4">
                          <div class="p-2.5 bg-amber-50 text-amber-700 rounded-lg shrink-0 mt-0.5">
                              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                              </svg>
                          </div>
                          <div>
                              <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-0.5">Điện thoại</h3>
                              <p class="text-sm text-gray-700 font-bold">0123 456 789</p>
                              <p class="text-gray-400 text-xs mt-0.5">(Thứ 2 - Chủ Nhật, 8:00 - 21:00)</p>
                          </div>
                      </div>

                      <div class="flex items-start gap-4">
                          <div class="p-2.5 bg-amber-50 text-amber-700 rounded-lg shrink-0 mt-0.5">
                              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                              </svg>
                          </div>
                          <div>
                              <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-0.5">Email</h3>
                              <p class="text-sm text-gray-700 font-medium">hello@teashop.example</p>
                          </div>
                      </div>
                  </div>
              </div>
          </div>

          <div class="lg:col-span-7 bg-white p-8 rounded-xl shadow-xs border border-gray-100">
              <h2 class="text-xl font-bold text-gray-800 font-serif uppercase tracking-wider border-b border-gray-100 pb-3 mb-6">
                  Gửi lời nhắn cho chúng tôi
              </h2>

              <form action="#" method="POST" class="space-y-5">
                  @csrf
                  
                  <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                      <div>
                          <label for="name" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Họ và tên *</label>
                          <input type="text" id="name" name="name" required class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-amber-600 focus:ring-1 focus:ring-amber-600 bg-gray-50/50 transition-colors" placeholder="Nguyễn Tuấn Anh">
                      </div>
                      <div>
                          <label for="email" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Địa chỉ Email *</label>
                          <input type="email" id="email" name="email" required class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-amber-600 focus:ring-1 focus:ring-amber-600 bg-gray-50/50 transition-colors" placeholder="your-email@example.com">
                      </div>
                  </div>

                  <div>
                      <label for="phone" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Số điện thoại</label>
                      <input type="text" id="phone" name="phone" class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-amber-600 focus:ring-1 focus:ring-amber-600 bg-gray-50/50 transition-colors" placeholder="0123456789">
                  </div>

                  <div>
                      <label for="message" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Lời nhắn của bạn *</label>
                      <textarea id="message" name="message" rows="5" required class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-amber-600 focus:ring-1 focus:ring-amber-600 bg-gray-50/50 resize-none transition-colors" placeholder="Viết nội dung tin nhắn của bạn tại đây..."></textarea>
                  </div>

                  <div class="pt-2 flex justify-end">
                      <button type="submit" 
                        class="w-full sm:w-auto bg-amber-800 hover:bg-amber-900 text-white font-bold text-xs uppercase tracking-widest px-10 py-3.5 rounded-lg shadow-sm hover:shadow transition-all duration-300 cursor-pointer">
                            Gửi tin nhắn đi
                      </button>
                  </div>
              </form>
          </div>

      </div>
  </main>

</body>
</html>