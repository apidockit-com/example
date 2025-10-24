<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create();
        //Create orders
        $userOrders = Order::factory()->count(2)->forUser($user)->create();
        $userOrders->each(function (Order $order) {
            OrderItem::factory()->count(3)->forOrder($order)->create();
        });

        $user2 = User::factory()->create();
        //Create orders
        $user2Orders = Order::factory()->count(2)->forUser($user2)->create();
        $user2Orders->each(function (Order $order) {
            OrderItem::factory()->count(3)->forOrder($order)->create();
        });
    }
}
