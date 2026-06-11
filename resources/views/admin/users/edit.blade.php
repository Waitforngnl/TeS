<x-admin>
    <div class="p-8 max-w-4xl mx-auto">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-black text-ef-fg tracking-tight uppercase">CHỈNH SỬA NGƯỜI DÙNG</h1>
                <p class="text-ef-grey-1 text-sm">Cập nhật thông tin chi tiết cho tài khoản <span
                        class="text-ef-blue font-bold">{{ $user->full_name }}</span></p>
            </div>
            <a href="{{ route('admin.users.index') }}"
                class="text-ef-grey-1 hover:text-ef-fg transition-colors flex items-center text-xs font-bold uppercase tracking-widest">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Quay lại
            </a>
        </div>

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-1">
                    <div class="bg-ef-bg-1 p-6 rounded-2xl border border-ef-bg-4 shadow-sm text-center sticky top-24">
                        <label class="block text-sm font-bold text-ef-fg mb-4 uppercase tracking-widest">Ảnh đại
                            diện</label>

                        <div class="relative group w-32 h-32 mx-auto mb-4">
                            <div id="avatar-preview"
                                class="w-full h-full rounded-full border-4 border-ef-bg-3 overflow-hidden bg-ef-bg-2 flex items-center justify-center shadow-inner">
                                @if ($user->avatar_url)
                                    <img src="{{ $user->avatar_url }}" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-12 h-12 text-ef-bg-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                @endif
                            </div>
                            <label for="avatar"
                                class="absolute bottom-0 right-0 bg-ef-blue text-ef-bg-0 p-2 rounded-full cursor-pointer shadow-lg hover:rotate-90 transition-all duration-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </label>
                            <input type="file" name="avatar" id="avatar" class="hidden" accept="image/*">
                        </div>
                        <p class="text-[10px] text-ef-grey-1 italic">Để trống nếu không muốn đổi ảnh</p>
                        @error('avatar')
                            <p class="text-ef-red text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-ef-bg-1 p-8 rounded-2xl border border-ef-bg-4 shadow-sm space-y-5">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-bold text-ef-fg mb-2 uppercase">Họ và tên</label>
                                <input type="text" name="full_name" value="{{ old('full_name', $user->full_name) }}"
                                    required
                                    class="w-full px-4 py-3 bg-ef-bg-0 border border-ef-bg-4 rounded-xl focus:border-ef-blue outline-none text-ef-fg">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-ef-fg mb-2 uppercase">Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                    class="w-full px-4 py-3 bg-ef-bg-0 border border-ef-bg-4 rounded-xl focus:border-ef-blue outline-none text-ef-fg">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-bold text-ef-fg mb-2 uppercase">Số điện thoại</label>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                    class="w-full px-4 py-3 bg-ef-bg-0 border border-ef-bg-4 rounded-xl focus:border-ef-blue outline-none text-ef-fg">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-ef-fg mb-2 uppercase">Vai trò</label>
                                <select name="role"
                                    class="w-full px-4 py-3 bg-ef-bg-0 border border-ef-bg-4 rounded-xl focus:border-ef-blue outline-none text-ef-fg font-bold"
                                    {{ auth()->id() === $user->id ? 'disabled' : '' }}>
                                    <option value="USER" {{ old('role', $user->role) == 'USER' ? 'selected' : '' }}>
                                        Người dùng (USER)</option>
                                    <option value="ADMIN" {{ old('role', $user->role) == 'ADMIN' ? 'selected' : '' }}>
                                        Quản trị viên (ADMIN)</option>
                                </select>
                                @if (auth()->id() === $user->id)
                                    <input type="hidden" name="role" value="{{ $user->role }}">
                                    <p class="text-[10px] text-ef-orange mt-1">* Bạn không thể tự đổi quyền của chính
                                        mình</p>
                                @endif
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-ef-fg mb-2 uppercase">Mật khẩu mới</label>
                            <div class="relative">
                                <input type="password" name="password" id="password_input"
                                    placeholder="Để trống nếu không thay đổi"
                                    class="w-full px-4 py-3 bg-ef-bg-0 border border-ef-bg-4 rounded-xl focus:border-ef-blue outline-none text-ef-fg pr-12">
                                <button type="button" id="toggle_password"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-ef-grey-1 hover:text-ef-blue transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
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
                                {{ old('is_active', $user->is_active) == '1' ? 'checked' : '' }}
                                {{ auth()->id() === $user->id ? 'disabled' : '' }}
                                class="w-5 h-5 rounded border-ef-bg-4 text-ef-blue focus:ring-ef-blue bg-ef-bg-0">
                            <label for="is_active" class="text-sm font-bold text-ef-fg cursor-pointer">Tài khoản đang
                                hoạt động</label>
                            @if (auth()->id() === $user->id)
                                <input type="hidden" name="is_active" value="1">
                            @endif
                        </div>

                        <div class="pt-4 flex gap-3">
                            <button type="submit"
                                class="flex-1 py-3.5 bg-ef-blue text-ef-bg-0 rounded-xl font-black text-xs tracking-widest hover:brightness-110 shadow-lg shadow-ef-blue/20 transition-all uppercase">
                                CẬP NHẬT THÔNG TIN
                            </button>
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
