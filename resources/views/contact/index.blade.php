<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Liên hệ - {{ env('APP_NAME') }}</title>
  @vite(['resources/css/app.css', 'resources/css/navbar.css'])
</head>

<body class="antialiased font-sans bg-[#faf9f6] text-gray-700">

  @include('partials.navbar')

  <main class="pt-28 pb-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 min-h-screen">
      
      <div class="text-center mb-16">
          <h1 class="text-3xl md:text-4xl font-light text-emerald-800 uppercase tracking-widest mb-3">
              Liên hệ với chúng tôi
          </h1>
          <div class="h-0.5 w-12 bg-emerald-700 mx-auto"></div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start mb-16">
          
          <div class="lg:col-span-5 space-y-8 bg-white p-8 rounded-xl shadow-xs border border-gray-100">
              <div>
                  <h2 class="text-xl font-medium text-emerald-800 uppercase tracking-wider mb-6">
                      Tea Shop Office
                  </h2>
                  <p class="text-sm text-gray-500 leading-relaxed mb-6">
                      Chúng tôi luôn sẵn sàng lắng nghe ý kiến, đóng góp và câu hỏi của bạn về các sản phẩm trà thượng hạng. Hãy kết nối với chúng tôi qua các kênh dưới đây.
                  </p>
              </div>

              <div class="space-y-6">
                  <div class="flex items-start gap-4">
                      <div class="text-emerald-700 mt-1">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                              <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                          </svg>
                      </div>
                      <div>
                          <h4 class="text-sm font-semibold text-gray-800 uppercase tracking-wider mb-1">Địa chỉ</h4>
                          <p class="text-sm text-gray-500">123 Đường Ô Long, Phường Matcha, Quận 12, TP. Hồ Chí Minh</p>
                      </div>
                  </div>

                  <div class="flex items-start gap-4">
                      <div class="text-emerald-700 mt-1">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                          </svg>
                      </div>
                      <div>
                          <h4 class="text-sm font-semibold text-gray-800 uppercase tracking-wider mb-1">Điện thoại</h4>
                          <p class="text-sm text-gray-500">0123 456 789 <span class="text-xs text-gray-400 block">(Thứ 2 - Chủ Nhật, 8:00 - 21:00)</span></p>
                      </div>
                  </div>

                  <div class="flex items-start gap-4">
                      <div class="text-emerald-700 mt-1">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                          </svg>
                      </div>
                      <div>
                          <h4 class="text-sm font-semibold text-gray-800 uppercase tracking-wider mb-1">Email</h4>
                          <p class="text-sm text-gray-500">hello@teashop.example</p>
                      </div>
                  </div>
              </div>
          </div>

          <div class="lg:col-span-7 bg-white p-8 md:p-10 rounded-xl shadow-xs border border-gray-100">
              <h3 class="text-lg font-medium text-emerald-800 uppercase tracking-wider mb-6">
                  Gửi lời nhắn cho chúng tôi
              </h3>
              
              <form action="#" method="POST" class="space-y-5">
                  @csrf
                  <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                      <div>
                          <label for="name" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Họ và tên *</label>
                          <input type="text" id="name" name="name" required class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-emerald-700 focus:ring-1 focus:ring-emerald-700 bg-gray-50/50" placeholder="Nguyễn Tuấn Anh">
                      </div>
                      <div>
                          <label for="email" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Địa chỉ Email *</label>
                          <input type="email" id="email" name="email" required class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-emerald-700 focus:ring-1 focus:ring-emerald-700 bg-gray-50/50" placeholder="your-email@example.com">
                      </div>
                  </div>

                  <div>
                      <label for="phone" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Số điện thoại</label>
                      <input type="text" id="phone" name="phone" class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-emerald-700 focus:ring-1 focus:ring-emerald-700 bg-gray-50/50" placeholder="0123456789">
                  </div>

                  <div>
                      <label for="message" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Lời nhắn của bạn *</label>
                      <textarea id="message" name="message" rows="5" required class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-emerald-700 focus:ring-1 focus:ring-emerald-700 bg-gray-50/50 resize-none" placeholder="Viết nội dung tin nhắn của bạn tại đây..."></textarea>
                  </div>

                  <div class="pt-2">
                      <button type="submit" 
                        style="background-color: #047857 !important; color: #ffffff !important;"
                        class="w-full sm:w-auto hover:bg-emerald-800 text-white font-bold text-xs uppercase tracking-widest px-10 py-4 rounded-full shadow-md hover:shadow-lg transition-all duration-300 transform active:scale-98">
                            Gửi tin nhắn đi
                        </button>
                  </div>
              </form>
          </div>

      </div>


      

  </main>

  @include('partials.chatbox')

</body>
</html>