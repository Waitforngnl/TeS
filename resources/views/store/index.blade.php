@extends('layouts.home')

@section('content')
<div class="pt-24 pb-10 px-6 max-w-7xl mx-auto min-h-screen">
    <h1 class="text-3xl font-bold text-amber-800 uppercase mb-6">Cửa hàng</h1>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
        <p class="text-gray-600">Đây là trang placeholder cho <strong>Cửa hàng</strong>. Bạn có thể thêm nội dung ở đây (ví dụ: danh sách chi nhánh, giờ mở cửa, bản đồ, hay các chương trình khuyến mãi).</p>

        <div class="mt-6">
            <a href="{{ route('products') }}" class="inline-block px-5 py-3 bg-amber-800 text-white rounded shadow">Xem sản phẩm</a>
        </div>
    </div>
</div>
@endsection