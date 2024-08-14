<?php

namespace Database\Seeders;

use App\Models\Agent;
use App\Models\Order;
use App\Models\Vendor;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $vendors = Vendor::factory()->count(5)->create();

        $vendors->each(function ($vendor) {
            $vendor->orders()->saveMany(Order::factory()->count(2)->create([
                'vendor_id' => $vendor->id
            ]));
        });

        Agent::factory()->count(3)->create();
    }
}
