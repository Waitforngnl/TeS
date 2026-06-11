<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;

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

    public function addToCart($id)
    {
        $product = Products::findOrFail($id);

        // If product is out of stock, warn user
        if ($product->stock_status === 'OUT_OF_STOCK' || $product->stock_quantity <= 0) {
            return redirect()->back()->with('error', 'Sản phẩm đã hết hàng.');
        }

        $cart = session()->get('cart', []);
        $currentQty = $cart[$id]['quantity'] ?? 0;

        // Prevent adding more than available stock
        if ($currentQty + 1 > $product->stock_quantity) {
            return redirect()->back()->with('error', 'Không thể thêm sản phẩm vì không đủ số lượng. Còn ' . $product->stock_quantity . ' sản phẩm.');
        }

        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image_url
            ];
        }

        session()->put('cart', $cart);
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
                // Prevent increasing beyond stock
                if (!$product || $product->stock_status === 'OUT_OF_STOCK' || $cart[$id]['quantity'] + 1 > $product->stock_quantity) {
                    // If product has 0 stock -> remove from cart and show removed modal
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

                    // If product has limited stock (< desired), keep previous quantity and show options
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
                    // ensure not exceeding stock
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