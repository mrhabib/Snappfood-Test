<?php

namespace Database\Factories;

use App\Enums\DelayedOrderStatus;
use App\Models\Agent;
use App\Models\DelayedOrder;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DelayedOrder>
 */
class DelayedOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'agent_id' => Agent::factory(),
            'order_id' => Order::factory(),
            'status' => $this->faker->randomElement(DelayedOrderStatus::cases())
        ];
    }
}
