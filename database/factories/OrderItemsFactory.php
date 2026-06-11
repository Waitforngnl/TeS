<?php

namespace Database\Factories;

use App\Models\Products;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItems>
 */
class OrderItemsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Lấy ngẫu nhiên 1 sản phẩm đã có trong bảng products
        $product = Products::inRandomOrder()->first();

        // Nếu chưa có sản phẩm nào thì mới tạo mới (để tránh lỗi nếu db trống)
        if (!$product) {
            $product = Products::factory()->create();
        }

        $unitPrice = $product->price; // Lấy giá thật của sản phẩm
        $quantity = $this->faker->numberBetween(1, 5);

        return [
            'product_id' => $product->id,
            'product_name' => $product->name,
            'unit_price' => $unitPrice,
            'quantity' => $quantity,
            'line_total' => $unitPrice * $quantity,
        ];
    }
}
