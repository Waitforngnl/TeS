<?php

namespace App\Imports;

use App\Models\Products;
use App\Models\Categories;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts; // Thêm concern xử lý cập nhật nếu trùng
use Illuminate\Support\Str;

class ProductsImport implements ToModel, WithHeadingRow, WithUpserts
{
    public function model(array $row)
    {
        $stockQuantity = (int)($row['so_luong'] ?? 0);
        $stockStatus = ($stockQuantity > 0) ? 'AVAILABLE' : 'OUT_OF_STOCK';

        // Đọc tên danh mục dạng chữ từ Excel
        $categoryName = trim($row['id_danh_muc'] ?? '');
        if (empty($categoryName)) {
            return null; // Bỏ qua dòng trống
        }

        // Tìm danh mục hoặc tự tạo mới nếu chưa có
        $category = Categories::firstOrCreate(
            ['name' => $categoryName],
            ['slug' => Str::slug($categoryName)]
        );

        // Gán slug trực tiếp tại đây để không phụ thuộc vào hàm boot() của Model khi import hàng loạt
        return new Products([
            'name'              => $row['ten_san_pham'],
            'slug'              => Str::slug($row['ten_san_pham']), // Ép dữ liệu có slug ngay lập tức
            'category_id'       => $category->id,
            'price'             => $row['gia_ban'],
            'description'       => $row['mo_ta'] ?? null,
            'ingredients'       => $row['thanh_phan'] ?? null,
            'usage_instruction' => $row['huong_dan_su_dung'] ?? null,
            'stock_quantity'    => $stockQuantity,
            'stock_status'      => $stockStatus,
            'image_url'         => (isset($row['anh_san_pham']) && (str_starts_with($row['anh_san_pham'], 'http://') || str_starts_with($row['anh_san_pham'], 'https://')))
                                    ? $row['anh_san_pham'] 
                                    : ($row['anh_san_pham'] ?? '/images/no-img.jpg'),
        ]);
    }

    /**
     * Xác định cột dùng để kiểm tra trùng lặp sản phẩm (Tránh lỗi trùng Unique)
     * Nếu trong file Excel có tên sản phẩm trùng với sản phẩm đã có, hệ thống sẽ CẬP NHẬT dữ liệu mới chứ không báo lỗi dữ liệu.
     */
    public function uniqueBy()
    {
        return 'name'; 
    }
}