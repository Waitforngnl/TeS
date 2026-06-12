<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Categories::orderBy('name', 'asc')->get();
        $products = Products::query()
            ->when($request->search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->when($request->category, function ($query, $category) {
                return $query->where('category_id', $category);
            })
            ->when($request->stock_status, function ($query, $status) {
                return $query->where('stock_status', $status);
            })
            ->latest()->paginate(12)->withQueryString();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Categories::all();
        return view('admin.products.create', compact('categories'));
    }

    public function edit(Products $product)
    {
        $categories = Categories::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:200',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'ingredients' => 'nullable|string', // <-- THÊM DÒNG NÀY
            'usage_instruction' => 'nullable|string', // <-- THÊM DÒNG NÀY
            'image' => 'nullable|image|max:2048',
            'stock_status' => 'required|in:AVAILABLE,OUT_OF_STOCK',
            'stock_quantity' => 'required|numeric|min:0',
        ]);

        // Logic ép buộc số lượng và trạng thái đồng bộ
        if ($validated['stock_status'] === 'OUT_OF_STOCK') {
            $validated['stock_quantity'] = 0;
        } elseif ($validated['stock_quantity'] == 0) {
            $validated['stock_status'] = 'OUT_OF_STOCK';
        }

        $validated['slug'] = Str::slug($request->name);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image_url'] = '/storage/' . $path;
        }

        // Eloquent::create sẽ tự động map các trường đã validate trong mảng để lưu
        Products::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Đã thêm sản phẩm mới!');
    }

    public function update(Request $request, Products $product)
    {
        // CẬP NHẬT: Thêm validation tương tự cho hàm update khi sửa sản phẩm
        $validated = $request->validate([
            'name' => 'required|string|max:200',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'ingredients' => 'nullable|string', // <-- THÊM DÒNG NÀY
            'usage_instruction' => 'nullable|string', // <-- THÊM DÒNG NÀY
            'image' => 'nullable|image|max:2048',
            'stock_status' => 'required|in:AVAILABLE,OUT_OF_STOCK',
            'stock_quantity' => 'required|numeric|min:0',                                                                                                         
        ]);

        // Logic ép buộc số lượng và trạng thái đồng bộ
        if ($validated['stock_status'] === 'OUT_OF_STOCK') {
            $validated['stock_quantity'] = 0;
        } elseif ($validated['stock_quantity'] == 0) {
            $validated['stock_status'] = 'OUT_OF_STOCK';
        }

        if ($product->name !== $request->name) {
            $validated['slug'] = Str::slug($request->name);
        }

        if ($request->hasFile('image')) {
            try {
                if ($product->image_url) {
                    $cleanPath = str_replace('/storage/', '', parse_url($product->image_url, PHP_URL_PATH));
                    Storage::disk('public')->delete($cleanPath);
                }

                $path = $request->file('image')->store('products', 'public');
                $validated['image_url'] = '/storage/' . $path;
            } catch (\Exception $e) {
                return back()->withErrors(['image' => 'Lỗi upload: ' . $e->getMessage()]);
            }
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Cập nhật thành công!');
    }

    public function destroy(Products $product)
    {
        // 1. Xóa file ảnh vật lý nếu tồn tại
        if ($product->image_url) {
            $filePath = str_replace('/storage/', '', $product->image_url);

            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
        }

        // 2. Xóa sản phẩm khỏi Database
        $product->delete();

        // 3. Quay lại trang danh sách với thông báo
        return redirect()->route('admin.products.index')->with('success', 'Đã xóa sản phẩm thành công!');
    }

    public function show($id)
    {
        $product = Products::findOrFail($id);
        
        return view('products.show', compact('product'));
    }

    public function importExcel(Request $request)
{
    $request->validate([
        'excel_file' => 'required|mimes:xlsx,xls,csv|max:5120', // Tối đa 5MB
    ]);

    try {
        Excel::import(new ProductsImport, $request->file('excel_file'));
        return redirect()->route('admin.products.index')->with('success', 'Nhập hàng loạt sản phẩm từ Excel thành công!');
    } catch (\Exception $e) {
        return redirect()->back()->withErrors(['excel_file' => 'Có lỗi xảy ra khi đọc file: ' . $e->getMessage()]);
    }
}
}