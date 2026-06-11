<x-admin>
    <div class="p-8 max-w-4xl mx-auto">
        <div class="mb-8">
            <h1 class="text-2xl font-black text-ef-fg tracking-tight uppercase">THÊM NGƯỜI DÙNG MỚI</h1>
            <p class="text-ef-grey-1 text-sm">Tạo tài khoản mới và phân quyền truy cập hệ thống.</p>
        </div>

        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-1">
                    <div class="bg-ef-bg-1 p-6 rounded-2xl border border-ef-bg-4 shadow-sm text-center">
                        <label class="block text-sm font-bold text-ef-fg mb-4 uppercase tracking-widest">Ảnh đại
                            diện</label>

                        <div class="relative group w-32 h-32 mx-auto mb-4">
                            <div id="avatar-preview"
                                class="w-full h-full rounded-full border-4 border-ef-bg-3 overflow-hidden bg-ef-bg-2 flex items-center justify-center">
                                <svg class="w-12 h-12 text-ef-bg-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <label for="avatar"
                                class="absolute bottom-0 right-0 bg-ef-blue text-ef-bg-0 p-2 rounded-full cursor-pointer shadow-lg hover:scale-110 transition-transform">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                            </label>
                            <input type="file" name="avatar" id="avatar" class="hidden" accept="image/*">
                        </div>
                        <p class="text-[10px] text-ef-grey-1 italic">Định dạng: JPG, PNG. Tối đa 2MB</p>
                        @error('avatar')
                            <p class="text-ef-red text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-ef-bg-1 p-8 rounded-2xl border border-ef-bg-4 shadow-sm space-y-5">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-bold text-ef-fg mb-2 uppercase tracking-tighter">Họ và
                                    tên <span class="text-ef-red">*</span></label>
                                <input type="text" name="full_name" value="{{ old('full_name') }}" required
                                    class="w-full px-4 py-3 bg-ef-bg-0 border border-ef-bg-4 rounded-xl focus:border-ef-blue outline-none text-ef-fg">
                                @error('full_name')
                                    <p class="text-ef-red text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-ef-fg mb-2 uppercase tracking-tighter">Email
                                    <span class="text-ef-red">*</span></label>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                    class="w-full px-4 py-3 bg-ef-bg-0 border border-ef-bg-4 rounded-xl focus:border-ef-blue outline-none text-ef-fg">
                                @error('email')
                                    <p class="text-ef-red text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-bold text-ef-fg mb-2 uppercase tracking-tighter">Số
                                    điện thoại</label>
                                <input type="text" name="phone" value="{{ old('phone') }}"
                                    class="w-full px-4 py-3 bg-ef-bg-0 border border-ef-bg-4 rounded-xl focus:border-ef-blue outline-none text-ef-fg">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-ef-fg mb-2 uppercase tracking-tighter">Vai
                                    trò <span class="text-ef-red">*</span></label>
                                <select name="role"
                                    class="w-full px-4 py-3 bg-ef-bg-0 border border-ef-bg-4 rounded-xl focus:border-ef-blue outline-none text-ef-fg font-bold">
                                    <option value="USER" {{ old('role') == 'USER' ? 'selected' : '' }}>Người dùng
                                        (USER)</option>
                                    <option value="ADMIN" {{ old('role') == 'ADMIN' ? 'selected' : '' }}>Quản trị viên
                                        (ADMIN)</option>
                                </select>
                            </div>
                        </div>

                        <div class="relative">
                            <label class="block text-sm font-bold text-ef-fg mb-2 uppercase tracking-tighter">Mật khẩu
                                <span class="text-ef-red">*</span></label>
                            <div class="relative">
                                <input type="password" name="password" id="password_input" required
                                    class="w-full px-4 py-3 bg-ef-bg-0 border border-ef-bg-4 rounded-xl focus:border-ef-blue outline-none text-ef-fg pr-12">
                                <button type="button" id="toggle_password"
                                    class="cursor-pointer absolute right-4 top-1/2 -translate-y-1/2 text-ef-grey-1 hover:text-ef-blue transition-colors">
                                    <svg id="eye_open" class="w-5 h-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="text-ef-red text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center gap-3 p-4 bg-ef-bg-2 rounded-xl border border-ef-bg-4">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" id="is_active"
                                {{ old('is_active', '1') == '1' ? 'checked' : '' }}
                                class="w-5 h-5 rounded border-ef-bg-4 text-ef-blue focus:ring-ef-blue bg-ef-bg-0">
                            <label for="is_active" class="text-sm font-bold text-ef-fg cursor-pointer">Kích hoạt tài
                                khoản ngay</label>
                        </div>

                        <div class="pt-4 flex gap-3">
                            <button type="submit"
                                class="cursor-pointer flex-1 py-3.5 bg-ef-green text-ef-bg-0 rounded-xl font-black text-xs tracking-widest hover:brightness-110 shadow-lg shadow-ef-green/20 transition-all uppercase">
                                TẠO TÀI KHOẢN
                            </button>
                            <a href="{{ route('admin.users.index') }}"
                                class="cursor-pointer px-8 py-3.5 bg-ef-bg-2 text-ef-grey-1 rounded-xl font-bold text-xs tracking-widest border border-ef-bg-4 uppercase">
                                HỦY
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>



    <script>
        // Preview Avatar
        const avatarInput = document.getElementById('avatar');
        const avatarPreview = document.getElementById('avatar-preview');

        avatarInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    avatarPreview.innerHTML =
                        `<img src="${e.target.result}" class="w-full h-full object-cover">`;
                }
                reader.readAsDataURL(file);
            }
        });

        // Toggle Password
        const toggleBtn = document.getElementById('toggle_password');
        const passInput = document.getElementById('password_input');

        toggleBtn.addEventListener('click', function() {
            const type = passInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passInput.setAttribute('type', type);
            this.classList.toggle('text-ef-blue');
        });
    </script>
</x-admin>
