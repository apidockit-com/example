<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $quantity = mt_rand(1, 10);
        $unitPrice = mt_rand(25, 150);
        $total = $quantity * $unitPrice;

        return [
            'name' => $this->faker->sentence(),
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total' => $total,
            'note' => array_rand([
                null,
                $this->faker->sentence()
            ]),
        ];
    }

    public function forOrder(Order $order): static
    {
        return $this->state(function () use ($order) {
            return [
                'order_id' => $order->id,
            ];
        });
    }
}
