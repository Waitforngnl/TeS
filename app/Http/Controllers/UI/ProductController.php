<?php

namespace App\Http\Controllers\UI;

use App\Http\Controllers\Controller;
use App\Models\Products;

class ProductController extends Controller
{
    public function index()
    {
        // Lấy 8 sản phẩm mới nhất để hiển thị
        $products = Products::latest()->paginate(8);
        return view('layouts.products', compact('products'));
    }
}