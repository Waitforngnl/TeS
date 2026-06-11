@extends('layouts.home')

@section('content')
<div class="pt-24 pb-10 px-6 max-w-7xl mx-auto min-h-screen">
    <h1 class="text-3xl font-bold text-amber-800 uppercase mb-6">Liên hệ</h1>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 space-y-4">
        <p class="text-gray-600">Đây là trang placeholder cho <strong>Liên hệ</strong>. Thêm địa chỉ, email hoặc form liên hệ tại đây.</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="font-bold text-gray-800">Địa chỉ</h3>
                <p class="text-gray-500">123 Đường Cà Phê, Phường Chill, TP. Coffee</p>
            </div>
            <div>
                <h3 class="font-bold text-gray-800">Email</h3>
                <p class="text-gray-500">hello@coffeeshop.example</p>
            </div>
        </div>
    </div>
</div>
@endsection