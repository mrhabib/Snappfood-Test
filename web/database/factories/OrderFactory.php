<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
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
            'vendor_id' => Vendor::factory(),
            'order_number' => $this->faker->unique()->randomNumber(8),
            'status' => OrderStatus::ACCEPTED->value,
            'delivery_time' => $this->faker->numberBetween(10,60),
            'created_at' => $this->faker->dateTimeBetween('-2 day', '-1 day'),
            'updated_at' => $this->faker->dateTimeBetween('-2 day', '-1 day')
        ];
    }
}
