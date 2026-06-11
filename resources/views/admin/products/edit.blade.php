<x-admin>
    <div class="p-6 max-w-5xl mx-auto min-h-screen text-ef-fg">

        {{-- Header: Gọn gàng hơn --}}
        <div class="mb-8 flex flex-col sm:flex-row sm:items-end justify-between gap-4 border-b border-ef-bg-4 pb-6">
            <div>
                <nav
                    class="flex items-center gap-2 text-[10px] font-black text-ef-grey-1 uppercase tracking-[0.2em] mb-2">
                    <span>Sản phẩm</span>
                    <span class="text-ef-bg-5">/</span>
                    <span class="text-ef-blue">Chỉnh sửa</span>
                </nav>
                <h1 class="text-2xl font-black uppercase tracking-tighter">Sửa sản phẩm #{{ $product->id }}</h1>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('admin.products.index') }}"
                    class="px-5 py-2.5 bg-ef-bg-2 text-ef-grey-2 rounded-lg font-bold text-[11px] tracking-widest hover:bg-ef-bg-3 border border-ef-bg-4 transition-all uppercase">
                    Hủy bỏ
                </a>
                <button type="submit" form="product-form" id="btn-submit-top"
                    class="px-6 py-2.5 bg-ef-blue text-ef-bg-0 rounded-lg font-black text-[11px] tracking-widest hover:brightness-105 shadow-sm transition-all uppercase">
                    Lưu thay đổi
                </button>
            </div>
        </div>

        {{-- Thông báo lỗi --}}
        @if ($errors->any())
            <div class="mb-6 p-4 bg-ef-bg-red border border-ef-red/20 rounded-xl flex items-start animate-pulse">
                <svg class="w-4 h-4 text-ef-red shrink-0 mt-0.5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <div class="ml-3">
                    <ul class="text-[11px] text-ef-red font-bold uppercase tracking-wide leading-relaxed">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form id="product-form" action="{{ route('admin.products.update', $product->id) }}" method="POST"
            enctype="multipart/form-data" class="grid grid-cols-12 gap-6">
            @csrf
            @method('PUT')

            {{-- Cột trái: Nội dung chính --}}
            <div class="col-span-12 lg:col-span-8 space-y-6">
                {{-- Box 1: Thông tin --}}
                <div class="bg-ef-bg-1 p-5 rounded-xl border border-ef-bg-4">
                    <div class="flex items-center gap-2 mb-6 border-l-4 border-ef-blue pl-3">
                        <h2 class="text-[11px] font-black uppercase tracking-[0.2em] text-ef-blue">Thông tin sản phẩm
                        </h2>
                    </div>

                    <div class="grid grid-cols-2 gap-5">
                        <div class="col-span-2 md:col-span-1">
                            <label
                                class="block text-[10px] font-black text-ef-grey-1 mb-2 uppercase tracking-widest">Tên
                                sản phẩm</label>
                            <input type="text" name="name" id="name"
                                value="{{ old('name', $product->name) }}" required
                                class="w-full px-3 py-2 bg-ef-bg-0 border border-ef-bg-4 rounded-lg focus:border-ef-blue outline-none transition-all text-sm font-medium">
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-[10px] font-black text-ef-bg-5 mb-2 uppercase tracking-widest">Slug
                                hệ thống</label>
                            <input type="text" name="slug" id="slug"
                                value="{{ old('slug', $product->slug) }}" readonly
                                class="w-full px-3 py-2 bg-ef-bg-2 border border-ef-bg-4 rounded-lg outline-none text-ef-grey-1 font-mono text-[11px]">
                        </div>

                        <div class="col-span-2">
                            <label class="block text-[10px] font-black text-ef-grey-1 mb-2 uppercase tracking-widest">Mô
                                tả chi tiết</label>
                            <textarea name="description" rows="6"
                                class="w-full px-3 py-2 bg-ef-bg-0 border border-ef-bg-4 rounded-lg focus:border-ef-blue outline-none transition-all text-sm leading-relaxed resize-none">{{ old('description', $product->description) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Box 2: Tài chính & Tồn kho --}}
                <div class="bg-ef-bg-1 p-5 rounded-xl border border-ef-bg-4">
                    <div class="flex items-center gap-2 mb-6 border-l-4 border-ef-orange pl-3">
                        <h2 class="text-[11px] font-black uppercase tracking-[0.2em] text-ef-orange">Giá & Kho hàng</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        {{-- Giá bán --}}
                        <div
                            class="bg-ef-bg-0 p-3 rounded-lg border border-ef-bg-4 group focus-within:border-ef-orange transition-all">
                            <label class="block text-[9px] font-black text-ef-orange mb-1 uppercase tracking-widest">Giá
                                bán (VNĐ)</label>
                            <input type="number" name="price" value="{{ old('price', $product->price) }}" required
                                class="w-full bg-transparent border-none p-0 focus:ring-0 font-black text-lg text-ef-fg">
                        </div>

                        {{-- Số lượng tồn kho --}}
                        <div
                            class="bg-ef-bg-0 p-3 rounded-lg border border-ef-bg-4 group focus-within:border-ef-blue transition-all">
                            <label class="block text-[9px] font-black text-ef-blue mb-1 uppercase tracking-widest">Số
                                lượng tồn</label>
                            <input type="number" name="stock_quantity"
                                value="{{ old('stock_quantity', $product->stock_quantity) }}" min="0" required
                                class="w-full bg-transparent border-none p-0 focus:ring-0 font-black text-lg text-ef-fg">
                        </div>

                        {{-- Trạng thái --}}
                        <div class="flex flex-col justify-center px-1 border-b border-ef-bg-4 md:border-none">
                            <label
                                class="block text-[9px] font-black text-ef-grey-1 mb-2 uppercase tracking-widest">Trạng
                                thái</label>
                            <select name="stock_status"
                                class="w-full bg-transparent border-none p-0 focus:ring-0 font-bold text-xs uppercase cursor-pointer text-ef-fg">
                                <option value="AVAILABLE"
                                    {{ old('stock_status', $product->stock_status) == 'AVAILABLE' ? 'selected' : '' }}>
                                    ● Còn hàng
                                </option>
                                <option value="OUT_OF_STOCK"
                                    {{ old('stock_status', $product->stock_status) == 'OUT_OF_STOCK' ? 'selected' : '' }}>
                                    ○ Hết hàng
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Cột phải: Phân loại & Ảnh --}}
            <div class="col-span-12 lg:col-span-4 space-y-6">
                {{-- Category --}}
                <div class="bg-ef-bg-1 p-5 rounded-xl border border-ef-bg-4">
                    <label class="block text-[10px] font-black text-ef-grey-1 mb-4 uppercase tracking-widest">Danh mục
                        món</label>
                    <select name="category_id" required
                        class="w-full px-3 py-2.5 bg-ef-bg-0 border border-ef-bg-4 rounded-lg outline-none focus:border-ef-blue font-bold text-xs transition-all uppercase tracking-tighter">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Image --}}
                <div class="bg-ef-bg-1 p-2 rounded-xl border border-ef-bg-4">
                    <div id="drop-zone"
                        class="relative group aspect-square bg-ef-bg-0 rounded-lg border-2 {{ $product->image_url ? 'border-solid' : 'border-dashed' }} border-ef-bg-4 flex flex-col items-center justify-center overflow-hidden transition-all hover:bg-ef-bg-blue/5">

                        {{-- Ảnh hiện tại/Preview --}}
                        <img id="image-preview" src="{{ $product->image_url ?? '#' }}"
                            class="{{ $product->image_url ? '' : 'hidden' }} w-full h-full object-cover z-0">

                        {{-- Placeholder --}}
                        <div id="placeholder-info"
                            class="{{ $product->image_url ? 'hidden' : '' }} text-center p-6 transition-all group-hover:scale-110">
                            <div
                                class="w-12 h-12 bg-ef-bg-2 rounded-full flex items-center justify-center mx-auto mb-3 border border-ef-bg-4 text-ef-grey-1">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 4v16m8-8H4" stroke-width="2" stroke-linecap="round" />
                                </svg>
                            </div>
                            <p class="text-[9px] font-black text-ef-fg uppercase tracking-widest">Click đổi ảnh</p>
                        </div>

                        {{-- Overlay khi hover --}}
                        <div
                            class="absolute inset-0 bg-ef-fg/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all backdrop-blur-[1px]">
                            <span
                                class="bg-ef-bg-0 text-ef-fg px-4 py-2 rounded-md text-[9px] font-black tracking-widest uppercase shadow-xl border border-ef-bg-4">Chọn
                                file mới</span>
                        </div>

                        <input type="file" name="image" id="input-image"
                            class="absolute inset-0 opacity-0 cursor-pointer z-10" accept="image/*">
                    </div>
                    <p
                        class="text-[9px] text-center text-ef-grey-2 mt-3 font-bold uppercase tracking-tighter italic opacity-60">
                        Để trống nếu không muốn thay đổi</p>
                </div>

                <div class="lg:hidden">
                    <button type="submit" form="product-form"
                        class="w-full py-4 bg-ef-blue text-ef-bg-0 rounded-xl font-black text-xs tracking-widest shadow-lg uppercase">
                        Cập nhật ngay
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-admin>

