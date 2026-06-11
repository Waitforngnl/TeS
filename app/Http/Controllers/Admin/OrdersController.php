<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index(Request $request)
    {
        $orders = Orders::query()
            ->when($request->search, function ($query, $search) {
                return $query->where('id', $search);
            })
            ->when($request->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->delivery_method, function ($query, $method) {
                return $query->where('delivery_method', $method);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Orders $order)
    {
        $order->load(['user', 'item.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function edit(Orders $order)
    {
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, Orders $order)
    {
        $request->validate([
            'status' => 'required|in:PENDING,COMPLETED,CANCELED',
            'delivery_method' => 'required|in:PICKUP,DELIVERY',
            'shipping_address' => 'nullable|string|max:500',
            'shipping_fee' => 'required|numeric|min:0',
            'note' => 'nullable|string|max:500',
        ]);

        $data = $request->all();

        if ($request->delivery_method === 'PICKUP') {
            $data['shipping_fee'] = 0;
            $data['shipping_address'] = 'Nhận tại cửa hàng';
        }

        $data['total_price'] = $order->sub_total + $data['shipping_fee'];

        $order->update($data);

        return redirect()->route('admin.orders.index')
            ->with('success', 'Đã cập nhật đơn hàng #' . $order->id . ' thành công!');
    }

    public function destroy(Orders $order)
    {
        if ($order->status !== 'CANCELED') {
            return back()->with('error', 'Chỉ có thể xóa các đơn hàng đã bị hủy!');
        }

        $order->delete();
        return redirect()->route('admin.orders.index')
            ->with('success', 'Đã xóa đơn hàng thành công!');
    }
}
