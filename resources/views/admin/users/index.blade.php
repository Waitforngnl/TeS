<x-admin>
    <header
        class="h-16 border-b border-ef-bg-4 bg-ef-bg-0 flex items-center justify-between px-8 sticky top-0 z-10 shadow-sm">
        <div class="flex items-center gap-4">
            <h1 class="text-xl text-ef-fg font-black tracking-tight uppercase">QUẢN LÝ NGƯỜI DÙNG</h1>
            <span class="bg-ef-bg-4 text-ef-grey-1 text-[10px] px-2 py-0.5 rounded-full font-bold">
                TỔNG: {{ $users->total() }}
            </span>
        </div>

        <a href="{{ route('admin.users.create') }}"
            class="bg-ef-green text-ef-bg-0 px-4 py-2 rounded-lg text-xs font-black tracking-widest hover:brightness-110 transition-all flex items-center shadow-lg shadow-ef-green/20">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
            </svg>
            THÊM NGƯỜI DÙNG
        </a>
    </header>

    <main class="p-8 max-w-7xl mx-auto">
        <div id="flash-message-container">
            @if (session('success'))
                <div
                    class="alert-box mb-6 p-4 bg-ef-bg-4 border-l-4 border-ef-green text-ef-green text-sm font-bold rounded-r-lg shadow-sm flex items-center transition-opacity duration-500">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div
                    class="alert-box mb-6 p-4 bg-ef-bg-4 border-l-4 border-ef-red text-ef-red text-sm font-bold rounded-r-lg shadow-sm flex items-center transition-opacity duration-500">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ session('error') }}
                </div>
            @endif
        </div>

        <form action="{{ route('admin.users.index') }}" method="GET" id="filter-form">
            <div
                class="mb-8 flex flex-col md:flex-row gap-4 items-center justify-between bg-ef-bg-1 p-5 rounded-2xl border border-ef-bg-4 shadow-sm">

                <div class="w-full md:w-1/2 relative group">
                    <span
                        class="absolute inset-y-0 left-0 pl-4 flex items-center text-ef-grey-1 group-focus-within:text-ef-blue transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Tìm kiếm tên người dùng..."
                        class="w-full pl-12 pr-4 py-3 bg-ef-bg-0 border border-ef-bg-4 rounded-xl focus:outline-none focus:border-ef-blue focus:ring-1 focus:ring-ef-blue text-sm text-ef-fg transition-all">
                </div>

                <div class="flex gap-2 w-full md:w-auto">
                    <select name="role" onchange="this.form.submit()"
                        class="bg-ef-bg-0 border border-ef-bg-4 rounded-xl px-4 py-2 text-sm text-ef-fg focus:outline-none focus:border-ef-blue cursor-pointer transition-all">
                        <option value="">Tất cả vai trò</option>
                        <option value="USER" {{ request('role') == 'USER' ? 'selected' : '' }}>Người dùng</option>
                        <option value="ADMIN" {{ request('role') == 'ADMIN' ? 'selected' : '' }}>Quản trị viên</option>
                    </select>

                    <select name="is_active" onchange="this.form.submit()"
                        class="bg-ef-bg-0 border border-ef-bg-4 rounded-xl px-4 py-2 text-sm text-ef-fg focus:outline-none focus:border-ef-blue cursor-pointer transition-all">
                        <option value="">Tất cả trạng thái</option>
                        {{-- Dùng string "1" và "0" để HTML gửi dữ liệu đi chuẩn xác nhất --}}
                        <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Hoạt động</option>
                        <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Đã khóa</option>
                    </select>
                </div>

                <button type="submit" class="hidden">Tìm kiếm</button>
            </div>
        </form>

        <div class="bg-ef-bg-1 rounded-2xl border border-ef-bg-4 shadow-sm overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-ef-bg-2 border-b border-ef-bg-4">
                        <th class="px-6 py-4 text-[10px] font-black text-ef-grey-1 uppercase tracking-widest">Người dùng
                        </th>
                        <th class="px-6 py-4 text-[10px] font-black text-ef-grey-1 uppercase tracking-widest">Liên hệ
                        </th>
                        <th
                            class="px-6 py-4 text-[10px] font-black text-ef-grey-1 uppercase tracking-widest text-center">
                            Vai trò</th>
                        <th
                            class="px-6 py-4 text-[10px] font-black text-ef-grey-1 uppercase tracking-widest text-center">
                            Trạng thái</th>
                        <th
                            class="px-6 py-4 text-[10px] font-black text-ef-grey-1 uppercase tracking-widest text-right">
                            Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ef-bg-4">
                    @forelse($users as $user)
                        <tr class="hover:bg-ef-bg-0/50 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full border-2 border-ef-bg-4 overflow-hidden bg-ef-bg-3 flex-shrink-0">
                                        @if ($user->avatar_url)
                                            <img src="{{ $user->avatar_url }}" alt="avatar"
                                                class="w-full h-full object-cover">
                                        @else
                                            <div
                                                class="w-full h-full flex items-center justify-center text-ef-grey-1 font-bold text-xs uppercase">
                                                {{ substr($user->full_name, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-ef-fg">{{ $user->full_name }}</div>
                                        <div class="text-[10px] text-ef-grey-1 font-mono uppercase tracking-tighter">ID:
                                            #{{ $user->id }}</div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="text-sm text-ef-fg font-medium">{{ $user->email }}</div>
                                <div class="text-xs text-ef-grey-1">{{ $user->phone ?? 'Chưa cập nhật SĐT' }}</div>
                            </td>

                            <td class="px-6 py-4 text-center">
                                @if ($user->role === 'ADMIN')
                                    <span
                                        class="px-2 py-1 bg-ef-bg-4 text-ef-orange text-[10px] font-black rounded border border-ef-orange/20">ADMIN</span>
                                @else
                                    <span
                                        class="px-2 py-1 bg-ef-bg-4 text-ef-blue text-[10px] font-black rounded border border-ef-blue/20">USER</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-center">
                                @if ($user->is_active)
                                    <span class="inline-flex items-center text-ef-green text-[11px] font-bold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-ef-green mr-2 animate-pulse"></span>
                                        Hoạt động
                                    </span>
                                @else
                                    <span class="inline-flex items-center text-ef-red text-[11px] font-bold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-ef-red mr-2"></span>
                                        Đã khóa
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                        class="p-2 text-ef-grey-1 hover:text-ef-blue hover:bg-ef-bg-3 rounded-lg transition-all"
                                        title="Chỉnh sửa">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>

                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa người dùng này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="cursor-pointer p-2 text-ef-grey-1 hover:text-ef-red hover:bg-ef-bg-3 rounded-lg transition-all shadow-none {{ auth()->id() === $user->id ? 'opacity-20 cursor-not-allowed' : '' }}"
                                            {{ auth()->id() === $user->id ? 'disabled' : '' }} title="Xóa">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center text-ef-grey-1">Chưa có người dùng nào.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-8">
            {{ $users->links() }}
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert-box');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }, 2000);
            });
        });
    </script>
</x-admin>
