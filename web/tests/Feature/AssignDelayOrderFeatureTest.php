<?php

namespace Tests\Feature;

use App\Enums\DelayedOrderStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Vendor;
use App\Models\Order;
use App\Models\Agent;
use Illuminate\Support\Carbon;
use App\Models\DelayedOrder;

class AssignDelayOrderFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected $vendor;
    protected $order;
    protected $agent;

    protected function setUp(): void
    {
        parent::setUp();

        // Setting up initial data
        $this->vendor = Vendor::factory()->create();

        $this->order = Order::factory()->create([
            'vendor_id' => $this->vendor->id,
            'delivery_time' => 30,
            'created_at' => Carbon::now()->subMinutes(10),
            'updated_at' => Carbon::now(),
        ]);

        $this->agent = Agent::factory()->create();
    }

    /** @test */
    public function an_agent_cannot_receive_another_order_if_one_is_already_assigned()
    {
        DelayedOrder::factory()->create([
            'agent_id' => $this->agent->id,
            'order_id' => $this->order->id,
            'status' => DelayedOrderStatus::ASSIGNED->value,
        ]);

        $response = $this->getJson(route('agent.assign-delay-order', [
            'agent' => $this->agent->id,
        ]));

        $response->assertStatus(422);
    }

    /** @test */
    public function an_agent_is_assigned_a_delayed_order_for_processing()
    {
        DelayedOrder::factory()->count(5)->create(['agent_id' => null]);

        $firstOrder = DelayedOrder::where('status', DelayedOrderStatus::WITHOUT_OWNER->value)
            ->orderBy('id')
            ->first();

        $response = $this->getJson(route('agent.assign-delay-order', [
            'agent' => $this->agent->id,
        ]));

        $response->assertStatus(200);

        $assignedOrder = DelayedOrder::where('agent_id', $this->agent->id)
            ->where('status', DelayedOrderStatus::ASSIGNED->value)
            ->first();

        $this->assertEquals($assignedOrder->id, $firstOrder->id);
    }
}
