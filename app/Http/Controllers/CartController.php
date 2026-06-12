<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products; // Giữ nguyên Model có chữ 's' theo cấu trúc nhóm bạn

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('cart.index', compact('cart', 'total'));
    }

    // CHỈNH SỬA: Thêm Request $request để nhận dữ liệu số lượng và loại nút bấm từ Form gửi lên
    public function addToCart(Request $request, $id)
    {
        $product = Products::findOrFail($id);

        // Nếu sản phẩm hết hàng, thông báo cho người dùng
        if ($product->stock_status === 'OUT_OF_STOCK' || $product->stock_quantity <= 0) {
            return redirect()->back()->with('error', 'Sản phẩm đã hết hàng.');
        }

        // Lấy số lượng người dùng muốn thêm (mặc định là 1 nếu nhấn từ trang danh sách)
        $quantityToAdd = (int) $request->input('quantity', 1);
        if ($quantityToAdd < 1) { $quantityToAdd = 1; }

        $cart = session()->get('cart', []);
        $currentQty = $cart[$id]['quantity'] ?? 0;

        // Ngăn thêm vượt quá số lượng tồn kho trong Database
        if ($currentQty + $quantityToAdd > $product->stock_quantity) {
            return redirect()->back()->with('error', 'Không thể thêm vì không đủ số lượng trong kho. Hiện tại bạn đã có ' . $currentQty . ' sản phẩm trong giỏ, kho chỉ còn lại ' . $product->stock_quantity . ' sản phẩm.');
        }

        // Tiến hành cập nhật hoặc thêm mới vào Session giỏ hàng
        if(isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantityToAdd;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => $quantityToAdd,
                "price" => $product->price,
                "image" => $product->image_url
            ];
        }

        session()->put('cart', $cart);

        // LOGIC CHUYỂN HƯỚNG THEO NÚT BẤM:
        // Nếu người dùng nhấn nút "Mua ngay" (value="buy_now"), chuyển thẳng đến trang giỏ hàng
        if ($request->input('action') === 'buy_now') {
            return redirect()->route('cart')->with('success', 'Đã thêm vào giỏ hàng, tiến hành thanh toán thôi nào!');
        }

        // Ngược lại nếu bấm "Thêm vào giỏ hàng", ở lại trang cũ và báo thành công
        return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
    }

    public function remove($id)
    {
        $cart = session()->get('cart');

        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Đã xóa sản phẩm!');
    }

    public function update(Request $request, $id)
    {
        $cart = session()->get('cart');

        if(isset($cart[$id])) {
            $product = Products::find($id);

            if($request->action == 'increase') {
                if (!$product || $product->stock_status === 'OUT_OF_STOCK' || $cart[$id]['quantity'] + 1 > $product->stock_quantity) {
                    if (!$product || $product->stock_quantity <= 0 || $product->stock_status === 'OUT_OF_STOCK') {
                        unset($cart[$id]);
                        session()->put('cart', $cart);

                        return redirect()->route('cart')->with('conflict', [
                            'id' => $id,
                            'type' => 'removed',
                            'name' => $product->name ?? 'Sản phẩm',
                            'message' => 'Sản phẩm đã hết hàng và đã được xóa khỏi giỏ hàng.'
                        ]);
                    }

                    return redirect()->back()->with('conflict', [
                        'id' => $id,
                        'type' => 'limit',
                        'available' => $product->stock_quantity,
                        'name' => $product->name ?? 'Sản phẩm',
                        'message' => 'Không thể tăng số lượng vì chỉ còn ' . $product->stock_quantity . ' sản phẩm. Bạn có muốn đặt lại số lượng về ' . $product->stock_quantity . ' hoặc xóa sản phẩm khỏi giỏ hàng?'
                    ]);
                }

                $cart[$id]['quantity']++;
            } 
            elseif ($request->action == 'decrease') {
                $cart[$id]['quantity']--;
                
                if($cart[$id]['quantity'] < 1) {
                    unset($cart[$id]);
                }
            } else if ($request->action == 'set') {
                $newQty = (int) $request->input('quantity', 1);
                if ($newQty < 1) {
                    unset($cart[$id]);
                } else {
                    if ($product && $product->stock_quantity < $newQty) {
                        $newQty = $product->stock_quantity;
                    }
                    $cart[$id]['quantity'] = $newQty;
                }
            }
            
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Đã cập nhật giỏ hàng!');
    } 
}