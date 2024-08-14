<?php

namespace Tests\Feature;

use App\Enums\OrderStatus;
use App\Enums\TripStatus;
use App\Models\Vendor;
use App\Models\Order;
use App\Models\Trip;
use App\Models\DelayReport;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VendorReportDelayFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create 5 vendors, each with 2 delayed orders
        $this->vendors = Vendor::factory()->count(5)->create()->each(function (Vendor $vendor) {
            // Create 2 delayed orders for each vendor
            $orders = Order::factory()->count(2)->create([
                'vendor_id' => $vendor->id,
                'status' => OrderStatus::DELAYED,
            ]);

            // Create a trip and delayed report for each order
            $orders->each(function (Order $order) {
                $order->trip()->save(Trip::factory()->create([
                    'status' => fake()->randomElement([TripStatus::ASSIGNED, TripStatus::PICKED]),
                    'order_id' => $order->id,
                ]));

                $order->delayReports()->save(DelayReport::factory()->create([
                    'order_id' => $order->id,
                ]));
            });
        });
    }

    /** @test */
    public function admin_can_see_the_report_of_vendors_with_delays_in_the_past_7_days()
    {
        // Perform the request to get the delayed orders report
        $response = $this->get(route('vendors.get-delayed-orders-report'));

        // Assert that the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert that the response contains exactly 5 vendors
        $this->assertCount(5, $response->json('data'));

        // Get the vendor with the highest total delay time
        $vendor = Vendor::withCount(['delays as total_delay_time' => function ($query) {
            $query->select(DB::raw('SUM(time)'));
        }])
            ->orderBy('total_delay_time', 'desc')
            ->first();

        // Assert that the first vendor in the response matches the vendor with the highest delay time
        $this->assertEquals($response->json('data.0.delayed'), $vendor->total_delay_time);
    }
}