<script>
    // 1. Logic Slug: Giữ nguyên logic cũ nhưng viết lại gọn hơn
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    nameInput?.addEventListener('input', function() {
        const slug = this.value.toLowerCase().normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '').replace(/[đĐ]/g, 'd')
            .replace(/([^0-9a-z-\s])/g, '').replace(/(\s+)/g, '-')
            .replace(/-+/g, '-').replace(/^-+|-+$/g, '');
        slugInput.value = slug;
    });

    // 2. Logic Preview: Đã sửa lại các ID class để khớp với thiết kế mới
    const inputImage = document.getElementById('input-image');
    const imagePreview = document.getElementById('image-preview');
    const placeholderInfo = document.getElementById('placeholder-info');
    const dropZone = document.getElementById('drop-zone');

    inputImage?.addEventListener('change', function() {
        const file = this.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = (e) => {
                imagePreview.src = e.target.result;
                imagePreview.classList.remove('hidden');
                placeholderInfo.classList.add('hidden');
                dropZone.classList.replace('border-dashed', 'border-solid');
            };
            reader.readAsDataURL(file);
        }
    });

    // 3. Logic Loading: Áp dụng màu Everforest
    document.getElementById('product-form')?.addEventListener('submit', function() {
        const btn = document.getElementById('btn-submit-top');
        btn.disabled = true;
        btn.classList.add('opacity-80', 'cursor-wait');
        btn.innerHTML = `
            <svg class="animate-spin h-3 w-3 text-ef-bg-0 mr-2 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="tracking-widest">ĐANG LƯU...</span>
        `;
    });
</script>
