<x-admin>
    <div class="p-8 max-w-3xl mx-auto">
        <div class="mb-8">
            <h1 class="text-2xl font-black text-ef-fg tracking-tight">THÊM DANH MỤC MỚI</h1>
            <p class="text-ef-grey-1 text-sm">Danh mục giúp bạn phân loại và quản lý sản phẩm dễ dàng hơn.</p>
        </div>

        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf

            <div class="bg-ef-bg-1 p-8 rounded-2xl border border-ef-bg-4 shadow-sm space-y-6">

                <div>
                    <label for="name" class="block text-sm font-bold text-ef-fg mb-2">Tên danh mục <span
                            class="text-ef-red">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="w-full px-4 py-3 bg-ef-bg-0 border {{ $errors->has('name') ? 'border-ef-red ring-1 ring-ef-red/20' : 'border-ef-bg-4' }} rounded-xl focus:border-ef-blue outline-none transition-all text-ef-fg font-medium">
                    @error('name')
                        <p class="text-ef-red text-xs mt-2 font-medium">× {{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="slug" class="text-sm font-bold text-ef-fg mb-2 flex items-center">
                        Slug (Đường dẫn)
                        <span class="ml-2 text-[10px] text-ef-grey-1 font-normal italic">(Tự động tạo từ tên)</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-ef-grey-1 text-sm">/</span>
                        <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
                            placeholder="ten-danh-muc"
                            class="w-full pl-7 pr-4 py-3 bg-ef-bg-2 border {{ $errors->has('slug') ? 'border-ef-red' : 'border-ef-bg-4' }} rounded-xl focus:border-ef-blue outline-none transition-all text-ef-grey-1 font-mono text-sm">
                    </div>
                    @error('slug')
                        <p class="text-ef-red text-xs mt-2 font-medium">× {{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4 flex flex-col sm:flex-row gap-3">
                    <button type="submit"
                        class="flex-1 py-3.5 bg-ef-green text-ef-bg-0 rounded-xl font-black text-xs tracking-widest hover:brightness-110 shadow-lg shadow-ef-green/20 transition-all uppercase">
                        TẠO DANH MỤC
                    </button>
                    <a href="{{ route('admin.categories.index') }}"
                        class="px-8 py-3.5 bg-ef-bg-2 text-ef-grey-1 text-center rounded-xl font-bold text-xs tracking-widest hover:bg-ef-bg-3 border border-ef-bg-4 transition-all uppercase">
                        HỦY BỎ
                    </a>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('name').addEventListener('input', function() {
            let name = this.value;
            let slug = name.toLowerCase()
                .normalize('NFD') // Chuẩn hóa Unicode để tách dấu
                .replace(/[\u0300-\u036f]/g, '') // Xóa các dấu tiếng Việt
                .replace(/[đĐ]/g, 'd')
                .replace(/([^0-9a-z-\s])/g, '') // Xóa ký tự đặc biệt
                .replace(/(\s+)/g, '-') // Thay khoảng trắng bằng gạch ngang
                .replace(/-+/g, '-') // Tránh lặp gạch ngang
                .replace(/^-+|-+$/g, ''); // Xóa gạch ngang ở đầu/cuối

            document.getElementById('slug').value = slug;
        });
    </script>
</x-admin>
