<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    public function index(Request $request)
    {
        $categories = Categories::query()
            ->when($request->search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->orderBy('name', 'asc')->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:120|unique:categories,name',
            'slug' => 'nullable|string|max:160|unique:categories,slug',
        ]);

        $data = $request->all();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($request->name);
        }

        Categories::create($data);

        return redirect()->route('admin.categories.index')->with('success', 'Đã thêm danh mục mới thành công!');
    }

    public function edit(Categories $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Categories $category)
    {
        $request->validate([
            'name' => 'required|string|max:120|unique:categories,name,' . $category->id,
            'slug' => 'required|string|max:160|unique:categories,slug,' . $category->id,
        ]);

        $data = $request->all();

        if ($request->name !== $category->name && $request->slug === $category->slug) {
            $data['slug'] = Str::slug($request->name);
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', 'Cập nhật danh mục thành công!');
    }

    public function destroy(Categories $category)
    {
        if ($category->products()->count() > 0) {
            return back()->with('error', 'Không thể xóa danh mục này vì vẫn còn sản phẩm bên trong!');
        }

        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Đã xóa danh mục thành công!');
    }
}
