<!DOCTYPE html>
<html lang="vi" class="antialiased">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản trị hệ thống</title>

    <link href='https://cdn.boxicons.com/3.0.6/fonts/basic/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }

        .custom-scrollbar:hover::-webkit-scrollbar-thumb {
            background: #cbd5e1;
        }

        .sidebar-mask {
            mask-image: linear-gradient(to bottom, black 90%, transparent 100%);
        }
    </style>
</head>

<body class="bg-ef-bg-0 text-ef-fg">

    <aside class="w-72 fixed inset-y-0 left-0 bg-ef-bg-1 border-r border-ef-bg-4 flex flex-col z-50">
        <div class="h-20 flex items-center px-8 flex-none border-b border-ef-bg-4/50">
            <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3">
                <div
                    class="w-10 h-10 bg-ef-green rounded-2xl flex items-center justify-center shadow-lg shadow-ef-blue/20 rotate-3 group-hover:rotate-0 transition-transform">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div class="flex flex-col">
                    <span class="text-sm font-black tracking-tighter text-ef-fg uppercase leading-none">ADMIN</span>
                    <span class="text-[9px] font-bold text-ef-green uppercase tracking-[0.2em] mt-1">Management</span>
                </div>
            </a>
        </div>

        <nav class="flex-1 px-4 py-6 overflow-y-auto space-y-8 custom-scrollbar">
            <div>
                <p class="px-4 text-[10px] font-black text-ef-grey-2 uppercase tracking-[0.2em] mb-4 opacity-70">Hệ
                    thống dữ liệu</p>
                <div class="space-y-1">
                    <x-nav-link route="admin.products.index" activeRoute="admin.products.*">
                        <x-slot name="icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </x-slot>
                        Sản phẩm
                    </x-nav-link>

                    <x-nav-link route="admin.categories.index" activeRoute="admin.categories.*">
                        <x-slot name="icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </x-slot>
                        Danh mục
                    </x-nav-link>
                </div>
            </div>

            <div>
                <p class="px-4 text-[10px] font-black text-ef-grey-2 uppercase tracking-[0.2em] mb-4 opacity-70">Kinh
                    doanh</p>
                <div class="space-y-1">
                    <x-nav-link route="admin.orders.index" activeRoute="admin.orders.*">
                        <x-slot name="icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </x-slot>
                        Đơn hàng
                    </x-nav-link>
                </div>
            </div>

            <div>
                <p class="px-4 text-[10px] font-black text-ef-grey-2 uppercase tracking-[0.2em] mb-4 opacity-70">Nhân sự
                </p>
                <div class="space-y-1">
                    <x-nav-link route="admin.users.index" activeRoute="admin.users.*">
                        <x-slot name="icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </x-slot>
                        Người dùng
                    </x-nav-link>
                </div>
            </div>
        </nav>

        <div class="p-4 mt-auto">
            <div
                class="bg-ef-bg-2/50 border border-ef-bg-4 rounded-3xl p-4 shadow-sm hover:border-ef-blue/30 transition-colors">
                <div class="flex items-center gap-3">
                    <div class="relative shrink-0">
                        <div
                            class="w-11 h-11 rounded-2xl bg-ef-green flex items-center justify-center text-white text-xs font-black shadow-lg shadow-ef-blue/20">
                            {{ strtoupper(substr(auth()->user()->full_name, 0, 2)) }}
                        </div>
                    </div>

                    <div class="flex-1 min-w-0">
                        <p class="text-[11px] font-black text-ef-fg truncate tracking-tight uppercase">
                            {{ auth()->user()->full_name }}
                        </p>
                        <p class="text-[9px] text-ef-grey-1 font-bold tracking-widest mt-0.5 opacity-60">
                            {{ auth()->user()->email }}
                        </p>
                    </div>

                    <form action="{{ route('logout') }}" method="POST" class="shrink-0 leading-none">
                        @csrf
                        <button type="submit" title="Đăng xuất"
                            class="cursor-pointer w-9 h-9 flex items-center justify-center text-ef-grey-1 hover:text-ef-red hover:bg-ef-red/10 rounded-xl transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </aside>

    <div class="ml-72 flex-1 min-h-screen">
        {{ $slot }}
    </div>

</body>

</html>
