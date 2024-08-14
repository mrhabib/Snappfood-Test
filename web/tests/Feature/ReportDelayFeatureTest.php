<?php

namespace Tests\Feature;


use App\Models\Vendor;
use App\Models\Order;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportDelayFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected $vendor;
    protected $order;

    protected function setUp(): void
    {
        parent::setUp();

        // Setting up vendor and order before each test
        $this->vendor = Vendor::factory()->create();

        $this->order = Order::factory()->create([
            'vendor_id' => $this->vendor->id,
            'delivery_time' => 60,
            'created_at' => Carbon::now()->subMinutes(10),
            'updated_at' => Carbon::now(),
        ]);
    }

    /** @test */
    public function a_user_can_report_a_delay_on_an_order_if_the_requirements_are_met()
    {
        // Simulate time being 1 hour later
        Carbon::setTestNow(Carbon::now()->addHour());

        // Send a POST request to report the delay
        $response = $this->getJson(route('order.report-delay', [
            'order' => $this->order->id,
        ]));

        // Assert that the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert that the delay report exists in the database
        $this->assertDatabaseHas('delay_reports', [
            'order_id' => $this->order->id,
            'time' => 10, // 10 minutes delay
        ]);
    }

    /** @test */
    public function a_user_cannot_report_a_delay_on_an_order_that_is_not_delayed()
    {
        // Simulate time being 5 minutes later (so the order is not delayed)
        Carbon::setTestNow(Carbon::now()->subMinutes(5));

        // Send a POST request to report the delay
        $response = $this->getJson(route('order.report-delay', [
            'order' => $this->order->id,
        ]));

        // Assert that the response status is 400 (Bad Request)
        $response->assertStatus(422);
    }
}
