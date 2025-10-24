<?php

namespace Database\Factories;

use App\Enum\OrderPaymentStatus;
use App\Enum\OrderStatus;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'description' => $this->faker->sentence(),
            'status' => OrderStatus::Pending->value,
            'payment_status' => OrderPaymentStatus::Pending->value,
            'total' => mt_rand(25, 150),
            'tags' => ['tag1', 'tag2'],
            'placed_at' => now(),
            'paid_at' => null,
        ];
    }

    public function forUser(User $user): static
    {
        return $this->state(function () use ($user) {
            return [
                'user_id' => $user->id,
            ];
        });
    }
}
