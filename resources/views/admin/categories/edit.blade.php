<x-admin>
    <div class="p-8 max-w-3xl mx-auto">
        <div class="mb-8 flex justify-between items-end">
            <div>
                <h1 class="text-2xl font-black text-ef-fg tracking-tight uppercase">CHỈNH SỬA DANH MỤC</h1>
                <p class="text-ef-grey-1 text-sm">Cập nhật thông tin cho danh mục: <span
                        class="text-ef-blue font-bold">{{ $category->name }}</span></p>
            </div>
            <span
                class="text-[10px] font-mono bg-ef-bg-4 px-2 py-1 rounded text-ef-grey-1 border border-ef-bg-5 shadow-sm">ID:
                #{{ $category->id }}</span>
        </div>

        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="bg-ef-bg-1 p-8 rounded-2xl border border-ef-bg-4 shadow-sm space-y-6">
                <div>
                    <label for="name" class="block text-sm font-bold text-ef-fg mb-2">Tên danh mục <span
                            class="text-ef-red">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}"
                        required
                        class="w-full px-4 py-3 bg-ef-bg-0 border {{ $errors->has('name') ? 'border-ef-red ring-1 ring-ef-red/20' : 'border-ef-bg-4' }} rounded-xl focus:border-ef-blue outline-none transition-all text-ef-fg font-medium">
                    @error('name')
                        <p class="text-ef-red text-xs mt-2 font-medium">× {{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="slug" class="text-sm font-bold text-ef-fg mb-2 flex items-center justify-between">
                        <span class="flex items-center">
                            Slug (Đường dẫn) <span class="text-ef-red ml-1">*</span>
                            <span id="slug-status"
                                class="ml-2 text-[10px] text-ef-blue opacity-0 transition-opacity uppercase tracking-widest font-black">●
                                Đã cập nhật</span>
                        </span>
                        <button type="button" id="btn-sync-slug"
                            class="text-[10px] bg-ef-bg-3 px-2 py-1 rounded text-ef-blue font-bold hover:bg-ef-bg-4 transition-all uppercase">
                            Đồng bộ lại
                        </button>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-ef-grey-1 text-sm">/</span>
                        <input type="text" name="slug" id="slug" value="{{ old('slug', $category->slug) }}"
                            required
                            class="w-full pl-7 pr-4 py-3 bg-ef-bg-2 border {{ $errors->has('slug') ? 'border-ef-red' : 'border-ef-bg-4' }} rounded-xl focus:border-ef-blue outline-none transition-all text-ef-grey-1 font-mono text-sm">
                    </div>
                    <p class="text-[10px] text-ef-grey-1 mt-2 italic">Lưu ý: Slug tự động cập nhật theo tên. Bạn vẫn có
                        thể chỉnh sửa thủ công nếu muốn.</p>
                    @error('slug')
                        <p class="text-ef-red text-xs mt-2 font-medium">× {{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4 flex flex-col sm:flex-row gap-3">
                    <button type="submit"
                        class="flex-1 py-3.5 bg-ef-blue text-ef-bg-0 rounded-xl font-black text-xs tracking-widest hover:brightness-110 shadow-lg shadow-ef-blue/20 transition-all uppercase">
                        LƯU THAY ĐỔI
                    </button>
                    <a href="{{ route('admin.categories.index') }}"
                        class="px-8 py-3.5 bg-ef-bg-2 text-ef-grey-1 text-center rounded-xl font-bold text-xs tracking-widest hover:bg-ef-bg-3 border border-ef-bg-4 transition-all uppercase">
                        QUAY LẠI
                    </a>
                </div>
            </div>
        </form>
    </div>

    <script>
        const nameInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');
        const syncBtn = document.getElementById('btn-sync-slug');
        const slugStatus = document.getElementById('slug-status');

        function generateSlug(text) {
            return text.toLowerCase()
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '')
                .replace(/[đĐ]/g, 'd')
                .replace(/([^0-9a-z-\s])/g, '')
                .replace(/(\s+)/g, '-')
                .replace(/-+/g, '-')
                .replace(/^-+|-+$/g, '');
        }

        // Biến để kiểm tra xem người dùng có đang sửa slug thủ công hay không
        let isManualSlug = false;

        slugInput.addEventListener('input', () => {
            isManualSlug = true;
            slugStatus.classList.add('opacity-0');
        });

        nameInput.addEventListener('input', function() {
            if (!isManualSlug) {
                const newSlug = generateSlug(this.value);

                if (slugInput.value !== newSlug) {
                    slugInput.value = newSlug;

                    // Hiệu ứng thông báo cho người dùng
                    slugStatus.classList.remove('opacity-0');
                    slugInput.classList.add('ring-2', 'ring-ef-blue/40', 'border-ef-blue');

                    // Tự động tắt hiệu ứng sau 800ms
                    setTimeout(() => {
                        slugStatus.classList.add('opacity-0');
                        slugInput.classList.remove('ring-2', 'ring-ef-blue/40', 'border-ef-blue');
                    }, 800);
                }
            }
        });

        syncBtn.addEventListener('click', function() {
            isManualSlug = false; // Reset trạng thái để quay lại chế độ tự động
            slugInput.value = generateSlug(nameInput.value);

            // Hiệu ứng highlight mạnh hơn khi bấm nút
            slugInput.focus();
            slugInput.classList.add('ring-4', 'ring-ef-blue/30');
            setTimeout(() => slugInput.classList.remove('ring-4', 'ring-ef-blue/30'), 1000);
        });
    </script>
</x-admin>
