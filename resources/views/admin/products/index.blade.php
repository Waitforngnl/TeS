<x-admin>
    {{-- Header --}}
    <header class="h-16 border-b border-ef-bg-4 bg-ef-bg-0 flex items-center justify-between px-8 sticky top-0 z-20 backdrop-blur-md bg-opacity-90">
        <div class="flex items-center gap-4">
            <h1 class="text-lg text-ef-fg font-black tracking-tighter uppercase">KHO HÀNG</h1>
            <span class="bg-ef-blue/10 text-ef-blue text-[10px] px-2.5 py-1 rounded-full font-black tracking-widest border border-ef-blue/20">
                {{ $products->total() }} SẢN PHẨM
            </span>
        </div>

        <a href="{{ route('admin.products.create') }}"
            class="inline-flex items-center px-4 py-2 bg-ef-green text-ef-bg-0 rounded-lg font-black text-[10px] tracking-[0.15em] hover:brightness-105 transition-all shadow-sm">
            <svg class="w-3.5 h-3.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
            </svg>
            THÊM MỚI
        </a>
    </header>

    <div class="p-8 max-w-7xl mx-auto space-y-6">
        
        {{-- Khối Nhập sản phẩm hàng loạt --}}
        <div class="bg-ef-bg-1 p-4 rounded-xl border border-ef-bg-4 shadow-sm">
            <div class="flex items-center gap-2 mb-3">
                <span class="w-1 h-3 bg-ef-green rounded-full"></span>
                <h3 class="text-[10px] font-black uppercase tracking-widest text-ef-green">Nhập sản phẩm hàng loạt</h3>
            </div>
            
            <form id="excel-import-form" action="{{ route('admin.products.import') }}" method="POST" enctype="multipart/form-data" class="flex flex-wrap items-center gap-4">
                @csrf
                <div class="flex flex-col gap-1.5">
                    <div class="relative bg-ef-bg-0 border border-ef-bg-4 rounded-lg px-3 py-1.5 flex items-center gap-2 cursor-pointer hover:bg-ef-bg-2 transition-all">
                        <svg class="w-4 h-4 text-ef-grey-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span class="text-xs font-bold text-ef-grey-2 uppercase tracking-tight">Chọn tệp Excel</span>
                        <input type="file" name="excel_file" id="input-excel" required accept=".xlsx, .xls, .csv" class="absolute inset-0 opacity-0 cursor-pointer">
                    </div>
                    <p id="excel-file-name" class="text-[10px] text-ef-blue font-bold uppercase tracking-tight italic hidden"></p>
                </div>
                
                <button type="submit" form="excel-import-form" class="px-4 py-2 bg-ef-green text-ef-bg-0 rounded-lg text-[10px] font-black uppercase tracking-wider hover:brightness-105 transition-all">
                    Tiến hành Import
                </button>
                
                <a href="#" class="text-[10px] text-ef-blue font-bold uppercase underline tracking-tight ml-auto">
                    Tải file Excel mẫu (.xlsx)
                </a>
            </form>
        </div>

        {{-- Bộ lọc --}}
        <form action="{{ route('admin.products.index') }}" method="GET" id="filter-form"
            class="bg-ef-bg-1 p-4 rounded-xl border border-ef-bg-4">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative group">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-ef-bg-5 group-focus-within:text-ef-blue transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Tìm tên hoặc mã sản phẩm..."
                        class="w-full pl-10 pr-4 py-2 bg-ef-bg-0 border border-ef-bg-4 rounded-lg focus:outline-none focus:border-ef-blue text-xs text-ef-fg transition-all font-medium">
                </div>

                <div class="flex gap-3">
                    <select name="category" onchange="this.form.submit()"
                        class="bg-ef-bg-0 border border-ef-bg-4 rounded-lg px-3 py-2 text-[11px] font-bold text-ef-grey-1 focus:border-ef-blue outline-none cursor-pointer uppercase tracking-tighter">
                        <option value="">Tất cả danh mục</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>

                    <select name="stock_status" onchange="this.form.submit()"
                        class="bg-ef-bg-0 border border-ef-bg-4 rounded-lg px-3 py-2 text-[11px] font-bold text-ef-grey-1 focus:border-ef-blue outline-none cursor-pointer uppercase tracking-tighter">
                        <option value="">Tất cả trạng thái</option>
                        <option value="AVAILABLE" {{ request('stock_status') == 'AVAILABLE' ? 'selected' : '' }}>Còn hàng</option>
                        <option value="OUT_OF_STOCK" {{ request('stock_status') == 'OUT_OF_STOCK' ? 'selected' : '' }}>Hết hàng</option>
                    </select>
                </div>
            </div>
        </form>

        {{-- Danh sách sản phẩm --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse ($products as $product)
                <div class="group bg-ef-bg-1 border border-ef-bg-4 rounded-2xl overflow-hidden hover:border-ef-blue/30 transition-all duration-300 flex flex-col hover:shadow-lg hover:shadow-ef-bg-4/50">
                    <div class="relative h-48 bg-ef-bg-2 overflow-hidden">
                        <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                            onerror="this.onerror=null; this.src='https://placehold.co/600x400?text=No+Image'">

                        <div class="absolute inset-x-0 top-0 p-3 flex justify-between items-start bg-gradient-to-b from-black/20 to-transparent">
                            <span class="px-2 py-0.5 text-[8px] font-black bg-ef-bg-0 text-ef-fg rounded border border-ef-bg-4 uppercase tracking-widest shadow-sm">
                                #{{ $product->id }}
                            </span>

                            @if ($product->stock_status === 'AVAILABLE')
                                <span class="px-2 py-1 text-[8px] font-black uppercase bg-ef-green text-ef-bg-0 rounded shadow-sm">AVAILABLE</span>
                            @else
                                <span class="px-2 py-1 text-[8px] font-black uppercase bg-ef-red text-ef-bg-0 rounded shadow-sm">OUT OF STOCK</span>
                            @endif
                        </div>
                    </div>

                    <div class="p-4 flex-1 flex flex-col">
                        <div class="flex justify-between items-start mb-1">
                            <p class="text-[9px] font-black text-ef-blue uppercase tracking-widest truncate">
                                {{ $product->category->name ?? 'Không rõ' }}
                            </p>
                            <span class="text-[9px] font-black uppercase {{ $product->stock_quantity <= 5 ? 'text-ef-red' : 'text-ef-grey-1' }}">
                                Kho: {{ $product->stock_quantity }}
                            </span>
                        </div>

                        <h3 class="font-black text-ef-fg text-sm line-clamp-1 mb-4 group-hover:text-ef-blue transition-colors">
                            {{ $product->name }}
                        </h3>

                        <div class="mt-auto pt-3 border-t border-ef-bg-4 flex items-center justify-between">
                            <div class="flex flex-col">
                                <p class="text-[8px] text-ef-grey-2 uppercase font-black tracking-tighter">Giá niêm yết</p>
                                <p class="text-sm font-black text-ef-orange italic tracking-tighter">
                                    {{ number_format($product->price, 0, ',', '.') }}đ
                                </p>
                            </div>

                            <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-2 group-hover:translate-y-0">
                                <a href="{{ route('admin.products.edit', $product->id) }}"
                                    class="p-2 text-ef-grey-1 hover:text-ef-blue hover:bg-ef-blue/10 rounded-lg transition-all" title="Chỉnh sửa">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>

                                <button type="button" onclick="confirmDelete({{ $product->id }}, '{{ $product->name }}')"
                                    class="p-2 text-ef-grey-1 hover:text-ef-red hover:bg-ef-red/10 rounded-lg transition-all" title="Xóa sản phẩm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>

                                <form id="delete-form-{{ $product->id }}" action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center bg-ef-bg-1 rounded-2xl border border-ef-bg-4 border-dashed">
                    <p class="text-ef-grey-1 font-black uppercase tracking-widest text-[10px]">Không tìm thấy sản phẩm phù hợp</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>
    </div>

    <script>
        // JS Lắng nghe sự kiện để cập nhật tên File ra giao diện
        document.addEventListener('DOMContentLoaded', function() {
            const inputExcel = document.getElementById('input-excel');
            const fileNameDisplay = document.getElementById('excel-file-name');

            inputExcel?.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    fileNameDisplay.innerText = `📎 Tệp đã chọn: ${file.name}`;
                    fileNameDisplay.classList.remove('hidden');
                } else {
                    fileNameDisplay.classList.add('hidden');
                    fileNameDisplay.innerText = "";
                }
            });
        });

        // Hàm confirm xóa cũ giữ nguyên
        function confirmDelete(id, name) {
            Swal.fire({
                title: '<span class="text-sm font-black uppercase tracking-widest">Xác nhận xóa?</span>',
                html: `<p class="text-xs text-ef-grey-1 font-medium italic">Bạn đang chuẩn bị xóa sản phẩm: <br><b class="text-ef-fg uppercase">${name}</b></p>`,
                icon: 'warning',
                iconColor: '#ff6666', 
                showCancelButton: true,
                confirmButtonColor: '#ff6666',
                cancelButtonColor: '#adb5bd',
                confirmButtonText: 'ĐỒNG Ý XÓA',
                cancelButtonText: 'HỦY',
                background: '#fffdfa', 
                borderRadius: '20px',
                customClass: {
                    title: 'font-black uppercase',
                    confirmButton: 'text-[10px] px-6 py-2 rounded-lg font-black tracking-widest',
                    cancelButton: 'text-[10px] px-6 py-2 rounded-lg font-black tracking-widest'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Đang xử lý...',
                        didOpen: () => { Swal.showLoading() },
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        background: '#fffdfa'
                    });
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
</x-admin>