<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Orders;
use App\Models\OrderItems;
use App\Models\Products;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('auth', ['tab' => 'login']);
        }

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->back()->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        $subTotal = 0;
        foreach ($cart as $item) {
            $subTotal += $item['price'] * $item['quantity'];
        }

        DB::beginTransaction();
        try {
            $order = Orders::create([
                'user_id' => Auth::id(),
                'status' => 'PENDING',
                'delivery_method' => 'PICKUP',
                'shipping_address' => null,
                'note' => null,
                'sub_total' => $subTotal,
                'shipping_fee' => 0,
                'total_price' => $subTotal,
            ]);

            foreach ($cart as $productId => $item) {
                // Giải quyết vấn đề tranh chấp với Pessimistic Locking
                // 1. Khóa sản phẩm này
                $product = Products::where('id', $productId)->lockForUpdate()->first();

                // 2. Kiểm tra: Nếu không đủ hoặc trạng thái 'OUT_OF_STOCK'
                if (!$product || $product->stock_quantity < $item['quantity'] || $product->stock_status === 'OUT_OF_STOCK') {
                    // Hủy giao dịch, xóa sản phẩm khỏi giỏ hàng và chuyển về trang sản phẩm với thông báo modal
                    DB::rollBack();

                    $cartSession = session()->get('cart', []);
                    if (isset($cartSession[$productId])) {
                        unset($cartSession[$productId]);
                        session()->put('cart', $cartSession);
                    }

                    return redirect()->route('cart')->with('conflict', [
                        'id' => $productId,
                        'type' => 'removed',
                        'name' => $item['name'],
                        'message' => "Sản phẩm '{$item['name']}' đã được mua bởi người khác. Lựa chọn đã bị xóa khỏi giỏ hàng."
                    ]);
                }

                // 3. Trừ số lượng tồn kho
                $product->decrement('stock_quantity', $item['quantity']);

                // 4. Cập nhật lại trạng thái 'OUT_OF_STOCK' khi số lượng = 0
                if ($product->fresh()->stock_quantity <= 0) {
                    $product->update(['stock_status' => 'OUT_OF_STOCK']);
                }

                OrderItems::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'product_name' => $item['name'],
                    'unit_price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'line_total' => $item['price'] * $item['quantity'],
                ]);
            }

            DB::commit();

            // Xóa giỏ hàng
            session()->forget('cart');

            return redirect()->route('history.index')->with('success', 'Đặt hàng thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Có lỗi khi tạo đơn hàng: ' . $e->getMessage());
        }
    }
}
