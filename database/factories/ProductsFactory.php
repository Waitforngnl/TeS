<?php

namespace Database\Factories;

use App\Models\Categories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Products>
 */
class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $products = [
            'Cà phê Tonic',
            'Cà phê đen đá',
            'Cà phê Trứng',
            'Mocha',
            'Cà phê sủi bọt',
            'Cà Phê Sữa Đá',
            'Bạc Xỉu',
            'Cà Phê Muối',
            'Espresso',
            'Cappuccino',
            'Latte Hạnh Nhân',
            'Americano',
            'Caramel Macchiato'
        ];

        $name = fake()->unique()->randomElement($products);

        return [
            'category_id' => Categories::query()->inRandomOrder()->first()?->id ?? Categories::factory(),
            'slug' => Str::slug($name),
            'name' => $name,
            'description' => fake()->paragraph(3),
            'price' => fake()->numberBetween(25, 75) * 1000,    // Random giá từ 25k -> 75k
            'image_url' => 'https://images.unsplash.com/photo-1541167760496-162955ed8a9f?q=80&w=600',
            'stock_status' => 'AVAILABLE',
        ];
    }

    public function outOfStock(): static
    {
        return $this->state(fn(array $attributes) => [
            'stock_status' => 'OUT_OF_STOCK',
        ]);
    }
}
