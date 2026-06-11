<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>{{ env('APP_NAME') }} - {{ request()->routeIs('register') ? 'Đăng ký' : 'Đăng nhập' }}</title>

  @vite(['resources/css/app.css', 'resources/css/auth-styles.css'])
</head>

<body class="auth-body">

  @include('partials.navbar')

    <div class="container-box {{ (request('tab') === 'register' || old('full_name') || $errors->has('full_name')) ? 'right-panel-active' : '' }}" id="container">
        <div class="form-container sign-up-container">
            <form action="{{ route('register') }}" method="POST">
            @csrf

            <h1 class="font-bold text-2xl text-gray-700 mb-2">ĐĂNG KÝ</h1>
            <div class="w-full mb-4"></div>

            <label class="form-label">Họ và tên</label>
            <input type="text" name="full_name" placeholder="Nguyễn Văn A" value="{{ old('full_name') }}" required />
            @error('full_name') <span class="text-red-500 text-xs self-start ml-2">{{ $message }}</span> @enderror

            <label class="form-label">Email</label>
            <input type="email" name="email" placeholder="email@gmail.com" value="{{ old('email') }}" required />
            @error('email') <span class="text-red-500 text-xs self-start ml-2">{{ $message }}</span> @enderror

            <label class="form-label">Mật khẩu</label>
            <input type="password" name="password" required />
            @error('password') <span class="text-red-500 text-xs self-start ml-2">{{ $message }}</span> @enderror

            <button type="submit" class="btn-primary">Đăng ký</button>
        </form>
    </div>

    <div class="form-container sign-in-container">
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <h1 class="font-bold text-2xl text-gray-700 mb-4">ĐĂNG NHẬP</h1>

            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required />

            <label class="form-label">Mật khẩu</label>
            <input type="password" name="password" required />

            <button type="submit" class="btn-primary">Đăng nhập</button>
            <a href="#" class="text-sm text-gray-500 hover:text-gray-800 mt-2 mb-2">Quên mật khẩu?</a>

            @error('email_login')
                <span class="text-red-500 text-sm font-bold mt-2 mb-2 block">
                    {{ $message }}
                </span>
            @enderror

        </form>
    </div>

    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-left">
                <h1 class="font-bold text-2xl mb-4">Chào mừng trở lại!</h1>
                <p class="text-sm font-light leading-6 mb-8">
                    Đăng nhập để tiếp tục mua sắm và theo dõi đơn hàng của bạn!
                </p>
                <button class="ghost" id="signIn">Đăng nhập</button>
            </div>
            <div class="overlay-panel overlay-right">
                <h1 class="font-bold text-2xl mb-4">Xin chào!</h1>
                <p class="text-sm font-light leading-6 mb-8">
                    Hãy tạo tài khoản để nhận ưu đãi và thông báo khuyến mãi mới nhất!
                </p>
                <button class="ghost" id="signUp">Đăng ký</button>
            </div>
        </div>
    </div>
  </div>

  @vite('resources/js/auth-scripts.js')

</body>
</html>
