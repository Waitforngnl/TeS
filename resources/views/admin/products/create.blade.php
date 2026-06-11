<x-admin>
    <div class="p-6 max-w-5xl mx-auto min-h-screen text-ef-fg">
        <div class="mb-8 flex items-end justify-between border-b border-ef-bg-4 pb-4">
            <div>
                <nav class="flex items-center gap-2 text-[10px] font-bold text-ef-grey-1 uppercase tracking-widest mb-1">
                    <span>Sản phẩm</span>
                    <span class="text-ef-bg-4">/</span>
                </nav>
                <h1 class="text-2xl font-black uppercase tracking-tight">Thêm món mới</h1>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('admin.products.index') }}"
                    class="px-4 py-2 text-xs font-bold border border-ef-bg-4 rounded-lg hover:bg-ef-bg-2 transition-all uppercase text-ef-grey-2">
                    Hủy
                </a>
                <button type="submit" form="product-form" id="btn-submit-top"
                    class="px-6 py-2 bg-ef-green text-ef-bg-0 rounded-lg text-xs font-black hover:brightness-105 shadow-sm transition-all uppercase tracking-wider">
                    Lưu sản phẩm
                </button>
            </div>
        </div>

        <form id="product-form" action="{{ route('admin.products.store') }}" method="POST"
            enctype="multipart/form-data" class="grid grid-cols-12 gap-6">
            @csrf

            <div class="col-span-12 lg:col-span-8 space-y-6">
                {{-- Box 1: Thông tin chung --}}
                <div class="bg-ef-bg-1 p-6 rounded-xl border border-ef-bg-4">
                    <div class="flex items-center gap-2 mb-6">
                        <span class="w-1 h-4 bg-ef-blue rounded-full"></span>
                        <h2 class="text-xs font-black uppercase tracking-widest text-ef-blue">Thông tin cơ bản</h2>
                    </div>

                    <div class="grid grid-cols-2 gap-5">
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-[10px] font-black uppercase mb-2 text-ef-grey-1">Tên sản phẩm <span
                                    class="text-ef-red">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                class="w-full px-3 py-2.5 bg-ef-bg-0 border border-ef-bg-4 rounded-lg text-sm focus:border-ef-blue focus:ring-1 focus:ring-ef-blue/20 outline-none transition-all"
                                placeholder="VD: Trà Đào Cam Sả">
                        </div>
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-[10px] font-black uppercase mb-2 text-ef-grey-2">Đường dẫn
                                (Slug)</label>
                            <input type="text" name="slug" id="slug" value="{{ old('slug') }}" readonly
                                class="w-full px-3 py-2.5 bg-ef-bg-2 border border-ef-bg-4 rounded-lg text-sm font-mono text-ef-grey-1 outline-none">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-[10px] font-black uppercase mb-2 text-ef-grey-1">Mô tả ngắn</label>
                            <textarea name="description" rows="4"
                                class="w-full px-3 py-2.5 bg-ef-bg-0 border border-ef-bg-4 rounded-lg text-sm focus:border-ef-blue outline-none transition-all resize-none"
                                placeholder="Viết vài dòng giới thiệu về món này...">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Box 2: Giá & Kho --}}
                <div class="bg-ef-bg-1 p-6 rounded-xl border border-ef-bg-4">
                    <div class="flex items-center gap-2 mb-6">
                        <span class="w-1 h-4 bg-ef-orange rounded-full"></span>
                        <h2 class="text-xs font-black uppercase tracking-widest text-ef-orange">Giá cả & Tồn kho</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div class="bg-ef-bg-0 p-3 rounded-lg border border-ef-bg-4">
                            <label class="block text-[10px] font-black uppercase mb-1 text-ef-orange">Giá bán
                                (VNĐ)</label>
                            <input type="number" name="price" value="{{ old('price', 0) }}" required
                                class="w-full bg-transparent border-none p-0 focus:ring-0 font-bold text-lg text-ef-fg">
                        </div>
                        <div class="bg-ef-bg-0 p-3 rounded-lg border border-ef-bg-4">
                            <label class="block text-[10px] font-black uppercase mb-1 text-ef-blue">Số lượng</label>
                            <input type="number" name="stock_quantity" value="{{ old('stock_quantity', 0) }}"
                                min="0" required
                                class="w-full bg-transparent border-none p-0 focus:ring-0 font-bold text-lg text-ef-fg">
                        </div>
                        <div class="flex flex-col justify-center px-1">
                            <label class="block text-[10px] font-black uppercase mb-2 text-ef-grey-1">Trạng thái</label>
                            <select name="stock_status"
                                class="bg-transparent border-b border-ef-bg-4 py-1 text-xs font-bold uppercase outline-none cursor-pointer focus:border-ef-fg">
                                <option value="AVAILABLE">● Còn hàng</option>
                                <option value="OUT_OF_STOCK">○ Hết hàng</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-12 lg:col-span-4 space-y-6">
                {{-- Danh mục --}}
                <div class="bg-ef-bg-1 p-6 rounded-xl border border-ef-bg-4 shadow-sm">
                    <label class="block text-[10px] font-black uppercase tracking-widest mb-4 text-ef-grey-1">Danh mục
                        món</label>
                    <div class="space-y-2 max-h-48 overflow-y-auto pr-2 custom-scrollbar">
                        @foreach ($categories as $category)
                            <label
                                class="flex items-center p-2 rounded-lg hover:bg-ef-bg-2 cursor-pointer transition-colors group">
                                <input type="radio" name="category_id" value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'checked' : '' }}
                                    class="w-3 h-3 text-ef-blue border-ef-bg-4 focus:ring-0 focus:ring-offset-0">
                                <span
                                    class="ml-3 text-xs font-bold text-ef-grey-2 group-hover:text-ef-fg">{{ $category->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Hình ảnh --}}
                <div class="bg-ef-bg-1 p-2 rounded-xl border border-ef-bg-4">
                    <div id="drop-zone"
                        class="relative group aspect-square bg-ef-bg-0 rounded-lg border-2 border-dashed border-ef-bg-4 flex flex-col items-center justify-center overflow-hidden transition-all">

                        {{-- Preview Image --}}
                        <img id="image-preview" src="#" class="hidden w-full h-full object-cover">

                        {{-- Nút xóa ảnh (Chỉ hiện khi có ảnh) --}}
                        <button type="button" id="btn-remove-image"
                            class="hidden absolute top-2 right-2 p-1.5 bg-ef-red text-ef-bg-0 rounded-md shadow-lg hover:scale-110 transition-transform z-20">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M6 18L18 6M6 6l12 12" stroke-width="2.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </button>

                        {{-- Placeholder --}}
                        <div id="placeholder-info" class="text-center p-4">
                            <div
                                class="w-10 h-10 bg-ef-bg-2 rounded-full flex items-center justify-center mx-auto mb-3 transition-transform group-hover:scale-110">
                                <svg class="w-5 h-5 text-ef-grey-1" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path d="M12 4v16m8-8H4" stroke-width="2" stroke-linecap="round" />
                                </svg>
                            </div>
                            <p class="text-[10px] font-black uppercase text-ef-grey-1">Ảnh đại diện</p>
                            <p id="image-error" class="text-[9px] font-bold text-ef-red mt-2 hidden italic"></p>
                        </div>

                        <input type="file" name="image" id="input-image"
                            class="absolute inset-0 opacity-0 cursor-pointer z-10"
                            accept="image/png, image/jpeg, image/webp">
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        // 1. Logic Auto-slug (Gọn hơn)
        const nameInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');

        nameInput?.addEventListener('input', () => {
            const slug = nameInput.value.toLowerCase()
                .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
                .replace(/[đĐ]/g, 'd')
                .replace(/([^0-9a-z-\s])/g, '')
                .replace(/(\s+)/g, '-')
                .replace(/-+/g, '-')
                .replace(/^-+|-+$/g, '');
            slugInput.value = slug;
        });

        // 2. Logic Hình ảnh (Preview & Validation)
        const inputImage = document.getElementById('input-image');
        const imagePreview = document.getElementById('image-preview');
        const placeholder = document.getElementById('placeholder-info');
        const btnRemove = document.getElementById('btn-remove-image');
        const errorDisplay = document.getElementById('image-error');
        const dropZone = document.getElementById('drop-zone');

        const MAX_SIZE = 2 * 1024 * 1024; // 2MB

        inputImage.addEventListener('change', function() {
            const file = this.files[0];
            errorDisplay.classList.add('hidden');
            dropZone.classList.replace('border-ef-red', 'border-ef-bg-4');

            if (file) {
                // Kiểm tra dung lượng
                if (file.size > MAX_SIZE) {
                    errorDisplay.innerText = "Lỗi: File vượt quá 2MB!";
                    errorDisplay.classList.remove('hidden');
                    dropZone.classList.replace('border-ef-bg-4', 'border-ef-red');
                    this.value = ""; // Reset input
                    return;
                }

                // Đọc file và hiển thị
                const reader = new FileReader();
                reader.onload = (e) => {
                    imagePreview.src = e.target.result;
                    imagePreview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                    btnRemove.classList.remove('hidden');
                    dropZone.classList.add('border-solid');
                    dropZone.classList.remove('border-dashed');
                };
                reader.readAsDataURL(file);
            }
        });

        // 3. Xóa ảnh
        btnRemove.addEventListener('click', (e) => {
            e.preventDefault();
            inputImage.value = "";
            imagePreview.classList.add('hidden');
            imagePreview.src = "#";
            placeholder.classList.remove('hidden');
            btnRemove.classList.add('hidden');
            dropZone.classList.replace('border-solid', 'border-dashed');
            dropZone.classList.replace('border-ef-red', 'border-ef-bg-4');
            errorDisplay.classList.add('hidden');
        });

        // 4. Loading khi Submit
        document.getElementById('product-form').addEventListener('submit', function() {
            const btn = document.getElementById('btn-submit-top');
            btn.disabled = true;
            btn.classList.add('opacity-70', 'cursor-not-allowed');
            btn.innerHTML = `
            <svg class="animate-spin h-3 w-3 text-ef-bg-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="ml-2">ĐANG LƯU...</span>
        `;
        });
    </script>
</x-admin>
