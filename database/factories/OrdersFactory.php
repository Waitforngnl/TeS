<?php

namespace Database\Factories;

use App\Models\OrderItems;
use App\Models\Orders;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Orders>
 */
class OrdersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Orders::class;

    public function definition(): array
    {
        $deliveryMethod = $this->faker->randomElement(['PICKUP', 'DELIVERY']);

        return [
            'user_id' => \App\Models\User::factory(),
            'status' => $this->faker->randomElement(['PENDING', 'COMPLETED', 'CANCELED']),
            'delivery_method' => $deliveryMethod,
            'shipping_address' => ($deliveryMethod === 'DELIVERY') ? $this->faker->address() : 'Nhận tại cửa hàng',
            'note' => $this->faker->sentence(),
            'shipping_fee' => ($deliveryMethod === 'PICKUP') ? 0 : 30000,
            'sub_total' => 0, // Sẽ cập nhật sau khi tạo items
            'total_price' => 0, // Sẽ cập nhật sau khi tạo items
        ];
    }

    /**
     * Cấu hình sau khi tạo Order thì tạo luôn Items
     */
    public function configure()
    {
        return $this->afterCreating(function (Orders $order) {
            // Tạo từ 2 đến 5 items cho mỗi đơn hàng
            $items = OrderItems::factory()->count(rand(2, 5))->create([
                'order_id' => $order->id
            ]);

            // Tính toán lại tổng tiền của các items
            $subTotal = $items->sum('line_total');

            // Cập nhật lại đơn hàng
            $order->update([
                'sub_total' => $subTotal,
                'total_price' => $subTotal + $order->shipping_fee
            ]);
        });
    }
}
