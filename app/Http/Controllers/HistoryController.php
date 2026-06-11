<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Orders;

class HistoryController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('auth', ['tab' => 'login']);
        }

        // 2. Gọi Model Orders
        $orders = Orders::where('user_id', Auth::id())
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);

        return view('history.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Orders::where('user_id', Auth::id())
                      ->where('id', $id)
                      ->with('item.product') // Load danh sách món ăn và sản phẩm liên quan
                      ->first();

        if (!$order) {
            return response()->json(['error' => 'Không tìm thấy đơn hàng'], 404);
        }

        return response()->json([
            'order' => $order,
        ]);
    }
}